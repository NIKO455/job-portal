<script setup>
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import TextInput from '@/Components/TextInput.vue';
import {Link, useForm, usePage} from '@inertiajs/vue3';
import PrimaryButton from "@/Components/PrimaryButton.vue";

defineProps({
    mustVerifyEmail: {
        type: Boolean,
    },
    status: {
        type: String,
    },
});

const user = usePage().props.auth.user;

const form = useForm({
    name: user.name,
    email: user.email,
    designation: user.designation,
    mobile: user.mobile
});

const submit = () => {
    form.patch(route('profile.update'), {preserveScroll:true})
}
</script>

<template>
    <section>
        <header>
            <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">Profile Information</h2>

            <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                Update your account's profile information and email address.
            </p>
        </header>

        <form @submit.prevent="submit" class="mt-6 space-y-6">
            <div class="mb-4">
                <InputLabel for="name" value="Name"/>

                <TextInput
                    id="name"
                    type="text"
                    v-model="form.name"
                    required
                    autofocus
                    autocomplete="name"
                    placeholder="Name"
                />

                <InputError class="mt-2" :message="form.errors.name"/>
            </div>

            <div class="mb-4">
                <InputLabel for="email" value="Email"/>

                <TextInput
                    id="email"
                    type="email"
                    v-model="form.email"
                    required
                    placeholder="Email"
                    autocomplete="username"
                />

                <InputError class="mt-2" :message="form.errors.email"/>
            </div>

            <div class="mb-4">
                <InputLabel for="designation" value="Designation"/>

                <TextInput
                    id="designation"
                    type="text"
                    v-model="form.designation"
                    autocomplete="designation"
                    placeholder="Designation"
                />

                <InputError class="mt-2" :message="form.errors.designation"/>
            </div>

            <div class="mb-4">
                <InputLabel for="mobile" value="Mobile"/>

                <TextInput
                    id="mobile"
                    type="tel"
                    v-model="form.mobile"
                    autocomplete="mobile"
                    placeholder="Mobile"
                />

                <InputError class="mt-2" :message="form.errors.mobile"/>
            </div>

            <div v-if="mustVerifyEmail && user.email_verified_at === null">
                <p class="text-sm mt-2 text-gray-800 dark:text-gray-200">
                    Your email address is unverified.
                    <Link
                        :href="route('verification.send')"
                        method="post"
                        as="button"
                        class="underline text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800"
                    >
                        Click here to re-send the verification email.
                    </Link>
                </p>

                <div
                    v-show="status === 'verification-link-sent'"
                    class="mt-2 font-medium text-sm text-green-600 dark:text-green-400"
                >
                    A new verification link has been sent to your email address.
                </div>
            </div>

            <div class="submit-btn">
                <PrimaryButton :disabled="form.processing">Save</PrimaryButton>

                <Transition
                    enter-active-class="transition ease-in-out"
                    enter-from-class="opacity-0"
                    leave-active-class="transition ease-in-out"
                    leave-to-class="opacity-0"
                >
                    <p v-if="form.recentlySuccessful" class="saved-text">Saved.</p>
                </Transition>
            </div>
        </form>
    </section>
</template>

<style scoped>
.submit-btn {
    display: flex;
    align-items: center;
    gap: 3px;
}

.saved-text {
    margin-top: 20px;
    font-size: 14px;
}
</style>
