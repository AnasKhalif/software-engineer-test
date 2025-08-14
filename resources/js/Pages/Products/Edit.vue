<template>
    <AppLayout>
        <ProductForm mode="edit" :product="product" :categories="categories" />
    </AppLayout>
</template>

<script setup>
import AppLayout from "@/Layouts/AppLayout.vue";
import ProductForm from "@/Components/Products/ProductForm.vue";

const props = defineProps({
    product: { type: Object, required: true },
    categories: { type: Array, default: () => [] },
});
</script>
