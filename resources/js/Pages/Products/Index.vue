<template>
    <AppLayout>
        <h1
            class="text-[22px] md:text-[28px] leading-[30px] md:leading-[36px] font-semibold text-slate-800 mb-6"
        >
            Daftar Produk
        </h1>

        <BaseCard>
            <div
                class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between mb-4"
            >
                <h2 class="text-[15px] font-medium text-slate-800">Produk</h2>
                <BaseButton
                    variant="primary"
                    class="self-start sm:self-auto w-auto"
                    @click="router.get('/products/create')"
                >
                    <svg
                        class="w-4 h-4"
                        fill="none"
                        stroke="currentColor"
                        stroke-width="1.8"
                        viewBox="0 0 24 24"
                    >
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            d="M12 4.5v15m7.5-7.5h-15"
                        />
                    </svg>
                    Tambah Produk
                </BaseButton>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full min-w-[800px] custom-table">
                    <thead class="bg-[#E3E7F4]">
                        <tr>
                            <th class="rounded-tl-lg">Nama Produk</th>
                            <th>SKU</th>
                            <th>Stok</th>
                            <th>Kategori</th>
                            <th>Harga Jual</th>
                            <th>Waktu Dibuat</th>
                            <th>Status</th>
                            <th class="rounded-tr-lg"></th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="p in products" :key="p.id">
                            <td>
                                <div class="flex items-center gap-3">
                                    <img
                                        class="w-11 h-11 rounded-md object-cover ring-1 ring-slate-200"
                                        :src="p.image"
                                        alt=""
                                    />
                                    <div>
                                        <div class="font-medium text-slate-800">
                                            {{ p.name }}
                                        </div>
                                        <div
                                            class="text-[11px] text-slate-500 font-medium tracking-wide"
                                        >
                                            {{ p.code }}
                                        </div>
                                    </div>
                                </div>
                            </td>
                            <td>{{ p.code }}</td>
                            <td>{{ p.stock }}</td>
                            <td>
                                <span class="badge">{{ p.category }}</span>
                            </td>
                            <td>{{ p.price }}</td>
                            <td>{{ p.created_at }}</td>
                            <td><BaseSwitch :checked="p.active" /></td>
                            <td>
                                <button
                                    class="p-1.5 rounded-md hover:bg-slate-100 text-slate-500"
                                    @click.stop="openPopover($event, p)"
                                    aria-haspopup="menu"
                                    :aria-expanded="
                                        popover.open &&
                                        popover.product?.id === p.id
                                    "
                                >
                                    <svg
                                        class="w-4 h-4"
                                        fill="currentColor"
                                        viewBox="0 0 20 20"
                                    >
                                        <circle cx="10" cy="4" r="1" />
                                        <circle cx="10" cy="10" r="1" />
                                        <circle cx="10" cy="16" r="1" />
                                    </svg>
                                </button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <div
                class="flex flex-wrap gap-1 items-center justify-end px-2 sm:px-5 py-5 border-t border-slate-100 mt-4"
            >
                <button
                    class="h-8 w-8 flex items-center justify-center rounded-md text-slate-400 border border-slate-200 hover:bg-slate-50"
                    @click="goToPage(currentPage - 1)"
                    :disabled="!hasPrev"
                >
                    <svg
                        class="w-3.5 h-3.5"
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

                <button
                    class="h-8 min-w-8 px-3 rounded-md text-[12px] font-medium text-white bg-primary-500 border border-primary-500"
                    @click="goToPage(currentPage)"
                >
                    {{ currentPage }}
                </button>

                <button
                    v-if="hasNext"
                    class="h-8 min-w-8 px-3 rounded-md text-[12px] font-medium text-slate-600 bg-white border border-slate-200 hover:bg-slate-50"
                    @click="goToPage(nextPage)"
                >
                    {{ nextPage }}
                </button>

                <span
                    v-if="showEllipsis"
                    class="px-2 text-slate-400 text-[12px]"
                    >...</span
                >

                <button
                    v-if="showLast"
                    class="h-8 min-w-8 px-3 rounded-md text-[12px] font-medium text-slate-600 bg-white border border-slate-200 hover:bg-slate-50"
                    @click="goToPage(lastPage)"
                >
                    {{ lastPage }}
                </button>

                <button
                    class="h-8 w-8 flex items-center justify-center rounded-md text-slate-600 border border-slate-200 hover:bg-slate-50"
                    @click="goToPage(currentPage + 1)"
                    :disabled="!hasNext"
                >
                    <svg
                        class="w-3.5 h-3.5"
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
                </button>
            </div>
        </BaseCard>

        <ActionPopover
            :open="popover.open"
            :position="popover.position"
            @detail="viewDetail"
            @delete="askDelete"
            @edit="editProduct"
        />
        <DeleteModal
            :open="deleteModal.open"
            :product-name="deleteModal.productName"
            @close="deleteModal.open = false"
            @confirm="confirmDelete"
        />
    </AppLayout>
