<script setup>
import { defineProps } from 'vue';
import BorderedContainer from '@/Shared/BorderedContainer';
import { Link } from '@inertiajs/inertia-vue3';
import GameLobbySteps from '@/Shared/GameLobbySteps.vue';
import { inject } from 'vue';

let dayjs = inject('dayjs');
let props = defineProps({
    gameLobby: Object,
    usersCount: Number,
    gameLobbyActivityLogs: Object,
});
</script>
<template>
    <div>
        <div class="">
            <BorderedContainer class="mb-8 bg-wgh-purple-3">
                <div class="space-y-8 p-6">
                    <div class="w-full text-4xl font-bold uppercase text-white">Lobby Info</div>
                    <div class="flex w-full flex-col items-center justify-around gap-10 text-gray-700 lg:flex-row">
                        <div
                            class="mt-4 flex w-full flex-col rounded-lg bg-gray-100 p-4 text-center font-inter text-base font-normal lg:w-1/4"
                        >
                            <dev class="text-md mb-2 font-semibold">The game lobby will be available at:</dev>
                            <dev>{{
                                dayjs(gameLobby.data.scheduled_at)
                                    .utc()
                                    .local()
                                    .tz(dayjs.tz.guess())
                                    .format('MMMM DD, YYYY hh:mm A')
                            }}</dev>
                        </div>
                        <div
                            class="mt-4 flex w-full flex-col rounded-lg bg-gray-100 p-4 text-center font-inter text-base font-normal lg:w-1/4"
                        >
                            <dev class="text-md mb-2 font-semibold">The game lobby will start at:</dev>
                            <dev>{{
                                dayjs(gameLobby.data.start_at)
                                    .utc()
                                    .local()
                                    .tz(dayjs.tz.guess())
                                    .format('MMMM DD, YYYY hh:mm A')
                            }}</dev>
                        </div>
                        <div
                            class="mt-4 flex w-full flex-col rounded-lg bg-gray-100 p-4 font-inter text-base font-normal lg:w-1/4"
                        >
                            <dev class="text-md mb-2 text-center font-semibold">Current Lobby Users:</dev>
                            <dev class="text-center">{{ usersCount }}</dev>
                        </div>
                        <div
                            v-if="gameLobby.data.type != 3 && gameLobby.data.game_play_duration"
                            class="mt-4 flex w-full flex-col rounded-lg bg-gray-100 p-4 text-center font-inter text-base font-normal lg:w-1/4"
                        >
                            <dev class="text-md mb-2 font-semibold">Gam Play Duration:</dev>
                            <dev
                                >{{ gameLobby.data.game_play_duration / 60 }}
                                <span class="font-semibold">min</span></dev
                            >
                        </div>
                    </div>
                </div>
            </BorderedContainer>
        </div>
        <div v-if="gameLobbyActivityLogs.data.length">
            <GameLobbySteps :steps="gameLobbyActivityLogs.data" class="mb-5" />
        </div>
    </div>
</template>
