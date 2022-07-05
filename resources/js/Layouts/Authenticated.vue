<script setup>
import echo from '@/Services/socket';
import {
    ref
} from 'vue';
import {
    usePage,
    Link
} from '@inertiajs/inertia-vue3';
import BreezeApplicationLogo from '@/Components/ApplicationLogo.vue';
import BreezeDropdown from '@/Components/Dropdown.vue';
import BreezeDropdownLink from '@/Components/DropdownLink.vue';
import BreezeNavLink from '@/Components/NavLink.vue';
import BreezeResponsiveNavLink from '@/Components/ResponsiveNavLink.vue';
import {
    TransitionRoot,
    TransitionChild,
    Dialog,
    DialogPanel,
    DialogTitle,
} from '@headlessui/vue';
import {
    useStopwatch
} from 'vue-timer-hook';
import BreezeButton from '@/Components/Button.vue';

import {
    Inertia
} from '@inertiajs/inertia'

const showingNavigationDropdown = ref(false);

let user = usePage().props.value.auth.user;

var uptime = 0

const stopwatch = useStopwatch(true);
stopwatch.reset(uptime, true)

var mins = stopwatch.minutes;
var secs = stopwatch.seconds;

function playSound(sound) {
    if(sound) {
        var audio = new Audio(sound);
        audio.play();
    }
}

const isOpen = ref(false);

function queuePop() {
    playSound('/sounds/ready.mp3');
    isOpen.value = true
}

// console.log(user.queue.queue_id);
if (user.queue) {
    echo().private(`queues.${user.queue.queue_id}`)
        .listen('QueuePop', (e) => {
            console.log(e);
            queuePop()
        });
}

const props = defineProps({
    mins: String,
    secs: String,
    notActive: false,
})

function joinQueue(event) {

    Inertia.post(route('dashboard.queue'), {}, {
        onSuccess(page) {
            user = page.props.auth.user;
            echo().private(`queues.${page.props.auth.user.queue.queue_id}`)
                .listen('QueuePop', (e) => {
                    console.log(e);
                    queuePop()
                });
        }
    });
    stopwatch.reset(uptime, true);
}

function leaveQueue(event) {
    echo().leave(`queues.${user.queue.queue_id}`)
    Inertia.delete(route('dashboard.queue.remove', event), {}, {
        onSuccess(page) {

        }
    });
}

</script>

