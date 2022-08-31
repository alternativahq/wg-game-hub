<script setup>
import { inject } from 'vue';

let snack = inject('snack');
</script>
<template>
    <div class="fixed top-0 left-0 flex w-full justify-center">
        <transition name="snack">
            <div class="mt-6 max-w-3xl rounded-lg bg-blue-500 p-2 px-8 text-sm text-white" v-if="snack.message">
                {{ snack.message }}
            </div>
        </transition>
    </div>
</template>
