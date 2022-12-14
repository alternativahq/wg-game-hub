<script setup>
import { defineProps, inject } from 'vue';
import BorderedContainer from '@/Shared/BorderedContainer';
import ButtonShape from '@/Shared/ButtonShape';
import RocketIcon from '@/Shared/SVG/RocketIcon';
import SettingsIcon from '@/Shared/SVG/SettingsIcon';
import MedalIcon from '@/Shared/SVG/MedalIcon';
import WatchIcon from '@/Shared/SVG/WatchIcon';
import { Link } from '@inertiajs/inertia-vue3';
import { TimeAgo, UTCToHumanReadable, timePlayedSecondsToHours} from '@/Helpers/Time'

let currentUser = inject('currentUser');

let props = defineProps({
    user: Object,
    totalPlayed: Number,
    lastGamePlayed: Object,
    latestGamesPlayedHistory: Object,
    latestAchievements: Object,
    totalTimePlayed: Number,
    topPlayedGamesTimeSpent: Object,
});

// TODO: make new mock data
//latestGamesPlayedHistory: Object,

//TODO: this page is need user location and bio.

//FIXME: there is a 'start_at_utc_string' but where is the 'start_at' timestamp??????


//note: need better naming. we need to seperate static game data with lobby game data.
// so basically, game_info means game details
// game_lobby means played game in the lobby
// or we should change this name to matches
const latestGamesPlayedHistoryData = [
    {
        game_info: {
            id: "fdaa08b1-07c4-4d29-aeaf-457285bd1ef5",
            image_url: "https://cdn.discordapp.com/attachments/1002536992971702312/1050380662982590545/metal-impact-logo-mid.png",
            name: "Metal Impact - Battle Royale"
        },
        game_lobby: {
            created_at: "2022-11-07T09:34:40.000000Z",
            has_available_spots: false,
            id: "b7aa0e47-64dc-4a35-94d8-b9dda01bc871",
            image_url: "https://picsum.photos/seed/b7aa0e47-64dc-4a35-94d8-b9dda01bc871/1280/720",
            players_in_lobby_count: 0,
            prize_pool: null,
            scheduled_at: "2022-10-26T09:49:40.000000Z",
            scheduled_at_utc_string: "Wed Oct 26 2022 09:49:40 GMT+0000",
            start_at_utc_string: "Tue Dec 6 2022 09:49:40 GMT+0000",
        },
        game_id: "fdaa08b1-07c4-4d29-aeaf-457285bd1ef5",
        game_lobby_id: "b7aa0e47-64dc-4a35-94d8-b9dda01bc871",
        id: "02082a0a-b9c4-40dc-a4b3-e7dec5562bd5",
        rank: 111,
        score: 2092,
        time_played: 972,
        updated_at: "2022-11-07T09:34:44.000000Z",
        user_id: "60e0b30a-3adc-4bb6-ad98-671bd5e1ca8d",
        mode: 'DeathMatch',
        result: 'Won',
        duration: "25:00",
        prize: "00001 ETH",
    },
    {
        game_info: {
            id: "fdaa08b1-07c4-4d29-aeaf-457285bd1ef5",
            image_url: "https://cdn.discordapp.com/attachments/1002536992971702312/1050380663339098163/Tank-genesis-logo-mid.png",
            name: "Tank Genesis"
        },
        game_lobby: {
            created_at: "2022-11-07T09:34:40.000000Z",
            has_available_spots: false,
            id: "b7aa0e47-64dc-4a35-94d8-b9dda01bc871",
            image_url: "https://picsum.photos/seed/b7aa0e47-64dc-4a35-94d8-b9dda01bc871/1280/720",
            players_in_lobby_count: 0,
            prize_pool: null,
            scheduled_at: "2022-10-26T09:49:40.000000Z",
            scheduled_at_utc_string: "Wed Oct 26 2022 09:49:40 GMT+0000",
            start_at_utc_string: "Wed Dec 4 2022 09:49:40 GMT+0000",
        },
        game_id: "fdaa08b1-07c4-4d29-aeaf-457285bd1ef5",
        game_lobby_id: "b7aa0e47-64dc-4a35-94d8-b9dda01bc871",
        id: "02082a0a-b9c4-40dc-a4b3-e7dec5562bd5",
        rank: 23,
        score: 2186,
        time_played: 1231,
        updated_at: "2022-11-07T09:34:44.000000Z",
        user_id: "60e0b30a-3adc-4bb6-ad98-671bd5e1ca8d",
        mode: 'DeathMatch',
        result: 'Lose',
        duration: "45:00",
        prize: "00001 ETH",
    },
    {
        game_info: {
            id: "fdaa08b1-07c4-4d29-aeaf-457285bd1ef5",
            image_url: "https://cdn.discordapp.com/attachments/1002536992971702312/1050380663339098163/Tank-genesis-logo-mid.png",
            name: "Tank Genesis"
        },
        game_lobby: {
            created_at: "2022-11-07T09:34:40.000000Z",
            has_available_spots: false,
            id: "b7aa0e47-64dc-4a35-94d8-b9dda01bc871",
            image_url: "https://picsum.photos/seed/b7aa0e47-64dc-4a35-94d8-b9dda01bc871/1280/720",
            players_in_lobby_count: 0,
            prize_pool: null,
            scheduled_at: "2022-10-26T09:49:40.000000Z",
            scheduled_at_utc_string: "Wed Oct 26 2022 09:49:40 GMT+0000",
            start_at_utc_string: "Thu Dec 1 2022 09:49:40 GMT+0000",
        },
        game_id: "fdaa08b1-07c4-4d29-aeaf-457285bd1ef5",
        game_lobby_id: "b7aa0e47-64dc-4a35-94d8-b9dda01bc871",
        id: "02082a0a-b9c4-40dc-a4b3-e7dec5562bd5",
        rank: 124,
        score: 2092,
        time_played: 972,
        updated_at: "2022-11-07T09:34:44.000000Z",
        user_id: "60e0b30a-3adc-4bb6-ad98-671bd5e1ca8d",
        mode: 'LastManStanding',
        result: 'Won',
        duration: "15:00",
        prize: "000011 XWGT",
    },
    {
        game_info: {
            id: "fdaa08b1-07c4-4d29-aeaf-457285bd1ef5",
            image_url: "https://cdn.discordapp.com/attachments/1002536992971702312/1050380662982590545/metal-impact-logo-mid.png",
            name: "Metal Impact - Battle Royale"
        },
        game_lobby: {
            created_at: "2022-11-07T09:34:40.000000Z",
            has_available_spots: false,
            id: "b7aa0e47-64dc-4a35-94d8-b9dda01bc871",
            image_url: "https://picsum.photos/seed/b7aa0e47-64dc-4a35-94d8-b9dda01bc871/1280/720",
            players_in_lobby_count: 0,
            prize_pool: null,
            scheduled_at: "2022-10-26T09:49:40.000000Z",
            scheduled_at_utc_string: "Wed Oct 26 2022 09:49:40 GMT+0000",
            start_at_utc_string: "Tue Nov 1 2022 09:49:40 GMT+0000",
        },
        game_id: "fdaa08b1-07c4-4d29-aeaf-457285bd1ef5",
        game_lobby_id: "b7aa0e47-64dc-4a35-94d8-b9dda01bc871",
        id: "02082a0a-b9c4-40dc-a4b3-e7dec5562bd5",
        rank: 175,
        score: 12312,
        time_played: 972,
        updated_at: "2022-11-07T09:34:44.000000Z",
        user_id: "60e0b30a-3adc-4bb6-ad98-671bd5e1ca8d",
        mode: 'TeamVTeam',
        result: 'Lose',
        duration: "23:00",
        prize: "0000012 BAN",
    },
    {
        game_info: {
            id: "fdaa08b1-07c4-4d29-aeaf-457285bd1ef5",
            image_url: "https://play-lh.googleusercontent.com/bp3s6Q09VuD2mKvbAv_vM42ZyKYntjztN5-qEJV_Fr5sSRRqfDYaQDCEPFEM7Cchg_eB",
            name: "Wagar IO"
        },
        game_lobby: {
            created_at: "2022-11-07T09:34:40.000000Z",
            has_available_spots: false,
            id: "b7aa0e47-64dc-4a35-94d8-b9dda01bc871",
            image_url: "https://picsum.photos/seed/b7aa0e47-64dc-4a35-94d8-b9dda01bc871/1280/720",
            players_in_lobby_count: 0,
            prize_pool: null,
            scheduled_at: "2022-10-26T09:49:40.000000Z",
            scheduled_at_utc_string: "Wed Oct 26 2022 09:49:40 GMT+0000",
            start_at_utc_string: "Wed Oct 26 2022 09:49:40 GMT+0000",
        },
        game_id: "fdaa08b1-07c4-4d29-aeaf-457285bd1ef5",
        game_lobby_id: "b7aa0e47-64dc-4a35-94d8-b9dda01bc871",
        id: "02082a0a-b9c4-40dc-a4b3-e7dec5562bd5",
        rank: 1725,
        score: 3123,
        time_played: 972,
        updated_at: "2022-11-07T09:34:44.000000Z",
        user_id: "60e0b30a-3adc-4bb6-ad98-671bd5e1ca8d",
        mode: 'OneVOne',
        result: 'Won',
        duration: "1:05:00",
        prize: "0000012 BAN",
    },
]

