<script setup>
import { inject, defineProps, reactive } from 'vue';
import { useCurrentUser } from '@/Composables/useCurrentUser';
import BorderedContainer from '@/Shared/BorderedContainer';
import { ClockIcon, InformationCircleIcon, TrophyIcon } from '@heroicons/vue/24/solid';
import { CurrencyDollarIcon } from '@heroicons/vue/24/solid';
import { Bars4Icon } from '@heroicons/vue/24/solid';
import { CalendarDaysIcon } from '@heroicons/vue/24/solid';
import CardList from '@/Shared/CardList.vue';
import CardListItem from '@/Shared/CardListItem.vue'
import CardListItemModal from '../../../Shared/Modals/CardListItemModal.vue';

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

let state = reactive({
    showCardListItemModal: false,
    selectedItem: [],
});

let badges = [
    {
        id: 1,
        name: "sharp shooter",
        image_url: "https://avatars.dicebear.com/api/adventurer/sduhfuih.svg",
        description: "its a badge for the most head shots"
    },
    {
        id: 2,
        name: "tank master",
        image_url: "https://avatars.dicebear.com/api/adventurer/asd.svg",
        description: "its a badge for the best tank drivers "
    },
    {
        id: 3,
        name: "chicken dinner",
        image_url: "https://avatars.dicebear.com/api/adventurer/sduhqfuih.svg",
        description: "its a badge for battle royal winners"
    },
    {
        id: 4,
        name: "last man stand",
        image_url: "https://avatars.dicebear.com/api/adventurer/asdf.svg",
        description: "Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum"
    },
    {
        id: 5,
        name: "men of mayhem",
        image_url: "https://avatars.dicebear.com/api/adventurer/qwe.svg",
        description: "iasdsadsa sadsa ds"
    },
]

let nfts = [
    {
        id: 1,
        name: "wodo network XWGT",
        image_url: "https://avatars.dicebear.com/api/adventurer/xcv.svg",
        description: "lorem ipsum"
    },
    {
        id: 2,
        name: "ninja squad nft #1",
        image_url: "https://avatars.dicebear.com/api/adventurer/fgh.svg",
        description: "lorem ipsum"
    },
    {
        id: 3,
        name: "monkey club nft #3",
        image_url: "https://avatars.dicebear.com/api/adventurer/tyh.svg",
        description: "lorem ipsum"
    },
    {
        id: 4,
        name: "luna token",
        image_url: "https://avatars.dicebear.com/api/adventurer/bdf.svg",
        description: "lorem ipsum"
    },
    {
        id: 5,
        name: "men of mayhem",
        image_url: "https://avatars.dicebear.com/api/adventurer/bfg.svg",
        description: "lorem ipsum"
    },
]

let achievements= [
    {
        id: 1,
        name: "played wodo mini-fps 1000 times",
        description: "lorem ipsum",
    },
    {
        id: 2,
        name: "you have earned more tokens from anyone else",
        description: "lorem ipsum",
    },
    {
        id: 2,
        name: "you have earned more tokens from anyone else",
        description: "lorem ipsum",
    },
    {
        id: 2,
        name: "you have earned more tokens from anyone else",
        description: "lorem ipsum",
    },
    {
        id: 2,
        name: "you have earned more tokens from anyone else",
        description: "lorem ipsum",
    },
    {
        id: 2,
        name: "you have earned more tokens from anyone else",
        description: "lorem ipsum",
    },
    {
        id: 2,
        name: "you have earned more tokens from anyone else",
        description: "lorem ipsum",
    },
    {
        id: 2,
        name: "you have earned more tokens from anyone else",
        description: "lorem ipsum",
    },
];

function modalClickToggled(item){
    state.showCardListItemModal=true
    state.selectedItem = item
}

</script>
<template>
    <CardListItemModal :itemInfo="state.selectedItem" :open="state.showCardListItemModal" @closed="state.showCardListItemModal = false" />
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
                    <CardList>
                        <template v-slot:title>
                            Players
                        </template>
                        <template v-slot:header>
                            <div class="font-semibold">Avatar</div>
                            <div class="font-semibold">Name</div>
                            <div class="font-semibold">Rank</div>
                        </template>
                        <div v-for="player in players" :key="player.id" class=" flex justify-around items-center mb-4">
                            <div>
                                <img :src="player.image_url" :alt="`${player.image_url} art`"
                                    class="h-5 w-5 object-cover md:h-11 md:w-11"
                                />
                            </div>
                            <div>{{player.name}}</div>
                            <div>{{player.rank}}</div>
                        </div>
                    </CardList>
                </div>
            </BorderedContainer>
        </div>
        <div class="">
            <div class="text-3xl font-bold mb-6">Achievements</div>
            <BorderedContainer class="bg-purple-300 mb-10 mx-auto">
                <div class="rounded-lg bg-gray-50 p-6">
                    <div class="">
                        <div class="w-full">
                            <BorderedContainer class="bg-purple-200 mb-0 md:mb-2 md:mx-10">
                                <div class="flex-col justify-around gap-2 rounded-lg bg-gray-50 p-4">
                                    <div class="flex justify-around md:flex-row mb-4">
                                        <div class="font-semibold">Name</div>
                                        <div class="font-semibold">Description</div>
                                    </div>
                                    <div class="overflow-hidden overflow-y-auto h-20 md:h-20 py-2">
                                        <div v-for="(achievement, index) in achievements" :key="achievement.id" class="flex justify-around items-center text-center mb-4" :style="{'background-color': index%2 == 0  ? '#EFF6FF' : '#DBEAFE'}">
                                            <div class="w-1/2">{{achievement.name}}</div>
                                            <div class="w-1/2">{{achievement.description}}</div>
                                        </div>
                                    </div>
                                </div>
                            </BorderedContainer>
                        </div>
                    </div>
                    <div class="flex flex-col md:flex-row gap-5 xl:gap-20 mx-auto md:mx-10">
                        <CardList>
                            <template v-slot:title>
                                Badges
                            </template>
                                <div v-for="item in badges" :key="item.id" class="border border-orange-200 bg-opacity-20 bg-purple-100 flex gap-8 items-center mb-4 py-4">
                                   <CardListItem @click="modalClickToggled(item)" :item="item"></CardListItem>
                                </div>
                        </CardList>
                        <CardList>
                            <template v-slot:title>
                                NFTs
                            </template>
                                <div v-for="item in nfts" :key="item.id" class="border border-orange-200 bg-opacity-20 bg-purple-100 flex gap-8 items-center mb-4 py-4">
                                    <CardListItem @click="modalClickToggled(item)" :item="item"></CardListItem>
                                </div>
                        </CardList>
                    </div>
                </div>
            </BorderedContainer>
        </div>
    </div>
</template>
