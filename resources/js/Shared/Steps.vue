<script setup>
import { CheckIcon } from '@heroicons/vue/solid'

let props = defineProps({
    steps: Object,
});
</script>
<template>
  <nav aria-label="Progress" class="ml-8 my-10">
    <ol role="list" class="overflow-hidden">
      <li v-for="(step, stepIdx) in steps" :key="step.name" :class="[stepIdx !== steps.length - 1 ? 'pb-10' : '', 'relative']">
        <div >
          <div v-if="stepIdx !== steps.length - 1" class="-ml-px absolute mt-0.5 top-4 left-4 w-0.5 h-full bg-indigo-600" aria-hidden="true" />
          <div class="relative flex items-start group">
            <span class="h-9 flex items-center">
              <span class="relative z-10 w-8 h-8 flex items-center justify-center bg-indigo-600 rounded-full group-hover:bg-indigo-800">
              </span>
            </span>
            <span class="ml-4 min-w-0 flex flex-col">
              <span class="text-sm font-medium">{{ step.txId }}</span>
              <span class="text-sm text-gray-500">{{ step.state }}</span>
            </span>
          </div>
        </div>
      </li>
    </ol>
  </nav>
</template>
