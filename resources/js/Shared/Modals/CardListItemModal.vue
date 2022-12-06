<script setup>
import { Dialog, DialogPanel, TransitionChild, TransitionRoot } from '@headlessui/vue';
import ButtonShape from '@/Shared/ButtonShape';
import { defineEmits, defineProps} from 'vue';

let props = defineProps({
    open: Boolean,
    itemInfo: Object,
});

const emit = defineEmits(['closed']);

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
                            class="relative transform rounded-2xl border-t-4 border-r-4 border-l-4 border-b-10 border-wgh-red-2 bg-white px-4 pt-5 pb-4 text-left shadow-xl transition-all sm:my-8 sm:w-full sm:max-w-2xl sm:p-6"
                        >
                            <div>
                                <div class="mb-4 border-b-2 border-b-gray-400">
                                    <div class="mb-3 flex items-center justify-between text-2xl font-semibold">
                                        <div>{{itemInfo.name}}</div>
                                        <div class="text-2xl hover:cursor-pointer" @click="$emit('closed')">&times;</div>
                                    </div>
                                </div>
                                    
                                <div class="flex">
                                    <div class="h-48 w-48">
                                        <img :src="itemInfo.image_url" :alt="`${itemInfo.image_url} art`"
                                        class="object-fill h-48 w-48"
                                        />
                                    </div>
                                    <div class="h-48 w-96">
                                        <p class="font-semibold text-center">{{itemInfo.description}}</p>
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
