<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import DeleteUserForm from './Partials/DeleteUserForm.vue';
import UpdatePasswordForm from './Partials/UpdatePasswordForm.vue';
import UpdateProfileInformationForm from './Partials/UpdateProfileInformationForm.vue';
import {Head} from '@inertiajs/vue3';
import Main from "@/Pages/Front/Layouts/Main.vue";

defineProps({
    mustVerifyEmail: {
        type: Boolean,
    },
    status: {
        type: String,
    },
    user: Object
});

</script>

<template>
    <Head title="Profile"/>
    <Main>
        <AuthenticatedLayout :user="user">
            <template #header>
                <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">Profile</h2>
            </template>

            <div class="card border-0 shadow mb-4">
                <div class="card-body">
                    <div class="p-4">
                        <UpdateProfileInformationForm
                            :must-verify-email="mustVerifyEmail"
                            :status="status"
                            class="max-w-xl"
                        />
                    </div>

                    <div class="p-4">
                        <UpdatePasswordForm class="max-w-xl"/>
                    </div>

                    <div class="p-4">
                        <DeleteUserForm class="max-w-xl"/>
                    </div>
                </div>
            </div>
        </AuthenticatedLayout>
    </Main>
</template>