</template>

<script setup>
import AppLayout from "@/Layouts/AppLayout.vue";
import BaseCard from "@/Components/UI/BaseCard.vue";
import BaseButton from "@/Components/UI/BaseButton.vue";
import BaseSwitch from "@/Components/UI/BaseSwitch.vue";
import ActionPopover from "@/Components/UI/ActionPopover.vue";
import DeleteModal from "@/Components/UI/DeleteModal.vue";
import { computed, reactive } from "vue";
import { router } from "@inertiajs/vue3";

const props = defineProps({
    products: { type: Array, default: () => [] },
    pagination: {
        type: Object,
        default: () => ({
            current_page: 1,
            last_page: 1,
            per_page: 10,
            total: 0,
        }),
    },
});

const products = computed(() => props.products);

const currentPage = computed(() => props.pagination.current_page || 1);
const lastPage = computed(() => props.pagination.last_page || 1);
const hasPrev = computed(() => currentPage.value > 1);
const hasNext = computed(() => currentPage.value < lastPage.value);
const nextPage = computed(() =>
    Math.min(currentPage.value + 1, lastPage.value)
);

// Ellipsis hanya muncul jika ada jarak > 1 halaman antara next dan last
const showEllipsis = computed(() => lastPage.value > nextPage.value + 1);
// Tampilkan tombol last hanya jika masih ada halaman setelah next
const showLast = computed(() => lastPage.value > nextPage.value);

function goToPage(page) {
    if (
        !page ||
        page < 1 ||
        page > lastPage.value ||
        page === currentPage.value
    )
        return;
    router.get("/", { page }, { preserveScroll: true, preserveState: true });
}

const popover = reactive({
    open: false,
    position: { top: 0, left: 0 },
    product: null,
});

function openPopover(e, product) {
    const r = e.currentTarget.getBoundingClientRect();
    const w = 200,
        h = 140;
    if (popover.open && popover.product?.id === product.id) {
        popover.open = false;
        return;
    }
    let top = window.scrollY + r.bottom + 8;
    let left = window.scrollX + r.right - w;
    if (left + w > window.scrollX + window.innerWidth - 8)
        left = window.scrollX + window.innerWidth - w - 8;
    if (top + h > window.scrollY + window.innerHeight - 8)
        top = window.scrollY + r.top - h - 8;
    popover.position = { top, left };
    popover.product = product;
    popover.open = true;
    document.addEventListener("click", outsideOnce, { once: true });
}
function outsideOnce(ev) {
    if (!ev.target.closest('[role="menu"]')) popover.open = false;
}

const deleteModal = reactive({
    open: false,
    productName: "",
    productId: null,
});

function askDelete() {
    deleteModal.open = true;
    deleteModal.productName = popover.product?.name || "";
    deleteModal.productId = popover.product?.id || null;
    popover.open = false;
}
function confirmDelete() {
    if (!deleteModal.productId) return;
    router.delete(`/products/${deleteModal.productId}`, {
        preserveScroll: true,
        onFinish: () => {
            deleteModal.open = false;
        },
    });
}
function editProduct() {
    if (!popover.product?.id) return;
    router.get(
        `/products/${popover.product.id}/edit`,
        {},
        { preserveScroll: true }
    );
    popover.open = false;
}

function viewDetail() {
    if (!popover.product?.id) return;
    router.get(`/products/${popover.product.id}`);
    popover.open = false;
}
</script>

<style scoped>
.custom-table th {
    background: transparent;
    text-align: left;
    font-size: 11px;
    text-transform: uppercase;
    letter-spacing: 0.05em;
    font-weight: 600;
    padding: 12px 16px;
    border-bottom: 1px solid #e2e8f0;
}
.custom-table td {
    padding: 12px 16px;
    border-bottom: 1px solid #f1f5f9;
    font-size: 13px;
    background: #f6f8fc;
}
.custom-table tbody tr:hover td {
    background: #f8fafc;
}
.badge {
    display: inline-block;
    font-size: 11px;
    padding: 4px 8px;
    border-radius: 9999px;
    background: #f1f5f9;
    color: #475569;
    font-weight: 500;
}
</style>
