<script setup>
import { inject, defineProps } from 'vue';
import { Inertia } from '@inertiajs/inertia';
import { Link } from '@inertiajs/inertia-vue3';
import { useCurrentUser } from '@/Composables/useCurrentUser';
import BorderedContainer from '@/Shared/BorderedContainer';

let currentUser = useCurrentUser();
let dayjs = inject('dayjs');

let props = defineProps({
    gameLobby: Object,
    scores: Object,
    current_url: String,
});
</script>

<template>
    <div>
        <!-- first section -->
        <div class="flex-col item-start lg:flex-row gap-16 mb-10">
            <div class="mb-5">
                <img :src="gameLobby.data.game.image_url" :alt="`${gameLobby.data.game.name} art`"
                    class="aspect-[16/9] rounded-lg md:mb-0 max-h-[20.25rem] md:w-full md:max-h-[10.25rem]"
                />
            </div>
            <div class="max-w-4xl">
                <div class="text-2xl font-bold mb-5">
                    {{gameLobby.data.game.name}}
                </div>
                <div class="text-md text-gray-500">
                    {{gameLobby.data.game.description}}
                </div>
            </div>
        </div>
        <div class="text-center text-3xl font-bold mb-10">Lobby Details</div>
        <div>
            <div class="">
                <BorderedContainer class="bg-gray-200">
                    <div class="divide-y-2 rounded-lg bg-gray-50 p-6">
                        <div class="py-4 flex items-center">
                            <div class="mr-4 w-1/2 text-lg font-semibold">Name:</div>
                            <div class="w-1/2">{{gameLobby.data.name}}</div>
                        </div>
                        <div class="py-4 flex items-center">
                            <div class="mr-4 w-1/2 text-lg font-semibold">Description:</div>
                            <div class="w-1/2">{{gameLobby.data.description}}</div>
                        </div>
                        <div class="py-4 flex items-center">
                            <div class="mr-4 w-1/2 text-lg font-semibold">Entrance Fee:</div>
                            <div class="w-1/2">{{gameLobby.data.base_entrance_fee}} {{gameLobby.data.asset.symbol}}</div>
                        </div>
                        <div class="py-4 flex items-center" v-if="gameLobby.data.game_play_duration">
                            <div class="mr-4 w-1/2 text-lg font-semibold">Game Play Duration:</div>
                            <div class="w-1/2">{{gameLobby.data.game_play_duration}} min</div>
                        </div>
                        <div class="py-4 flex items-center">
                            <div class="mr-4 w-1/2 text-lg font-semibold">Game Mode:</div>
                            <div class="w-1/2">{{gameLobby.data.type_label}}</div>
                        </div>
                        <div class="py-4 flex items-center">
                            <div class="mr-4 w-1/2 text-lg font-semibold">Min Players:</div>
                            <div class="w-1/2">{{gameLobby.data.min_players}} Players</div>
                        </div>
                        <div class="py-4 flex items-center">
                            <div class="mr-4 w-1/2 text-lg font-semibold">Max Players:</div>
                            <div class="w-1/2">{{gameLobby.data.max_players}} Players</div>
                        </div>
                        <div class="py-4 flex items-center">
                            <div class="mr-4 w-1/2 text-lg font-semibold">Rules:</div>
                            <div class="w-1/2">{{gameLobby.data.rules}}</div>
                        </div>
                        <div class="py-4 flex items-center">
                            <div class="mr-4 w-1/2 text-lg font-semibold">Rank:</div>
                            <div class="w-1/2">{{gameLobby.data.name}} Place</div>
                        </div>
                        <div class="py-4 flex items-center">
                            <div class="mr-4 w-1/2 text-lg font-semibold">Earned:</div>
                            <div class="w-1/2">{{gameLobby.data.name}} earned</div>
                        </div>
                        <div class="py-4 flex items-center">
                            <div class="mr-4 w-1/2 text-lg font-semibold">Played_At:</div>
                            <div class="w-1/2">{{
                                    dayjs(gameLobby.data.start_at)
                                    .utc()
                                    .local()
                                    .tz(dayjs.tz.guess())
                                    .format('YYYY/MM/DD')
                                }}
                            </div>
                        </div>
                    </div>
                </BorderedContainer>
                <div>{{gameLobby.data.name}}</div>
            </div>
        </div>
        <!-- end first section -->

         <!-- {{gameLobby}} -->
        <br>
        {{scores}}
    </div>
</template>
