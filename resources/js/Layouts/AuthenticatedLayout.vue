<script setup>
import {Link, useForm, usePage} from '@inertiajs/vue3';
import {ref} from "vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";

const user = defineProps({
    user:Object
})

const authUser = usePage().props.auth.user
const avatarImageSrc = ref('')

const imageForm = useForm({
    avatar: authUser.image
});

function onAvatarChange(event) {
    imageForm.avatar = event.target.files[0];
    if(avatarImageSrc){
        const reader = new FileReader()
        reader.onload = () =>{
            avatarImageSrc.value = reader.result;
        }

        reader.readAsDataURL(imageForm.avatar)
    }
}

const submit = () => {
    imageForm.post(route('profile.avatar', authUser.id));
    $('#exampleModal').modal('hide');
};

</script>

<template>
    <div>
        <div class="min-h-screen bg-gray-100 dark:bg-gray-900">
            <section class="section-5 bg-2">
                <div class="container py-5">
                    <div class="row">
                        <div class="col">
                            <nav aria-label="breadcrumb" class=" rounded-3 p-3 mb-4">
                                <ol class="breadcrumb mb-0">
                                    <Link :href="route('home')" class="breadcrumb-item">Home</Link>
                                    <li class="breadcrumb-item active">Account Settings</li>
                                </ol>
                            </nav>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-3">
                            <div class="card border-0 shadow mb-4 p-3">
                                <div class="s-body text-center mt-3">
                                    <img :src="avatarImageSrc || user.user.image|| 'assets/assets/images/avatar7.png'"
                                         alt="avatar"
                                         class="rounded-circle img-fluid"
                                         style="width: 150px; height: 150px; object-fit: cover;">

                                    <h5 class="mt-3 pb-0">{{ user.user.name }}</h5>
                                    <p class="text-muted mb-1 fs-6">Full Stack Developer</p>
                                    <div class="d-flex justify-content-center mb-2">
                                        <button data-bs-toggle="modal" data-bs-target="#exampleModal" type="button"
                                                class="btn btn-primary">Change Profile Picture
                                        </button>
                                    </div>
                                </div>
                            </div>
                            <div class="card account-nav border-0 shadow mb-4 mb-lg-0">
                                <div class="card-body p-0">
                                    <ul class="list-group list-group-flush ">
                                        <li class="list-group-item d-flex justify-content-between p-3">
                                            <Link :href="route('profile')">Profile</Link>
                                        </li>
                                        <li class="list-group-item d-flex justify-content-between align-items-center p-3">
                                            <Link :href="route('job.create')">Post a Job</Link>
                                        </li>
                                        <li class="list-group-item d-flex justify-content-between align-items-center p-3">
                                            <Link :href="route('job.index')">My Jobs</Link>
                                        </li>
                                        <li class="list-group-item d-flex justify-content-between align-items-center p-3">
                                            <Link :href="route('job.apply.index')">Jobs Applied</Link>
                                        </li>
                                        <li class="list-group-item d-flex justify-content-between align-items-center p-3">
                                            <Link :href="route('job.save.index')">Saved Jobs</Link>
                                        </li>
                                        <li class="list-group-item d-flex justify-content-between p-3">
                                            <Link :href="route('profile.edit')">Account Settings</Link>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-9">
                            <slot/>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </div>

    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title pb-0" id="exampleModalLabel">Change Profile Picture</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form @submit.prevent="submit">
                        <div class="mb-3">
                            <label for="exampleInputEmail1" class="form-label">Profile Image</label>
                            <input type="file" class="form-control" id="image"  name="image" @change="onAvatarChange">
                        </div>
                        <div class="d-flex justify-content-end gap-3">
                            <button type="button" class="btn btn-outline-primary" data-bs-dismiss="modal">Close</button>
                            <PrimaryButton>Update</PrimaryButton>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</template>
