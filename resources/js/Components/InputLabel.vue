<script setup>
defineProps({
    value: {
        type: String,
    },
    id:{}
});
</script>

<template>
    <label class="mb-2" :for="id">
        <span v-if="value">{{ value }}</span>
        <span v-else><slot /></span>
    </label>
</template>

<style scoped>
    span{
        font-size: 16px;
    }
</style>
