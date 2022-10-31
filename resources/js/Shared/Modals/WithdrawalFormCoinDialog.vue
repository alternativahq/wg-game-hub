<script setup>
import { Dialog, DialogPanel, TransitionChild, TransitionRoot } from '@headlessui/vue';
import { useForm } from '@inertiajs/inertia-vue3';
import { Inertia } from '@inertiajs/inertia';
import TextInput from '@/Shared/Inputs/TextInput';
import InputError from '@/Shared/InputError';
import ButtonShape from '@/Shared/ButtonShape';
import { defineEmits, defineProps} from 'vue';

let props = defineProps({
    open: Boolean,
    assets: Object,
});
</script>
<template>
    <TransitionRoot as="template" :show="open">
        <Dialog as="div" class="relative z-10">
            <TransitionChild
                as="template"
                enter="ease-out duration-300"
                enter-from="opacity-0"
                enter-to="opacity-100"
                leave="ease-in duration-200"
                leave-from="opacity-100"
                leave-to="opacity-0"
            >
                <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" />
            </TransitionChild>
            <div class="fixed inset-0 z-10 overflow-y-auto">
                <div class="flex min-h-full items-end justify-center p-4 text-center sm:items-center sm:p-0">
                    <TransitionChild
                        as="template"
                        enter="ease-out duration-300"
                        enter-from="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                        enter-to="opacity-100 translate-y-0 sm:scale-100"
                        leave="ease-in duration-200"
                        leave-from="opacity-100 translate-y-0 sm:scale-100"
                        leave-to="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                    >
                        <DialogPanel
                            class="relative transform rounded-2xl border-t-4 border-r-4 border-l-4 border-b-10 border-wgh-red-2 bg-white px-4 pt-5 pb-4 text-left shadow-xl transition-all sm:my-8 sm:w-full sm:max-w-lg sm:p-6"
                        >
                            <div>
                                <div class="mb-4 border-b-2 border-b-gray-400">
                                    <div class="mb-3 flex items-center justify-between text-2xl font-semibold">
                                        <div>Select a coin</div>
                                        <div class="text-2xl hover:cursor-pointer" @click="$emit('close')">&times;</div>
                                    </div>
                                </div>
                                <div :key="asset.id" v-for="asset in assets" :value="asset.id" @click="$emit('update:modelValue', asset.symbol),$emit('close')" class="flex justify-between my-4 hover:bg-gray-300 px-4 py-2 cursor-pointer">
                                    <div class="">
                                        <div class="">{{asset.name}}</div>
                                        <div class="text-sm text-gray-500 mb-2">{{asset.symbol}}</div>
                                    </div>
                                    <div class="">
                                        <div class="text-sm mb-2">Daily Limit: {{asset.dailyLimit}}</div>
                                    </div>
                                </div>
                            </div>
                        </DialogPanel>
                    </TransitionChild>
                </div>
            </div>
        </Dialog>
    </TransitionRoot>
</template>
