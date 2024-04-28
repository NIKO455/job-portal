<script setup>
import {defineProps} from "vue";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import {Head, Link, router} from "@inertiajs/vue3";
import Main from "@/Pages/Front/Layouts/Main.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";

defineProps({
    user: Object,
    job_posts: Object
});

import Pagination from "@/Components/Pagination.vue";

function RemoveJob(id) {
    router.delete(`/job-save/delete/${id}`)
}

function JobDetail(slug) {
    router.get(`/job/${slug}`)
}

</script>

<template>
    <Head title="Profile"/>
    <Main>
        <AuthenticatedLayout :user="user">
            <div class="card border-0 shadow mb-4 p-4">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div>
                            <h3 class="fs-4 mb-1">Saved Jobs</h3>
                        </div>
                        <div style="margin-top: -10px">
                            <Link :href="route('job.create')">
                                <PrimaryButton>Post a Job</PrimaryButton>
                            </Link>
                        </div>
                    </div>
                    <div class="table-responsive">
                        <table class="table">
                            <thead class="bg-light">
                            <tr>
                                <th scope="col">Title</th>
                                <th scope="col">Job Created</th>
                                <th scope="col">Applicants</th>
                                <th scope="col">Status</th>
                                <th scope="col">Action</th>
                            </tr>
                            </thead>
                            <tbody class="border-0" v-if="job_posts.data.length > 0" v-for="job_post in job_posts.data">
                            <tr class="active">
                                <td>
                                    <div class="job-name fw-500">
                                        {{ job_post.title }}
                                    </div>
                                    <div class="info1">
                                        <span>{{ job_post.job_type_id.name.replace('_', ' ') }}</span> .
                                        {{ job_post.location }}
                                    </div>
                                </td>
                                <td>{{ job_post.created_at }}</td>
                                <td>{{job_post.application_count}}</td>
                                <td>
                                    <div v-if="job_post.status" class="job-status text-capitalize badge badge-success">
                                        Active
                                    </div>
                                    <div v-else class="job-status text-capitalize badge badge-danger">
                                        Inactive
                                    </div>
                                </td>
                                <td>
                                    <div class="action-dots float-end">
                                        <a
                                            class=""
                                            data-bs-toggle="dropdown"
                                            aria-expanded="false"
                                        >
                                            <i
                                                class="fa fa-ellipsis-v"
                                                aria-hidden="true"
                                            ></i>
                                        </a>
                                        <ul
                                            class="dropdown-menu dropdown-menu-end"
                                        >
                                            <li>
                                                <Link
                                                    class="dropdown-item"
                                                    @click="JobDetail(job_post.slug)"
                                                >
                                                    <i
                                                        class="fa fa-eye"
                                                        aria-hidden="true"
                                                    ></i>
                                                    View</Link
                                                >
                                            </li>
                                            <li>
                                                <a
                                                    class="dropdown-item"
                                                    @click="RemoveJob(job_post.id)"
                                                ><i
                                                    class="fa fa-trash"
                                                    aria-hidden="true"
                                                ></i>
                                                    Remove</a
                                                >
                                            </li>
                                        </ul>
                                    </div>
                                </td>
                            </tr>
                            </tbody>
                            <tbody class="border-0" v-else>
                            No data Found
                            </tbody>
                        </table>
                        <Pagination :pagination="job_posts.meta"/>
                    </div>
                </div>
            </div>
        </AuthenticatedLayout>
    </Main>
</template>

<style scoped>
.badge {
    display: inline-block;
    font-size: 11px;
    font-weight: 600;
    padding: 3px 6px;
    border: 1px solid transparent;
    min-width: 10px;
    line-height: 1;
    color: #fff;
    text-align: center;
    white-space: nowrap;
    vertical-align: middle;
    border-radius: 99999px
}

.badge.badge-success {
    background-color: rgb(32, 132, 32);
}

.badge.badge-danger {
    background-color: #ef1c1c
}

.info1 span {
    font-size: 16px;
    text-transform: capitalize;
}
</style>
