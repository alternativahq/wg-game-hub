<script setup>
import LogoRed from '@/Shared/SVG/LogoRed';
import Logo from '@/Shared/SVG/Logo';
import { Menu, MenuButton, MenuItem, MenuItems } from '@headlessui/vue';
import { ChevronDownIcon } from '@heroicons/vue/solid';

import NavigationItem from '@/Shared/Navigation/NavigationItem';
import RocketIcon from '@/Shared/SVG/RocketIcon';
import AccountIcon from '@/Shared/SVG/AccountIcon';
import Footer from '@/Shared/Footer/Footer';
import ButtonShape from '@/Shared/ButtonShape';
import { Link } from '@inertiajs/inertia-vue3';

import {
    Popover,
    PopoverButton,
    PopoverOverlay,
    PopoverPanel,
    Dialog,
    DialogPanel,
    DialogTitle,
    TransitionChild,
    TransitionRoot,
} from '@headlessui/vue';
import { MenuIcon, XIcon, BellIcon } from '@heroicons/vue/outline';
import { useCurrentUser } from '@/Composables/useCurrentUser';
import { inject, reactive } from 'vue';
import FlashMessage from '../Shared/FlashMessage.vue';

let props = defineProps({
    config: Object,
});

let currentUser = inject('currentUser');

let state = reactive({
    isNotificationSlideOverOn: false,
});

