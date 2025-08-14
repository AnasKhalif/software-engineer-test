<template>
    <main class="flex-1 overflow-y-auto p-4 md:p-8">
        <nav
            class="text-[12px] font-medium flex items-center gap-1 text-slate-500 mb-6"
        >
            <span class="hover:text-slate-700 cursor-pointer" @click="goIndex"
                >Daftar Produk</span
            >
            <svg
                class="w-3 h-3 text-slate-400"
                fill="none"
                stroke="currentColor"
                stroke-width="1.8"
                viewBox="0 0 24 24"
            >
                <path
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    d="m9 6 6 6-6 6"
                />
            </svg>
            <span class="text-slate-700">{{ title }}</span>
        </nav>

        <div
            class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 mb-6"
        >
            <h1 class="text-[24px] md:text-[26px] font-semibold text-slate-800">
                {{ title }}
            </h1>
            <div class="flex gap-3">
                <button
                    type="button"
                    class="h-[42px] px-6 rounded-md text-[13px] font-medium bg-[#E0E6F2] hover:bg-[#d6deec] text-slate-700 transition"
                    @click="goIndex"
                >
                    Kembali
                </button>
                <button
                    :disabled="!isValid"
                    class="h-[42px] px-7 rounded-md text-[13px] font-semibold bg-primary-500 hover:bg-primary-600 disabled:bg-slate-300 disabled:text-slate-500 text-white transition"
                    @click="submit"
                >
                    {{ submitLabel }}
                </button>
            </div>
        </div>

        <form class="space-y-8" @submit.prevent="submit">
            <section class="bg-white shadow-card rounded-xl p-6 md:p-8">
                <h2 class="section-title">Informasi Produk</h2>

                <div class="space-y-7">
                    <div>
                        <label class="field-label">Gambar Produk</label>
                        <div class="mt-2 flex items-center gap-4">
                            <img
                                :src="
                                    previewImage ||
                                    props.product.image ||
                                    'https://placehold.co/120x120'
                                "
                                alt="Preview"
                                class="w-20 h-20 rounded-lg object-cover ring-1 ring-slate-200 bg-white"
                            />
                            <div class="flex items-center gap-3">
                                <label
                                    class="inline-flex items-center justify-center h-10 px-4 rounded-md bg-white border border-slate-200 text-[13px] font-medium text-slate-700 hover:bg-slate-50 cursor-pointer"
                                >
                                    Pilih Gambar
                                    <input
                                        type="file"
                                        accept="image/*"
                                        class="hidden"
                                        @change="onFileChange"
                                    />
                                </label>
                                <button
                                    v-if="form.image"
                                    type="button"
                                    class="h-10 px-4 rounded-md bg-slate-100 text-[13px] text-slate-700 hover:bg-slate-200"
                                    @click="clearImage"
                                >
                                    Hapus Pilihan
                                </button>
                            </div>
                        </div>
                        <p class="help-text">JPG, PNG, atau WebP. Maks 2MB.</p>
                    </div>

                    <div>
                        <label for="namaProduk" class="field-label req"
                            >Nama Produk</label
                        >
                        <input
                            id="namaProduk"
                            v-model.trim="form.name"
                            type="text"
                            placeholder="Masukkan nama produk"
                            class="mt-2 h-11 w-full rounded-lg border border-[#E3E9F2] bg-[#F8FAFE] px-4 text-[13px] text-slate-800 placeholder:text-slate-400 focus:border-primary-500 focus:bg-white focus:ring-4 focus:ring-primary-500/15 outline-none transition-colors"
                        />
                    </div>

                    <div>
                        <label for="kategoriProduk" class="field-label req"
                            >Kategori Produk</label
                        >
                        <div class="relative mt-2">
                            <select
                                id="kategoriProduk"
                                v-model="form.category_id"
                                class="h-11 w-full rounded-lg border border-[#E3E9F2] bg-[#F8FAFE] px-4 text-[13px] text-slate-800 focus:border-primary-500 focus:bg-white focus:ring-4 focus:ring-primary-500/15 outline-none transition-colors"
                            >
                                <option disabled value="">
                                    Pilih kategori
                                </option>
                                <option
                                    v-for="c in categories"
                                    :key="c.id"
                                    :value="c.id"
                                >
                                    {{ c.name }}
                                </option>
                            </select>
                            <p class="help-text">
                                Pilih kategori berdasarkan nama (mengirim ID).
                            </p>
                        </div>
                    </div>

                    <div>
                        <label for="skuProduk" class="field-label req"
                            >SKU</label
                        >
                        <input
                            id="skuProduk"
                            v-model.trim="form.sku"
                            type="text"
                            maxlength="100"
                            placeholder="Masukkan SKU"
                            class="mt-2 h-11 w-full rounded-lg border border-[#E3E9F2] bg-[#F8FAFE] px-4 text-[13px] text-slate-800 placeholder:text-slate-400 focus:border-primary-500 focus:bg-white focus:ring-4 focus:ring-primary-500/15 outline-none transition-colors"
                        />
                        <p class="help-text">Maksimal 100 karakter</p>
                    </div>

                    <div class="border rounded-lg bg-[#F7F9FD] px-5 py-5">
                        <div class="flex items-start gap-6">
                            <div class="flex-1">
                                <p class="field-label mb-1">Status Produk</p>
                                <p
                                    class="text-[12px] leading-relaxed text-slate-600"
                                >
                                    Tentukan apakah produk ditampilkan di toko
                                    dan toko digital.
                                </p>
                            </div>
                            <label
                                class="inline-flex items-center cursor-pointer mt-1"
                            >
                                <input
                                    id="statusProduk"
                                    v-model="form.status"
                                    type="checkbox"
                                    class="peer sr-only"
                                />
                                <span class="switch"></span>
                            </label>
                        </div>
                    </div>

                    <div class="divider"></div>

                    <h2 class="section-title">
                        Harga, Variasi, & Stok Ketersediaan
                    </h2>

                    <div
                        class="grid gap-6 md:gap-7 md:grid-cols-2 xl:grid-cols-4"
                    >
                        <div>
                            <label for="stokProduk" class="field-label req"
                                >Stok</label
                            >
                            <input
                                id="stokProduk"
                                v-model.number="form.stock"
                                type="number"
                                min="0"
                                placeholder="Masukkan stok"
                                class="mt-2 h-11 w-full rounded-lg border border-[#E3E9F2] bg-[#F8FAFE] px-4 text-[13px] text-slate-800 placeholder:text-slate-400 focus:border-primary-500 focus:bg-white focus:ring-4 focus:ring-primary-500/15 outline-none transition-colors"
                            />
                        </div>
                        <div>
                            <label for="hargaModal" class="field-label req"
                                >Harga Modal</label
                            >
                            <input
                                id="hargaModal"
                                v-model.number="form.cost_price"
                                type="number"
                                min="0"
                                placeholder="Masukkan harga modal"
                                class="mt-2 h-11 w-full rounded-lg border border-[#E3E9F2] bg-[#F8FAFE] px-4 text-[13px] text-slate-800 placeholder:text-slate-400 focus:border-primary-500 focus:bg-white focus:ring-4 focus:ring-primary-500/15 outline-none transition-colors"
                            />
                        </div>
                        <div>
                            <label for="hargaJual" class="field-label req"
                                >Harga Jual</label
                            >
                            <input
                                id="hargaJual"
                                v-model.number="form.sell_price"
                                type="number"
                                min="0"
                                placeholder="Masukkan harga jual"
                                class="mt-2 h-11 w-full rounded-lg border border-[#E3E9F2] bg-[#F8FAFE] px-4 text-[13px] text-slate-800 placeholder:text-slate-400 focus:border-primary-500 focus:bg-white focus:ring-4 focus:ring-primary-500/15 outline-none transition-colors"
                            />
                        </div>
                        <div>
                            <label for="hargaSpesial" class="field-label"
                                >Harga Spesial</label
                            >
                            <input
                                id="hargaSpesial"
                                v-model.number="form.special_price"
                                type="number"
                                min="0"
                                placeholder="Masukkan harga spesial"
                                class="mt-2 h-11 w-full rounded-lg border border-[#E3E9F2] bg-[#F8FAFE] px-4 text-[13px] text-slate-800 placeholder:text-slate-400 focus:border-primary-500 focus:bg-white focus:ring-4 focus:ring-primary-500/15 outline-none transition-colors"
                            />
                        </div>
                    </div>
                </div>
            </section>
        </form>
    </main>
