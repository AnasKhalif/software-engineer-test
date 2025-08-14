<template>
    <teleport to="body">
        <div
            v-if="open"
            class="absolute z-[1000]"
            :style="{ top: position.top + 'px', left: position.left + 'px' }"
        >
            <div class="relative">
                <div
                    class="absolute inset-0 -m-[2px] rounded-lg bg-[#2545AE] opacity-10 blur-md"
                ></div>
                <div
                    class="relative w-[200px] rounded-lg bg-white p-4 flex flex-col gap-4 shadow-[0_1px_2px_rgba(16,24,40,0.05),0_4px_20px_-2px_rgba(37,69,174,0.28)]"
                    role="menu"
                >
                    <button
                        type="button"
                        class="group flex w-full items-center gap-4 rounded-md px-2 py-3 text-[13px] font-medium text-[#2545AE] hover:bg-[#F1F5FF]"
                        @click="$emit('detail')"
                    >
                        <svg
                            class="w-5 h-5"
                            xmlns="http://www.w3.org/2000/svg"
                            viewBox="0 0 24 24"
                            fill="none"
                            stroke="currentColor"
                            stroke-width="1.8"
                            stroke-linecap="round"
                            stroke-linejoin="round"
                        >
                            <path
                                d="M2 12s3.5-6 10-6 10 6 10 6-3.5 6-10 6-10-6-10-6"
                            />
                            <circle cx="12" cy="12" r="3.5" />
                        </svg>
                        <span>Detail Produk</span>
                    </button>
                    <button
                        type="button"
                        class="group flex w-full items-center gap-4 rounded-md px-2 py-3 text-[13px] font-medium text-[#2545AE] hover:bg-[#F1F5FF]"
                        @click="$emit('delete')"
                    >
                        <img
                            src="/public/icons/Outline copy 3.png"
                            alt="Hapus"
                            class="w-5 h-5"
                        />
                        <span>Hapus Produk</span>
                    </button>
                    <button
                        type="button"
                        class="group flex w-full items-center gap-4 rounded-md px-2 py-3 text-[13px] font-medium text-[#2545AE] hover:bg-[#F1F5FF]"
                        @click="$emit('edit')"
                    >
                        <img
                            src="/public/icons/Outline copy 4.png"
                            alt="Edit"
                            class="w-5 h-5"
                        />
                        <span>Edit Produk</span>
                    </button>
                </div>
            </div>
        </div>
    </teleport>
</template>

<script setup>
defineProps({
    open: Boolean,
    position: { type: Object, default: () => ({ top: 0, left: 0 }) },
});
defineEmits(["detail", "delete", "edit"]);
</script>
