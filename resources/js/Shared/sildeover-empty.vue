<script setup>
import { defineProps } from 'vue';
import { Link } from '@inertiajs/inertia-vue3';
import { ref, inject } from 'vue';
import { Dialog, DialogPanel, DialogTitle, TransitionChild, TransitionRoot } from '@headlessui/vue';
import { XIcon } from '@heroicons/vue/24/outline';
import { Inertia } from '@inertiajs/inertia';
import Navigation from './navigation.vue';
import { useCurrentUser } from '@/Composables/useCurrentUser';

let currentUser = useCurrentUser();
// let currentUser = inject('currentUser');

function deleteAllNotifications() {
    Inertia.delete('/notifications');
}

function markNotificationAsRead(notification) {
    Inertia.put(`/notifications/${notification.id}/read`);
}

const open = ref(false);
</script>

<template>
    <div>
        <a
            @click="open = true"
            class="dropdown-toggle hidden-arrow mr-4 flex items-center text-gray-500 hover:text-gray-700 focus:text-gray-700"
            href="#"
            id="dropdownMenuButton1"
            role="button"
            data-bs-toggle="dropdown"
            aria-expanded="false"
        >
            <svg
                aria-hidden="true"
                focusable="false"
                data-prefix="fas"
                data-icon="bell"
                class="w-4"
                role="img"
                xmlns="http://www.w3.org/2000/svg"
                viewBox="0 0 448 512"
            >
                <path
                    fill="currentColor"
                    d="M224 512c35.32 0 63.97-28.65 63.97-64H160.03c0 35.35 28.65 64 63.97 64zm215.39-149.71c-19.32-20.76-55.47-51.99-55.47-154.29 0-77.7-54.48-139.9-127.94-155.16V32c0-17.67-14.32-32-31.98-32s-31.98 14.33-31.98 32v20.84C118.56 68.1 64.08 130.3 64.08 208c0 102.3-36.15 133.53-55.47 154.29-6 6.45-8.66 14.16-8.61 21.71.11 16.4 12.98 32 32.1 32h383.8c19.12 0 32-15.6 32.1-32 .05-7.55-2.61-15.27-8.61-21.71z"
                ></path>
            </svg>
        </a>
        <TransitionRoot as="template" :show="open">
            <Dialog as="div" class="relative z-10" @close="open = false">
                <div class="fixed inset-0" />
                <div class="fixed inset-0 overflow-hidden">
                    <div class="absolute inset-0 overflow-hidden">
                        <div class="pointer-events-none fixed inset-y-0 right-0 flex max-w-full pl-10">
                            <TransitionChild
                                as="template"
                                enter="transform transition ease-in-out duration-500 sm:duration-700"
                                enter-from="translate-x-full"
                                enter-to="translate-x-0"
                                leave="transform transition ease-in-out duration-500 sm:duration-700"
                                leave-from="translate-x-0"
                                leave-to="translate-x-full"
                            >
                                <DialogPanel class="pointer-events-auto w-screen max-w-md">
                                    <div class="flex h-full flex-col bg-white py-6 shadow-xl">
                                        <div class="px-4 sm:px-6">
                                            <div class="flex items-start justify-between">
                                                <DialogTitle class="text-lg font-medium text-gray-900">
                                                    Notifications
                                                </DialogTitle>
                                                <div class="ml-3 flex h-7 items-center">
                                                    <button
                                                        type="button"
                                                        class="rounded-md bg-white text-gray-400 hover:text-gray-500 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2"
                                                        @click="open = false"
                                                    >
                                                        <span class="sr-only">Close panel</span>
                                                        <XIcon class="h-6 w-6" aria-hidden="true" />
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="relative mt-6 flex-1 px-4 sm:px-6" v-if="currentUser">
                                            <!-- Replace with your content -->
                                            <div class="absolute inset-0 overflow-y-scroll px-4 sm:px-6">
                                                <div class="flex justify-end">
                                                    <button
                                                        @click="deleteAllNotifications"
                                                        class="text-red-500 hover:text-red-300"
                                                    >
                                                        Clear All
                                                    </button>
                                                </div>
                                                <div
                                                    class="my-5 flex items-center justify-between bg-gray-100 py-4 px-4"
                                                    v-for="notification in currentUser.notifications.data"
                                                    :key="notification.id"
                                                >
                                                    <div class="flex items-center justify-between">
                                                        <div class="mr-2">
                                                            <img
                                                                :src="currentUser.image_url"
                                                                alt="user profile image"
                                                                class="md:h-15 md:w-15 h-12 w-12 rounded-full object-cover"
                                                            />
                                                        </div>
                                                        <div class="text-sm">
                                                            <div>
                                                                {{ notification.id }}the notifications message static
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div
                                                        @click="markNotificationAsRead(notification)"
                                                        class="text-md rounded bg-blue-200 py-2 px-2 hover:cursor-pointer hover:bg-blue-300 hover:text-white"
                                                    >
                                                        Read
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- /End replace -->
                                        </div>
                                        <!-- /start paginate -->
                                        <div>
                                            <Navigation />
                                        </div>
                                        <!-- /End paginate -->
                                    </div>
                                </DialogPanel>
                            </TransitionChild>
                        </div>
                    </div>
                </div>
            </Dialog>
        </TransitionRoot>
    </div>
</template>
