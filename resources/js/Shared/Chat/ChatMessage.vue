<script setup>
import { defineProps } from 'vue';

defineProps({
    fromMe: {
        required: true,
        type: Boolean,
    },
    userImageUrl: {
        required: false,
        type: String,
    },
    username: {
        required: false,
        type: String,
    },
    time: {
        required: false,
        type: String,
    },
    message: {
        required: true,
        type: String,
    },
});
</script>
<template>
    <div
        id="me"
        class="inline-block flex max-w-md flex-row space-x-2 rounded-lg p-2"
        :class="{
            'flex-row-reverse space-x-reverse self-end bg-wgh-pink-1': fromMe,
            'flex-row self-start bg-[#EEEEF9]': !fromMe,
        }"
    >
        <img
            class="aspect-square h-8 w-8 rounded-full"
            :src="userImageUrl"
            alt=""
        />
        <div>
            <div
                class="mb-1 flex justify-between"
                :class="{
                    'flex-row-reverse self-end': fromMe,
                    'flex-row': !fromMe,
                }"
            >
                <span
                    class="font-inter text-xs font-semibold text-wgh-gray-2"
                    >{{ username }}</span
                >
                <span
                    class="shrink-0 font-inter text-xs font-normal text-wgh-gray-2"
                    >{{ time }}</span
                >
            </div>
            <p class="font-inter text-sm font-normal text-wgh-gray-6">
                {{ message }}
            </p>
        </div>
    </div>
</template>
