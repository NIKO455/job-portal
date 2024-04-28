<script setup>
defineProps({
    message: {
        type: String,
    },
});
</script>

<template>
    <div v-show="message">
        <p>
            {{ message }}
        </p>
    </div>
</template>

<style scoped>
p {
    font-size: 14px;
    color: red;
}
</style>
