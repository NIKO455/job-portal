<script setup>
import { onMounted, ref } from 'vue';

const model = defineModel({
    type: String,
    required: true,
});

const input = ref(null);

onMounted(() => {
    if (input.value.hasAttribute('autofocus')) {
        input.value.focus();
    }
});

defineExpose({ focus: () => input.value.focus() });
</script>

<template>
    <input
        class="form-control shadow-none"
        v-model="model"
        ref="input"
    />
</template>

<style scoped>
input:focus{
    border: 1px solid #5beb5b;
}
</style>
