<script setup>
import BorderedContainer from '@/Shared/BorderedContainer';
import KiteArrow from '@/Shared/SVG/KiteArrow';
import ChatMessage from '@/Shared/Chat/ChatMessage';
import { onBeforeUnmount, onMounted, defineProps, reactive, ref, watch } from 'vue';
import { Inertia } from '@inertiajs/inertia';
import { inject } from 'vue';
import LeaderBoardModal from '@/Shared/Modals/LeaderBoardModal';
import GameAbortedRefundingDialog from '@/Shared/Modals/GameAbortedRefundingDialog';
import GameLobby from '@/Models/GameLobby';
import { Link } from '@inertiajs/inertia-vue3';
import { useCurrentUser } from '@/Composables/useCurrentUser';

let currentUser = useCurrentUser();

let props = defineProps({
    gameLobby: Object,
    config: Object,
    prize: Number,
    currentUserScore: Object,
    current_url: String,
});

let data = reactive({
    latestUpdateMessage: props.gameLobby.data.latest_update,
    chatMessages: [],
    chatMessageInput: '',
});
let chatBox = ref();

// let currentUser = inject('currentUser');

let gameLobbyModel = reactive(new GameLobby(props.gameLobby.data));

onMounted(() => {
    if (gameLobbyModel.status === GameLobby.availableStatuses.InGame) {
        channelInGame({ url: gameLobbyModel.url });
    }
    gameLobbyModel.startCountDownTimer();
    if (currentUser) {
        window.echo
            .join(`game-lobby.${gameLobbyModel.id}`)
            .error(channelError)
            .listen(GameLobby.socketEvents.chatMessage, channelNewChatMessage)
            .listen(GameLobby.socketEvents.userJoined, channelUserJoined)
            .listen(GameLobby.socketEvents.userLeft, channelUserLeft)
            .listen(GameLobby.socketEvents.status.inGame, channelInGame)
            .listen(GameLobby.socketEvents.status.gameStartDelayed, channelGameStartDelayed)
            .listen(GameLobby.socketEvents.status.gameAbortedRefunding, channelAbortedRefunding)
            .listen(GameLobby.socketEvents.status.gameAborted, channelAborted)
            .listen(GameLobby.socketEvents.status.gameEnded, channelGameEnded)
            .listen(GameLobby.socketEvents.status.distributingPrizes, channelDistributingPrizes)
            .listen(GameLobby.socketEvents.status.distributedPrizes, channelDistributedPrizes)
            .listen(GameLobby.socketEvents.status.archived, channelArchived)
            .listen(GameLobby.socketEvents.prizeUpdated, channelPrizeUpdated)
            .listen(GameLobby.socketEvents.status.latestUpdate, channelLatestUpdate);
    }
});

onBeforeUnmount(() => {
    gameLobbyModel.killCountDownTimer();
    if (currentUser) {
        window.echo.leave(`game-lobby.${gameLobbyModel.id}`);
    }
});

function channelError(error) {
    console.error('channel error: ', error);
}

function channelGameStartDelayed(payload) {
    gameLobbyModel.killCountDownTimer();
    gameLobbyModel.start_at = payload.newStartAt;
    gameLobbyModel.startCountDownTimer();
}

function channelAbortedRefunding(payload) {
    state.open = true;
    state.abortRefundingCause = payload.cause;
}

function channelAborted(payload) {
    console.log(payload)
}

function sendChatMessage() {
    if (data.chatMessageInput.length <= 0) {
        return;
    }

    Inertia.post(
        `/chat-rooms/${props.gameLobby.data.id}/message`,
        {
            message: data.chatMessageInput,
        },
        {
            preserveScroll: true,
        }
    );
    data.chatMessageInput = '';
}

function channelNewChatMessage(message) {
    data.chatMessages.push(message);
}

function channelUserJoined(payload) {
    gameLobbyModel.addUser(payload.user);
    data.latestUpdateMessage = `${payload.user.name} joined the lobby.`;
}

