<template>
    <aside
        id="sidebar"
        class="h-full shrink-0 bg-white shadow-[0_10px_20px_0_#404C9733] flex flex-col pt-2 pr-6 pb-4 pl-6 gap-4 z-50 md:static transition-all duration-300 w-[275px]"
        :class="[
            state.collapsed ? 'collapsed w-[88px]' : 'w-[275px]',
            state.mobileOpen ? 'mobile-open fixed top-0 left-0 w-[260px]' : '',
        ]"
    >
        <!-- Desktop collapse -->
        <div
            class="flex items-center justify-between collapse-wrapper relative"
        >
            <div class="pt-1 overflow-hidden">
                <img
                    :class="[
                        'nav-logo transition-all duration-300',
                        state.collapsed ? 'w-[40px]' : 'w-[160px]',
                    ]"
                    src="/public/images/logo.png"
                    alt="Logo"
                />
            </div>
            <div
                class="absolute top-2 -right-12 w-12 h-12 rounded-r-full bg-white flex items-center justify-center p-2 shadow-[8px_0_24px_-8px_rgba(64,76,151,0.12)]"
            >
                <button
                    class="w-8 h-8 p-1 rounded-full border border-black/70 flex items-center justify-center text-slate-700 hover:bg-slate-50"
                    @click="toggleCollapse"
                    aria-label="Toggle sidebar"
                >
                    <svg
                        class="w-6 h-6 transition-transform duration-300"
                        :class="state.collapsed ? 'rotate-180' : ''"
                        fill="none"
                        stroke="currentColor"
                        stroke-width="2"
                        viewBox="0 0 24 24"
                    >
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            d="M15 6l-6 6 6 6"
                        />
                    </svg>
                </button>
            </div>
        </div>

        <!-- Mobile top bar -->
        <div class="md:hidden flex items-center justify-between mb-2">
            <img
                src="/public/images/logo.png"
                alt="Logo"
                class="w-[140px] h-auto"
            />
            <button
                class="w-10 h-10 flex items-center justify-center rounded-md text-slate-500 hover:bg-slate-100"
                aria-label="Tutup menu"
                @click="closeMobile"
            >
                <svg
                    class="w-5 h-5"
                    fill="none"
                    stroke="currentColor"
                    stroke-width="2"
                    viewBox="0 0 24 24"
                >
                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        d="M6 6l12 12M18 6 6 18"
                    />
                </svg>
            </button>
        </div>

        <nav class="flex-1 overflow-y-auto">
            <div class="flex flex-col gap-2 pt-1">
                <button
                    class="w-full h-10 flex justify-between items-center text-left text-[15px] font-semibold text-slate-800 px-2 rounded-[4px] hover:bg-slate-50"
                    type="button"
                    @click="toggleProdukSubmenu"
                >
                    <span class="inline-flex items-center gap-3">
                        <img
                            src="/public/icons/box-outline.png"
                            alt="Produk"
                            class="w-5 h-5"
                        />
                        <span class="nav-label" v-if="!state.collapsed"
                            >Produk</span
                        >
                    </span>
                    <svg
                        v-if="!state.collapsed"
                        class="w-4 h-4 text-slate-400 transition-transform duration-200"
                        :class="state.produkSubmenuOpen ? 'rotate-180' : ''"
                        fill="none"
                        stroke="currentColor"
                        stroke-width="1.5"
                        viewBox="0 0 24 24"
                    >
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            d="m6 9 6 6 6-6"
                        />
                    </svg>
                </button>

                <div
                    v-show="state.produkSubmenuOpen && !state.collapsed"
                    class="flex flex-col gap-1 mt-1"
                >
                    <a
                        href="#"
                        class="sidebar-menu-item w-full h-9 flex items-center gap-3 px-2 rounded-[4px] bg-[#2545AE] text-white text-[13px] font-semibold hover:bg-[#1f3d97]"
                    >
                        <img
                            src="/public/icons/list-ul.png"
                            alt="Daftar Produk"
                            class="w-5 h-5 opacity-90"
                        />
                        <span class="nav-label">Daftar Produk</span>
                    </a>
                </div>
            </div>
        </nav>

        <div
            class="text-[11px] text-slate-400 mt-4"
            :class="state.collapsed ? 'text-center' : ''"
        >
            © 2025
        </div>
    </aside>

    <div
        class="mobile-sidebar-overlay"
        :class="state.mobileOpen ? 'show' : ''"
        @click="closeMobile"
    />
</template>

<script setup>
import { useSidebar } from "@/Composables/useSidebar";
const { state, toggleCollapse, toggleProdukSubmenu, closeMobile } =
    useSidebar();
</script>

<style scoped>
@media (max-width: 767px) {
    /* Off-canvas behavior so content uses full width on mobile */
    #sidebar {
        position: fixed;
        top: 0;
        left: 0;
        height: 100vh;
        width: 260px;
        transform: translateX(-100%);
    }
    #sidebar.mobile-open {
        transform: translateX(0);
    }
    /* Hide desktop collapse controls on mobile */
    #sidebar .collapse-wrapper {
        display: none;
    }
}
.collapsed .nav-label,
.collapsed .caret-icon {
    display: none;
}
.mobile-sidebar-overlay {
    position: fixed;
    inset: 0;
    background: rgba(0, 0, 0, 0.4);
    backdrop-filter: blur(2px);
    z-index: 40;
    display: none;
}
.mobile-sidebar-overlay.show {
    display: block;
}
</style>
