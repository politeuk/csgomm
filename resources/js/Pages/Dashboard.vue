<script setup>
import BreezeAuthenticatedLayout from '@/Layouts/Authenticated.vue';
import { Head } from '@inertiajs/inertia-vue3';
</script>

<template>
    <Head title="Dashboard" />

    <BreezeAuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-white leading-tight">
                Dashboard
            </h2>
        </template>

        <div class="py-12" v-if="!$page.props.auth.user.discord_id">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-secondary text-primary overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 bg-secondary">
                        Looks like you still need to link your <a href="#" class="text-white hover:text-accent transition duration-300 ease-in-out">discord account</a>.
                    </div>
                </div>
            </div>
        </div>
    </BreezeAuthenticatedLayout>
</template>
