<template>
    <AppLayout>
        <ProductForm mode="create" :categories="categories" />
    </AppLayout>
</template>

<script setup>
import AppLayout from "@/Layouts/AppLayout.vue";
import ProductForm from "@/Components/Products/ProductForm.vue";

const props = defineProps({
    categories: { type: Array, default: () => [] },
});
</script>
