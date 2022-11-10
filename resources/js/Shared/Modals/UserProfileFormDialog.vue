<script setup>
import { Dialog, DialogPanel, TransitionChild, TransitionRoot } from '@headlessui/vue';
import { useForm } from '@inertiajs/inertia-vue3';
import { Inertia } from '@inertiajs/inertia';
import TextInput from '@/Shared/Inputs/TextInput';
import InputError from '@/Shared/InputError';
import ButtonShape from '@/Shared/ButtonShape';
import { defineEmits, defineProps, inject} from 'vue';
import { Link } from '@inertiajs/inertia-vue3';
import Datepicker from '@vuepic/vue-datepicker';
import '@vuepic/vue-datepicker/dist/main.css';

let props = defineProps({
    open: Boolean,
    userInfo: Object,
    genders: Object,
});

const emit = defineEmits(['closed']);
let dayjs = inject('dayjs');

function UTCToHumanReadable(u) {
    return dayjs(u).utc().local().tz(dayjs.tz.guess()).format('MMMM DD, YYYY hh:mm A');
}

let userProfileUpdateForm = useForm({
    name: props.userInfo.name,
    familyName: props.userInfo.familyName,
    picture: props.userInfo.picture,
    preferredUsername: props.userInfo.preferredUsername,
    gender: props.userInfo.gender,
    phoneNumber: props.userInfo.phoneNumber,
    birthDate: props.userInfo.birthDate,
    address: props.userInfo.address,
    updatedAt: "2022-11-07T08:55:48.000Z"
});

