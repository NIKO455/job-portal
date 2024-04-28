<script setup>

import {Link} from '@inertiajs/vue3'

defineProps({
    pagination: Object
})
</script>

<template>
    <nav>
        <template v-for="link in pagination.links" :key="link.label">
            <Link :href="link.url" v-html="link.label" class="link-btn"/>
        </template>
    </nav>
</template>

<style scoped>
nav {
    width: 100%;
    position: relative;
    display: flex;
    justify-content: center;
}

.link-btn {
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 20px;
    color: black;
}

.link-btn:hover{
    color: green;
}
</style>
