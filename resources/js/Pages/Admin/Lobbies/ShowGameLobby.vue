<script setup>
import { defineProps} from 'vue';
import BorderedContainer from '@/Shared/BorderedContainer';
import { Link } from '@inertiajs/inertia-vue3';
import GameLobbySteps from '@/Shared/GameLobbySteps.vue';
import { inject } from 'vue';

let dayjs = inject('dayjs');
let props = defineProps({
    gameLobby: Object,
    usersCount: Number,
});
</script>
<template>
    <div>
        <div class=""> 
            <BorderedContainer class="mb-8 bg-wgh-purple-3">
                <div class="p-6 space-y-8">
                    <div class="w-full text-4xl font-bold">
                        Lobby Info
                    </div>
                    <div class="w-full flex justify-around items-center text-gray-700 gap-10 ">
                        <div class="text-center flex flex-col mt-4 font-inter text-base font-normal bg-gray-100 w-1/4 p-4 rounded-lg">
                            <dev class="text-md mb-2 font-semibold">The game lobby will be available at:</dev> 
                            <dev>{{
                                dayjs(gameLobby.scheduled_at).utc().local().tz(dayjs.tz.guess()).format('MMMM DD, YYYY hh:mm A')
                            }}</dev> 
                        </div>
                        <div class="text-center flex flex-col mt-4 font-inter text-base font-normal bg-gray-100 w-1/4 p-4 rounded-lg">
                            <dev class="text-md mb-2 font-semibold">The game lobby will start at:</dev> 
                            <dev>{{
                                dayjs(gameLobby.start_at).utc().local().tz(dayjs.tz.guess()).format('MMMM DD, YYYY hh:mm A')
                            }}</dev> 
                        </div>
                        <div class="flex flex-col mt-4 font-inter text-base font-normal bg-gray-100 w-1/4 p-4 rounded-lg">
                            <dev class="text-center mb-2 text-md font-semibold">Current Lobby Users:</dev> 
                            <dev class="text-center">{{usersCount}}</dev> 
                        </div>
                        <div v-if="gameLobby.data.type != 3" class="text-center flex flex-col mt-4 font-inter text-base font-normal bg-gray-100 w-1/4 p-4 rounded-lg">
                            <dev class="text-md font-semibold mb-2">Gam Play Duration:</dev> 
                            <dev>{{gameLobby.data.game_play_duration/60}} <span class="font-semibold">min</span></dev> 
                        </div>
                    </div>
                </div>
            </BorderedContainer>
        </div>
        <div v-if="gameLobby.data.game_lobby_logs.length">
            <GameLobbySteps :steps="gameLobby.data.game_lobby_logs" style="zoom: 160%;"  class="mb-5"/>
        </div>
    </div>
</template>