function channelUserLeft(payload) {
    gameLobbyModel.removeUser(payload.user);
    data.latestUpdateMessage = `${payload.user.name} left the lobby.`;
}

function channelInGame(payload) {
    console.log('redirecting user to game server...');
    try {
        let newWindow = window.open('', '_blank', 'resizable=yes');
        let gameServerUrl = new URL(payload.url);
        gameServerUrl.searchParams.set('userId', currentUser.id);
        gameServerUrl.searchParams.set('username', currentUser.username);
        newWindow.location = gameServerUrl.toString();
    } catch (e) {
        return false;
    }
}

async function channelGameEnded(payload) {
    Inertia.reload({ only: ['gameLobby', 'currentUserScore'] });
}

function channelDistributingPrizes() {
    console.log('distributing prizes..');
}

function channelDistributedPrizes() {
    console.log('prizes distributed..');
}

function channelArchived() {
    Inertia.replace('/');
}

function channelPrizeUpdated(payload) {
    data.prize = payload.prize;
}

function channelLatestUpdate(payload) {
    // console.log(payload.latest_update);
    data.latestUpdateMessage = payload.latest_update;
}

watch(
    data.chatMessages,
    () => {
        chatBox.value.scrollTop = chatBox.value.scrollHeight;
    },
    {
        flush: 'post',
    }
);
</script>
<script>
import BaseLayout from '@/Layouts/_BaseLayout';
import GameLobbyLayout from '@/Layouts/GameLobbyLayout';

export default {
    layout: [BaseLayout, GameLobbyLayout],
};