</template>

<script setup>
import { computed, ref } from "vue";
import { useForm, router } from "@inertiajs/vue3";

const props = defineProps({
    mode: { type: String, default: "create" }, // 'create' | 'edit'
    product: {
        type: Object,
        default: () => ({
            name: "",
            category_id: "",
            sku: "",
            stock: null,
            cost_price: null,
            sell_price: null,
            special_price: null,
            status: true,
            id: null,
        }),
    },
    categories: { type: Array, default: () => [] },
});

const form = useForm({
    name: props.product.name,
    category_id: props.product.category_id,
    sku: props.product.sku,
    stock: props.product.stock,
    cost_price: props.product.cost_price,
    sell_price: props.product.sell_price,
    special_price: props.product.special_price,
    status: props.product.status ?? true,
    image: null,
});

const title = computed(() =>
    props.mode === "edit" ? "Edit Produk" : "Tambah Produk"
);
const submitLabel = computed(() =>
    props.mode === "edit" ? "Simpan Perubahan" : "Tambah Produk"
);
const categories = computed(() => props.categories);

const isValid = computed(() => {
    return (
        String(form.name || "").trim() &&
        String(form.category_id || "").trim() &&
        String(form.sku || "").trim() &&
        form.stock !== null &&
        form.cost_price !== null &&
        form.sell_price !== null
    );
});

