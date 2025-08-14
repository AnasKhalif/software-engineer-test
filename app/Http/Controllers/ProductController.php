<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\Product;
use Illuminate\Support\Str;
use App\Models\Category;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $perPage = (int) $request->get('per_page', 5);

        $products = Product::with('category')
            ->orderBy('created_at', 'desc')
            ->paginate($perPage);

        $items = $products->getCollection()->map(function ($p) {
            return [
                'id'         => (string) ($p->_id ?? $p->getKey()),
                'name'       => $p->name,
                'slug'       => $p->slug,
                'code'       => $p->sku,
                'type'       => 'Physical',
                'category'   => optional($p->category)->name ?? 'Uncategorized',
                'stock'      => (int) ($p->stock ?? 0),
                'price'      => $p->sell_price !== null
                    ? 'Rp ' . number_format($p->sell_price, 0, ',', '.')
                    : '-',
                'created_at' => $p->created_at ? $p->created_at->format('d M Y') : '-',
                'active'     => (bool) $p->status,
                'image'      => $p->image ?: 'https://placehold.co/300',
            ];
        })->values();

        return Inertia::render('Products/Index', [
            'products' => $items,
            'pagination' => [
                'current_page' => $products->currentPage(),
                'last_page'    => $products->lastPage(),
                'per_page'     => $products->perPage(),
                'total'        => $products->total(),
            ],
        ]);
    }

    public function create()
    {
        $categories = Category::orderBy('name')->get(['_id', 'name'])
            ->map(fn ($c) => ['id' => (string) $c->_id, 'name' => $c->name])
            ->values()
            ->all();

        return Inertia::render('Products/Create', [
            'categories' => $categories,
        ]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name'          => ['required', 'string', 'max:255'],
            'category_id'   => ['required', 'string'],
            'sku'           => ['required', 'string', 'max:100'],
            'stock'         => ['required', 'integer', 'min:0'],
            'cost_price'    => ['required', 'integer', 'min:0'],
            'sell_price'    => ['required', 'integer', 'min:0'],
            'special_price' => ['nullable', 'integer', 'min:0'],
            'status'        => ['boolean'],
            'image'         => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
        ]);

        if (Product::where('sku', $data['sku'])->whereNull('deleted_at')->exists()) {
            return back()->withErrors(['sku' => 'SKU sudah digunakan.'])->withInput();
        }

        if (!Category::where('_id', $data['category_id'])->exists()) {
            return back()->withErrors(['category_id' => 'Kategori tidak valid.'])->withInput();
        }

        $slug = $this->makeUniqueSlug($data['name']);

        $imageUrl = null;
        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('products', 'public');
            $imageUrl = asset('storage/' . $path);
        }

        Product::create([
            'name'          => $data['name'],
            'slug'          => $slug,
            'category_id'   => $data['category_id'],
            'sku'           => $data['sku'],
            'stock'         => $data['stock'],
            'cost_price'    => $data['cost_price'],
            'sell_price'    => $data['sell_price'],
            'special_price' => $data['special_price'] ?? null,
            'status'        => (bool) ($data['status'] ?? true),
            'image'         => $imageUrl,
        ]);

        return redirect()->route('products.index', [], 303)
            ->with('success', 'Produk berhasil ditambahkan.');
    }

    public function edit(Product $product)
    {
        $categories = Category::orderBy('name')->get(['_id', 'name'])
            ->map(fn ($c) => ['id' => (string) $c->_id, 'name' => $c->name])
            ->values()
            ->all();

        $item = [
            'id'            => (string) ($product->_id ?? $product->getKey()),
            'name'          => $product->name,
            'category_id'   => (string) $product->category_id,
            'sku'           => $product->sku,
            'stock'         => (int) ($product->stock ?? 0),
            'cost_price'    => (int) $product->cost_price,
            'sell_price'    => (int) $product->sell_price,
            'special_price' => $product->special_price,
            'status'        => (bool) $product->status,
            'slug'          => $product->slug,
            'image'         => $product->image,
        ];

        return Inertia::render('Products/Edit', [
            'product'    => $item,
            'categories' => $categories,
        ]);
    }

    public function update(Request $request, Product $product)
    {

        \Log::info('Update request received:', [
            'product_id' => (string)$product->_id,
            'method' => $request->method(),
            'content_type' => $request->header('content-type'),
            'all_data' => $request->all(),
            'input_data' => $request->input(),
            'file_data' => $request->file(),
            'has_files' => $request->hasFile('image'),
        ]);

        $data = $request->validate([
            'name'          => ['required', 'string', 'max:255'],
            'category_id'   => ['required', 'string'],
            'sku'           => ['required', 'string', 'max:100'],
            'stock'         => ['required', 'integer', 'min:0'],
            'cost_price'    => ['required', 'integer', 'min:0'],
            'sell_price'    => ['required', 'integer', 'min:0'],
            'special_price' => ['nullable', 'integer', 'min:0'],
            'status'        => ['boolean'],
            'image'         => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
        ]);


        if (Product::where('sku', $data['sku'])
            ->where('_id', '!=', $product->_id)
            ->whereNull('deleted_at')
            ->exists()
        ) {
            return back()->withErrors(['sku' => 'SKU sudah digunakan.'])->withInput();
        }

        if (!Category::where('_id', $data['category_id'])->exists()) {
            return back()->withErrors(['category_id' => 'Kategori tidak valid.'])->withInput();
        }

        $payload = [
            'name'          => $data['name'],
            'category_id'   => $data['category_id'],
            'sku'           => $data['sku'],
            'stock'         => $data['stock'],
            'cost_price'    => $data['cost_price'],
            'sell_price'    => $data['sell_price'],
            'special_price' => $data['special_price'] ?? null,
            'status'        => (bool) ($data['status'] ?? true),
        ];

        if ($product->name !== $data['name']) {
            $payload['slug'] = $this->makeUniqueSlugForUpdate($data['name'], $product->_id);
        }

        if ($request->hasFile('image')) {
            if ($product->image && str_contains($product->image, '/storage/')) {
                $rel = str_replace(asset('') . 'storage/', '', $product->image);
                \Illuminate\Support\Facades\Storage::disk('public')->delete($rel);
            }
            $path = $request->file('image')->store('products', 'public');
            $payload['image'] = asset('storage/' . $path);
        }

        $result = $product->update($payload);

        \Log::info('Update result:', [
            'success' => $result,
            'updated_product' => $product->fresh()->toArray(),
        ]);

        return redirect()->route('products.index', [], 303)
            ->with('success', 'Produk berhasil diperbarui.');
    }

    private function makeUniqueSlug(string $name): string
    {
        $base = Str::slug($name);
        $slug = $base;

        if (Product::where('slug', $slug)->whereNull('deleted_at')->exists()) {
            $slug = $base . '-' . Str::lower(Str::ulid());
        }

        return $slug;
    }

    private function makeUniqueSlugForUpdate(string $name, $productId): string
    {
        $base = Str::slug($name);
        $slug = $base;

        if (Product::where('slug', $slug)
            ->where('_id', '!=', $productId)
            ->whereNull('deleted_at')
            ->exists()
        ) {
            $slug = $base . '-' . Str::lower(Str::ulid());
        }

        return $slug;
    }

    public function destroy(Product $product)
    {

        if ($product->image && str_contains($product->image, '/storage/')) {
            $rel = str_replace(asset('') . 'storage/', '', $product->image);
            \Illuminate\Support\Facades\Storage::disk('public')->delete($rel);
        }
        $product->delete();

        return redirect()->route('products.index', [], 303)
            ->with('success', 'Produk berhasil dihapus.');
    }

    public function show(Product $product)
    {
        $product->load('category');
        $item = [
            'id'            => (string) ($product->_id ?? $product->getKey()),
            'name'          => $product->name,
            'slug'          => $product->slug,
            'category'      => $product->category ? [
                'id' => (string) $product->category->_id,
                'name' => $product->category->name,
            ] : null,
            'sku'           => $product->sku,
            'stock'         => (int) ($product->stock ?? 0),
            'cost_price'    => (int) $product->cost_price,
            'sell_price'    => (int) $product->sell_price,
            'special_price' => $product->special_price,
            'status'        => (bool) $product->status,
            'image'         => $product->image ?: 'https://placehold.co/600x400',
            'created_at'    => $product->created_at ? $product->created_at->toIso8601String() : null,
            'updated_at'    => $product->updated_at ? $product->updated_at->toIso8601String() : null,
        ];

        return Inertia::render('Products/Show', [
            'product' => $item,
        ]);
    }
}