let state = reactive({
    abortRefundingCause: '',
    open: false,
});
</script>
<template>
    <div>
        <GameAbortedRefundingDialog :cause="state.abortRefundingCause" @closed="state.open = false" :gameLobby="gameLobby" :open="state.open"/>
        <LeaderBoardModal
            v-if="gameLobby.data.hasOwnProperty('scores')"
            :is-open="gameLobby.data.hasOwnProperty('scores')"
            :game-lobby="gameLobby.data"
            :currentUserScore="currentUserScore || {}"
        />
        <div class="col-span-12 mt-4 inline-flex items-center lg:col-span-5">
            <Link method="delete" as="button" type="button" :href="`/game-lobbies/${gameLobby.data.id}/leave`" replace>
                <div
                    class="cursor-pointer rounded-lg border-b-6 border-wgh-red-3 bg-wgh-red-3 transition-all duration-100 active:mt-1.5 active:border-b-0"
                >
                    <div
                        class="flex flex-row space-x-2.5 rounded-lg border-3 border-wgh-red-3 bg-wgh-red-2 px-4 py-2 text-center font-grota text-white outline-none transition-all duration-100 hover:bg-wgh-red-1 active:border-wgh-red-4 active:bg-wgh-red-3"
                    >
                        Leave Lobby
                    </div>
                </div>
            </Link>
            <div class="ml-20 text-2xl font-serif font-extrabold">{{gameLobby.data.name}}</div>
        </div>
        <div class="grid min-h-full grow grid-cols-12 gap-y-8 pt-4 lg:gap-y-0 lg:gap-x-8">
            <div class="col-span-full h-full space-y-10 lg:col-span-9">
                <!--          Content -->
                <div class="mx-auto max-w-4xl rounded-lg bg-white p-2 shadow-2xl">
                    <img
                        src="https://s3.eu-central-1.amazonaws.com/static.wodo.io/game_intro_in_lobby.png"
                        alt="lobby image"
                    />
                </div>
                <div class="grid grid-cols-12 place-items-start gap-y-8 lg:gap-x-8">
                    <BorderedContainer class="col-span-full w-full bg-wgh-gray-1.5 lg:col-span-3">
                        <div class="flex flex-row items-center space-x-4 rounded-lg bg-white p-4">
                            <svg
                                xmlns="http://www.w3.org/2000/svg"
                                class="h-6 w-6"
                                viewBox="0 0 20 20"
                                fill="currentColor"
                            >
                                <path
                                    fill-rule="evenodd"
                                    d="M4 4a2 2 0 00-2 2v4a2 2 0 002 2V6h10a2 2 0 00-2-2H4zm2 6a2 2 0 012-2h8a2 2 0 012 2v4a2 2 0 01-2 2H8a2 2 0 01-2-2v-4zm6 4a2 2 0 100-4 2 2 0 000 4z"
                                    clip-rule="evenodd"
                                />
                            </svg>
                            <div>
                                <p class="font-grota text-lg font-extrabold uppercase text-wgh-gray-6">Prize Pool</p>
                                <p class="font-inter font-normal uppercase text-wgh-gray-6">
                                    {{ prize }} {{ gameLobbyModel.asset.symbol }}
                                </p>
                            </div>
                        </div>
                    </BorderedContainer>
                    <BorderedContainer class="col-span-full w-full bg-wgh-gray-1.5 lg:col-span-3" v-if="gameLobbyModel.type != 3">
                        <div class="flex flex-row items-center space-x-4 rounded-lg bg-white p-4">
                            <svg
                                xmlns="http://www.w3.org/2000/svg"
                                class="h-6 w-6"
                                viewBox="0 0 20 20"
                                fill="currentColor"
                            >
                                <path
                                    fill-rule="evenodd"
                                    d="M4 4a2 2 0 00-2 2v4a2 2 0 002 2V6h10a2 2 0 00-2-2H4zm2 6a2 2 0 012-2h8a2 2 0 012 2v4a2 2 0 01-2 2H8a2 2 0 01-2-2v-4zm6 4a2 2 0 100-4 2 2 0 000 4z"
                                    clip-rule="evenodd"
                                />
                            </svg>
                            <div>
                                <p class="font-grota text-lg font-extrabold uppercase text-wgh-gray-6">Game Play Duration</p>
                                <p class="font-inter font-normal uppercase text-wgh-gray-6">
                                    {{  gameLobbyModel.game_play_duration }} min
                                </p>
                            </div>
                        </div>
                    </BorderedContainer>
                    <BorderedContainer class="col-span-full w-full bg-wgh-gray-1.5 lg:col-span-3">
                        <div class="flex flex-row items-center space-x-4 rounded-lg bg-white p-4">
                            <svg
                                xmlns="http://www.w3.org/2000/svg"
                                class="h-6 w-6"
                                viewBox="0 0 20 20"
                                fill="currentColor"
                            >
                                <path
                                    fill-rule="evenodd"
                                    d="M4 4a2 2 0 00-2 2v4a2 2 0 002 2V6h10a2 2 0 00-2-2H4zm2 6a2 2 0 012-2h8a2 2 0 012 2v4a2 2 0 01-2 2H8a2 2 0 01-2-2v-4zm6 4a2 2 0 100-4 2 2 0 000 4z"
                                    clip-rule="evenodd"
                                />
                            </svg>
                            <div>
                                <p class="font-grota text-lg font-extrabold uppercase text-wgh-gray-6">Game Mode</p>
                                <p class="font-inter font-normal uppercase text-wgh-gray-6">
                                    {{ gameLobbyModel.type_label }}
                                </p>
                            </div>
                        </div>
                    </BorderedContainer>
                    <BorderedContainer
                        class="col-span-full w-full bg-wgh-gray-1.5 lg:col-span-3"
                        v-if="gameLobbyModel.status !== GameLobby.availableStatuses.GameEnded"
                    >
                        <div class="flex flex-row items-center space-x-4 rounded-lg bg-white p-4">
                            <svg
                                xmlns="http://www.w3.org/2000/svg"
                                class="h-6 w-6"
                                fill="none"
                                viewBox="0 0 24 24"
                                stroke="currentColor"
                                stroke-width="2"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"
                                />
                            </svg>
                            <div>
                                <p class="font-grota text-lg font-extrabold uppercase text-wgh-gray-6">
                                    Game Starts In
                                </p>
                                <p
                                    v-if="!gameLobbyModel.timeToStartAsString"
                                    class="font-inter font-normal uppercase text-wgh-gray-6"
                                >
                                    loading...
                                </p>
                                <p
                                    v-if="
                                        gameLobbyModel.timeToStartAsString ||
                                        gameLobbyModel.status !== GameLobby.availableStatuses.GameEnded
                                    "
                                    class="font-inter font-normal uppercase text-wgh-gray-6"
                                >
                                    {{ gameLobbyModel.timeToStartAsString }}
                                </p>
                            </div>
                        </div>
                    </BorderedContainer>
                </div>
                <BorderedContainer class="col-span-full w-full bg-wgh-gray-1.5 lg:col-span-6">
                        <div class="flex flex-row items-center space-x-4 rounded-lg bg-white p-4">
                            <svg
                                xmlns="http://www.w3.org/2000/svg"
                                class="h-6 w-6"
                                fill="none"
                                viewBox="0 0 24 24"
                                stroke="currentColor"
                                stroke-width="2"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"
                                />
                            </svg>
                            <div>
                                <p class="font-grota text-lg font-extrabold uppercase text-wgh-gray-6">Live updates</p>
                                <p class="font-inter font-normal uppercase text-wgh-gray-6">
                                    {{ data.latestUpdateMessage }}
                                </p>
                            </div>
                        </div>
                    </BorderedContainer>
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
                                                        Name
                                                    </th>
                                                    <th
                                                        scope="col"
                                                        class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900"
                                                    >
                                                        Entrance Fee
                                                    </th>
                                                    <th
                                                        scope="col"
                                                        class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900"
                                                    >
                                                        Actions
                                                    </th>
                                                </tr>
                                            </thead>
                                            <tbody class="divide-y divide-gray-200 bg-white">
                                                <tr v-for="user in gameLobbyModel.users" :key="user.id">
                                                    <td
                                                        class="whitespace-nowrap py-4 pl-4 pr-3 text-sm font-medium text-gray-900 sm:pl-6 lg:pl-8"
                                                    >
                                                        {{ user.full_name }}
                                                    </td>
                                                    <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">
                                                        {{ user.entrance_fee }} {{ gameLobbyModel.asset.symbol }}
                                                    </td>
                                                    <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">
                                                        NOT AVAILABLE
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
            </div>
            <div class="relative col-span-full h-full max-h-full min-h-[30rem] grow shadow-2xl lg:col-span-3">
                <BorderedContainer class="absolute inset-0 h-full bg-wgh-purple-3">
                    <div class="flex h-full w-full grow flex-col justify-between rounded-lg bg-white p-4">
                        <div
                            id="chat-messages"
                            class="flex flex-col space-y-2 overflow-y-scroll scroll-smooth px-2 pb-2"
                            ref="chatBox"
                        >
                            <ChatMessage
                                v-for="(chatMessage, index) in data.chatMessages"
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
                                class="shrink grow p-2 outline-none ring-0"
                                placeholder="Type your message here"
                                v-model="data.chatMessageInput"
                                @keyup.enter="sendChatMessage"
                            />
                            <button
                                :disabled="data.chatMessageInput.length <= 0"
                                @click.prevent="sendChatMessage"
                                class="rounded-md bg-wgh-purple-2 py-2 px-4 disabled:cursor-no-drop"
                            >
                                <KiteArrow class="h-4 w-4" />
                            </button>
                        </div>
                    </div>
                </BorderedContainer>
            </div>
        </div>
    </div>
</template>
<style scoped>
div::-webkit-scrollbar {
    display: none;
    scrollbar-width: none;
}
</style>
