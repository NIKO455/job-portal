<script setup>

import Main from "@/Pages/Front/Layouts/Main.vue";
import {Head, Link} from "@inertiajs/vue3";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import PrimaryButtonOutline from "@/Components/PrimaryButtonOutline.vue";

defineProps({
    jobs: Object
})


</script>

<template>
    <Main>
        <Head title="Job Details"/>
        <section class="section-4 bg-2">
            <div class="container pt-5">
                <div class="row">
                    <div class="col">
                        <nav aria-label="breadcrumb" class=" rounded-3 p-3">
                            <ol class="breadcrumb mb-0">
                                <li class="breadcrumb-item">
                                    <Link :href="route('jobs')"><i class="fa fa-arrow-left" aria-hidden="true"></i>
                                        &nbsp;Back
                                        to Jobs
                                    </Link>
                                </li>
                            </ol>
                        </nav>
                    </div>
                </div>
            </div>
            <div class="container job_details_area">
                <div class="row pb-5">
                    <div class="col-md-8">
                        <div class="card shadow border-0">
                            <div class="job_details_header">
                                <div class="single_jobs white-bg d-flex justify-content-between">
                                    <div class="jobs_left d-flex align-items-center">

                                        <div class="jobs_conetent">
                                            <a href="#">
                                                <h4>{{ jobs[0].title }}</h4>
                                            </a>
                                            <div class="links_locat d-flex align-items-center">
                                                <div class="location">
                                                    <p><i class="fa fa-map-marker"></i> {{ jobs[0].location }}</p>
                                                </div>

                                                <div class="location">
                                                    <p style="text-transform: capitalize;"><i class="fa fa-clock-o"></i>
                                                        {{ jobs[0].job_type_id.name }}</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="jobs_right" v-if="jobs[0].saved_post">
                                        <div class="apply_now saved-heart">
                                            <a class="heart_mark"> <i class="fa fa-heart-o"
                                                                               aria-hidden="true"></i></a>
                                        </div>
                                    </div>
                                    <div class="jobs_right" v-else>
                                        <div class="apply_now">
                                            <a class="heart_mark"> <i class="fa fa-heart-o"
                                                                               aria-hidden="true"></i></a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="descript_wrap white-bg">
                                <div class="single_wrap">
                                    <h4>Job description</h4>
                                    <p>{{ jobs[0].description }}</p>
                                </div>
                                <div class="single_wrap" v-if="jobs[0].responsibility">
                                    <h4>Responsibility</h4>
                                    <p>{{ jobs[0].responsibility }}</p>
                                </div>
                                <div class="single_wrap" v-if="jobs[0].qualification">
                                    <h4>Qualification</h4>
                                    <p>{{ jobs[0].qualification }}</p>
                                </div>
                                <div class="single_wrap" v-if="jobs[0].benefits">
                                    <h4>Benefits</h4>
                                    <p>{{ jobs[0].benefits }}</p>
                                </div>
                                <div class="border-bottom"></div>
                                <div class="pt-3 text-end">
                                    <Link v-if="jobs[0].user_id.id !== ($page.props.auth.user ? $page.props.auth.user.id : true)" :href="route('job.save', jobs[0].id)" method="POST">
                                        <PrimaryButtonOutline>Save</PrimaryButtonOutline>
                                    </Link>
                                    <User
                                        v-if="jobs.length && jobs[0].user_id.id === ($page.props.auth.user ? $page.props.auth.user.id : true)">
                                        <Link :href="route('job.edit', jobs[0].id)">
                                            <PrimaryButton>
                                                Edit Post
                                            </PrimaryButton>
                                        </Link>
                                    </User>
                                    <User v-else-if="$page.props.auth.user">
                                        <Link :href="route('job.apply', jobs[0].id)" method="POST">
                                            <PrimaryButton>
                                                Apply
                                            </PrimaryButton>
                                        </Link>
                                    </User>
                                    <User v-else>
                                        <Link :href="route('login')">
                                            <PrimaryButton>
                                                Login to Apply
                                            </PrimaryButton>
                                        </Link>
                                    </User>

                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card shadow border-0">
                            <div class="job_sumary">
                                <div class="summery_header pb-1 pt-4">
                                    <h3>Job Summery</h3>
                                </div>
                                <div class="job_content pt-3">
                                    <ul>
                                        <li>Published on: <span>{{ jobs[0].created_at }}</span></li>
                                        <li>Vacancy: <span>{{ jobs[0].vacancy }}</span></li>
                                        <li>Salary: <span>{{ jobs[0].salary }}</span></li>
                                        <li>Location: <span>{{ jobs[0].location }}</span></li>
                                        <li style="text-transform: capitalize;">Job Nature:
                                            <span>{{ jobs[0].job_type_id.name }}</span></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="card shadow border-0 my-4">
                            <div class="job_sumary">
                                <div class="summery_header pb-1 pt-4">
                                    <h3>Company Details</h3>
                                </div>
                                <div class="job_content pt-3">
                                    <ul>
                                        <li>Name: <span>{{ jobs[0].company_name }}</span></li>
                                        <li v-if="jobs[0].company_location">Location:
                                            <span>{{ jobs[0].company_location }}</span></li>
                                        <li v-if="jobs[0].company_website">Website:
                                            <span>{{ jobs[0].company_website }}</span></li>
                                    </ul>
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

.saved-heart .heart_mark{
    background-color: #00D363 !important;
    color: white !important;
}
</style>
