<template>
    <div
        class="w-9 h-5 rounded-full relative transition-colors"
        :class="checked ? 'bg-[#2545AE]' : 'bg-slate-300'"
    >
        <div
            class="absolute top-0.5 left-0.5 h-4 w-4 rounded-full bg-white shadow transition-transform"
            :class="checked ? 'translate-x-4' : 'translate-x-0'"
        />
    </div>
</template>
<script setup>
defineProps({ checked: { type: Boolean, default: false } });
</script>
