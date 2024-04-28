<script setup>
import {defineProps, ref} from 'vue';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import {Head, useForm} from '@inertiajs/vue3';
import Main from "@/Pages/Front/Layouts/Main.vue";
import InputError from "@/Components/InputError.vue";
import InputLabel from "@/Components/InputLabel.vue";
import TextInput from "@/Components/TextInput.vue";
import AreaInput from "@/Components/AreaInput.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";



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

const {user,post, job_types, categories} = defineProps({
    user: Object,
    post:Object,
    job_types: Object,
    categories: Object,
})
let selectedCategory = ref(categories[post.category_id])
let selectedJobType = ref(job_types[post.job_type_id])
let selectedExperience = ref(post.experience)


const form = useForm({
    title: post.title,
    category_id: '',
    job_type_id: '',
    vacancy: post.vacancy,
    salary: post.salary,
    location: post.location,
    description: post.description,
    benefits: post.benefits,
    responsibility: post.responsibility,
    qualification: post.qualification,
    keywords: post.keywords,
    experience: post.experience,
    company_name: post.company_name,
    company_location: post.company_location,
    company_website: post.company_website,
});


const submit = () => {
    form.category_id = selectedCategory.value.id;
    form.job_type_id = selectedJobType.value.id;
    form.experience = selectedExperience.value.name ?? selectedExperience;
    form.post(route('job.update',post.id), {
        onSuccess: () => {
            form.reset();
            selectedExperience = '';
            selectedCategory = '';
            selectedJobType = '';
        },
    });
};



</script>

