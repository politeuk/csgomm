<script setup>
    import BreezeAuthenticatedLayout from '@/Layouts/Authenticated.vue';
    import {
        Head
    } from '@inertiajs/inertia-vue3';
</script>

<template>

    <Head title="Users" />

    <BreezeAuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-white leading-tight">
                Users
            </h2>
        </template>

        <div class="container max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="py-8">
                <div class="-mx-4 sm:-mx-8 px-4 sm:px-8 py-4 overflow-x-auto">
                    <div class="inline-block min-w-full shadow rounded-lg overflow-hidden">
                        <table class="min-w-full leading-normal">
                            <thead>
                                <tr>
                                    <th scope="col"
                                        class="px-5 py-3 bg-secondary  border-b border-gray-200 text-primary  text-left text-sm uppercase font-normal">
                                        User
                                    </th>
                                    <th scope="col"
                                        class="px-5 py-3 bg-secondary border-b border-gray-200 text-primary  text-left text-sm uppercase font-normal">
                                        Rank
                                    </th>
                                    <th scope="col"
                                        class="px-5 py-3 bg-secondary border-b border-gray-200 text-primary  text-left text-sm uppercase font-normal">
                                        Created at
                                    </th>
                                    <th scope="col"
                                        class="px-5 py-3 bg-secondary border-b border-gray-200 text-primary  text-left text-sm uppercase font-normal">
                                        Status
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="user in users.data" :key="user.id">
                                    <td class="px-5 py-5 border-b border-gray-200 bg-secondary text-sm">
                                        <div class="flex items-center">
                                            <div class="flex-shrink-0">
                                                <a href="/" class="block relative text-accent" :class="{ verified: user.discord_id }">
                                                    <img alt="profil" v-bind:src="user.avatar"
                                                        class="mx-auto object-cover rounded-full h-10 w-10" />
                                                </a>
                                            </div>
                                            <div class="ml-3">
                                                <p class="text-white whitespace-no-wrap mb-1">
                                                    {{ user.name }}
                                                </p>
                                                <p class="text-primary text-xs whitespace-no-wrap">
                                                    {{ user.id }}
                                                </p>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-5 py-5 border-b border-gray-200 bg-secondary text-sm">
                                        <p class="text-primary whitespace-no-wrap">
                                            Global Elite
                                        </p>
                                    </td>
                                    <td class="px-5 py-5 border-b border-gray-200 bg-secondary text-sm">
                                        <p class="text-primary whitespace-no-wrap">
                                            {{ new Date(user.created_at).toLocaleString('en-GB') }}
                                        </p>
                                    </td>
                                    <td class="px-5 py-5 border-b border-gray-200 bg-secondary text-sm">
                                        <span class="relative inline-block px-3 py-1 text-accent leading-tight">
                                            <span aria-hidden="true"
                                                class="absolute inset-0 bg-accent opacity-25 rounded-full" />
                                            <span class="relative uppercase text-xs">
                                                Online
                                            </span>
                                        </span>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </BreezeAuthenticatedLayout>
</template>

<script>
    export default {
        name: "Users",
        props: {
            users: Object
        }
    }
</script>