let userAchievements= [
    {
        id: 1,
        image_url: "https://cdn.akamai.steamstatic.com/steamcommunity/public/images/apps/578080/3a0cf87d38da2bb779867cf8bded8ce452528772.jpg",
        name: "Killing Spree",
        description: "Kill at least 4 players in a single match.",
        game_name: "Metal Impact - Battle Royale",
        unlocked_at: "Wed Oct 26 2022 09:49:40 GMT+0000",
        type: "one time",
    },
    {
        id: 2,
        image_url: "https://cdn.akamai.steamstatic.com/steamcommunity/public/images/apps/578080/9ef7ec6c4abfedc2a5436fc75b9f63bf9ae80161.jpg",
        name: "Marksman Master",
        description: "Kill 100 players with an assault rifle and/or a sniper rifle from over 100 meters away.",
        game_name: "Metal Impact - Battle Royale",
        unlocked_at: "Wed Oct 26 2022 09:49:40 GMT+0000",
        type: "one time",
    },
    {
        id: 3,
        image_url: "https://cdn.akamai.steamstatic.com/steamcommunity/public/images/apps/578080/0ba42c6fbcf0fecb0893124f138c5d30fc5f8ff4.jpg",
        name: "Winner Winner Chicken Dinner!",
        description: "Obtain a Chicken Dinner in Solo.",
        game_name: "Metal Impact - Battle Royale",
        unlocked_at: "Wed Oct 26 2022 09:49:40 GMT+0000",
        type: "progress",
    },
    {
        id: 4,
        image_url: "https://cdn.akamai.steamstatic.com/steamcommunity/public/images/apps/578080/7e5158bb86d4522518db622dd58fe8b2ac1b312b.jpg",
        name: "Ghost",
        description: "Equip a suppressed weapon in every weapon slot. Let's find out which weapon is suppressed!",
        game_name: "Metal Impact - Battle Royale",
        unlocked_at: "Wed Oct 26 2022 09:49:40 GMT+0000",
        type: "one time",
    },
    {
        id: 5,
        image_url: "https://cdn.akamai.steamstatic.com/steamcommunity/public/images/apps/578080/59abda8f6cfe24cb94398ce496a1aab1248a3f61.jpg",
        name: "Last Survivor",
        description: "Win a game 10 times.",
        game_name: "Metal Impact - Battle Royale",
        unlocked_at: "Wed Oct 26 2022 09:49:40 GMT+0000",
        type: "progress",
    }
];