<template>
    <Head title="Profile"/>
    <Main>
        <AuthenticatedLayout :user="user">
            <div class="card border-0 shadow mb-4">
                <div class="card-body">
                    <form @submit.prevent="submit">
                        <div class="card-body card-form p-4">
                            <h3 class="fs-4 mb-1">Job Details</h3>
                            <div class="row">
                                <div class="col-md-6 mb-4">
                                    <InputLabel :for="'title'">Title <span id="important">*</span></InputLabel>
                                    <TextInput
                                        id="title"
                                        type="text"
                                        v-model="form.title"
                                        autofocus
                                        required
                                        autocomplete="title"
                                        placeholder="Job Title"
                                    />
                                    <InputError class="mt-2" :message="form.errors.title"/>
                                </div>

                                <div class="col-md-6  mb-4">
                                    <InputLabel :for="'category'">Category <span id="important">*</span></InputLabel>
                                    <div class="dropdown">
                                        <button
                                            class="form-control dropdown-toggle"
                                            type="button"
                                            id="dropdownMenuButton"
                                            data-bs-toggle="dropdown"
                                            aria-expanded="false"
                                            style="text-align: left"
                                        >
                                        {{ selectedCategory.name ?? 'Select Job Type' }}
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
                                    <InputError class="mt-2" :message="form.errors.category_id"/>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6 mb-4">
                                    <InputLabel :for="'job_type'">Job Type <span id="important">*</span></InputLabel>

                                    <div class="dropdown">
                                        <button
                                            class="form-control dropdown-toggle"
                                            type="button"
                                            id="dropdownMenuButton"
                                            data-bs-toggle="dropdown"
                                            aria-expanded="false"
                                            style="text-align: left; text-transform: capitalize;"
                                        >
                                            {{ selectedJobType.name.replace('_',' ')  ?? 'Select Job Type' }}
                                        </button>
                                        <ul
                                            class="dropdown-menu"
                                            aria-labelledby="dropdownMenuButton"
                                            style="width: 100%; max-height: 200px; overflow-y: auto; scrollbar-width: none;"
                                        >
                                            <li
                                                v-for="job in job_types"
                                                :key="job.name"
                                                @click="selectedJobType = job"
                                                class="dropdown-item"
                                                style="text-transform: capitalize;"
                                            >
                                                {{ job.name.replace('_',' ') }}
                                            </li>
                                        </ul>
                                    </div>
                                    <InputError class="mt-2" :message="form.errors.job_type_id"/>

                                </div>
                                <div class="col-md-6  mb-4">
                                    <InputLabel :for="'vacancy'">Vacancy <span id="important">*</span></InputLabel>
                                    <TextInput
                                        id="vacancy"
                                        type="number"
                                        v-model="form.vacancy"
                                        required
                                        placeholder="Vacancy"
                                    />
                                    <InputError class="mt-2" :message="form.errors.vacancy"/>
                                </div>
                            </div>
                            <div class="row">
                                <div class="mb-4 col-md-6">
                                    <InputLabel :for="'salary'">Salary</InputLabel>
                                    <TextInput
                                        id="salary"
                                        type="text"
                                        v-model="form.salary"
                                        autocomplete="salary"
                                        placeholder="Salary"
                                    />
                                    <InputError class="mt-2" :message="form.errors.salary"/>

                                </div>

                                <div class="mb-4 col-md-6">
                                    <InputLabel :for="'location'">Location <span id="important">*</span></InputLabel>
                                    <TextInput
                                        id="location"
                                        type="text"
                                        v-model="form.location"
                                        required
                                        autocomplete="location"
                                        placeholder="Location"
                                    />
                                    <InputError class="mt-2" :message="form.errors.location"/>
                                </div>
                            </div>
                            <div class="mb-4">
                                <InputLabel :for="'description'">Description <span id="important">*</span></InputLabel>
                                <AreaInput
                                    id="description"
                                    type="text"
                                    v-model="form.description"
                                    required
                                    autocomplete="description"
                                    placeholder="Description"
                                />
                                <InputError class="mt-2" :message="form.errors.description"/>
                            </div>
                            <div class="mb-4">
                                <InputLabel :for="'benefits'">Benefits</InputLabel>
                                <AreaInput
                                    id="benefits"
                                    type="text"
                                    v-model="form.benefits"
                                    autocomplete="benefits"
                                    placeholder="Benefits"
                                />
                                <InputError class="mt-2" :message="form.errors.benefits"/>
                            </div>
                            <div class="mb-4">
                                <InputLabel :for="'responsibility'">Responsibility
                                </InputLabel>
                                <AreaInput
                                    id="responsibility"
                                    type="text"
                                    v-model="form.responsibility"
                                    autocomplete="responsibility"
                                    placeholder="Responsibility"
                                />
                                <InputError class="mt-2" :message="form.errors.responsibility"/>
                            </div>
                            <div class="mb-4">
                                <InputLabel :for="'qualifications'">Qualifications
                                </InputLabel>
                                <AreaInput
                                    id="qualifications"
                                    type="text"
                                    v-model="form.qualification"
                                    autocomplete="qualification"
                                    placeholder="Qualifications"
                                />
                                <InputError class="mt-2" :message="form.errors.qualification"/>
                            </div>
                            <div class="mb-4">
                                <InputLabel :for="'experience'">Experience <span id="important">*</span></InputLabel>

                                <div class="dropdown">
                                    <button
                                        class="form-control dropdown-toggle"
                                        type="button"
                                        id="dropdownMenuButton"
                                        data-bs-toggle="dropdown"
                                        aria-expanded="false"
                                        style="text-align: left"
                                    >
                                        {{ selectedExperience.name ?? selectedExperience ?? "Select Experience" }}
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
                                <InputError class="mt-2" :message="form.errors.experience"/>

                            </div>
                            <div class="mb-4">
                                <InputLabel :for="'keywords'">Keywords</InputLabel>
                                <TextInput
                                    id="keywords"
                                    type="text"
                                    v-model="form.keywords"
                                    autocomplete="keywords"
                                    placeholder="Keywords"
                                />
                                <InputError class="mt-2" :message="form.errors.keywords"/>
                            </div>


                            <h3 class="fs-4 mb-1 mt-5 border-top pt-5">Company Details</h3>
                            <div class="row">
                                <div class="mb-4 col-md-6">
                                    <InputLabel :for="'company_name'">Company Name <span id="important">*</span>
                                    </InputLabel>
                                    <TextInput
                                        id="company_name"
                                        type="text"
                                        v-model="form.company_name"
                                        required
                                        autocomplete="company_name"
                                        placeholder="Company Name"
                                    />
                                    <InputError class="mt-2" :message="form.errors.company_name"/>
                                </div>

                                <div class="mb-4 col-md-6">
                                    <InputLabel :for="'location'">Location</InputLabel>
                                    <TextInput
                                        id="location"
                                        type="text"
                                        v-model="form.company_location"
                                        autocomplete="company_location"
                                        placeholder="Location"
                                    />
                                    <InputError class="mt-2" :message="form.errors.company_location"/>
                                </div>
                            </div>
                            <div>
                                <InputLabel :for="'website'">Website</InputLabel>
                                <TextInput
                                    id="website"
                                    type="url"
                                    v-model="form.company_website"
                                    autocomplete="company_website"
                                    placeholder="Website"
                                />
                                <InputError class="mt-2" :message="form.errors.company_website"/>
                            </div>
                        </div>
                        <div class="p-4">
                            <PrimaryButton as="button">Save Job</PrimaryButton>
                        </div>
                    </form>
                </div>
            </div>
        </AuthenticatedLayout>
    </Main>

</template>

<style scoped>
#important {
    color: red;
}

.dropdown-toggle {
    width: 100%;
    border: 1px solid #e8e3e3;
}

.dropdown-toggle:focus {
    border: 1px solid #5beb5b;
}

.cross-div {
    padding: 5px;
    cursor: pointer;
    transition: .1s ease-in-out;
}

.cross-div:hover{
    background-color: rgba(55, 55, 218, 0.78);
    border-radius: 2px;
    color: whitesmoke;

}

.cross-icon {
    height: 20px;
    width: 20px;
    margin-top: -5px;
}
</style>
