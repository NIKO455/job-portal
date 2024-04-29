<script setup>

import {Head, router} from "@inertiajs/vue3";
import Main from "@/Pages/Front/Layouts/Main.vue";
import JobSideBar from "@/Components/JobSideBar.vue";
import {ref} from "vue";

defineProps({
    job_types: Object,
    categories: Object,
    jobs: Object
})

function JobDetail(slug) {
    router.get(`/job/${slug}`)
}

let sort = ref(1);
let queryString = window.location.search;
let urlParams = new URLSearchParams(queryString);


if (urlParams.has('sort')) {
    sort = urlParams.get('sort');
}


function sortJob(event) {
    // Get the existing query parameters from the URL
    const queryString = window.location.search;
    const urlParams = new URLSearchParams(queryString);
    const queryParams = {};

    // Copy existing query parameters to the new object
    for (const [key, value] of urlParams.entries()) {
        queryParams[key] = value;
    }

    // Update the sort parameter based on the selected value
    if (event.target.value === 'Oldest') {
        queryParams.sort = 0;
    } else if (event.target.value === 'Latest') {
        queryParams.sort = 1;
    }

    // Use router to navigate to the URL with updated query parameters
    router.get('/jobs', queryParams);
}



</script>

<template>
    <Main>
        <Head title="Welcome"/>
        <section class="section-3 py-5 bg-2 ">
            <div class="container">
                <div class="row">
                    <div class="col-6 col-md-10 ">
                        <h2>Find Jobs</h2>
                    </div>
                    <div class="col-6 col-md-2">
                        <div class="align-end">
                            <select name="sort" id="sort" class="form-control shadow-none" @change="sortJob($event)">
                                <option :selected="sort == 1">Latest</option>
                                <option :selected="sort == 0">Oldest</option>
                            </select>
                        </div>
                    </div>
                </div>

                <div class="row pt-5">
                    <div class="col-md-4 col-lg-3 sidebar mb-4">
                        <JobSideBar :job_types="job_types" :categories="categories"/>
                    </div>
                    <div class="col-md-8 col-lg-9 ">
                        <div class="job_listing_area">
                            <div class="job_lists">
                                <div class="row">
                                    <div class="col-md-4" v-for="job in jobs.data">
                                        <div class="card border-0 p-3 shadow mb-4">
                                            <div class="card-body">
                                                <h3 class="border-0 fs-5 pb-2 mb-0">{{ job.title }}</h3>
                                                <p class="truncate-text">{{ job.description }}</p>
                                                <div class="bg-light p-3 border">
                                                    <p class="mb-0">
                                                        <span class="fw-bolder"><i class="fa fa-map-marker"></i></span>
                                                        <span class="ps-1">{{ job.location }}</span>
                                                    </p>
                                                    <p class="mb-0">
                                                        <span class="fw-bolder"><i class="fa fa-clock-o"></i></span>
                                                        <span class="ps-1" style="text-transform: capitalize;">{{
                                                                job.job_type_id.name.replace('_', ' ')
                                                            }}</span>
                                                    </p>
                                                    <p class="mb-0">
                                                        <span class="fw-bolder"><i class="fa fa-usd"></i></span>
                                                        <span class="ps-1">{{ job.salary }}</span>
                                                    </p>
                                                </div>

                                                <div class="d-grid mt-3">
                                                    <a class="btn btn-primary btn-lg" @click="JobDetail(job.slug)">Details</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </section>
    </Main>
</template>

<style scoped>
.truncate-text {
    overflow: hidden;
    white-space: nowrap;
    text-overflow: ellipsis;
}

select:focus {
    border: 1px solid #5beb5b;
}

</style>
