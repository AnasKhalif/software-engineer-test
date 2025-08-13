import { reactive } from "vue";

const state = reactive({
    collapsed: false,
    mobileOpen: false,
    produkSubmenuOpen: false,
});

function toggleCollapse() {
    if (window.innerWidth < 768) return;
    state.collapsed = !state.collapsed;
    if (state.collapsed) state.produkSubmenuOpen = false;
}
function openMobile() {
    state.mobileOpen = true;
    document.body.classList.add("overflow-hidden");
}
function closeMobile() {
    state.mobileOpen = false;
    document.body.classList.remove("overflow-hidden");
}
function toggleMobile() {
    state.mobileOpen ? closeMobile() : openMobile();
}
function toggleProdukSubmenu() {
    if (state.collapsed) return;
    state.produkSubmenuOpen = !state.produkSubmenuOpen;
}
function handleResize() {
    if (window.innerWidth >= 768) closeMobile();
}

export function useSidebar() {
    return {
        state,
        toggleCollapse,
        toggleMobile,
        closeMobile,
        toggleProdukSubmenu,
        handleResize,
    };
}
