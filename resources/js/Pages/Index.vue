<script setup>
import GameCard from '@/Shared/GameCard';
import DashboardBalanceCard from '@/Shared/DashboardBalanceCard/DashboardBalanceCard';
import DashboardBalanceCardCreateAccount from '@/Shared/DashboardBalanceCard/DashboardBalanceCardCreateAccount';
import ButtonShape from '@/Shared/ButtonShape';
import ActiveSessionBanner from '@/Shared/ActiveSessionBanner';
import KiteArrow from '@/Shared/SVG/KiteArrow';
import ChatMessage from '@/Shared/Chat/ChatMessage';
import { Link } from '@inertiajs/inertia-vue3';
import BorderedContainer from '@/Shared/BorderedContainer';
import { ref, reactive, onMounted, watch, inject } from 'vue';
import { Inertia } from '@inertiajs/inertia';
import ChatRoom from '@/Models/ChatRoom';
import CooldownBanner from '@/Shared/CooldownBanner';
import { useCurrentUser } from '@/Composables/useCurrentUser';
import { throttle } from 'lodash';
import Datepicker from '@vuepic/vue-datepicker';
import '@vuepic/vue-datepicker/dist/main.css';

// let currentUser = inject('currentUser');
let currentUser = useCurrentUser();

let chatBox = ref();
let snack = inject('snack');

let props = defineProps({
    mainChatRoom: Object,
    availableGames: Object,
    assets: Object,
    gameTypes: Object,
    filters: Object,
    current_url: String,
    config: Object,
    balance: Array,
});

onMounted(() => {
    window.echo.channel('chat-rooms.main').listen('.message', (payload) => {
        state.chatMessages.push(payload);
    });
});

let filters = reactive({ ...props.filters });
let currentUrl = window.location.toString();
let state = reactive({
    chatMessages: [],
    chatMessageBody: '',
    chatRoom: new ChatRoom(props.mainChatRoom.data),
});

watch(
    () => filters,
    throttle(() => {
        Inertia.get(currentUrl, { ...filters }, { preserveState: true, preserveScroll: true });
    }, 1000),
    {
        deep: true,
    }
);

watch(
    () => props.gameLobbies,
    (value, oldValue) => {
        state.gameLobbies = new GameLobbyCollection(value);
    },
    {
        deep: true,
    }
);

