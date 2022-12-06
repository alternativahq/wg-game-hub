<script setup>
import BorderedContainer from '@/Shared/BorderedContainer';
import { defineProps } from 'vue';

let props = defineProps({
    item: Object
});
</script>
<template>
    <div class="w-full md:w-1/2">
        <div class="text-xl font-semibold mb-2"><slot name="title"></slot></div>
        <BorderedContainer class="bg-purple-200 mb-0 md:mb-2">
            <div class="flex-col justify-around gap-2 rounded-lg bg-gray-50 p-4">
                <div class="flex justify-around md:flex-row mb-4">
                    <slot name="header"></slot>
                </div>
                <div class="overflow-hidden overflow-y-auto h-48 md:h-64 py-2">
                    <slot></slot>
                </div>
            </div>
        </BorderedContainer>
    </div>
</template>
