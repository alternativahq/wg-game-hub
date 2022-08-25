<script setup>
import {
    Dialog,
    DialogPanel,
    TransitionChild,
    TransitionRoot,
} from '@headlessui/vue';
import { Inertia } from '@inertiajs/inertia';

defineProps({
    open: Boolean,
    transaction: String,
    transactionSteps: String,
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
                <div
                    class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity"
                />
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
                                    <div class="border-b-2 border-b-gray-400 mb-4">
                                        <div class="mb-3 flex justify-between items-center text-2xl font-semibold">
                                            <div>Withdraw Details</div>
                                            <div class="text-2xl hover:cursor-pointer" @click="$emit('close')">&times;</div>
                                        </div>
                                    </div>
                                    <div class="border-b-2 border-b-gray-400 mb-4">
                                        <div class="mx-4">
                                            <div class="mb-5">
                                                <div class="font-medium">Withdraw Odrder submited</div>
                                                <div class="text-sm text-gray-500">2022-8-5 13:42</div>
                                            </div>
                                            <div class="mb-5">
                                                <div class="font-medium">system prosessing</div>
                                                <div class="text-sm text-gray-500">2022-8-5 13:42</div>
                                            </div>
                                            <div class="mb-5">
                                                <div class="font-medium">completed</div>
                                                <div class="text-sm text-gray-500">2022-8-5 13:42</div>
                                            </div>
                                            <div class="mb-5">
                                                <div class="text-sm text-gray-500 mb-1">please note that you will receive a email once it is completed.</div>
                                                <div class="text-sm text-gray-500 underline">why hasn't my withdrawal arrived yet?</div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="mx-2">
                                        <div class="mb-4 flex justify-between items-center">
                                            <div class="text-md text-gray-500 font-normal">Status</div>
                                            <div class="text-md text-gray-900 font-semibold">{{transaction.state}}</div>
                                        </div>
                                        <div class="mb-4 flex justify-between items-center">
                                            <div class="text-md text-gray-500 font-normal">Date</div>
                                            <div class="text-md text-gray-900 font-semibold">{{transaction.createdAt}}</div>
                                        </div>
                                        <div class="mb-4 flex justify-between items-center">
                                            <div class="text-md text-gray-500 font-normal">Withdraw wallet</div>
                                            <div class="text-md text-gray-900 font-semibold">{{transaction.fromAccountId}}</div>
                                        </div>
                                        <div class="mb-4 flex justify-between items-center">
                                            <div class="text-md text-gray-500 font-normal">Coin</div>
                                            <div class="text-md text-gray-900 font-semibold">{{transaction.asset}}</div>
                                        </div>
                                        <div class="mb-4 flex justify-between items-center">
                                            <div class="text-md text-gray-500 font-normal">Withdraw amount</div>
                                            <div class="text-md text-gray-900 font-semibold">{{transaction.amount}}</div>
                                        </div>
                                        <div class="mb-4 flex justify-between items-center">
                                            <div class="text-md text-gray-500 font-normal">Network Fee</div>
                                            <div class="text-md text-gray-900 font-semibold">{{transaction.fee}}</div>
                                        </div>
                                        <div class="mb-4 flex justify-between items-center">
                                            <div class="text-md text-gray-500 font-normal">Network</div>
                                            <div class="text-md text-gray-900 font-semibold">TRX</div>
                                        </div>
                                        <div class="mb-4 flex justify-between items-center">
                                            <div class="text-md text-gray-500 font-normal">Address</div>
                                            <div class="text-md text-gray-900 font-semibold">{{transaction.toAccountId}}</div>
                                        </div>
                                        <div class="mb-4 flex justify-between items-center">
                                            <div class="text-md text-gray-500 font-normal">TxID</div>
                                            <div class="text-md text-gray-900 font-semibold">{{transaction.globalTxId}}</div>
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