watch(
    state.chatMessages,
    () => {
        chatBox.value.scrollTop = chatBox.value.scrollHeight;
    },
    {
        flush: 'post',
    }
);
</script>
<template>
    <div class="flex h-full flex-col lg:flex-row lg:space-x-6">
        <div class="w-full lg:w-3/4">
            <ActiveSessionBanner />
            <CooldownBanner />
            <BorderedContainer class="mb-8 bg-wgh-purple-3">
                <div
                    class="flex flex-col space-y-6 rounded-lg bg-wgh-purple-2 p-6 md:flex-row md:space-x-6 md:space-y-0"
                >
                    <div class="w-full md:w-1/2">
                        <img :src="props.config.dashboard_art" alt="Dashboard Art" />
                    </div>
                    <div class="flex w-full flex-col justify-center md:w-1/2">
                        <h2 class="font-grota text-2xl font-extrabold text-white">
                            The First Retro Gaming Playground Competitions!
                        </h2>
                        <p class="mt-4 font-inter text-base font-normal text-white">
                            Monetize blockchain gaming with the Wodo XWGT Token, available across the Wodo Gaming Hub.
                            Earn, play and win with Wodo!
                        </p>
                    </div>
                </div>
            </BorderedContainer>
            <div class="my-10 flex justify-between">
                <div>
                    <div class="mb-3">
                        <label for="Name" class="form-label mb-2 inline-block text-lg text-gray-700">Name</label>
                        <input
                            type="text"
                            class="form-control m-0 block rounded border border-solid border-gray-300 bg-white bg-clip-padding px-2 py-1 text-lg font-normal text-gray-700 transition ease-in-out focus:border-blue-600 focus:bg-white focus:text-gray-700 focus:outline-none"
                            name="search"
                            id="search"
                            placeholder="Search"
                            v-model="filters.q"
                        />
                    </div>
                    <div>
                        <div class="mb-3 xl:w-64">
                            <label for="Date" class="form-label mb-2 inline-block text-lg text-gray-700">Date</label>
                            <Datepicker
                                range
                                required
                                class="block rounded-md border border-wgh-gray-1.5 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                                utc
                                placeholder="Select date and time"
                                v-model="filters.date"
                                :min-date="new Date()"
                                :max-date="maxDate"
                            ></Datepicker>
                        </div>
                    </div>
                </div>
                <div>
                    <div>
                        <div class="mb-3">
                            <label for="Maximum Players" class="form-label mb-2 inline-block text-lg text-gray-700"
                                >Mode</label
                            >
                            <select
                                id="asset_name"
                                name="asset_name"
                                v-model="filters.games_gamelobbies_type"
                                class="flex rounded border border-wgh-gray-1 px-4 py-2 pr-10 font-grota text-sm font-normal text-wgh-gray-6 placeholder-wgh-gray-3 outline-none"
                            >
                                <option :value="undefined">All</option>
                                <option :key="index" v-for="(gameType, index) in gameTypes" :value="gameType.value">
                                    {{ gameType.label }}
                                </option>
                            </select>
                        </div>
                    </div>
                    <div>
                        <div class="mb-3">
                            <label for="Asset" class="form-label mb-2 inline-block text-lg text-gray-700">Asset</label>
                            <select
                                id="games_gamelobbies_asset_symbol"
                                name="games_gamelobbies_asset_symbol"
                                v-model="filters.games_gamelobbies_asset_symbol"
                                class="flex rounded border border-wgh-gray-1 px-4 py-2 pr-10 font-grota text-sm font-normal text-wgh-gray-6 placeholder-wgh-gray-3 outline-none"
                            >
                                <option :value="undefined">All</option>
                                <option :key="asset.id" v-for="asset in assets" :value="asset.symbol">
                                    {{ asset.name }}
                                </option>
                            </select>
                        </div>
                    </div>
                </div>
                <div>
                    <div>
                        <div class="mb-3">
                            <label
                                for="Minimum Base Entrance Fee"
                                class="form-label mb-2 inline-block text-lg text-gray-700"
                                >Minimum Base Entrance Fee</label
                            >
                            <input
                                class="form-control m-0 block rounded border border-solid border-gray-300 bg-white bg-clip-padding px-2 py-1 text-lg font-normal text-gray-700 transition ease-in-out focus:border-blue-600 focus:bg-white focus:text-gray-700 focus:outline-none"
                                type="number"
                                name="min-base_entrance_fee"
                                id="min-base_entrance_fee"
                                v-model="filters.min_base_entrance_fee"
                                placeholder="Minimum Base Entrance Fee"
                            />
                        </div>
                        <div>
                            <div class="mb-3">
                                <label
                                    for="Maximum Base Entrance Fee"
                                    class="form-label mb-2 inline-block text-lg text-gray-700"
                                    >Maximum Base Entrance Fee</label
                                >
                                <input
                                    class="form-control m-0 block rounded border border-solid border-gray-300 bg-white bg-clip-padding px-2 py-1 text-lg font-normal text-gray-700 transition ease-in-out focus:border-blue-600 focus:bg-white focus:text-gray-700 focus:outline-none"
                                    type="number"
                                    name="max-base_entrance_fee"
                                    id="max-base_entrance_fee"
                                    v-model="filters.max_base_entrance_fee"
                                    placeholder="Maximum Base Entrance Fee"
                                />
                            </div>
                        </div>
                    </div>
                </div>
                <div>
                    <div>
                        <div class="mb-3">
                            <label for="Minimum Players" class="form-label mb-2 inline-block text-lg text-gray-700"
                                >Minimum Players</label
                            >
                            <input
                                class="form-control m-0 block rounded border border-solid border-gray-300 bg-white bg-clip-padding px-2 py-1 text-lg font-normal text-gray-700 transition ease-in-out focus:border-blue-600 focus:bg-white focus:text-gray-700 focus:outline-none"
                                type="number"
                                name="min-players"
                                id="min-players"
                                v-model="filters.min_players"
                                placeholder="Minimum Players"
                            />
                        </div>
                    </div>
                    <div>
                        <div class="mb-3">
                            <label for="Maximum_Players" class="form-label text-md mb-2 inline-block text-gray-700"
                                >Maximum Players</label
                            >
                            <input
                                class="form-control m-0 block rounded border border-solid border-gray-300 bg-white bg-clip-padding px-2 py-1 text-lg font-normal text-gray-700 transition ease-in-out focus:border-blue-600 focus:bg-white focus:text-gray-700 focus:outline-none"
                                type="number"
                                name="max-players"
                                id="max-players"
                                v-model="filters.max_players"
                                placeholder="Maximum Players"
                            />
                        </div>
                    </div>
                </div>
            </div>
            <h1 class="mb-6 font-grota text-2xl font-extrabold text-wgh-gray-6">Games</h1>
            <div>
                <GameCard
                    v-for="availableGame in props.availableGames.data"
                    :key="availableGame.id"
                    :game="availableGame"
                />
            </div>
        </div>
        <div class="flex flex-col space-y-6 lg:w-1/4">
            <DashboardBalanceCard v-if="currentUser" :balance="balance" :asset_accounts="currentUser.asset_accounts" />
            <DashboardBalanceCardCreateAccount v-if="!currentUser" />
            <BorderedContainer class="h-[30rem] grow bg-wgh-purple-3">
                <div class="flex h-full w-full grow flex-col justify-between rounded-lg bg-white p-4">
                    <img
                        v-if="state.chatMessages.length === 0"
                        class="mx-auto w-40 grow"
                        :src="config.game_lobby_loading_gif"
                        alt="Loading.."
                    />
                    <div
                        id="chat-messages"
                        class="flex grow flex-col space-y-2 overflow-y-auto scroll-smooth px-2 pb-2"
                        ref="chatBox"
                    >
                        <ChatMessage
                            v-for="(chatMessage, index) in state.chatMessages"
                            :key="index"
                            :from-me="chatMessage.sender.id === currentUser.id"
                            :user-image-url="chatMessage.sender.image_url"
                            :time="chatMessage.created_at_human_readable"
                            :username="chatMessage.sender.username"
                            :message="chatMessage.message.message"
                        />
                    </div>
                    <div class="flex items-center justify-between rounded-md lg:flex-col xl:flex-row">
                        <input
                            type="text"
                            class="p-2 outline-none ring-0"
                            placeholder="Type your message here"
                            v-model="state.chatMessageBody"
                            @keyup.enter="
                                state.chatRoom.sendChatMessage(state.chatMessageBody);
                                state.chatMessageBody = '';
                            "
                        />
                        <button
                            :disabled="state.chatMessageBody.length <= 0"
                            @click.prevent="state.chatRoom.sendChatMessage(state.chatMessageBody)"
                            class="rounded-md bg-wgh-purple-2 py-2 px-4 disabled:cursor-no-drop"
                        >
                            <KiteArrow class="h-4 w-4" />
                        </button>
                    </div>
                    <Link href="/login">
                        <ButtonShape v-if="!currentUser" type="purple" class="w-full text-center">
                            <p class="w-full text-center">Click here to register</p>
                        </ButtonShape>
                    </Link>
                </div>
            </BorderedContainer>
        </div>
    </div>
</template>
