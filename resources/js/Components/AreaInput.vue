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
    <textarea ref="input" class="form-control shadow-none" cols="5" rows="5"
              v-model="model"></textarea>
</template>

<style scoped>
textarea:focus{
    border: 1px solid #5beb5b;
}
</style>
