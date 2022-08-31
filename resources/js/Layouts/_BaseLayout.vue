<script setup>
import { onBeforeUnmount, onMounted, provide } from 'vue';
import { useCurrentUser } from '@/Composables/useCurrentUser';
import SnackService from '@/Services/Snack';
import Snack from '@/Shared/Snack';
import dayjs from 'dayjs';
import utc from 'dayjs/plugin/utc';
import timezone from 'dayjs/plugin/timezone';
import relativeTime from 'dayjs/plugin/relativeTime';
import duration from 'dayjs/plugin/duration';
dayjs.extend(relativeTime);
dayjs.extend(duration);
dayjs.extend(utc);
dayjs.extend(timezone);

let currentUser = useCurrentUser();

let snack = new SnackService();
provide('currentUser', currentUser);
provide('snack', snack);
provide('dayjs', dayjs);

onMounted(() => {
    if (currentUser) {
        window.echo.private(`user.${currentUser.id}`).notification((notification) => {
            currentUser.unread_notifications.unshift(notification);
            snack.fireSnack(notification.data.message);
        });
    }
});

onBeforeUnmount(() => {
    if (currentUser) {
        window.echo.leave(`user.${currentUser.id}`);
    }
});
</script>
<template>
    <Snack />
    <slot />
</template>
