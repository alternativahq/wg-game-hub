<script setup>
import { Dialog, DialogPanel, TransitionChild, TransitionRoot } from '@headlessui/vue';
import { Inertia } from '@inertiajs/inertia';
import Steps from '../Steps.vue';

let props = defineProps({
    open: Boolean,
    transaction: Object,
    transactionSteps: Object,
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
                                <div class="mb-4">
                                    <div class="mb-4 border-b-2 border-b-gray-400">
                                        <div class="mb-3 flex items-center justify-between text-2xl font-semibold">
                                            <div>Withdraw Details</div>
                                            <div class="text-2xl hover:cursor-pointer" @click="$emit('close')">
                                                &times;
                                            </div>
                                        </div>
                                    </div>
                                    <Steps :steps="transactionSteps" class="mb-5" />
                                    <div class="mb-4 border-b-2 border-b-gray-400">
                                        <div class="mx-4">
                                            <div class="mb-5">
                                                <div class="mb-1 text-sm text-gray-500">
                                                    please note that you will receive a email once it is completed.
                                                </div>
                                                <div class="text-sm text-gray-500 underline">
                                                    why hasn't my withdrawal arrived yet?
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="mx-2">
                                        <div class="mb-4 flex items-center justify-between space-x-4">
                                            <div class="text-md shrink-0 font-normal text-gray-500">Status</div>
                                            <div class="text-md font-semibold text-gray-900">
                                                {{ transaction.state }}
                                            </div>
                                        </div>
                                        <div class="mb-4 flex items-center justify-between space-x-4">
                                            <div class="text-md font-normal text-gray-500">Date</div>
                                            <div class="text-md font-semibold text-gray-900">
                                                {{ transaction.createdAt }}
                                            </div>
                                        </div>
                                        <div class="mb-4 flex items-center justify-between space-x-4">
                                            <div class="text-md shrink-0 font-normal text-gray-500">
                                                Withdraw wallet
                                            </div>
                                            <div class="text-md truncate font-semibold text-gray-900">
                                                {{ transaction.fromAccountId }}
                                            </div>
                                        </div>
                                        <div class="mb-4 flex items-center justify-between space-x-4">
                                            <div class="text-md font-normal text-gray-500">Coin</div>
                                            <div class="text-md font-semibold text-gray-900">
                                                {{ transaction.asset }}
                                            </div>
                                        </div>
                                        <div class="mb-4 flex items-center justify-between space-x-4">
                                            <div class="text-md font-normal text-gray-500">Withdraw amount</div>
                                            <div class="text-md font-semibold text-gray-900">
                                                {{ transaction.amount }}
                                            </div>
                                        </div>
                                        <div class="mb-4 flex items-center justify-between space-x-4">
                                            <div class="text-md font-normal text-gray-500">Network Fee</div>
                                            <div class="text-md font-semibold text-gray-900">{{ transaction.fee }}</div>
                                        </div>
                                        <div class="mb-4 flex items-center justify-between space-x-4">
                                            <div class="text-md font-normal text-gray-500">Network</div>
                                            <div class="text-md font-semibold text-gray-900">TRX</div>
                                        </div>
                                        <div class="mb-4 flex items-center justify-between space-x-4">
                                            <div class="text-md font-normal text-gray-500">Address</div>
                                            <div class="text-md font-semibold text-gray-900">
                                                {{ transaction.toAccountId }}
                                            </div>
                                        </div>
                                        <div class="mb-4 flex items-center justify-between space-x-4">
                                            <div class="text-md font-normal text-gray-500">TxID</div>
                                            <div class="text-md font-semibold text-gray-900">
                                                {{ transaction.globalTxId }}
                                            </div>
                                        </div>
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
