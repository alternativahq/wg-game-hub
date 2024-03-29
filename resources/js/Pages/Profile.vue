<script setup>
import BorderedContainer from '@/Shared/BorderedContainer';
import { Link } from '@inertiajs/inertia-vue3';
import SettingsIcon from '@/Shared/SVG/SettingsIcon';
import MedalIcon from '@/Shared/SVG/MedalIcon';
import RocketIcon from '@/Shared/SVG/RocketIcon';
import WatchIcon from '@/Shared/SVG/WatchIcon';
import ButtonShape from '@/Shared/ButtonShape';
import UserProfileFormDialog from '@/Shared/Modals/UserProfileFormDialog.vue';
import { inject, ref, reactive } from 'vue';

let props = defineProps({
    userProfileInfo: Object,
    genders: Object,
});
let dayjs = inject('dayjs');
let activeTransactionNetwork = ref('banano');
let currentUser = inject('currentUser');
let state = reactive({
    showUserProfileForm: false,
});
</script>
<template>
    <div>
        <UserProfileFormDialog :userInfo="userProfileInfo" :genders="genders" :open="state.showUserProfileForm" @closed="state.showUserProfileForm = false" />
        <BorderedContainer class="mb-9 bg-wgh-gray-1.5">
            <div class="flex flex-col justify-between rounded-lg bg-white p-6 md:flex-row">
                <div class="flex flex-row items-start space-x-5 lg:items-center">
                    <BorderedContainer class="shrink-0 bg-wgh-purple-3">
                        <div class="rounded-lg bg-white">
                            <img
                                :src="currentUser.image_url"
                                alt="user profile image"
                                class="h-12 w-12 object-cover md:h-24 md:w-24"
                            />
                        </div>
                    </BorderedContainer>
                    <div class="flex flex-col space-y-2">
                        <div class="flex flex-row items-start justify-between">
                            <h1 class="font-grota text-lg font-extrabold capitalize text-wgh-gray-6">
                                {{ currentUser.full_name }}
                            </h1>
                            <Link class="space-x-2 font-inter text-xs font-normal text-wgh-gray-4 md:hidden">
                                <SettingsIcon class="h-4 w-4"
                            /></Link>
                        </div>
                        <p class="font-inter text-sm font-normal text-wgh-gray-4"><span class="mr-2">🇨🇱</span> Chile</p>
                        <p class="font-enter text-base font-normal text-black">🎮 Keep calm and game on 🕹</p>
                    </div>
                </div>
                <div class="mt-4 flex flex-col justify-between lg:mt-0">
                    <div class="flex items-center justify-between">
                        <Link href="/profile">
                            <button
                                class="text-wgh-gray-8 mx-4 flex-row justify-end rounded bg-green-500 py-1 px-2 text-xs"
                            >
                                <span class="flex flex-row">
                                    <span class="font-bold uppercase">profile</span>
                                </span>
                            </button>
                        </Link>
                        <Link
                            class="hidden flex-row justify-end space-x-2 font-inter text-xs font-normal text-wgh-gray-4 md:flex"
                            ><span>settings</span>
                            <SettingsIcon class="h-4 w-4" />
                        </Link>
                    </div>
                    <div class="flex flex-row lg:space-x-8">
                        <div class="flex flex-row space-x-2">
                            <div class="rounded-full bg-wgh-pink-1 p-3">
                                <MedalIcon class="h-7 w-7 text-wgh-purple-2" />
                            </div>
                            <div class="flex flex-col justify-center">
                                <span class="font-inter text-[10px] font-semibold uppercase text-wgh-gray-2">won</span>
                                <span class="font-grota text-sm font-normal uppercase text-wgh-gray-6">37 USD</span>
                            </div>
                        </div>
                        <div class="flex flex-row space-x-2">
                            <div class="rounded-full bg-wgh-pink-1 p-3">
                                <RocketIcon class="h-7 w-7 text-wgh-purple-2" />
                            </div>
                            <div class="flex flex-col justify-center">
                                <span class="font-inter text-[10px] font-semibold uppercase text-wgh-gray-2"
                                    >payed</span
                                >
                                <span class="font-grota text-sm font-normal uppercase text-wgh-gray-6">18 times</span>
                            </div>
                        </div>
                        <div class="flex flex-row space-x-2">
                            <div class="rounded-full bg-wgh-pink-1 p-3">
                                <WatchIcon class="h-7 w-7 text-wgh-purple-2" />
                            </div>
                            <div class="flex flex-col justify-center">
                                <span class="font-inter text-[10px] font-semibold uppercase text-wgh-gray-2"
                                    >spent</span
                                >
                                <span class="font-grota text-sm font-normal uppercase text-wgh-gray-6">15H</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </BorderedContainer>
        <div class="flex flex-col space-y-6 lg:flex-row lg:space-y-0 lg:space-x-6">
            <!-- ****************************************left side ******************************************************* -->
            <div class="grow basis-0">
                <div class="mb-6 flex h-14 shrink-0 flex-row items-center justify-between">
                    <h2 class="font-grota text-2xl font-extrabold uppercase text-wgh-gray-6">Profile</h2>
                    <button>
                        <ButtonShape type="purple" @click="state.showUserProfileForm = true">
                            <span>Edit</span>
                        </ButtonShape>
                    </button>
                </div>
                <BorderedContainer class="bg-gray-200">
                    <div class="divide-y-2 rounded-lg bg-gray-50 p-6">
                        <div class="m-4 flex items-center">
                            <div class="mr-4 w-1/2 text-lg font-semibold">Name:</div>
                            <div class="w-1/2">{{ userProfileInfo.name }}</div>
                        </div>
                        <div class="m-4 flex items-center">
                            <div class="mr-4 w-1/2 text-lg font-semibold">LastName:</div>
                            <div class="w-1/2">{{ userProfileInfo.familyName }}</div>
                        </div>
                        <div class="m-4 flex items-center">
                            <div class="mr-4 w-1/2 text-lg font-semibold">Picture:</div>
                            <div class="w-1/2">{{ userProfileInfo.picture }}</div>
                        </div>
                        <div class="m-4 flex items-center">
                            <div class="mr-4 w-1/2 text-lg font-semibold">UserName:</div>
                            <div class="w-1/2">{{ userProfileInfo.preferredUsername }}</div>
                        </div>
                        <div class="m-4 flex items-center">
                            <div class="mr-4 w-1/2 text-lg font-semibold">Gender:</div>
                            <div class="w-1/2">{{ userProfileInfo.gender }}</div>
                        </div>
                        <div class="m-4 flex items-center">
                            <div class="mr-4 w-1/2 text-lg font-semibold">Phone Number:</div>
                            <div class="w-1/2">{{ userProfileInfo.phoneNumber }}</div>
                        </div>
                        <div class="m-4 flex items-center">
                            <div class="mr-4 w-1/2 text-lg font-semibold">Birth Date:</div>
                            <div class="w-1/2">{{
                                    dayjs(userProfileInfo.birthDate)
                                        .utc()
                                        .local()
                                        .tz(dayjs.tz.guess())
                                        .format('YYYY/MM/DD')
                                }}</div>
                        </div>
                        <div class="m-4 flex items-center">
                            <div class="mr-4 w-1/2 text-lg font-semibold">Address:</div>
                            <div class="w-1/2">{{ userProfileInfo.address }}</div>
                        </div>
                    </div>
                </BorderedContainer>
            </div>
            <!-- ****************************************left side ******************************************************* -->
            <!-- ****************************************right side ******************************************************* -->
            <div class="grow basis-0">
                <div class="mb-6 flex h-14 shrink-0 flex-row items-center justify-between">
                    <h2 class="font-grota text-2xl font-extrabold uppercase text-wgh-gray-6">Account</h2>
                    <button>
                        <ButtonShape type="purple">
                            <span>Edit</span>
                        </ButtonShape>
                    </button>
                </div>
                <BorderedContainer class="bg-gray-200">
                    <div class="divide-y-2 rounded-lg bg-gray-50 p-6">
                        <div class="m-4 flex items-center">
                            <div class="mr-4 w-1/2 text-lg font-semibold">Name:</div>
                            <div class="w-1/2">{{ currentUser.name }}</div>
                        </div>
                        <div class="m-4 flex items-center">
                            <div class="mr-4 w-1/2 text-lg font-semibold">LastName:</div>
                            <div class="w-1/2">{{ currentUser.last_name }}</div>
                        </div>
                        <div class="m-4 flex items-center">
                            <div class="mr-4 w-1/2 text-lg font-semibold">Email:</div>
                            <div class="w-1/2">{{ currentUser.email }}</div>
                        </div>
                        <div class="m-4 flex items-center">
                            <div class="mr-4 w-1/2 text-lg font-semibold">UserName:</div>
                            <div class="w-1/2">{{ currentUser.username }}</div>
                        </div>
                    </div>
                </BorderedContainer>
            </div>
            <!-- ****************************************right side ******************************************************* -->
        </div>
    </div>
</template>
