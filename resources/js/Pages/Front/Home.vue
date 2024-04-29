<script setup>
import {Head, Link, router} from '@inertiajs/vue3';
import Main from "@/Pages/Front/Layouts/Main.vue";
import {ref} from "vue";
import TextInput from "@/Components/TextInput.vue";

defineProps({
    canLogin: {
        type: Boolean,
    },
    canRegister: {
        type: Boolean,
    },
    laravelVersion: {
        type: String,
        required: true,
    },
    phpVersion: {
        type: String,
        required: true,
    },
    categories:{
        type: Object,
    },
    featured_jobs:{
        type:Object,
    },
    latest_jobs:{
        type:Object,
    }
});

let selectedCategory = ref('')
let keyword = ref('');
let location = ref('');

// Truncate text method
const truncateText = (text, limit) => {
    if (text.length > limit) {
        return text.split(' ').slice(0, limit).join(' ') + '...';
    } else {
        return text;
    }
};

function JobDetail(slug) {
    router.get(`/job/${slug}`)
}

function jobSearch() {
    const querySearch = {}

    if (selectedCategory.value.id !== undefined) {
        querySearch.category = selectedCategory.value.id;
    }

    if (keyword.value) {
        querySearch.keyword = keyword.value;
    }

    if (location.value) {
        querySearch.location = location.value;
    }

    router.get('/jobs', querySearch);
}

</script>

<template>
    <Main>
        <Head title="Welcome" />
        <section class="section-0 lazy d-flex bg-image-style dark align-items-center hero-section">
            <div class="container">
                <div class="row">
                    <div class="col-12 col-xl-8">
                        <h1>Find your dream job</h1>
                        <p>Thousands of jobs available.</p>
                        <div class="banner-btn mt-5"><Link :href="route('jobs')" class="btn btn-primary mb-4 mb-sm-0">Explore Now</Link></div>
                    </div>
                </div>
            </div>
        </section>

        <section class="section-1 py-5 ">
            <div class="container">
                <div class="card border-0 shadow p-5">
                    <form @submit.prevent="jobSearch">
                        <div class="row">
                            <div class="col-md-3 mb-3 mb-sm-3 mb-lg-0">
                                <TextInput type="text" class="form-control"  v-model="keyword" name="search" id="search" placeholder="Keywords"/>
                            </div>
                            <div class="col-md-3 mb-3 mb-sm-3 mb-lg-0">
                                <TextInput type="text" class="form-control"  v-model="location" name="search" id="search" placeholder="Location" />
                            </div>
                            <div class="col-md-3 mb-3 mb-sm-3 mb-lg-0">
                                <div class="dropdown">
                                    <button
                                        class="form-control dropdown-toggle"
                                        type="button"
                                        id="dropdownMenuButton"
                                        data-bs-toggle="dropdown"
                                        aria-expanded="false"
                                        style="text-align: left"
                                    >
                                        {{ selectedCategory.name ?? "Select Category" }}
                                    </button>
                                    <ul
                                        class="dropdown-menu"
                                        aria-labelledby="dropdownMenuButton"
                                        style="width: 100%; max-height: 200px; overflow-y: auto; scrollbar-width: none;"
                                    >
                                        <li
                                            v-for="category in categories"
                                            :key="category.id"
                                            @click="selectedCategory = category"
                                            class="dropdown-item"
                                        >
                                            {{ category.name }}
                                        </li>
                                    </ul>
                                </div>
                            </div>

                            <div class=" col-md-3 mb-xs-3 mb-sm-3 mb-lg-0">
                                <div class="d-grid gap-2">
                                    <button type="submit" class="btn btn-primary btn-block">Search</button>
                                </div>

                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </section>

        <section class="section-2 bg-2 py-5">
            <div class="container">
                <h2>Popular Categories</h2>
                <div class="row pt-5">
                    <div class="col-lg-4 col-xl-3 col-md-6" v-for="category in categories">
                        <div class="single_catagory">
                            <Link><h4 class="pb-2">{{category.name}}</h4></Link>
                            <p class="mb-0"> <span>50</span> Available position</p>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section class="section-3  py-5">
            <div class="container">
                <h2>Featured Jobs</h2>
                <div class="row pt-5">
                    <div class="job_listing_area">
                        <div class="job_lists">
                            <div class="row">
                                <div class="col-md-4" v-for="featured_job in featured_jobs">
                                    <div class="card border-0 p-3 shadow mb-4">
                                        <div class="card-body">
                                            <h3 class="border-0 fs-5 pb-2 mb-0">{{ featured_job.title }}</h3>
                                            <p class="truncate-text">{{ featured_job.description }}</p>
                                            <div class="bg-light p-3 border">
                                                <p class="mb-0">
                                                    <span class="fw-bolder"><i class="fa fa-map-marker"></i></span>
                                                    <span class="ps-1">{{featured_job.location}}</span>
                                                </p>
                                                <p class="mb-0">
                                                    <span class="fw-bolder"><i class="fa fa-clock-o"></i></span>
                                                    <span class="ps-1" style="text-transform: capitalize">{{featured_job.job_type_id.name}}</span>
                                                </p>
                                                <p class="mb-0" v-if="featured_job.salary > 0">
                                                    <span class="fw-bolder"><i class="fa fa-usd"></i></span>
                                                    <span class="ps-1">{{featured_job.salary}}</span>
                                                </p>
                                            </div>

                                            <div class="d-grid mt-3">
                                                <a class="btn btn-primary btn-lg" @click="JobDetail(featured_job.slug)">Details</a>
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

        <section class="section-3 bg-2 py-5">
            <div class="container">
                <h2>Latest Jobs</h2>
                <div class="row pt-5">
                    <div class="job_listing_area">
                        <div class="job_lists">
                            <div class="row">
                                <div class="col-md-4" v-for="latest_job in latest_jobs">
                                    <div class="card border-0 p-3 shadow mb-4">
                                        <div class="card-body">
                                            <h3 class="border-0 fs-5 pb-2 mb-0">{{latest_job.title}}</h3>
                                            <p class="truncate-text">{{latest_job.description}}</p>
                                            <div class="bg-light p-3 border">
                                                <p class="mb-0">
                                                    <span class="fw-bolder"><i class="fa fa-map-marker"></i></span>
                                                    <span class="ps-1">{{latest_job.location}}</span>
                                                </p>
                                                <p class="mb-0">
                                                    <span class="fw-bolder"><i class="fa fa-clock-o"></i></span>
                                                    <span class="ps-1" style="text-transform: capitalize;">{{latest_job.job_type_id.name}}</span>
                                                </p>
                                                <p class="mb-0">
                                                    <span class="fw-bolder"><i class="fa fa-usd"></i></span>
                                                    <span class="ps-1">{{latest_job.salary}}</span>
                                                </p>
                                            </div>

                                            <div class="d-grid mt-3">
                                                <a class="btn btn-primary btn-lg" @click="JobDetail(latest_job.slug)">Details</a>
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
    .hero-section{
        background-image: url("assets/images/banner5.jpg");
    }

    .truncate-text{
        overflow: hidden;
        white-space: nowrap;
        text-overflow: ellipsis;
    }
</style>
