<script setup>
import GameOptionsIcon from '@/Shared/SVG/GameOptionsIcon';
import GameLiveIcon from '@/Shared/SVG/GameLiveIcon';
import BorderedContainer from '@/Shared/BorderedContainer';
import ButtonShape from '@/Shared/ButtonShape';
import ChevronLeft from '@/Shared/SVG/ChevronLeft';
import { Inertia } from '@inertiajs/inertia';
import { Link } from '@inertiajs/inertia-vue3';
import { inject, reactive, watch } from 'vue';
import { isEmpty } from 'lodash';
import TentModal from '@/Shared/Modals/TentModal';
import ActiveSessionBanner from '@/Shared/ActiveSessionBanner';
import Game from '@/Models/Game';
import GameLobby from '@/Models/GameLobby';
import CooldownBanner from '@/Shared/CooldownBanner';
import { onBeforeMount, onMounted } from 'vue';
import GameLobbyCollection from '@/Models/GameLobbyCollection';
import Pagination from '@/Models/Pagination';
import { useCurrentUser } from '@/Composables/useCurrentUser';
import Datepicker from '@vuepic/vue-datepicker';
import '@vuepic/vue-datepicker/dist/main.css';
import { throttle } from 'lodash';

//TODO: useing currentUser insted of inject because inject does not reload
// let currentUser = inject('currentUser');
let currentUser = useCurrentUser();

let props = defineProps({
    game: Object,
    gameLobbies: Object,
    gameTypes: Object,
    filters: Object,
    current_url: String,
    flash: Object,
});

let filters = reactive({ ...props.filters });
let currentUrl = window.location.toString();
let pagination = reactive(new Pagination(props.gameLobbies));
const lobbyCount = generateNumber(52,41);
const onlinePlayers = generateNumber(2100,1501);

function generateNumber(max, min) {
      return Math.floor(Math.random()*(max-min+1)+min);
};

watch(
    () => filters,
    throttle(() => {
        Inertia.get(currentUrl, { filter_by_asset: filters.filter_by_asset, q: filters.q }, { preserveState: true });
    }, 1000),
    {
        deep: true,
    }
);

onMounted(() => {
    if (currentUser) {
        currentUser.startCooldownCountdownTimer();
    }
});

onBeforeMount(() => {
    if (currentUser) {
        currentUser.killCooldownCountdownTimer();
    }
});

let state = reactive({
    game: new Game(props.game.data),
    gameLobbies: new GameLobbyCollection(props.gameLobbies),
    selectedGameLobby: {},
    settings: {
        startGameConfirmationModalIsOpen: false,
        currentActiveLobbySession: currentUser?.current_lobby_session
            ? new GameLobby(currentUser.current_lobby_session.data)
            : null,
    },
});

// Open Modal and set the selected game option
function startGameButtonClicked(gameLobby) {
    if (!currentUser) {
        Inertia.visit('/login');
        return;
    }

    gameLobby = new GameLobby(gameLobby);
    if (state.settings.currentActiveLobbySession && state.settings.currentActiveLobbySession.is(gameLobby)) {
        gameLobby.redirectBackToGameLobby();
        return;
    }

    state.selectedGameLobby = gameLobby;
    state.settings.startGameConfirmationModalIsOpen = true;
}

function modalStartGameButtonClicked() {
    if (isEmpty(state.selectedGameLobby)) {
        return;
    }

    state.selectedGameLobby.join();
    state.settings.startGameConfirmationModalIsOpen = false;
}

function modalCancelGameButtonClicked() {
    state.settings.startGameConfirmationModalIsOpen = false;
}
</script>

