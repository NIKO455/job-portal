<script setup>
import InputError from '@/Components/InputError.vue';
import {Head, Link, useForm} from '@inertiajs/vue3';
import Main from "@/Pages/Front/Layouts/Main.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import TextInput from "@/Components/TextInput.vue";
import InputLabel from "@/Components/InputLabel.vue";

const form = useForm({
    email: '',
    password: '',
});

const submit = () => {
    form.post(route('login'), {
        onFinish: () => form.reset('password'),
    });
};
</script>

<template>
    <Head title="Log in"/>
    <Main>
        <section class="section-5">
            <div class="container my-5">
                <div class="py-lg-2">&nbsp;</div>
                <div class="row d-flex justify-content-center">
                    <div class="col-md-5">
                        <div class="card shadow border-0 p-5">
                            <h1 class="h3">Login</h1>
                            <form @submit.prevent="submit">
                                <div class="mb-3">
                                    <InputLabel :for="'email'">Email*</InputLabel>
                                    <TextInput
                                        id="email"
                                        type="email"
                                        v-model="form.email"
                                        required
                                        autofocus
                                        autocomplete="email"
                                        placeholder="Enter email"
                                    />
                                    <InputError class="mt-2" :message="form.errors.email"/>

                                </div>
                                <div class="mb-3">
                                    <InputLabel :for="'password'">Password*</InputLabel>
                                    <TextInput
                                        id="password"
                                        type="password"
                                        v-model="form.password"
                                        required
                                        autocomplete="password"
                                        placeholder="Enter password"
                                    />
                                    <InputError class="mt-2" :message="form.errors.password"/>

                                </div>
                                <div class="justify-content-between d-flex">
                                    <PrimaryButton type="submit">Login</PrimaryButton>
                                    <Link
                                        :href="route('password.request')"
                                        class="mt-3"
                                    >
                                        Forgot password?
                                    </Link>
                                </div>


                            </form>
                        </div>
                        <div class="mt-4 text-center">
                            <p>Do not have an account?
                                <Link :href="route('register')">Register</Link>
                            </p>
                        </div>
                    </div>
                </div>
                <div class="py-lg-5">&nbsp;</div>
            </div>
        </section>
    </Main>
</template>

