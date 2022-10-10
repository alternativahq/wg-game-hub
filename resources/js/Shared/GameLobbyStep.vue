<script setup>
import { inject, reactive } from 'vue';
import BorderedContainer from '@/Shared/BorderedContainer';

let dayjs = inject('dayjs');
let props = defineProps({
    step: Object,
});

let state = reactive({
    isOpen: false,
});
</script>
<template>
    <div class="flex flex-col">
        <div class="ml-4 cursor-pointer" @click="state.isOpen = !state.isOpen">
            <div class="flex">
                <div class="mr-4 text-sm font-medium">{{ step.name }}</div>
                <div class="text-sm text-gray-500">
                    {{ dayjs(step.date).utc().local().tz(dayjs.tz.guess()).format('MMMM DD, YYYY hh:mm A') }}
                </div>
            </div>
            <div class="mb-2 text-sm font-normal">{{ step.description }}</div>
        </div>
        <div class="text-sm font-normal" v-if="state.isOpen">
            <BorderedContainer class="mb-8 bg-gray-300" v-if="step.payload">
                <div class="p-4">
                    {{ step.payload }}
                </div>
            </BorderedContainer>
        </div>
    </div>
</template>
