<script setup>
import { inject } from 'vue';
import BorderedContainer from '@/Shared/BorderedContainer';
import { Link } from '@inertiajs/inertia-vue3';
import GameLobby from '@/Models/GameLobby';

let currentUser = inject('currentUser');

let currentActiveLobby = currentUser.current_lobby_session
    ? new GameLobby(currentUser.current_lobby_session?.data)
    : null;
</script>
<template>
    <BorderedContainer
        v-if="currentActiveLobby"
        class="mb-8 flex flex-col space-y-6 border-wgh-red-3 bg-wgh-red-2 p-6 md:flex-row md:space-x-6 md:space-y-0"
    >
        <div class="rounded-lg p-4">
            <p class="font-grota text-2xl font-extrabold text-white">
                You have an active session for "{{ currentActiveLobby.name }}",
                <Link :href="`/game-lobbies/${currentActiveLobby.id}`">
                    <span class="underline"> Click here </span>
                </Link>
                to go back to lobby
            </p>
        </div>
    </BorderedContainer>
</template>
