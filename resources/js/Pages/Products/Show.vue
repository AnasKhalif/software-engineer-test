<template>
    <AppLayout>
        <div class="flex items-center gap-3 mb-6">
            <button
                class="p-2 rounded-md hover:bg-slate-100 text-slate-600"
                @click="router.get('/')"
            >
                <svg
                    class="w-5 h-5"
                    fill="none"
                    stroke="currentColor"
                    stroke-width="1.8"
                    viewBox="0 0 24 24"
                >
                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        d="m15 6-6 6 6 6"
                    />
                </svg>
            </button>
            <h1
                class="text-[22px] md:text-[28px] leading-[30px] md:leading-[36px] font-semibold text-slate-800"
            >
                Detail Produk
            </h1>
        </div>

        <BaseCard class="mb-6">
            <div class="flex flex-col md:flex-row gap-6">
                <img
                    :src="product.image"
                    alt="Gambar produk"
                    class="w-full md:w-80 aspect-[4/3] object-cover rounded-lg ring-1 ring-slate-200"
                />
                <div class="flex-1 space-y-3">
                    <div class="flex items-start justify-between">
                        <div>
                            <h2 class="text-xl font-semibold text-slate-800">
                                {{ product.name }}
                            </h2>
                            <p class="text-slate-500 text-sm">
                                SKU: {{ product.sku }}
                            </p>
                        </div>
                        <BaseButton
                            variant="primary"
                            @click="router.get(`/products/${product.id}/edit`)"
                            >Edit</BaseButton
                        >
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 pt-2">
                        <div>
                            <div class="text-xs text-slate-500 mb-1">
                                Kategori
                            </div>
                            <div class="text-slate-700 font-medium">
                                {{ product.category?.name || "-" }}
                            </div>
                        </div>
                        <div>
                            <div class="text-xs text-slate-500 mb-1">
                                Status
                            </div>
                            <div>
                                <span
                                    v-if="product.status"
                                    class="inline-flex items-center gap-1 px-2 py-1 rounded-full bg-green-50 text-green-700 text-xs font-medium"
                                >
                                    Aktif
                                </span>
                                <span
                                    v-else
                                    class="inline-flex items-center gap-1 px-2 py-1 rounded-full bg-slate-100 text-slate-600 text-xs font-medium"
                                >
                                    Nonaktif
                                </span>
                            </div>
                        </div>
                        <div>
                            <div class="text-xs text-slate-500 mb-1">Stok</div>
                            <div class="text-slate-700 font-medium">
                                {{ product.stock }}
                            </div>
                        </div>
                        <div>
                            <div class="text-xs text-slate-500 mb-1">
                                Harga Jual
                            </div>
                            <div class="text-slate-700 font-semibold">
                                {{ formatRupiah(product.sell_price) }}
                            </div>
                        </div>
                        <div>
                            <div class="text-xs text-slate-500 mb-1">
                                Harga Pokok
                            </div>
                            <div class="text-slate-700">
                                {{ formatRupiah(product.cost_price) }}
                            </div>
                        </div>
                        <div>
                            <div class="text-xs text-slate-500 mb-1">
                                Harga Spesial
                            </div>
                            <div class="text-slate-700">
                                {{
                                    product.special_price
                                        ? formatRupiah(product.special_price)
                                        : "-"
                                }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </BaseCard>
    </AppLayout>
</template>

<script setup>
import AppLayout from "@/Layouts/AppLayout.vue";
import BaseCard from "@/Components/UI/BaseCard.vue";
import BaseButton from "@/Components/UI/BaseButton.vue";
import { router } from "@inertiajs/vue3";

const props = defineProps({
    product: { type: Object, required: true },
});

function formatRupiah(value) {
    if (value === null || value === undefined) return "-";
    try {
        return new Intl.NumberFormat("id-ID", {
            style: "currency",
            currency: "IDR",
            maximumFractionDigits: 0,
        }).format(value);
    } catch (e) {
        return `Rp ${Number(value).toLocaleString("id-ID")}`;
    }
}
</script>
