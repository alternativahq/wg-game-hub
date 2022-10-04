<script setup>
import { inject, provide } from 'vue';

defineProps({
    notification: Object,
    currentUser: Object,
});

let dayjs = inject('dayjs');
</script>
<template>
    <div class="flex flex-col justify-between">
        <div class="">
            <div class="mb-2 flex flex-col items-start justify-between lg:flex-row lg:items-center">
                <p class="mb-0.5 text-base font-bold lg:mb-0">{{ notification.data.title }}</p>
                <p class="text-xs font-light">{{ dayjs(notification.created_at).fromNow() }}</p>
            </div>
            <p class="text-sm">{{ notification.data.message }}</p>
        </div>
    </div>
    <div
        @click.prevent="currentUser.markNotificationAsRead(notification.id)"
        class="self-baseline rounded bg-blue-200 py-2 px-2 text-xs hover:cursor-pointer hover:bg-blue-300 hover:text-white"
    >
        Mark as read
    </div>
</template>
