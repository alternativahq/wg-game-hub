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

let currentUser = inject('currentUser');
let chatBox = ref();
let snack = inject('snack');

let props = defineProps({
    mainChatRoom: Object,
    availableGames: Object,
    config: Object,
    balance: Array,
});

onMounted(() => {
    window.echo.channel('chat-rooms.main').listen('.message', (payload) => {
        state.chatMessages.push(payload);
    });
});

let state = reactive({
    chatMessages: [],
    chatMessageBody: '',
    chatRoom: new ChatRoom(props.mainChatRoom.data),
});

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
            <BorderedContainer class="mb-8 bg-wgh-red-3">
                <div class="flex flex-col space-y-6 rounded-lg bg-wgh-red-2 p-6 md:flex-row md:space-x-6 md:space-y-0">
                    <div class="w-full md:w-1/2">
                        <img :src="props.config.dashboard_art" alt="Dashboard Art" />
                    </div>
                    <div class="flex w-full flex-col justify-center md:w-1/2">
                        <h2 class="font-grota text-2xl font-extrabold text-white">
                            The First Retro Gaming Playground Competitions!
                        </h2>
                        <p class="mt-4 font-inter text-base font-normal text-white">
                            A small description about the first section explaining about the platform.
                        </p>
                    </div>
                </div>
            </BorderedContainer>
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
                    <div
                        v-if="currentUser"
                        class="flex w-full flex-row space-x-2 rounded-md border-2 border-wgh-gray-1 p-px"
                    >
                        <input
                            type="text"
                            class="shrink grow p-2 outline-none ring-0"
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

                    <Link :href="route('login')">
                        <ButtonShape v-if="!currentUser" type="purple" class="w-full text-center">
                            <p class="w-full text-center">Click here to register</p>
                        </ButtonShape>
                    </Link>
                </div>
            </BorderedContainer>
        </div>
    </div>
</template>
