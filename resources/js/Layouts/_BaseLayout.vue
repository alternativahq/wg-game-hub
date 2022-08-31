<script setup>
import { onBeforeUnmount, onMounted, provide } from 'vue';
import SnackService from '@/Services/Snack';
import Snack from '@/Shared/Snack';
import { inject } from 'vue';
import { useCurrentUser } from '@/Composables/useCurrentUser';

let currentUser = useCurrentUser();
// let currentUser = inject('currentUser');

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
    <div>
        <Snack />
        <slot />
    </div>
</template>
