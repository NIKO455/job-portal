<script setup>
import {Link, usePage} from '@inertiajs/vue3';
import PrimaryButtonOutline from "@/Components/PrimaryButtonOutline.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
</script>

<template>
    <header>
        <nav class="navbar navbar-expand-lg navbar-light bg-white shadow py-3">
            <div class="container">
                <Link class="navbar-brand" :href="route('home')">CareerVibe</Link>

                <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                        data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                        aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav ms-0 ms-sm-0 me-auto mb-2 mb-lg-0 ms-lg-4">
                        <li class="nav-item">
                            <Link class="nav-link" :href="route('home')">Home</Link>
                        </li>
                        <li class="nav-item">
                            <Link class="nav-link" :href="route('jobs')">Find Jobs</Link>
                        </li>
                    </ul>
                    <template v-if="$page.url !== '/profile/account' && $page.url !== '/profile' && $page.url !== '/create/job' && $page.url !== '/my_job' ">
                        <template v-if="$page.props.auth.user">
                            <Link :href="route('profile')">
                                <PrimaryButtonOutline>Account</PrimaryButtonOutline>
                            </Link>
                        </template>
                        <template v-else>
                            <Link :href="route('login')">
                                <PrimaryButtonOutline>Login</PrimaryButtonOutline>
                            </Link>
                        </template>
                    </template>
                    <template v-else>
                        <Link :href="route('logout')" method="POST">
                            <PrimaryButtonOutline>Logout</PrimaryButtonOutline>
                        </Link>
                    </template>
                    <Link :href="route('job.create')">
                        <PrimaryButton>Post a Job</PrimaryButton>
                    </Link>

                </div>
            </div>
        </nav>
    </header>
</template>

<style scoped>

</style>