<template>
    <TransitionRoot appear :show="isOpen" as="template">
        <Dialog as="div" @close="closeModal" class="relative z-10">
            <div class="fixed inset-0 bg-black/30" aria-hidden="true"/>
            <TransitionChild as="template" enter="duration-300 ease-out" enter-from="opacity-0" enter-to="opacity-100"
                             leave="duration-200 ease-in" leave-from="opacity-100" leave-to="opacity-0">
                <div class="fixed inset-0 bg-black bg-opacity-25"/>
            </TransitionChild>

            <div class="fixed inset-0 overflow-y-auto">
                <div class="flex min-h-full items-center justify-center p-4 text-center">
                    <TransitionChild as="template" enter="duration-300 ease-out" enter-from="opacity-0 scale-95"
                                     enter-to="opacity-100 scale-100" leave="duration-200 ease-in"
                                     leave-from="opacity-100 scale-100"
                                     leave-to="opacity-0 scale-95">
                        <DialogPanel
                            class="w-full max-w-md transform overflow-hidden rounded-2xl bg-secondary p-6 text-left align-middle shadow-xl transition-all">
                            <DialogTitle as="h3" class="text-lg font-medium leading-6 text-primary text-center">
                                Your Match is Ready
                            </DialogTitle>
                            <div class="my-4">
                                <div class="flex justify-center" id="readied">
                                    <span class="isReady active"></span>
                                    <span class="isReady active"></span>
                                    <span class="isReady active"></span>
                                    <span class="isReady active"></span>
                                    <span class="isReady active"></span>
                                    <span class="isReady active"></span>
                                    <span class="isReady active"></span>
                                    <span class="isReady"></span>
                                    <span class="isReady"></span>
                                    <span class="isReady"></span>
                                </div>
                            </div>

                            <div class="text-center mt-6">
                                <BreezeButton :type="button" id="readyup">
                                    Read Up
                                </BreezeButton>
                            </div>
                        </DialogPanel>
                    </TransitionChild>
                </div>
            </div>
        </Dialog>
    </TransitionRoot>
    <div>
        <div class="min-h-screen bg-dark">
            <nav class="bg-secondary border-b border-dark">
                <!-- Primary Navigation Menu -->
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                    <div class="flex justify-between h-16">
                        <div class="flex">
                            <!-- Logo -->
                            <div class="shrink-0 flex items-center">
                                <Link :href="route('dashboard')">
                                    <BreezeApplicationLogo class="block h-9 w-auto"/>
                                </Link>
                            </div>

                            <!-- Navigation Links -->
                            <div class="hidden space-x-8 sm:-my-px sm:ml-10 sm:flex">
                                <BreezeNavLink :href="route('dashboard')" :active="route().current('dashboard')">
                                    Dashboard
                                </BreezeNavLink>
                            </div>
                            <div class="hidden space-x-8 sm:ml-10 sm:flex">
                                <BreezeNavLink :href="route('dashboard.users')"
                                               :active="route().current('dashboard.users')">
                                    Users
                                </BreezeNavLink>
                            </div>
                        </div>

                        <div class="hidden sm:flex sm:items-center sm:ml-6">
                            <!-- Settings Dropdown -->
                            <div class="ml-3 relative">
                                <BreezeDropdown align="right" width="48">
                                    <template #trigger>
                                        <span class="inline-flex rounded-md">
                                            <button type="button"
                                                    class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-white bg-secondary hover:text-white focus:outline-none transition ease-in-out duration-150">
                                                {{ $page.props.auth.user.name }}

                                                <svg class="ml-2 -mr-0.5 h-4 w-4" xmlns="http://www.w3.org/2000/svg"
                                                     viewBox="0 0 20 20" fill="currentColor">
                                                    <path fill-rule="evenodd"
                                                          d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                                          clip-rule="evenodd"/>
                                                </svg>
                                            </button>
                                        </span>
                                    </template>

                                    <template #content>
                                        <BreezeDropdownLink :href="route('logout')" method="post" as="button">
                                            Log Out
                                        </BreezeDropdownLink>
                                    </template>
                                </BreezeDropdown>
                            </div>
                        </div>

                        <!-- Hamburger -->
                        <div class="-mr-2 flex items-center sm:hidden">
                            <button @click="showingNavigationDropdown = ! showingNavigationDropdown"
                                    class="inline-flex items-center justify-center p-2 rounded-md text-white hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 focus:text-gray-500 transition duration-150 ease-in-out">
                                <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                                    <path
                                        :class="{'hidden': showingNavigationDropdown, 'inline-flex': ! showingNavigationDropdown }"
                                        stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M4 6h16M4 12h16M4 18h16"/>
                                    <path
                                        :class="{'hidden': ! showingNavigationDropdown, 'inline-flex': showingNavigationDropdown }"
                                        stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M6 18L18 6M6 6l12 12"/>
                                </svg>
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Responsive Navigation Menu -->
                <div :class="{'block': showingNavigationDropdown, 'hidden': ! showingNavigationDropdown}"
                     class="sm:hidden">
                    <div class="pt-2 pb-3 space-y-1">
                        <BreezeResponsiveNavLink :href="route('dashboard')" :active="route().current('dashboard')">
                            Dashboard
                        </BreezeResponsiveNavLink>

                        <BreezeResponsiveNavLink :href="route('dashboard.users')"
                                                 :active="route().current('dashboard.users')">
                            Users
                        </BreezeResponsiveNavLink>
                    </div>

                    <!-- Responsive Settings Options -->
                    <div class="pt-4 pb-1 border-t border-primary">
                        <div class="px-4">
                            <div class="font-medium text-base text-white">{{ $page.props.auth.user.name }}</div>
                            <div class="font-medium text-sm text-accent">{{ $page.props.auth.user.email }}</div>
                        </div>

                        <div class="mt-3 space-y-1">
                            <BreezeResponsiveNavLink :href="route('logout')" method="post" as="button">
                                Log Out
                            </BreezeResponsiveNavLink>
                        </div>
                    </div>
                </div>
            </nav>

            <!-- Page Heading -->
            <header class="bg-secondary shadow" v-if="$slots.header">
                <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8 flex justify-between">
                    <div class="my-auto">
                        <slot name="header" class="my-auto"/>
                    </div>
                    <div v-if="!$page.props.auth.user.queue">
                        <BreezeButton @click="joinQueue()" :type="button" id="queue">
                            <svg class="w-5 h-5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                 xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z">
                                </path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            <span class="my-auto">
                                Join Queue
                            </span>
                        </BreezeButton>
                    </div>
                    <div v-if="$page.props.auth.user.queue">
                        <BreezeButton @click="leaveQueue($page.props.auth.user.queue.queue_id)" :type="button"
                                      id="queue">
                            <svg class="w-5 h-5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                 xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            <span class="my-auto">
                                {{ mins.toString().padStart(2, '0') + ':' + secs.toString().padStart(2, '0') }}
                            </span>
                        </BreezeButton>
                    </div>
                </div>
            </header>

            <!-- Page Content -->
            <main>
                <slot/>
            </main>
        </div>
    </div>
</template>
