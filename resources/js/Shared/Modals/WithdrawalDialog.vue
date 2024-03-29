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
});

const emit = defineEmits(['close']);

let withdrawalConfirmationForm = useForm({
    code: '',
    transaction_uuid: '',
});

function WithdrawalConfirmationFormSubmit() {
    let newUrl = new URL(window.location);
    withdrawalConfirmationForm.transaction_uuid = newUrl.searchParams.get('TransactionUuid');
    withdrawalConfirmationForm.post('/wallet/withdrawal/completeSendConfirmation', { 
        onSuccess: () =>{ 
            emit('close')
            withdrawalConfirmationForm.clearErrors();
            withdrawalConfirmationForm.reset();
        } });
}
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
                                        <div>Withdraw Conformation</div>
                                        <div class="text-2xl hover:cursor-pointer" @click="$emit('close')">&times;</div>
                                    </div>
                                </div>
                                <form @submit.prevent="WithdrawalConfirmationFormSubmit()">
                                    <div class="font-semibold">code</div>
                                    <TextInput
                                        v-model="withdrawalConfirmationForm.code"
                                        placeholder="Enter the code"
                                        type="text"
                                        id="code"
                                        name="code"
                                        class="mt-4"
                                    />
                                    <InputError class="my-5">
                                        <div v-if="withdrawalConfirmationForm.errors.code" class="mt-2">
                                            {{ withdrawalConfirmationForm.errors.code }}
                                        </div>
                                    </InputError>
                                    <button
                                        type="submit"
                                        class="w-full"
                                        :disabled="withdrawalConfirmationForm.processing"
                                    >
                                        <ButtonShape type="purple">
                                            <span v-if="!withdrawalConfirmationForm.processing" class="w-full uppercase">Submit</span>
                                            <span v-if="withdrawalConfirmationForm.processing" class="w-full uppercase">Processing...</span>
                                        </ButtonShape>
                                    </button>
                                </form>
                            </div>
                        </DialogPanel>
                    </TransitionChild>
                </div>
            </div>
        </Dialog>
    </TransitionRoot>
</template>