</script>
<template>
    <div class="grid grid-flow-row gap-y-8">
        <section class="overflow-x-auto">
            <BorderedContainer class="mb-9 bg-wgh-gray-1.5">
                <div class="flex flex-col justify-between rounded-lg bg-white p-6 md:flex-row">
                    <div class="flex flex-row items-start space-x-5 lg:items-center">
                        <BorderedContainer class="shrink-0 bg-wgh-purple-3">
                            <div class="rounded-lg bg-white">
                                <img
                                    :src="user.image_url"
                                    alt="user profile image"
                                    class="h-12 w-12 object-cover md:h-24 md:w-24"
                                />
                            </div>
                        </BorderedContainer>
                        <div class="flex flex-col space-y-2">
                            <div class="flex flex-row items-start justify-between">
                                <h1 class="font-grota text-base font-extrabold capitalize text-wgh-gray-6 md:text-lg">
                                    {{ user.full_name }}
                                </h1>
                                <Link class="space-x-2 font-inter text-xs font-normal text-wgh-gray-4 md:hidden">
                                    <SettingsIcon class="h-4 w-4" />
                                </Link>
                            </div>
                            <p class="font-inter text-sm font-normal text-wgh-gray-4">
                                <span class="mr-2">🇨🇱</span> Chile
                            </p>
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
                        <div class="flex flex-row justify-between md:space-x-8">
                            <div class="flex flex-col items-center space-y-2 sm:flex-row sm:space-y-0 sm:space-x-2">
                                <div class="rounded-full bg-wgh-pink-1 p-3">
                                    <MedalIcon class="h-7 w-7 text-wgh-purple-2" />
                                </div>
                                <div class="flex flex-col justify-center">
                                    <span
                                        class="text-center font-inter text-[10px] font-semibold uppercase text-wgh-gray-2 lg:text-left"
                                        >won</span
                                    >
                                    <span
                                        class="text-center font-grota text-sm font-normal uppercase text-wgh-gray-6 lg:text-left"
                                        >37 USD</span
                                    >
                                </div>
                            </div>
                            <div class="flex flex-col items-center space-y-2 sm:flex-row sm:space-y-0 sm:space-x-2">
                                <div class="rounded-full bg-wgh-pink-1 p-3">
                                    <RocketIcon class="h-7 w-7 text-wgh-purple-2" />
                                </div>
                                <div class="flex flex-col justify-center">
                                    <span
                                        class="text-center font-inter text-[10px] font-semibold uppercase text-wgh-gray-2 lg:text-left"
                                        >played</span
                                    >
                                    <span
                                        class="text-center font-grota text-sm font-normal uppercase text-wgh-gray-6 lg:text-left"
                                        >{{ props.totalPlayed }} times</span
                                    >
                                </div>
                            </div>
                            <div class="flex flex-col items-center space-y-2 sm:flex-row sm:space-y-0 sm:space-x-2">
                                <div class="rounded-full bg-wgh-pink-1 p-3">
                                    <WatchIcon class="h-7 w-7 text-wgh-purple-2" />
                                </div>
                                <div class="flex flex-col justify-center">
                                    <span
                                        class="text-center font-inter text-[10px] font-semibold uppercase text-wgh-gray-2 lg:text-left"
                                        >spent</span
                                    >
                                    <span
                                        class="text-center font-grota text-sm font-normal uppercase text-wgh-gray-6 lg:text-left"
                                        >{{ timePlayedSecondsToHours(totalTimePlayed) }}</span
                                    >
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </BorderedContainer>
        </section>

        <section class="overflow-x-auto">
            <div class="flex flex-col">
                <h2 class="mb-6 font-grota text-2xl font-extrabold uppercase text-wgh-gray-6">Summary</h2>
                <div class="flex flex-col">
                <h1 class="mb-6 font-grota text-xl font-extrabold uppercase text-wgh-gray-6"> ↳ Last two weeks</h1>

                <div class="mt-4 grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4">
                    <div class="flex items-start rounded-xl bg-white p-4 shadow-lg">
                    <div class="flex h-12 w-12 items-center justify-center rounded-full border border-blue-100 bg-blue-50">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-blue-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12,6 L12,2 M12,6 C14.4983324,6.0444148 16.0056152,6 17,6 C19,6 21,6.5 22,10 C23,13.5 23,15.5 23,18 C23,20.5 21,21 19,21 C17,21 15.9456522,17 12,17 C8.05434783,17 7,21 5,21 C3,21 1,20.5 1,18 C1,15.5 1,13.5 2,10 C3,6.5 5,6 7,6 C7.99438477,6 9.50166757,6.0444148 12,6 L12,6 L12,6 Z M18,15 C18.5522847,15 19,14.5522847 19,14 C19,13.4477153 18.5522847,13 18,13 C17.4477153,13 17,13.4477153 17,14 C17,14.5522847 17.4477153,15 18,15 Z M14,12 C14.5522847,12 15,11.5522847 15,11 C15,10.4477153 14.5522847,10 14,10 C13.4477153,10 13,10.4477153 13,11 C13,11.5522847 13.4477153,12 14,12 Z M4,12 L10,12 M7,9 L7,15"/>
                        </svg>
                    </div>

                    <div class="ml-4">
                        <h2 class="font-semibold">Versatility</h2>
                        <p class="mt-2 text-sm text-gray-500">Played 7 different games</p>
                    </div>
                    </div>

                    <!-- playtime section starts -->
                    <div class="flex items-start rounded-xl bg-white p-4 shadow-lg">
                    <div class="flex h-12 w-12 items-center justify-center rounded-full border border-orange-100 bg-orange-50">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-orange-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 3.75H13.5M12 9.75V12.75M17.625 6.375L19.125 7.875M6.375 6.375L4.875 7.875M5.625 7.125L7.125 8.625M18.375 7.125L16.875 8.625M12 20.25C8.27208 20.25 5.25 17.2279 5.25 13.5C5.25 9.77208 8.27208 6.75 12 6.75C15.7279 6.75 18.75 9.77208 18.75 13.5C18.75 17.2279 15.7279 20.25 12 20.25Z"/>
                        </svg>
                    </div>

                    <div class="ml-4">
                        <h2 class="font-semibold">Playtime</h2>
                        <p class="mt-2 text-sm text-gray-500">Spend 3000 hours</p>
                    </div>
                    </div>
                    <!-- playtime section ends -->

                    <div class="flex items-start rounded-xl bg-white p-4 shadow-lg">
                    <div class="flex h-12 w-12 items-center justify-center rounded-full border border-red-100 bg-red-50">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-red-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path fill="none" stroke-width="2" d="M16,16 C16,14.8954305 12.8659932,14 9,14 C5.13400675,14 2,14.8954305 2,16 C2,17.1045695 5.13400675,18 9,18 C12.8659932,18 16,17.1045695 16,16 Z M2,16 L2,20.9367547 C2,22.0762536 5.13400675,23 9,23 C12.8659932,23 16,22.0762537 16,20.9367548 L16,16 M9,5 C4.581722,5 1,5.8954305 1,7 C1,8.1045695 4.581722,9 9,9 M1,7 L1,12.0000002 C1,13.0128881 4.581722,14 9,14 M23,4 C23,2.8954305 19.9004329,2 16.0769231,2 C12.2534133,2 9.15384615,2.8954305 9.15384615,4 C9.15384615,5.1045695 12.2534133,6 16.0769231,6 C19.9004329,6 23,5.1045695 23,4 Z M16,16 C19.8235098,16 23.0000002,15.0128879 23.0000002,14 L23,4 M9.15384615,3.99999999 L9.15384615,14.1660042 M8.99999999,9.00000001 C8.99999999,10.0128879 12.2534135,11 16.0769233,11 C19.9004331,11 23.0000004,10.0128879 23.0000004,9.00000001"/>
                        </svg>
                    </div>

                    <div class="ml-4">
                        <h2 class="font-semibold">Earnings</h2>
                        <p class="mt-2 text-sm text-gray-500">Earned 045 ETH, 099 BAN</p>
                    </div>
                    </div>
                    <div class="flex items-start rounded-xl bg-white p-4 shadow-lg">
                    <div class="flex h-12 w-12 items-center justify-center rounded-full border border-indigo-100 bg-indigo-50">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-indigo-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path fill="none" stroke-width="2" d="M12,15 C8.686,15 6,12.314 6,9 L6,1 L18,1 L18,9 C18,12.314 15.314,15 12,15 Z M6,3 L1,3 L1,7 C1,9.509 2.791,11 5,11 L6,11 L6,3 Z M18,11 L19,11 C21.209,11 23,9.509 23,7 L23,3 L18,3 L18,11 Z M5,23 L19,23 L19,19 L5,19 L5,23 Z M16,19 C16,16.790861 14.209139,15 12,15 C9.790861,15 8,16.790861 8,19"/>
                        </svg>
                    </div>

                    <div class="ml-4">
                        <h2 class="font-semibold">Recent 20 game(s)</h2>
                        <p class="mt-2 text-sm text-gray-500">11 Win / 9 Lose</p>
                    </div>
                    </div>
                </div>
                </div>
            </div>
        </section>

        <section class="overflow-x-auto" v-if="lastGamePlayed">
            <h2 class="mb-6 font-grota text-2xl font-extrabold uppercase text-wgh-gray-6">Last Played</h2>

            <BorderedContainer class="bg-wgh-gray-1.5">
                <div class="flex w-full flex-col rounded-lg bg-white p-6 md:flex-row">
                    <div class="flex w-full flex-col space-y-4 md:w-2/3 md:flex-row md:space-y-0 md:space-x-4">
                        <img
                            :src="lastGamePlayed.image_url"
                            :alt="`${lastGamePlayed.name} art`"
                            class="aspect-[16/9] rounded-lg md:mb-0 md:max-h-[6.25rem]"
                        />
                        <div class="flex flex-col justify-center">
                            <h3 class="font-grota text-base font-bold uppercase text-wgh-gray-6">
                                {{ lastGamePlayed.name }}
                            </h3>
                            <p class="mb-4 font-inter text-sm font-normal text-wgh-gray-4">
                                {{ lastGamePlayed.description }}
                            </p>
                        </div>
                    </div>
                    <div
                        class="mt-4 flex flex-col items-center justify-end md:mt-0 md:w-1/3 md:flex-row md:items-baseline"
                    >
                        <Link :href="`/games/${lastGamePlayed.id}`">
                            <ButtonShape type="red">
                                <span>Play Again</span>
                            </ButtonShape>
                        </Link>
                    </div>
                </div>
            </BorderedContainer>
        </section>
        <section class="overflow-x-auto">
            <div class="mb-6 flex flex-row items-center justify-between">
                <h2 class="truncate font-grota text-2xl font-extrabold uppercase text-wgh-gray-6">
                    Latest Matches
                </h2>
                <Link class="shrink-0" :href="`/w/${user.username}/games-played-history`">
                    <ButtonShape type="red"> View All</ButtonShape>
                </Link>
            </div>
            <BorderedContainer class="bg-wgh-gray-1.5">
                <div class="rounded-lg">
                    <div class="flex flex-col">
                        <div class="overflow-x-auto">
                            <div class="inline-block min-w-full align-middle">
                                <div class="overflow-hidden rounded-lg shadow-sm ring-1 ring-black ring-opacity-5">
                                    <table class="min-w-full divide-y divide-gray-300 overflow-scroll w-full">
                                        <thead class="bg-gray-50">
                                            <tr>
                                                <th
                                                    scope="col"
                                                    class="py-3.5 pl-4 pr-3 text-left text-sm font-semibold text-gray-900 sm:pl-6 lg:pl-8"
                                                >

                                                </th>
                                                <th
                                                    scope="col"
                                                    class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900"
                                                >
                                                    Game Name
                                                </th>
                                                <th
                                                    scope="col"
                                                    class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900"
                                                >
                                                    Played at
                                                </th>
                                                <th
                                                    scope="col"
                                                    class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900"
                                                >
                                                    Game Mode
                                                </th>
                                                <th
                                                    scope="col"
                                                    class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900"
                                                >
                                                    Result
                                                </th>
                                                <th
                                                    scope="col"
                                                    class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900"
                                                >
                                                    Duration
                                                </th>
                                                <th
                                                    scope="col"
                                                    class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900"
                                                >
                                                    Prize
                                                </th>
                                                <th
                                                    scope="col"
                                                    class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900"
                                                >
                                                    Score
                                                </th>
                                                <th
                                                    scope="col"
                                                    class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900"
                                                >
                                                    Rank
                                                </th>
                                            </tr>
                                        </thead>
                                        <tbody class="divide-y divide-gray-200 bg-white">
                                            <tr v-for="(scoreItem, index) in latestGamesPlayedHistoryData" :key="scoreItem.id" :style="{'background-color': index%2 == 0  ? '#F5F3FF' : ''}">
                                                <td
                                                    class="whitespace-nowrap py-4 pl-4 pr-3 text-sm font-medium text-gray-900 sm:pl-6 lg:pl-8"
                                                >
                                                <img :src="scoreItem.game_info.image_url" :alt="`${scoreItem.image_url} art`"
                                                    class="h-7 w-50 object-cover md:h-13 md:w-50"
                                                />
                                                </td>
                                                <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">
                                                    {{ scoreItem.game_info.name }}
                                                </td>
                                                <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">
                                                {{ TimeAgo(UTCToHumanReadable(scoreItem.game_lobby.start_at_utc_string, 'MMMM DD, YYYY hh:mm A')) }}
                                                </td>
                                                <td
                                                    class="whitespace-nowrap px-3 py-4 text-sm text-gray-500"
                                                >
                                                    {{ scoreItem.mode }}
                                                </td>
                                                <td
                                                    class="whitespace-nowrap px-3 py-4 text-sm text-gray-500"
                                                >
                                                    {{ scoreItem.result }}
                                                </td>
                                                <td
                                                    class="whitespace-nowrap px-3 py-4 text-sm text-gray-500"
                                                >
                                                    {{ scoreItem.duration }}
                                                </td>
                                                <td
                                                    class="whitespace-nowrap px-3 py-4 text-sm text-gray-500"
                                                >
                                                    {{ scoreItem.prize }}
                                                </td>
                                                <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">
                                                    {{ scoreItem.score }}
                                                </td>
                                                <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">
                                                    #{{ scoreItem.rank }}
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </BorderedContainer>
        </section>
        <section class="overflow-x-auto">
            <div class="mb-6 flex flex-row items-center justify-between">
                <h2 class="truncate font-grota text-2xl font-extrabold uppercase text-wgh-gray-6">
                    Latest Achievements
                </h2>
                <Link class="shrink-0" :href="`/w/${user.username}/achievements`">
                    <ButtonShape type="red"> View All</ButtonShape>
                </Link>
            </div>
            <BorderedContainer class="bg-wgh-gray-1.5">
                <div class="rounded-lg">
                    <div class="flex flex-col">
                        <div class="overflow-x-auto">
                            <div class="inline-block min-w-full align-middle">
                                <div class="overflow-hidden rounded-lg shadow-sm ring-1 ring-black ring-opacity-5">
                                    <table class="min-w-full divide-y divide-gray-300">
                                        <thead class="bg-gray-50">
                                            <tr>
                                                <th
                                                    scope="col"
                                                    class="py-3.5 pl-4 pr-3 text-left text-sm font-semibold text-gray-900 sm:pl-6 lg:pl-8"
                                                >

                                                </th>
                                                <th
                                                    scope="col"
                                                    class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900"
                                                >
                                                    Name
                                                </th>
                                                <th
                                                    scope="col"
                                                    class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900"
                                                >
                                                    Description
                                                </th>
                                                <th
                                                    scope="col"
                                                    class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900"
                                                >
                                                    Game
                                                </th>
                                                <th
                                                    scope="col"
                                                    class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900"
                                                >
                                                    Unlocked at
                                                </th>
                                                <th
                                                    scope="col"
                                                    class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900"
                                                >
                                                    Type
                                                </th>
                                            </tr>
                                        </thead>
                                        <tbody class="divide-y divide-gray-200 bg-white">
                                            <tr v-for="(achievement, index) in userAchievements" :key="achievement.id" :style="{'background-color': index%2 == 0  ? '#FFFBEB' : ''}">
                                                <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">
                                                    <img :src="achievement.image_url" :alt="`${achievement.image_url} art`"
                                                        class="h-7 w-50 object-cover md:h-13 md:w-50"
                                                    />
                                                </td>
                                                <td
                                                    class="whitespace-nowrap py-4 pl-4 pr-3 text-sm font-medium text-gray-900 sm:pl-6 lg:pl-8"
                                                >
                                                    {{ achievement.name }}
                                                </td>
                                                <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">
                                                    {{ achievement.description }}
                                                </td>
                                                <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">
                                                    {{ achievement.game_name }}
                                                </td>
                                                <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">
                                                    {{ TimeAgo(UTCToHumanReadable(achievement.unlocked_at, 'MMMM DD, YYYY hh:mm A')) }}
                                                </td>
                                                <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">
                                                    {{ achievement.type }}
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </BorderedContainer>
        </section>
    </div>
</template>
