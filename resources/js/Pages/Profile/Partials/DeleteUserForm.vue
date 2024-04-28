<script setup>
import DangerButton from '@/Components/DangerButton.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import Modal from '@/Components/Modal.vue';
import SecondaryButton from '@/Components/SecondaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import {useForm} from '@inertiajs/vue3';
import {nextTick, ref} from 'vue';
import PrimaryButton from "@/Components/PrimaryButton.vue";

const confirmingUserDeletion = ref(false);
const passwordInput = ref(null);

const form = useForm({
    password: '',
});

const confirmUserDeletion = () => {
    confirmingUserDeletion.value = true;

    nextTick(() => passwordInput.value.focus());
};

const deleteUser = () => {
    form.delete(route('profile.destroy'), {
        preserveScroll: true,
        onSuccess: () => closeModal(),
        onError: () => passwordInput.value.focus(),
        onFinish: () => form.reset(),
    });
};

const closeModal = () => {
    form.reset();
};
</script>

<template>
    <section class="space-y-6">
        <header>
            <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">Delete Account</h2>

            <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                Once your account is deleted, all of its resources and data will be permanently deleted. Before deleting
                your account, please download any data or information that you wish to retain.
            </p>
        </header>

        <DangerButton data-bs-toggle="modal" data-bs-target="#deleteAccount" type="button">Delete Account</DangerButton>

        <div class="modal fade" id="deleteAccount" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                            Delete my account?
                        </h2>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="p-2">
                            <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                                Once your account is deleted, all of its resources and data will be permanently deleted.
                                Please
                                enter your password to confirm you would like to permanently delete your account.
                            </p>

                            <div class="mt-6">
                                <InputLabel for="password" value="Password" class="sr-only"/>

                                <TextInput
                                    id="password"
                                    ref="passwordInput"
                                    v-model="form.password"
                                    type="password"
                                    class="mt-1 block w-3/4"
                                    placeholder="Password"
                                    @keyup.enter="deleteUser"
                                />

                                <InputError :message="form.errors.password" class="mt-2"/>
                            </div>

                            <div class="mt-2 flex justify-end">
                                <DangerButton
                                    :class="{ 'opacity-25': form.processing }"
                                    :disabled="form.processing"
                                    @click="deleteUser"
                                >
                                    Delete Account
                                </DangerButton>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</template>



