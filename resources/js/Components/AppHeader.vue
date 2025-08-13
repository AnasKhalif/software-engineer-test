<template>
    <header
        class="h-[60px] md:h-[72px] bg-white border-b border-slate-200 flex items-center justify-between md:justify-end px-4 md:px-6"
    >
        <button
            class="md:hidden inline-flex items-center justify-center w-10 h-10 rounded-md border border-slate-200 text-slate-600 active:scale-95"
            aria-label="Buka menu"
            @click="toggleMobile"
        >
            <svg
                class="w-6 h-6"
                fill="none"
                stroke="currentColor"
                stroke-width="1.8"
                viewBox="0 0 24 24"
            >
                <path
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    d="M4 7h16M4 12h16M4 17h16"
                />
            </svg>
        </button>

        <div class="flex items-center gap-2 md:gap-4">
            <div class="hidden md:flex items-center gap-4">
                <button class="p-2 rounded-md text-slate-600">
                    <img src="/public/icons/Status Order.png" alt="" />
                </button>
                <button class="p-2 rounded-md text-slate-600">
                    <img src="/public/icons/Outline.png" alt="" />
                </button>
                <button class="p-2 rounded-md text-slate-600">
                    <img src="/public/icons/Outline copy.png" alt="" />
                </button>
                <button class="p-2 rounded-md text-slate-600">
                    <img src="/public/icons/Outline copy 2.png" alt="" />
                </button>
            </div>
            <div class="flex items-center bg-[#EFF4FF] rounded-xl p-1 w-fit">
                <div
                    class="w-9 h-9 md:w-10 md:h-10 rounded-lg overflow-hidden bg-slate-100 flex items-center justify-center"
                >
                    <img
                        src="/public/images/Frame 1737.png"
                        alt="User"
                        class="w-full h-full object-cover"
                    />
                </div>
                <div
                    class="hidden md:flex items-center justify-center bg-white rounded-lg w-[132px] h-[40px] ml-1"
                >
                    <span class="text-[15px] font-medium text-[#2545AE]"
                        >Starter Package</span
                    >
                </div>
                <svg
                    xmlns="http://www.w3.org/2000/svg"
                    class="hidden md:block w-4 h-4 text-[#2545AE] mx-2"
                    fill="none"
                    viewBox="0 0 24 24"
                    stroke="currentColor"
                    stroke-width="2"
                >
                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        d="m6 9 6 6 6-6"
                    />
                </svg>
            </div>
        </div>
    </header>
</template>

<script setup>
import { useSidebar } from "@/Composables/useSidebar";
const { toggleMobile } = useSidebar();
</script>
