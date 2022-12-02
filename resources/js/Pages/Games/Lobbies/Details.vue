<script setup>
import { inject, defineProps } from 'vue';
import { Inertia } from '@inertiajs/inertia';
import { Link } from '@inertiajs/inertia-vue3';
import { useCurrentUser } from '@/Composables/useCurrentUser';
import BorderedContainer from '@/Shared/BorderedContainer';
import { ClockIcon, InformationCircleIcon, TrophyIcon } from '@heroicons/vue/24/solid';
import { CurrencyDollarIcon } from '@heroicons/vue/24/solid';
import { Bars4Icon } from '@heroicons/vue/24/solid';
import { CalendarDaysIcon } from '@heroicons/vue/24/solid';

let currentUser = useCurrentUser();
let dayjs = inject('dayjs');

let props = defineProps({
    gameLobby: Object,
    scores: Object,
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
        <BorderedContainer class="bg-purple-300 mb-10">
            <div class="flex flex-col md:flex-row rounded-lg bg-gray-50 p-6">
                <div class="w-full md:w-3/5 mr-5 flex flex-col md:flex-row item-start mt-10 mb-5">
                    <div class="mb-5 md:mr-16">
                        <img :src="gameLobby.data.game.image_url" :alt="`${gameLobby.data.game.name} art`"
                            class="aspect-[16/9] rounded-lg md:mb-0 max-h-[40.25rem] md:w-full md:max-h-[10.25rem]"
                        />
                    </div>
                    <div class="max-w-4xl">
                        <div class="text-2xl font-bold mb-5">
                            {{gameLobby.data.game.name}}
                        </div>
                        <div class="text-md text-gray-500">
                            {{gameLobby.data.game.description?.substring(0,100)+ '...' }}
                        </div>
                    </div>
                </div>
                <div class="w-full md:w-2/5 space-y-9 divide-y-2 font-semibold">
                    <div class="flex gap-2">
                        <div><Bars4Icon class="h-5 w-5"/></div>
                        <div>{{gameLobby.data.name?.substring(0,25)+ '...' }}</div>
                    </div>
                    <div class="flex gap-2">
                        <div><TrophyIcon class="h-5 w-5"/></div>
                        <div>{{ currentUserScore.rank }} place</div>
                    </div>
                    <div class="flex gap-2">
                        <div><CurrencyDollarIcon class="h-5 w-5"/></div>
                        <div>{{ currentUserScore.rank }} earned</div>
                    </div>
                    <div class="flex gap-2">
                        <div><CalendarDaysIcon class="h-5 w-5"/></div>
                        <div>Played At {{
                                dayjs(gameLobby.data.start_at)
                                .utc()
                                .local()
                                .tz(dayjs.tz.guess())
                                .format('H:s YYYY/MM/DD')
                            }}
                        </div>
                    </div>
                </div>
            </div>
        </BorderedContainer>
        <div class="">
            <div class="text-3xl font-bold mb-6">Lobby Details</div>
            <BorderedContainer class="bg-purple-300 mb-10">
                <div class="flex flex-col md:flex-row gap-2 rounded-lg bg-gray-50 p-6">
                    <div class="w-full mb-8 md:w-1/2 md:mb-0">
                        <div class="mt-10 space-y-10 divide-y-2 font-semibold">
                            <div class="flex items-center gap-2">
                                <div><Bars4Icon class="h-5 w-5"/></div>
                                <div>{{gameLobby.data.name?.substring(0,80)+ '...' }}</div>
                            </div>
                            <div class="flex items-center gap-2">
                                <div><Bars4Icon class="h-5 w-5"/></div>
                                <div>{{ gameLobby.data.description }}</div>
                            </div>
                            <div class="flex items-center gap-2">
                                <div><CurrencyDollarIcon class="h-5 w-5"/></div>
                                <div>{{gameLobby.data.base_entrance_fee}} {{gameLobby.data.asset.symbol}} entrance fee</div>
                            </div>
                            <div class="flex items-center gap-2">
                                <div><ClockIcon class="h-5 w-5"/></div>
                                <div>{{gameLobby.data.game_play_duration}} (min)</div>
                            </div>
                            <div class="flex items-center gap-2">
                                <div><InformationCircleIcon class="h-5 w-5"/></div>
                                <div>{{gameLobby.data.type_label}}</div>
                            </div>
                        </div>
                    </div>
                    <div class="w-full md:w-1/2">
                        <div class="text-xl font-semibold mb-2">Players</div>
                        <BorderedContainer class="bg-purple-200 mb-0 md:mb-10">
                            <div class="overflow-hidden h-48 md:h-64 flex-col justify-around gap-2 rounded-lg bg-gray-50 p-4">
                                <div class="flex justify-around md:flex-row mb-4">
                                    <div class="font-semibold">Avatar</div>
                                    <div class="font-semibold">Name</div>
                                    <div class="font-semibold">Rank</div>
                                </div>
                                <div class="overflow-y-scroll">
                                    <div v-for="player in players" :key="player.id" class=" flex justify-around items-center mb-4">
                                        <div>
                                            <img :src="player.image_url" :alt="`${player.image_url} art`"
                                                class="h-5 w-5 object-cover md:h-11 md:w-11"
                                            />
                                        </div>
                                        <div>{{player.name}}</div>
                                        <div>{{player.rank}}</div>
                                    </div>
                                </div>
                            </div>
                        </BorderedContainer>
                    </div>
                </div>
            </BorderedContainer>
        </div>
        <div class="">
            <div class="text-3xl font-bold mb-6">Achievments</div>
            <BorderedContainer class="bg-purple-300 mb-10 ">
                <div class="flex flex-col md:flex-row gap-2 rounded-lg bg-gray-50 p-6">
                    <div class="w-full md:w-1/2">
                        <div class="text-xl font-semibold mb-2">Badges</div>
                        <BorderedContainer class="bg-purple-200 mb-10">
                            <div class="overflow-hidden h-72 flex-col justify-around gap-2 rounded-lg bg-gray-50 p-6">
                                <div class="flex justify-around md:flex-row mb-4">
                                    <div class="font-semibold">Avatar</div>
                                    <div class="font-semibold">Name</div>
                                    <div class="font-semibold">Rank</div>
                                </div>
                                <div class="overflow-y-scroll">
                                    <div v-for="player in players" :key="player.id" class=" flex justify-around items-center mb-4">
                                        <div>
                                            <img :src="player.image_url" :alt="`${player.image_url} art`"
                                                class="h-5 w-5 object-cover md:h-11 md:w-11"
                                            />
                                        </div>
                                        <div>{{player.name}}</div>
                                        <div>{{player.rank}}</div>
                                    </div>
                                </div>
                            </div>
                        </BorderedContainer>
                    </div>
                    <div class="w-full md:w-1/2">
                        <div class="text-xl font-semibold mb-2">NFTs</div>
                        <BorderedContainer class="bg-purple-200 mb-10">
                            <div class="overflow-hidden h-72 flex-col justify-around gap-2 rounded-lg bg-gray-50 p-6">
                                <div class="flex justify-around md:flex-row mb-4">
                                    <div class="font-semibold">Avatar</div>
                                    <div class="font-semibold">Name</div>
                                    <div class="font-semibold">Rank</div>
                                </div>
                                <div class="overflow-y-scroll">
                                    <div v-for="player in players" :key="player.id" class=" flex justify-around items-center mb-4">
                                        <div>
                                            <img :src="player.image_url" :alt="`${player.image_url} art`"
                                                class="h-5 w-5 object-cover md:h-11 md:w-11"
                                            />
                                        </div>
                                        <div>{{player.name}}</div>
                                        <div>{{player.rank}}</div>
                                    </div>
                                </div>
                            </div>
                        </BorderedContainer>
                    </div>
                </div>
            </BorderedContainer>
        </div>
    </div>
</template>
