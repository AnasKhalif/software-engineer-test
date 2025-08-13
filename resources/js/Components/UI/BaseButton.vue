<template>
    <button
        :type="type"
        class="inline-flex items-center gap-1.5 rounded-md text-[13px] font-medium px-3.5 py-2 transition"
        :class="classes"
    >
        <slot />
    </button>
</template>

<script setup>
import { computed } from "vue";
const props = defineProps({
    variant: { type: String, default: "primary" },
    type: { type: String, default: "button" },
});
const classes = computed(() => {
    if (props.variant === "primary")
        return "bg-primary-500 hover:bg-primary-600 text-white";
    if (props.variant === "outline")
        return "border border-slate-300 bg-white hover:bg-slate-50 text-slate-700";
    return "bg-slate-200 text-slate-700";
});
</script>