<template>
    <div>
        <TentModal :open="state.settings.startGameConfirmationModalIsOpen">
            <template v-slot:header><p>Ready to Play!</p></template>
            <template v-slot:title>
                <p>{{ state.game.name }} - {{ state.selectedGameLobby.name }}</p>
            </template>
            <template v-slot:subtitle>
                <p class="wgh-gray-6 font-inter text-base font-normal">
                    Entrance fee for this lobby is
                    {{ state.selectedGameLobby?.base_entrance_fee }}
                    {{ state.selectedGameLobby?.asset?.symbol }} <br />
                    are you sure you want continue ?
                </p>
            </template>
            <template v-slot:actions>
                <button @click.prevent="modalCancelGameButtonClicked">
                    <ButtonShape type="gray">
                        <span>Cancel</span>
                    </ButtonShape>
                </button>
                <button @click.prevent="modalStartGameButtonClicked">
                    <ButtonShape type="red">
                        <span>Start</span>
                    </ButtonShape>
                </button>
            </template>
        </TentModal>
        <div>
            <BorderedContainer class="mb-10 bg-wgh-purple-3">
                <div class="flex flex-col justify-between rounded-lg bg-wgh-purple-2 p-7 md:flex-row">
                    <div class="mb-4 flex flex-row space-x-6 lg:mb-0">
                        <Link href="/">
                            <ButtonShape type="whiteBorderPurple">
                                <ChevronLeft class="text-white" />
                            </ButtonShape>
                        </Link>
                        <div class="flex flex-col space-y-2">
                            <h1 class="font-grota text-3xl font-extrabold uppercase text-white">
                                {{ state.game.name }}
                            </h1>
                            <p class="max-w-3xl font-inter text-sm font-normal text-white">
                                {{ state.game.description }}
                            </p>
                        </div>
                    </div>
                    <div class="flex shrink-0 flex-row divide-x divide-wgh-gray-0.5">
                        <div class="flex flex-row items-center space-x-2 pr-4 md:space-x-4">
                            <GameOptionsIcon class="h-6 w-6 text-white" />
                            <div class="flex flex-col">
                                <span class="font-inter text-[10px] font-semibold uppercase text-wgh-gray-2"
                                    >Game Lobbies</span
                                >
                                <span class="font-grota text-sm font-normal uppercase text-white"
                                    >{{ /*state.gameLobbies.meta.total.toLocaleString('en')*/lobbyCount }} Lobbies</span
                                >
                            </div>
                        </div>
                        <div class="flex flex-row items-center space-x-2 pl-4 md:space-x-4">
                            <GameLiveIcon class="h-6 w-6 text-white" />
                            <div class="flex flex-col">
                                <span class="font-inter text-[10px] font-semibold uppercase text-wgh-gray-2"
                                    >Online Players</span
                                >
                                <span class="font-grota text-sm font-normal uppercase text-white"> {{ onlinePlayers }} Players</span>
                            </div>
                        </div>
                    </div>
                </div>
            </BorderedContainer>
            <ActiveSessionBanner />
            <CooldownBanner />
            
                
            <BorderedContainer
                class="mb-8 flex flex-col justify-around space-y-6  p-6 xl:flex-row xl:space-x-6 xl:space-y-0"
            >
                <div class="flex items-center gap-2 rounded-lg p-4">
                    <span>name</span>
                    <input
                        type="text"
                        name="search"
                        id="search"
                        class="block w-full rounded-md border border-wgh-gray-1.5 py-3 px-2 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                        placeholder="Search"
                    />
                        <!-- v-model="filters.q" -->
                </div>
                <div class="flex items-center gap-2 rounded-lg p-4">
                    <span>Mode</span>
                    <select
                        id="asset_name"
                        name="asset_name"
                        class="flex w-full flex-none rounded border border-wgh-gray-1 px-4 py-2 pr-10 font-grota text-sm font-normal text-wgh-gray-6 placeholder-wgh-gray-3 outline-none"
                    >
                        <!-- v-model="AddLobbyForm.algorithm_id" -->
                        <option value="all">all</option>
                        <option :key="index" v-for="(gameType, index) in gameTypes" :value="gameType.value">
                            {{ gameType.label }}
                        </option>
                    </select>
                        <!-- v-model="filters.q" -->
                </div>
                <div class="flex items-center gap-2 rounded-lg p-4">
                    <span>Prize</span>
                    <input
                        type="text"
                        name="search"
                        id="search"
                        class="block w-full rounded-md border border-wgh-gray-1.5 py-3 px-2 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                        placeholder="Search"
                    />
                        <!-- v-model="filters.q" -->
                </div>
                <div class="flex items-center gap-2 rounded-lg p-4">
                    <span>Players</span>
                    <input
                        type="text"
                        name="search"
                        id="search"
                        class="block w-full rounded-md border border-wgh-gray-1.5 py-3 px-2 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                        placeholder="Search"
                    />
                        <!-- v-model="filters.q" -->
                </div>
                <div class="flex items-center gap-2 rounded-lg p-4">
                    <span>StartTime</span>
                    <Datepicker
                        required
                        class="w-full"
                        utc
                        placeholder="Select date and time"
                        :min-date="new Date()"
                        :max-date="maxDate"
                    ></Datepicker>
                        <!-- v-model="AddLobbyForm.start_at" -->
                        <!-- v-model="filters.q" -->
                </div>
                
            </BorderedContainer>
            <BorderedContainer
                v-if="flash.error"
                class="mb-8 flex flex-col space-y-6 border-wgh-red-3 bg-wgh-red-2 p-6 md:flex-row md:space-x-6 md:space-y-0"
            >
                <div class="rounded-lg p-4">
                    <p class="font-grota text-2xl font-extrabold text-white">
                        {{ flash.error }}
                    </p>
                </div>
            </BorderedContainer>
            <div class="grid grid-cols-1 flex-row flex-wrap gap-6 md:grid-cols-2 lg:grid-cols-3 lg:px-12">
                <borderedContainer
                    v-for="gameLobby in state.gameLobbies.data"
                    :key="gameLobby.id"
                    :style="{ 'background-color': `${gameLobby.theme_color}` }"
                >
                    <div class="h-full max-w-3xl rounded-lg bg-white p-6">
                        <div class="aspect-w-16 aspect-h-9 mb-4">
                            <img
                                class="rounded-lg"
                                :src="gameLobby.image_url"
                                :alt="`${state.game.name} - ${gameLobby.name} Art`"
                            />
                        </div>
                        <div class="mb-4 flex flex-row justify-between space-x-2">
                            <h2 class="font-grota text-xl font-extrabold uppercase text-wgh-gray-6">
                                {{ gameLobby.name }}
                            </h2>
                            <div class="text-bold shrink-0 font-grota text-base text-wgh-gray-6">
                                <span>{{ gameLobby.base_entrance_fee }} {{ gameLobby.asset?.symbol }}</span>
                            </div>
                        </div>
                        <button
                            v-if="!currentUser?.cooldown_end_at"
                            class="mb-6 w-full uppercase disabled:cursor-not-allowed"
                            @click.prevent="startGameButtonClicked(gameLobby)"
                            :disabled="
                                state.settings.currentActiveLobbySession &&
                                state.settings.currentActiveLobbySession.is(gameLobby)
                            "
                        >
                            <ButtonShape type="red">
                                <div class="w-full content-center">
                                    <span
                                        class="w-full"
                                        v-if="
                                            state.settings.currentActiveLobbySession &&
                                            state.settings.currentActiveLobbySession.is(gameLobby)
                                        "
                                        >Rejoin Lobby</span
                                    >
                                    <span v-else class="w-full">Start Playing</span>
                                </div>
                            </ButtonShape>
                        </button>

                        <div>
                            <p class="mb-2 font-inter text-sm font-semibold text-wgh-gray-6">Game Rules</p>
                            <div class="list-inside list-disc font-inter text-sm font-normal text-wgh-gray-4">
                                {{ gameLobby?.rules }}
                            </div>
                        </div>
                    </div>
                </borderedContainer>
            </div>
            <BorderedContainer class="my-4 bg-wgh-gray-1.5" v-if="pagination.meta.from">
                <nav
                    class="flex w-full items-center justify-between rounded-lg border-t border-gray-200 bg-white px-4 py-3 sm:px-6"
                    aria-label="Pagination"
                >
                    <div class="hidden sm:block">
                        <p class="font-inter text-sm text-gray-700">
                            Showing
                            {{ ' ' }}
                            <span class="font-medium">{{ pagination.meta.from }}</span>
                            {{ ' ' }}
                            to
                            {{ ' ' }}
                            <span class="font-medium">{{ pagination.meta.to }}</span>
                            {{ ' ' }}
                            of
                            {{ ' ' }}
                            <span class="font-medium">{{ pagination.meta.total }}</span>
                            {{ ' ' }}
                            results
                        </p>
                    </div>
                    <div class="flex flex-1 justify-between space-x-4 sm:justify-end">
                        <Link :href="pagination.links.prev">
                            <ButtonShape v-if="pagination.links.prev" type="gray"> Previous</ButtonShape>
                        </Link>
                        <Link :href="pagination.links.next">
                            <ButtonShape v-if="pagination.links.next" type="gray"> Next</ButtonShape>
                        </Link>
                    </div>
                </nav>
            </BorderedContainer>
        </div>
    </div>
</template>