function FormSubmit() {
    userProfileUpdateForm.put('/profile/update', {
        onSuccess: () =>{
            emit('closed')
            userProfileUpdateForm.clearErrors();
            userProfileUpdateForm.reset();
        }
    });
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
                            class="relative transform rounded-2xl border-t-4 border-r-4 border-l-4 border-b-10 border-wgh-red-2 bg-white px-4 pt-5 pb-4 text-left shadow-xl transition-all sm:my-8 sm:w-full sm:max-w-2xl sm:p-6"
                        >
                            <div>
                                <div class="mb-4 border-b-2 border-b-gray-400">
                                    <div class="mb-3 flex items-center justify-between text-2xl font-semibold">
                                        <div>Profile Update</div>
                                        <div class="text-2xl hover:cursor-pointer" @click="$emit('closed')">&times;</div>
                                    </div>
                                </div>
                                <form @submit.prevent="FormSubmit()">
                                    <div class="mb-5">
                                        <div >
                                            <div class="mb-2 text-lg font-semibold">Name:</div>
                                            <div class="bg-gray-100 border border-gray-500">
                                                <div class="rounded-lg">
                                                    <input
                                                        class="py-2 px-2 text-lg w-full "
                                                        type="text"
                                                        placeholder="name"
                                                        v-model="userProfileUpdateForm.name"
                                                    />
                                                </div>
                                            </div>
                                        </div>
                                        <InputError class="my-5">
                                            <div v-if="userProfileUpdateForm.errors.name" class="mt-2">
                                                {{ userProfileUpdateForm.errors.name }}
                                            </div>
                                        </InputError>
                                    </div>
                                    <div class="mb-5">
                                        <div >
                                            <div class="mb-2 text-lg font-semibold">Last Name:</div>
                                            <div class="bg-gray-100 border border-gray-500">
                                                <div class="rounded-lg">
                                                    <input
                                                        class="py-2 px-2 text-lg w-full "
                                                        type="text"
                                                        placeholder="last name"
                                                        v-model="userProfileUpdateForm.familyName"
                                                    />
                                                </div>
                                            </div>
                                        </div>
                                        <InputError class="my-5">
                                            <div v-if="userProfileUpdateForm.errors.familyName" class="mt-2">
                                                {{ userProfileUpdateForm.errors.familyName }}
                                            </div>
                                        </InputError>
                                    </div>
                                    <div class="mb-5">
                                        <div >
                                            <div class="mb-2 text-lg font-semibold">Picture</div>
                                            <div class="bg-gray-100 border border-gray-500">
                                                <div class="rounded-lg">
                                                    <input
                                                        class="py-2 px-2 text-lg w-full "
                                                        type="text"
                                                        placeholder="picture"
                                                        v-model="userProfileUpdateForm.picture"
                                                    />
                                                </div>
                                            </div>
                                        </div>
                                        <InputError class="my-5">
                                            <div v-if="userProfileUpdateForm.errors.picture" class="mt-2">
                                                {{ userProfileUpdateForm.errors.picture }}
                                            </div>
                                        </InputError>
                                    </div>
                                    <div class="mb-5">
                                        <div >
                                            <div class="mb-2 text-lg font-semibold">User Name:</div>
                                            <div class="bg-gray-100 border border-gray-500">
                                                <div class="rounded-lg">
                                                    <input
                                                        class="py-2 px-2 text-lg w-full "
                                                        type="text"
                                                        placeholder="amount"
                                                        v-model="userProfileUpdateForm.preferredUsername"
                                                    />
                                                </div>
                                            </div>
                                        </div>
                                        <InputError class="my-5">
                                            <div v-if="userProfileUpdateForm.errors.preferredUsername" class="mt-2">
                                                {{ userProfileUpdateForm.errors.preferredUsername }}
                                            </div>
                                        </InputError>
                                    </div>
                                    <div class="mb-5">
                                        <div >
                                            <div class="mb-2 text-lg font-semibold">Gender:</div>
                                            <div class="bg-gray-100 border border-gray-500">
                                                <div class="rounded-lg">
                                                    <select
                                                        id="asset_name"
                                                        name="asset_name"
                                                        class="py-2 px-2 text-lg w-full"
                                                        v-model="userProfileUpdateForm.gender"
                                                    >
                                                        <option :key="index" v-for="(gender, index) in genders" :value="gender.value" >
                                                            {{ gender.label }}
                                                        </option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <InputError class="my-5">
                                            <div v-if="userProfileUpdateForm.errors.gender" class="mt-2">
                                                {{ userProfileUpdateForm.errors.gender }}
                                            </div>
                                        </InputError>
                                    </div>
                                    <div class="mb-5">
                                        <div >
                                            <div class="mb-2 text-lg font-semibold">Phone Number:</div>
                                            <div class="bg-gray-100 border border-gray-500">
                                                <div class="rounded-lg">
                                                    <input
                                                        class="py-2 px-2 text-lg w-full "
                                                        type="text"
                                                        placeholder="phone number"
                                                        v-model="userProfileUpdateForm.phoneNumber"
                                                    />
                                                </div>
                                            </div>
                                        </div>
                                        <InputError class="my-5">
                                            <div v-if="userProfileUpdateForm.errors.phoneNumber" class="mt-2">
                                                {{ userProfileUpdateForm.errors.phoneNumber }}
                                            </div>
                                        </InputError>
                                    </div>
                                    <div class="mb-5">
                                        <div >
                                            <div class="mb-2 text-lg font-semibold">Birth Date</div>
                                            <div class="bg-gray-100 border border-gray-500">
                                                <div class="rounded-lg">
                                                    <Datepicker
                                                        modelAuto
                                                        required
                                                        class="block w-full rounded-md border border-wgh-gray-1.5 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                                                        placeholder="Select date and time"
                                                        v-model="userProfileUpdateForm.birthDate"
                                                        :enable-time-picker="false"
                                                        :max-date="new Date()"
                                                    ></Datepicker>
                                                </div>
                                            </div>
                                        </div>
                                        <InputError class="my-5">
                                            <div v-if="userProfileUpdateForm.errors.birthDate" class="mt-2">
                                                {{ userProfileUpdateForm.errors.birthDate }}
                                            </div>
                                        </InputError>
                                    </div>
                                    <div class="mb-5">
                                        <div >
                                            <div class="mb-2 text-lg font-semibold">Address</div>
                                            <div class="bg-gray-100 border border-gray-500">
                                                <div class="rounded-lg">
                                                    <input
                                                        class="py-2 px-2 text-lg w-full "
                                                        type="text"
                                                        placeholder="address"
                                                        v-model="userProfileUpdateForm.address"
                                                    />
                                                </div>
                                            </div>
                                        </div>
                                        <InputError class="my-5">
                                            <div v-if="userProfileUpdateForm.errors.address" class="mt-2">
                                                {{ userProfileUpdateForm.errors.address }}
                                            </div>
                                        </InputError>
                                    </div>
                                    <button
                                        type="submit"
                                        class="w-full"
                                    >
                                        <ButtonShape type="purple">
                                            <span v-if="!userProfileUpdateForm.processing" class="w-full uppercase">Update</span>
                                            <span v-if="userProfileUpdateForm.processing" class="w-full uppercase">Processing...</span>
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
