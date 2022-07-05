<script setup>
import BreezeAuthenticatedLayout from '@/Layouts/Authenticated.vue';
import {Head} from '@inertiajs/inertia-vue3';
</script>

<template>
    <Head title="Dashboard"/>

    <BreezeAuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-white leading-tight">
                Dashboard
            </h2>
        </template>
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 mt-12" v-if="$page.props.flash.message" id="alert">
            <div class="bg-orange-100 border-l-4 border-orange-500 text-orange-700 p-4 sm:rounded-lg relative">
                <p class="font-bold">Failed to connect discord.</p>
                <p>{{ $page.props.flash.message }}</p>
                <span class="absolute top-7 bottom-0 right-4">
                    <svg class="fill-current h-6 w-6 text-orange-500" role="button" xmlns="http://www.w3.org/2000/svg"
                         viewBox="0 0 20 20" onclick="document.getElementById('alert').remove()">
                        <title>Close</title>
                        <path
                            d="M14.348 14.849a1.2 1.2 0 0 1-1.697 0L10 11.819l-2.651 3.029a1.2 1.2 0 1 1-1.697-1.697l2.758-3.15-2.759-3.152a1.2 1.2 0 1 1 1.697-1.697L10 8.183l2.651-3.031a1.2 1.2 0 1 1 1.697 1.697l-2.758 3.152 2.758 3.15a1.2 1.2 0 0 1 0 1.698z"/>
                    </svg>
                </span>
            </div>
        </div>

        <div class="py-12" v-if="!$page.props.auth.user.discord_id">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-secondary text-primary overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 bg-secondary">
                        Looks like you still need to link your
                        <a :href="route('connect.discord')"
                           class="text-white hover:text-accent transition duration-300 ease-in-out">discord account</a>.
                    </div>
                </div>
            </div>
        </div>

        <div class="py-12">
            <div class="max-w-7xl mx-5 md:mx-auto sm:px-6 lg:px-8">
                <div class="bg-secondary text-primary overflow-hidden shadow-sm rounded-lg"
                     :style="{background: `linear-gradient(to top left, rgba(37, 40, 59, 1) 0%, rgba(37, 40, 59, 0.95) 100%), url('${ $page.props.auth.user.avatar }')`}">
                    <div class="p-6 md:flex text-center md:text-start pb-12 md:pb-6">
                        <img class="rounded-full w-24 h-auto mx-auto md:ml-0 md:mr-0" :src="$page.props.auth.user.avatar"
                             alt="{{ $page.props.auth.user.name }}">
                        <div class="user-info ml-5 my-auto">
                            <h1 class="text-white whitespace-nowrap text-2xl font-bold mb-2">
                                {{ $page.props.auth.user.name }}</h1>
                            <p class="text-primary">{{ $page.props.auth.user.discord_id }}</p>
                        </div>
                        <div class="user-rank ml-auto my-auto relative text-center md:text-left">
                            <img class="h-14 mx-auto mt-4 md:mt-0 md:ml-0" src="/imgs/smfc.png" alt="SMFC">
                            <div class="progress-bar h-2 w-100 bg-dark rounded-lg mt-5 md:mt-2">
                                <div class="progress-percent w-2/4 h-2 bg-accent rounded-lg"></div>
                            </div>
                            <p class="absolute progress-from">1900</p>
                            <p class="absolute progress-to">2000</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>


        <div class="max-w-7xl mx-5 md:mx-auto sm:px-6 lg:px-8">
            <h4 class="text-white text-2xl bold mb-12">Your Summary</h4>
            <div class="md:flex">
                <div class="md:w-1/3 md:mx-3 md:ml-0">
                    <div class="bg-secondary text-primary p-6 lg:px-8 rounded-lg text-center">
                        Coming Soon
                    </div>
                </div>
                <div class="mt-3 md:w-1/3 md:mx-3 md:mt-0">
                    <div class="bg-secondary text-primary p-6 lg:px-8 rounded-lg text-center">
                        Coming Soon
                    </div>
                </div>
                <div class="mt-3 md:w-1/3 md:mx-3 md:mr-0 md:mt-0">
                    <div class="bg-secondary text-primary p-6 lg:px-8 rounded-lg text-center">
                        Coming Soon
                    </div>
                </div>
            </div>
        </div>

    </BreezeAuthenticatedLayout>
</template>
