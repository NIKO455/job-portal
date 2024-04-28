<script setup>
import { defineProps } from 'vue';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import {Head} from '@inertiajs/vue3';
import Main from "@/Pages/Front/Layouts/Main.vue";

defineProps({
    user:Object
})

</script>

<template>
    <Head title="Profile"/>
    <Main>
        <AuthenticatedLayout :user="user">
            <div class="card border-0 shadow mb-4">
                <div class="card-body">
                    <p>User Information</p>
                </div>
            </div>
        </AuthenticatedLayout>
    </Main>

</template>
