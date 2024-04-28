<script setup>
import InputError from '@/Components/InputError.vue';
import TextInput from '@/Components/TextInput.vue';
import {Head, Link, useForm} from '@inertiajs/vue3';
import Main from "@/Pages/Front/Layouts/Main.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import InputLabel from "@/Components/InputLabel.vue";

const form = useForm({
    name: '',
    email: '',
    password: '',
    password_confirmation: '',
});

const submit = () => {
    form.post(route('register'), {
        onFinish: () => form.reset('password', 'password_confirmation'),
    });
};
</script>

<template>
    <Main>
        <Head title="Register"/>
        <section class="section-5">
            <div class="container my-5">
                <div class="py-lg-2">&nbsp;</div>
                <div class="row d-flex justify-content-center">
                    <div class="col-md-5">
                        <div class="card shadow border-0 p-5">
                            <h1 class="h3">Register</h1>
                            <form @submit.prevent="submit">
                                <div class="mb-3">
                                    <InputLabel :for="'name'">Name*</InputLabel>
                                    <TextInput
                                        id="name"
                                        type="text"
                                        class="mt-1 block w-full"
                                        v-model="form.name"
                                        required
                                        autofocus
                                        autocomplete="name"
                                    />

                                    <InputError class="mt-2" :message="form.errors.name"/>
                                </div>
                                <div class="mb-3">
                                    <InputLabel :for="'email'">Email*</InputLabel>

                                    <TextInput
                                        id="email"
                                        type="email"
                                        class="mt-1 block w-full"
                                        v-model="form.email"
                                        required
                                        autocomplete="username"
                                    />

                                    <InputError class="mt-2" :message="form.errors.email"/>
                                </div>
                                <div class="mb-3">
                                    <InputLabel :for="'password'">Password*</InputLabel>

                                    <TextInput
                                        id="password"
                                        type="password"
                                        class="mt-1 block w-full"
                                        v-model="form.password"
                                        required
                                        autocomplete="new-password"
                                    />

                                    <InputError class="mt-2" :message="form.errors.password"/>
                                </div>
                                <div class="mb-3">
                                    <InputLabel :for="'password_confirmation'"> ConfirmPassword*</InputLabel>

                                    <TextInput
                                        id="password_confirmation"
                                        type="password"
                                        class="mt-1 block w-full"
                                        v-model="form.password_confirmation"
                                        required
                                        autocomplete="new-password"
                                    />

                                    <InputError class="mt-2" :message="form.errors.password_confirmation"/>
                                </div>
                                <PrimaryButton type="submit">
                                    Register
                                </PrimaryButton>
                            </form>
                        </div>
                        <div class="mt-4 text-center">
                            <p>Have an account?
                                <Link :href="route('login')">
                                    Login
                                </Link>
                            </p>

                        </div>
                    </div>
                </div>
            </div>
        </section>
    </Main>
</template>
