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
    currentUserScore: Object,
    current_url: String,
});

let players = _.merge(_.keyBy(props.gameLobby.data.users, 'id'), _.keyBy(props.gameLobby.data.scores, 'user_id'));
let orderedPlayers = _.flatten(players);
orderedPlayers = _.concat(
    _.orderBy(
        _.filter(players, (player) => {
            if (player.rank % 2 === 0) {
                return player.rank % 2 === 0;
            }
        }),
        ['rank'],
        ['desc']
    ),
    _.orderBy(
        _.filter(players, (player) => {
            if (player.rank % 2 !== 0) {
                return player.rank;
            }
        }),
        ['rank'],
        ['asc']
    )
);
</script>
<template>
    <div>
        <BorderedContainer class="bg-green-200 mb-10">
            <div class="divide-y-2 rounded-lg bg-gray-50 p-6">
                <div class="flex flex-col  md:flex-row item-start gap-16 mt-10 mb-5">
                    <div class="mb-5">
                        <img :src="gameLobby.data.game.image_url" :alt="`${gameLobby.data.game.name} art`"
                            class="aspect-[16/9] rounded-lg md:mb-0 max-h-[40.25rem] md:w-full md:max-h-[10.25rem]"
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
            </div>
        </BorderedContainer>
        <BorderedContainer class="bg-green-200 mb-10">
            <div class="divide-y-2 rounded-lg bg-gray-50 p-2">
                <div class="text-center text-3xl font-bold mb-10">Top Players</div>
                <div class="flex flex-col md:flex-row justify-around py-5 md:text-center">
                    <div v-for="player in orderedPlayers" :key="player.id" class="flex flex-row md:flex-col">
                        <div class="mb-4 w-1/2 md:w-20">
                            <img :src="player.image_url" :alt="`${player.image_url} art`"
                                class="h-12 w-12 object-cover md:h-24 md:w-24"
                            />
                        </div>
                        <div class="w-1/2 md:w-20">
                            <div>{{player.name}}</div>
                            <div>Rank: {{player.rank}}</div>
                        </div>
                    </div>
                </div>
                <div
                    class="mb-6"
                    v-if="currentUserScore && currentUserScore.hasOwnProperty('rank')"
                >
                    <p class="text-center font-semibold text-lg mt-5 text-wgh-gray-6">
                        Your Rank: #
                        {{ currentUserScore.rank }}
                    </p>
                    <p class="text-center font-semibold text-lg mt-5 text-wgh-gray-6">
                        Earned:
                        {{ currentUserScore.rank }}
                    </p>
                </div>
            </div>
        </BorderedContainer>
        <BorderedContainer class="bg-blue-200 mb-4">
            <div class="divide-y-2 rounded-lg bg-gray-50 p-6">
                <div class="text-center text-3xl font-bold ">Lobby Details</div>
            </div>
        </BorderedContainer>
        <div>
            <div class="">
                <BorderedContainer class="bg-blue-200 mb-10">
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
            </div>
        </div>
    </div>
</template>