const navigation = [{ name: 'Dashboard', href: route('landing'), current: true, external: false }];
</script>
<template>
    <div>
        <TransitionRoot as="template" :show="state.isNotificationSlideOverOn">
            <Dialog as="div" class="relative z-10" @close="state.isNotificationSlideOverOn = false">
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
                                                        @click="state.isNotificationSlideOverOn = false"
                                                    >
                                                        <span class="sr-only">Close panel</span>
                                                        <XIcon class="h-6 w-6" aria-hidden="true" />
                                                    </button>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="relative mt-6 flex-1 px-4 sm:px-6" v-if="currentUser">
                                            <!-- Replace with your content -->
                                            <div v-if="currentUser.unread_notifications.length <= 0">
                                                <p>There is no notifications</p>
                                            </div>

                                            <div
                                                class="absolute inset-0 overflow-y-scroll px-4 sm:px-6"
                                                v-if="currentUser.unread_notifications.length > 0"
                                            >
                                                <div class="flex justify-between">
                                                    <button
                                                        v-if="currentUser.unread_notifications.length > 0"
                                                        @click.prevent="currentUser.deleteAllNotifications()"
                                                        class="text-red-500 hover:text-red-300"
                                                    >
                                                        Delete all
                                                    </button>
                                                </div>
                                                <TransitionGroup name="notifications" tag="div">
                                                    <div
                                                        class="my-5 flex flex-col justify-between space-y-2 bg-gray-100 py-4 px-4"
                                                        v-for="notification in currentUser.unread_notifications"
                                                        :key="notification.id"
                                                    >
                                                        <div class="flex flex-col justify-between">
                                                            <div class="text-sm">
                                                                <div>
                                                                    {{ notification.data.message }}
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div
                                                            @click.prevent="
                                                                currentUser.markNotificationAsRead(notification.id)
                                                            "
                                                            class="self-baseline rounded bg-blue-200 py-2 px-2 text-xs hover:cursor-pointer hover:bg-blue-300 hover:text-white"
                                                        >
                                                            Mark as read
                                                        </div>
                                                    </div>
                                                </TransitionGroup>
                                            </div>
                                            <!-- /End replace -->
                                        </div>
                                    </div>
                                </DialogPanel>
                            </TransitionChild>
                        </div>
                    </div>
                </div>
            </Dialog>
        </TransitionRoot>
    </div>
    <div
        id="wrapper"
        class="flex min-h-screen w-full flex-col justify-between bg-[#F6F6F7]"
        :style="{
            backgroundImage: `url(${props.config.main_pattern})`,
            backgroundRepeat: `repeat`,
            backgroundPosition: `center`,
        }"
    >
        <div class="mb-6 w-full bg-white">
            <nav class="container mx-auto flex hidden flex-row justify-between px-4 lg:flex">
                <div class="flex flex-row items-center space-x-14 py-5">
                    <Link :href="route('landing')">
                        <Logo class="w-32" />
                    </Link>
                    <div class="flex flex-row space-x-6">
                        <NavigationItem :href="link.href" as="link" v-for="link in navigation" :key="link.name">
                            <RocketIcon class="h-6 w-6" />
                            <span>{{ link.name }}</span></NavigationItem
                        >
                    </div>
                </div>
                <div class="hidden flex-row items-center space-x-8 lg:flex">
                    <!--                                        <SearchIcon class="h-6 w-6 cursor-pointer" />-->
                    <button @click.prevent="state.isNotificationSlideOverOn = true" class="relative" v-if="currentUser">
                        <BellIcon class="h-7 w-7 cursor-pointer" />
                        <span
                            v-if="currentUser.unread_notifications.length > 0"
                            class="absolute -top-2 -right-2 inline-block rounded-full bg-wgh-red-1 px-2 py-1 text-xs text-white"
                            >{{
                                currentUser.unread_notifications.length > 9
                                    ? '+9'
                                    : currentUser.unread_notifications.length
                            }}</span
                        >
                    </button>
                    <Menu v-if="currentUser" as="div" class="relative inline-block text-left">
                        <div>
                            <MenuButton>
                                <ButtonShape type="purple">
                                    <span class="flex flex-row space-x-2.5">
                                        <AccountIcon class="h-6 w-6" />
                                        <span class="font-bold uppercase">{{ currentUser.name }}</span>
                                    </span>
                                </ButtonShape>
                            </MenuButton>
                        </div>

                        <transition
                            enter-active-class="transition ease-out duration-100"
                            enter-from-class="transform opacity-0 scale-95"
                            enter-to-class="transform opacity-100 scale-100"
                            leave-active-class="transition ease-in duration-75"
                            leave-from-class="transform opacity-100 scale-100"
                            leave-to-class="transform opacity-0 scale-95"
                        >
                            <MenuItems
                                class="absolute right-0 mt-2 w-56 origin-top-right divide-y divide-gray-100 rounded-md bg-white shadow-lg ring-1 ring-black ring-opacity-5 focus:outline-none"
                            >
                                <div class="px-4 py-3">
                                    <p class="text-sm">Signed in as</p>
                                    <p class="truncate text-sm font-medium text-gray-900">
                                        {{ currentUser.email }}
                                    </p>
                                </div>
                                <div class="py-1">
                                    <MenuItem v-slot="{ active }">
                                        <Link
                                            :href="route('user.profile', { user: currentUser.username })"
                                            :class="[
                                                active ? 'bg-gray-100 text-gray-900' : 'text-gray-700',
                                                'block px-4 py-2 text-sm',
                                            ]"
                                        >
                                            Dashboard
                                        </Link>
                                    </MenuItem>
                                    <MenuItem v-slot="{ active }">
                                        <Link
                                            :href="route('user.wallet')"
                                            :class="[
                                                active ? 'bg-gray-100 text-gray-900' : 'text-gray-700',
                                                'block px-4 py-2 text-sm',
                                            ]"
                                        >
                                            Wallet
                                        </Link>
                                    </MenuItem>
                                    <MenuItem v-slot="{ active }">
                                        <Link
                                            :href="route('user.transactions')"
                                            :class="[
                                                active ? 'bg-gray-100 text-gray-900' : 'text-gray-700',
                                                'block px-4 py-2 text-sm',
                                            ]"
                                        >
                                            Transactions
                                        </Link>
                                    </MenuItem>
                                </div>
                                <div class="py-1">
                                    <MenuItem v-slot="{ active }">
                                        <Link
                                            :href="route('admin-games')"
                                            :class="[
                                                active ? 'bg-gray-100 text-gray-900' : 'text-gray-700',
                                                'block px-4 py-2 text-sm',
                                            ]"
                                            >Admin Dashboard</Link
                                        >
                                    </MenuItem>
                                </div>
                            </MenuItems>
                        </transition>
                    </Menu>
                    <Link as="button" method="POST" v-if="currentUser" :href="route('logout')">
                        <ButtonShape type="red">
                            <span class="flex flex-row space-x-2.5">
                                <span class="font-bold uppercase">Sign out</span>
                            </span>
                        </ButtonShape>
                    </Link>
                    <Link v-if="!currentUser" :href="route('login')">
                        <ButtonShape type="purple">
                            <span class="flex flex-row space-x-2.5">
                                <span class="font-bold uppercase">Login / Register</span>
                            </span>
                        </ButtonShape>
                    </Link>
                </div>
            </nav>
            <FlashMessage />
            <div
                class="container mx-auto flex w-full flex-shrink-0 flex-row items-center justify-between bg-white px-4 lg:hidden"
            >
                <Link :href="route('landing')">
                    <Logo class="w-32 py-5" />
                </Link>

                <!-- Mobile menu button -->
                <Popover as="header" class="bg-white" v-slot="{ open }">
                    <!-- Menu button -->

                    <!-- Mobile menu button -->
                    <PopoverButton
                        class="inline-flex items-center justify-center rounded-md bg-transparent p-2 text-indigo-200 hover:bg-white hover:bg-opacity-10 hover:text-white focus:outline-none focus:ring-2 focus:ring-white"
                    >
                        <span class="sr-only">Open main menu</span>
                        <MenuIcon v-if="!open" class="block h-6 w-6" aria-hidden="true" />
                        <XIcon v-else class="block h-6 w-6" aria-hidden="true" />
                    </PopoverButton>

                    <TransitionRoot as="template" :show="open">
                        <div class="lg:hidden">
                            <TransitionChild
                                as="template"
                                enter="duration-150 ease-out"
                                enter-from="opacity-0"
                                enter-to="opacity-100"
                                leave="duration-150 ease-in"
                                leave-from="opacity-100"
                                leave-to="opacity-0"
                            >
                                <PopoverOverlay class="fixed inset-0 z-20 bg-black bg-opacity-25" />
                            </TransitionChild>

                            <TransitionChild
                                as="template"
                                enter="duration-150 ease-out"
                                enter-from="opacity-0 scale-95"
                                enter-to="opacity-100 scale-100"
                                leave="duration-150 ease-in"
                                leave-from="opacity-100 scale-100"
                                leave-to="opacity-0 scale-95"
                            >
                                <PopoverPanel
                                    focus
                                    class="absolute inset-x-0 top-0 z-30 mx-auto w-full max-w-3xl origin-top transform p-2 transition"
                                >
                                    <div
                                        class="divide-y divide-gray-200 rounded-lg bg-white shadow-lg ring-1 ring-black ring-opacity-5"
                                    >
                                        <div class="pt-3 pb-2">
                                            <div class="flex items-center justify-between px-4">
                                                <div>
                                                    <Link :href="route('landing')">
                                                        <Logo class="h-8 w-auto" />
                                                    </Link>
                                                    <!--                                                    <img-->
                                                    <!--                                                        class="h-8 w-auto"-->
                                                    <!--                                                        src="https://tailwindui.com/img/logos/workflow-mark-indigo-600.svg"-->
                                                    <!--                                                        alt="Workflow"-->
                                                    <!--                                                    />-->
                                                </div>
                                                <div class="-mr-2">
                                                    <PopoverButton
                                                        class="inline-flex items-center justify-center rounded-md bg-white p-2 text-gray-400 hover:bg-gray-100 hover:text-gray-500 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-indigo-500"
                                                    >
                                                        <span class="sr-only">Close menu</span>
                                                        <XIcon class="h-6 w-6" aria-hidden="true" />
                                                    </PopoverButton>
                                                </div>
                                            </div>
                                            <div class="mt-3 space-y-1 px-2">
                                                <NavigationItem
                                                    class="block rounded-md px-3 py-2 text-base font-medium"
                                                    :href="link.href"
                                                    as="link"
                                                    v-for="link in navigation"
                                                    :key="link.name"
                                                >
                                                    <RocketIcon class="h-6 w-6" />
                                                    <span>{{ link.name }}</span></NavigationItem
                                                >
                                            </div>
                                        </div>
                                        <div v-if="currentUser" class="pt-4 pb-2">
                                            <div class="flex items-center px-5">
                                                <div class="aspect-square flex-shrink-0">
                                                    <img
                                                        class="h-10 w-10 rounded-full"
                                                        :src="currentUser.image_url"
                                                        alt=""
                                                    />
                                                </div>
                                                <div class="ml-3 min-w-0 flex-1">
                                                    <div class="truncate text-base font-medium text-gray-800">
                                                        {{ currentUser.full_name }}
                                                    </div>
                                                    <div class="truncate text-sm font-medium text-gray-500">
                                                        {{ currentUser.email }}
                                                    </div>
                                                </div>
                                                <button
                                                    type="button"
                                                    @click.prevent="state.isNotificationSlideOverOn = true"
                                                    class="ml-auto flex-shrink-0 rounded-full bg-white p-1 text-gray-400 hover:text-gray-500 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2"
                                                >
                                                    <span class="sr-only">View notifications</span>
                                                    <BellIcon class="h-6 w-6" aria-hidden="true" />
                                                </button>
                                            </div>
                                            <div class="mt-3 space-y-1 px-2" v-if="useCurrentUser()">
                                                <a
                                                    :href="route('user.profile', { user: useCurrentUser().username })"
                                                    class="block rounded-md px-3 py-2 text-base font-medium text-gray-900 hover:bg-gray-100 hover:text-gray-800"
                                                    >Your Profile</a
                                                >
                                                <Link
                                                    :href="route('logout')"
                                                    method="post"
                                                    as="button"
                                                    replace
                                                    class="block w-full rounded-md px-3 py-2 text-left text-base font-medium text-gray-900 hover:bg-gray-100 hover:text-gray-800"
                                                    >Sign out</Link
                                                >
                                            </div>
                                        </div>
                                    </div>
                                </PopoverPanel>
                            </TransitionChild>
                        </div>
                    </TransitionRoot>
                </Popover>
            </div>
        </div>
        <div class="container mx-auto flex h-full flex-1 flex-grow flex-col px-4 lg:mt-0" scroll-region>
            <!--            <transition name="page">-->
            <slot />
            <!--            </transition>-->
        </div>
        <div class="mx-auto mt-8 w-full bg-white py-2">
            <Footer />
        </div>
    </div>
</template>

<style scoped>
.page-enter-active,
.page-leave-active {
    transition: all 0.3s;
}

.page-enter,
.page-leave-active {
    opacity: 0;
}
</style>
