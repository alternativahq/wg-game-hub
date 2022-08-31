<script setup>
import BorderedContainer from '@/Shared/BorderedContainer';
import { useCurrentUser } from '@/Composables/useCurrentUser';
import { onBeforeMount, onMounted, inject } from 'vue';

// let currentUser = inject('currentUser');
let currentUser = useCurrentUser();
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
</script>
<template>
    <BorderedContainer
        v-if="currentUser?.cooldown_end_at"
        class="mb-8 flex flex-col space-y-6 border-wgh-red-3 bg-wgh-red-2 p-6 md:flex-row md:space-x-6 md:space-y-0"
    >
        <div class="rounded-lg p-4">
            <p class="font-grota text-2xl font-extrabold text-white">
                You are in cooldown period and it will end in
                {{ currentUser.secondsToEndCooldown ? currentUser.secondsToEndCooldown : '...' }} seconds.
            </p>
        </div>
    </BorderedContainer>
</template>
