<template>
    <div class="flex h-screen overflow-hidden bg-body">
        <Sidebar />
        <div class="flex-1 flex flex-col min-w-0">
            <AppHeader />
            <main class="flex-1 overflow-y-auto p-4 md:p-6">
                <slot />
            </main>
        </div>
    </div>
</template>

<script setup>
import Sidebar from "@/Components/Sidebar.vue";
import AppHeader from "@/Components/AppHeader.vue";
import { onMounted, onBeforeUnmount } from "vue";
import { useSidebar } from "@/Composables/useSidebar";

const { handleResize } = useSidebar();

onMounted(() => {
    window.addEventListener("resize", handleResize, { passive: true });
    handleResize();
});
onBeforeUnmount(() => {
    window.removeEventListener("resize", handleResize);
});
</script>