function goIndex() {
    router.get("/", {}, { preserveScroll: true });
}

function submit() {
    if (!isValid.value) return;

    console.log("Submit called with mode:", props.mode);
    console.log("Product ID:", props.product.id);
    console.log("Form data before submit:", form.data());

    if (props.mode === "edit" && props.product.id) {
        const updateUrl = `/products/${props.product.id}`;
        console.log("Sending POST with _method=PUT to:", updateUrl);

        const formWithMethod = useForm({
            _method: "PUT",
            name: form.name,
            category_id: form.category_id,
            sku: form.sku,
            stock: form.stock,
            cost_price: form.cost_price,
            sell_price: form.sell_price,
            special_price: form.special_price,
            status: form.status,
            image: form.image,
        });

        formWithMethod.post(updateUrl, {
            preserveScroll: true,
            forceFormData: true,
            onStart: () => {
                console.log("Request started");
            },
            onProgress: (progress) => {
                console.log("Upload progress:", progress);
            },
            onSuccess: (response) => {
                console.log("Update berhasil:", response);
            },
            onError: (errors) => {
                console.error("Update gagal:", errors);
                console.log("Form data was:", formWithMethod.data());
            },
            onFinish: () => {
                console.log("Request finished");
            },
        });
    } else {
        console.log("Sending POST to: /products");
        form.post("/products", {
            preserveScroll: true,
            forceFormData: true,
            onSuccess: (response) => {
                console.log("Create berhasil:", response);
            },
            onError: (errors) => {
                console.error("Create gagal:", errors);
            },
        });
    }
}

const previewImage = ref("");
function onFileChange(e) {
    const file = e.target.files?.[0];
    if (!file) return;
    form.image = file;
    previewImage.value = URL.createObjectURL(file);
}
function clearImage() {
    form.image = null;
    previewImage.value = "";
}
</script>

<style scoped>
.switch {
    width: 40px;
    height: 22px;
    border-radius: 9999px;
    background: #d1d8e5;
    position: relative;
    transition: 0.25s;
}
.switch::after {
    content: "";
    position: absolute;
    top: 3px;
    left: 3px;
    width: 16px;
    height: 16px;
    background: #fff;
    border-radius: 50%;
    box-shadow: 0 1px 2px rgba(0, 0, 0, 0.15);
    transition: transform 0.25s;
}
.peer:checked + .switch {
    background: #2545ae;
}
.peer:checked + .switch::after {
    transform: translateX(18px);
}
.field-label {
    font-size: 13px;
    font-weight: 500;
    color: #1e293b;
}
.help-text {
    font-size: 11px;
    color: #64748b;
    margin-top: 6px;
}
.section-title {
    font-size: 18px;
    font-weight: 600;
    color: #1e293b;
    margin-bottom: 18px;
}
.divider {
    height: 1px;
    background: #edf0f5;
    margin: 26px 0;
}
</style>
