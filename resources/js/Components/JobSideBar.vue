<script setup>
import {computed, ref} from "vue";
import {router} from "@inertiajs/vue3";
import PrimaryButtonOutline from "@/Components/PrimaryButtonOutline.vue";

const {job_types, categories} = defineProps({
    job_types: Object,
    categories: Object
})

const experiences = [
    {
        id: 1,
        name: '1 Year'
    },
    {
        id: 2,
        name: '2 Years'
    },
    {
        id: 3,
        name: '3 Years'
    },
    {
        id: 4,
        name: '4 Years'
    },
    {
        id: 5,
        name: '5 Years'
    },
    {
        id: 6,
        name: '6 Years'
    },
    {
        id: 7,
        name: '7 Years'
    },
    {
        id: 8,
        name: '8 Years'
    },
    {
        id: 9,
        name: '9 Years'
    },
    {
        id: 10,
        name: '10 Years'
    },
    {
        id: 11,
        name: '10+ Years'
    },

]

let selectedCategory = ref('')
let categoryValue = ref('')
let experienceValue = ref('')
let selectedExperience = ref('')

let keyword = ref('');
let location = ref('');
let jobTypeID = ref([]);

let queryString = window.location.search;
let urlParams = new URLSearchParams(queryString);

if (urlParams.has('keyword')) {
    keyword = urlParams.get('keyword');
}

if (urlParams.has('location')) {
    location = urlParams.get('location');
}

if (urlParams.has('category')) {
    let id = urlParams.get('category');
    categoryValue = categories[id - 1];
}

if (urlParams.has('experience')) {
    let id = urlParams.get('experience');
    experienceValue = experiences[id - 1];
}

if (urlParams.has('job_type')) {
    const jobTypeValues = urlParams.get('job_type').split(',');
    jobTypeValues.forEach(value => {
        let id = Number(value.trim());
        if (!isNaN(id)) {
            jobTypeID.value.push(id);
        }
    });
}


function hasValue(id) {
    return jobTypeID.value.includes(id);
}

function jobType(id) {
    const index = jobTypeID.value.indexOf(id);
    if (index === -1) {
        jobTypeID.value.push(id);
    } else {
        jobTypeID.value.splice(index, 1);
    }
}



function jobSearch() {
    const queryParams = {};

    if (selectedCategory.value.id !== undefined) {
        queryParams.category = selectedCategory.value.id;
    }

    if (selectedExperience.value.id !== undefined) {
        queryParams.experience = selectedExperience.value.id;
    }

    if (keyword.value) {
        queryParams.keyword = keyword.value;
    }

    if (location.value) {
        queryParams.location = location.value;
    }

    if (jobTypeID.value.length > 0) {
        const jobTypeValues = Array.from(jobTypeID.value);
        queryParams.job_type = jobTypeValues.join(',')
    }

    router.get('/jobs', queryParams);
}



</script>

<template>
    <div class="card border-0 shadow p-4">
        <form @submit.prevent="jobSearch">
            <div class="mb-4">
                <h2>Keywords</h2>
                <input type="text" placeholder="Keywords" v-model="keyword" class="form-control shadow-none">
            </div>

            <div class="mb-4">
                <h2>Location</h2>
                <input type="text" placeholder="Location" v-model="location" class="form-control shadow-none">
            </div>

            <div class="mb-4">
                <h2>Category</h2>
                <div class="dropdown">
                    <button
                        class="form-control dropdown-toggle"
                        type="button"
                        id="dropdownMenuButton"
                        data-bs-toggle="dropdown"
                        aria-expanded="false"
                        style="text-align: left"
                    >
                        {{ selectedCategory.name ?? categoryValue.name ?? "Select Category" }}
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

            <div class="mb-4">
                <h2>Job Type</h2>
                <div class="form-check mb-2" v-for="job_type in job_types" :key="job_type.id">
                    <input class="form-check-input shadow-none" name="job_type" type="checkbox"
                           :id="'job_type_' + job_type.id"
                           @change="jobType(job_type.id)"
                           :checked="hasValue(job_type.id)"
                    >

                    <label class="form-check-label" :for="'job_type_' + job_type.id"
                           style="text-transform: capitalize;">{{ job_type.name.replace('_',' ') }}</label>
                </div>
            </div>


            <div class="mb-4">
                <h2>Experience</h2>
                <div class="dropdown">
                    <button
                        class="form-control dropdown-toggle"
                        type="button"
                        id="dropdownMenuButton"
                        data-bs-toggle="dropdown"
                        aria-expanded="false"
                        style="text-align: left"
                    >
                        {{ selectedExperience.name ?? experienceValue.name ?? "Select Experience" }}
                    </button>
                    <ul
                        class="dropdown-menu"
                        aria-labelledby="dropdownMenuButton"
                        style="width: 100%; max-height: 200px; overflow-y: auto; scrollbar-width: none;"
                    >
                        <li
                            v-for="experience in experiences"
                            :key="experience.id"
                            @click="selectedExperience = experience"
                            class="dropdown-item"
                        >
                            {{ experience.name }}
                        </li>
                    </ul>
                </div>
            </div>

            <div class="d-flex align-items-center justify-content-center">
                <button class="btn btn-primary">Search</button>
            </div>
        </form>
    </div>
</template>

<style scoped>
.dropdown-toggle:focus, input:focus {
    border: 1px solid #5beb5b;
}

.d-flex button {
    width: 100%;
}
</style>
