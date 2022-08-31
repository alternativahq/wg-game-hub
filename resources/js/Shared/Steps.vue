<script setup>
import { CheckIcon } from '@heroicons/vue/solid';
import { inject } from 'vue';

let props = defineProps({
    steps: Object,
});

let dayjs = inject('dayjs');
</script>

<template>
    <nav aria-label="Progress" class="my-10 ml-8">
        <ol role="list" class="overflow-hidden">
            <li
                v-for="(step, stepIdx) in steps"
                :key="step.name"
                :class="[stepIdx !== steps.length - 1 ? 'pb-10' : '', 'relative']"
            >
                <div>
                    <div
                        v-if="stepIdx !== steps.length - 1"
                        class="absolute top-4 left-4 -ml-px mt-0.5 h-full w-0.5 bg-indigo-600"
                        aria-hidden="true"
                    />
                    <div class="group relative flex items-start">
                        <span class="flex h-9 items-center">
                            <span
                                class="relative z-10 flex h-8 w-8 items-center justify-center rounded-full bg-indigo-600 group-hover:bg-indigo-800"
                            >
                            </span>
                        </span>
                        <span class="ml-4 flex min-w-0 flex-col">
                            <span class="text-sm font-medium capitalize">{{ step.state }}</span>
                            <span class="text-sm text-gray-500">{{
                                dayjs(step.createdAt).utc().local().tz(dayjs.tz.guess()).format('MMMM DD, YYYY hh:mm A')
                            }}</span>
                        </span>
                    </div>
                </div>
            </li>
        </ol>
    </nav>
</template>
