<script setup>
import { ChevronDownIcon } from '@heroicons/vue/solid';
import { defineProps, reactive, watch } from 'vue';
import BorderedContainer from '@/Shared/BorderedContainer';
import dayjs from 'dayjs';
import utc from 'dayjs/plugin/utc';
import timezone from 'dayjs/plugin/timezone';
import relativeTime from 'dayjs/plugin/relativeTime';
import duration from 'dayjs/plugin/duration';
import ButtonShape from '@/Shared/ButtonShape';
import Pagination from '@/Models/Pagination';
import { Link } from '@inertiajs/inertia-vue3';
import { Inertia } from '@inertiajs/inertia';
import TextInput from '@/Shared/Inputs/TextInput';
import InputError from '@/Shared/InputError';
import { useForm } from '@inertiajs/inertia-vue3';

dayjs.extend(utc);
dayjs.extend(timezone);
dayjs.extend(relativeTime);
dayjs.extend(duration);

let props = defineProps({
    userWithdrawTransactions: Object,
    assets: Object,
    filters: Object,
    current_url: String,
});

let filters = reactive(props.filters);
let currentUrl = window.location.toString();
let pagination = reactive(new Pagination(props.userWithdrawTransactions));

let withdrawalForm = useForm({
    email: '',
    password: '',
    remember_me: false,
});

function UTCToHumanReadable(u) {
    return dayjs(u).utc().local().tz(dayjs.tz.guess()).format('MMMM DD, YYYY hh:mm A');
}

// function byTransactionChanged() {
//     Inertia.get(currentUrl, { filter_by_game: filters.filter_by_asset });
// }
</script>
<template>
    <div>
                    <div v-if="withdrawalForm.errors.email" class="mt-2">
        <section class="flex justify-between items-center">
            <h2 class="mb-6 font-grota text-2xl font-extrabold uppercase text-wgh-gray-6">Withdraw Crypto</h2>
            <div class="mb-6 text-lg round mx-5 px-3 py-2 bg-gray-300 font-semibold text-black">Withdrawal Fiat  -></div>
        </section>
        <section class=" flex">
            <div class="flex justify-center items-center w-2/3" >
                <form @submit.prevent="" class="w-full mb-10" > 
                    <div class=" flex items-center py-4 px-4 mb-5">
                        <div class="w-2/5 text-right mr-20">Select a Coin</div>
                        <div class="w-3/5">
                            <div class="mb-2">coin</div>
                            <BorderedContainer class="bg-wgh-gray-1.5">
                                <div class="rounded-lg">
                                    <select
                                        id="location"
                                        name="location"
                                        class="mt-1 block w-full rounded-md border-gray-300 py-2 pl-3 pr-10 font-inter text-base focus:border-indigo-500 focus:outline-none focus:ring-indigo-500 sm:text-sm"
                                    >
                                        <!-- v-model="filters.filter_by_asset"
                                        @change.prevent="byTransactionChanged" -->
                                        <option :value="undefined">All</option>
                                        <!-- <option :key="asset.id" v-for="asset in assets.data" :value="asset.id">
                                            {{ asset.name }}
                                        </option>  -->
                                    </select>
                                </div>
                            </BorderedContainer>
                            <InputError class="mt-2">
                                <div v-if="withdrawalForm.errors.email" class="mt-2">
                                    {{ withdrawalForm.errors.email }}
                                </div>
                            </InputError>
                        </div>
                    </div>
                    <div class=" flex items-center py-4 px-4 mb-5">
                        <div class="w-2/5 text-right mr-20">Withdrawal Information</div>
                        <div class="w-3/5">
                            <div class="mb-2">Wallet Address</div>
                            <BorderedContainer class="bg-wgh-gray-1.5">
                                <div class="rounded-lg">
                                    <select
                                        id="location"
                                        name="location"
                                        class="mt-1 block w-full rounded-md border-gray-300 py-2 pl-3 pr-10 font-inter text-base focus:border-indigo-500 focus:outline-none focus:ring-indigo-500 sm:text-sm"
                                    >
                                        <!-- v-model="filters.filter_by_asset"
                                        @change.prevent="byTransactionChanged" -->
                                        <option :value="undefined">All</option>
                                        <!-- <option :key="asset.id" v-for="asset in assets.data" :value="asset.id">
                                            {{ asset.name }}
                                        </option>  -->
                                    </select>
                                </div>
                            </BorderedContainer>
                            <InputError class="mt-2">
                                <div v-if="withdrawalForm.errors.email" class="mt-2">
                                    {{ withdrawalForm.errors.email }}
                                </div>
                            </InputError>
                        </div>
                    </div>
                    <div class=" flex items-center py-4 px-4 mb-5">
                        <div class="w-2/5 text-right mr-20"></div>
                        <div class="w-3/5">
                            <div class="mb-2">Network</div>
                            <BorderedContainer class="bg-wgh-gray-1.5">
                                <div class="rounded-lg">
                                    <select
                                        id="location"
                                        name="location"
                                        class="mt-1 block w-full rounded-md border-gray-300 py-2 pl-3 pr-10 font-inter text-base focus:border-indigo-500 focus:outline-none focus:ring-indigo-500 sm:text-sm"
                                    >
                                        <!-- v-model="filters.filter_by_asset"
                                        @change.prevent="byTransactionChanged" -->
                                        <option :value="undefined">All</option>
                                        <!-- <option :key="asset.id" v-for="asset in assets.data" :value="asset.id">
                                            {{ asset.name }}
                                        </option>  -->
                                    </select>
                                </div>
                            </BorderedContainer>
                            <InputError class="mt-2">
                                <div v-if="withdrawalForm.errors.email" class="mt-2">
                                    {{ withdrawalForm.errors.email }}
                                </div>
                            </InputError>
                        </div>
                    </div>
                    <!-- <button
                        type="submit"
                        class="w-full"
                        :disabled="withdrawalForm.processing"
                    >
                        <ButtonShape type="purple">
                            <span class="w-full uppercase">Sign in</span>
                        </ButtonShape>
                    </button> -->
                </form>
            </div>
            <div class="w-1/3 ml-8">
                <div class="text-lg font-bold mb-4">FAQ</div>
                <Link href="" class="text-gray-500 mb-2 underline block">
                    How do i withdrawal from my kucoin account?
                </Link>
                <Link href="" class="text-gray-500 mb-2 underline block">
                    What should i do if i didn't receive my withdrawal or if i made a withdrawal to an incorrect address?
                </Link>
                <Link href="" class="text-gray-500 mb-2 underline block">
                    is there a limit on 24h withdrawal?
                </Link>
            </div>
        </section>
        <section class="mb-10 flex ">
            <div class="w-2/3 flex">
                <div class="w-2/5 mr-20"></div>
                <div class="w-3/5 flex items-center">
                    <div class="w-1/2 ">
                        <div class="mb-2">
                            <div>Avalibale Balance</div>
                            <div>0.00 XNO</div>
                        </div>
                        <div class="mb-2">
                            <div>Fees</div>
                            <div>0.02 XNO</div>
                        </div>
                    </div>
                    <div class="w-1/2">
                        <div class="mb-2">
                            <div>Minimom Withdrawal</div>
                            <div>1.00 XNO</div>
                        </div>
                        <div class="mb-2">
                            <div>Remaning daily withdrawal amount</div>
                            <div>1 BTC</div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="w-1/3"></div>
        </section>
        <div class="flex flex-row justify-between">
            <h2 class="mb-6 font-grota text-2xl font-extrabold uppercase text-wgh-gray-6">Recent Withdrawals</h2>
            <div class="font-grota text-sm text-wgh-gray-6">can't find a blockchain record?</div>
        </div>
        <BorderedContainer class="mb-2 overflow-hidden bg-wgh-gray-1.5">
            <div class="rounded-lg bg-white px-4 sm:px-0 lg:px-0">
                <div class="flex flex-col">
                    <div class="-my-2 -mx-4 overflow-x-auto sm:-mx-6 lg:-mx-8">
                        <div class="inline-block min-w-full py-2 align-middle md:px-6 lg:px-8">
                            <div class="overflow-hidden shadow ring-1 ring-black ring-opacity-5 md:rounded-lg">
                                <table class="min-w-full divide-y divide-gray-300">
                                    <thead class="bg-gray-50">
                                        <tr>
                                            <th
                                                scope="col"
                                                class="py-3.5 pl-4 pr-3 text-left text-sm font-semibold text-gray-900 sm:pl-6"
                                            >
                                                <Link
                                                    class="group inline-flex"
                                                    :href="currentUrl"
                                                    :data="{
                                                        sort_by: 'transaction_amount',
                                                        sort_order: filters.sort_order === 'desc' ? 'asc' : 'desc',
                                                    }"
                                                >
                                                    Amount
                                                    <span
                                                        :class="{
                                                            'invisible ml-2 flex-none rounded text-gray-400 group-hover:visible group-focus:visible':
                                                                filters.sort_by !== 'transaction_amount',
                                                            'ml-2 flex-none rounded bg-gray-200 text-gray-900 group-hover:bg-gray-300':
                                                                filters.sort_by === 'transaction_amount',
                                                            'rotate-180':
                                                                filters.sort_by === 'transaction_amount' &&
                                                                filters.sort_order === 'asc',
                                                        }"
                                                    >
                                                        <ChevronDownIcon class="h-5 w-5" aria-hidden="true" />
                                                    </span>
                                                </Link>
                                            </th>
                                            <th
                                                scope="col"
                                                class="py-3.5 pl-4 pr-3 text-left text-sm font-semibold text-gray-900 sm:pl-6"
                                            >
                                                <Link
                                                    class="group inline-flex"
                                                    :href="currentUrl"
                                                    :data="{
                                                        sort_by: 'transaction_network',
                                                        sort_order: filters.sort_order === 'desc' ? 'asc' : 'desc',
                                                    }"
                                                >
                                                    Network
                                                    <span
                                                        :class="{
                                                            'invisible ml-2 flex-none rounded text-gray-400 group-hover:visible group-focus:visible':
                                                                filters.sort_by !== 'transaction_network',
                                                            'ml-2 flex-none rounded bg-gray-200 text-gray-900 group-hover:bg-gray-300':
                                                                filters.sort_by === 'transaction_network',
                                                            'rotate-180':
                                                                filters.sort_by === 'transaction_network' &&
                                                                filters.sort_order === 'asc',
                                                        }"
                                                    >
                                                        <ChevronDownIcon class="h-5 w-5" aria-hidden="true" />
                                                    </span>
                                                </Link>
                                            </th>
                                            <th
                                                scope="col"
                                                class="py-3.5 pl-4 pr-3 text-left text-sm font-semibold text-gray-900 sm:pl-6"
                                            >
                                                <Link
                                                    class="group inline-flex"
                                                    :href="currentUrl"
                                                    :data="{
                                                        sort_by: 'transaction_blockchain_record',
                                                        sort_order: filters.sort_order === 'desc' ? 'asc' : 'desc',
                                                    }"
                                                >
                                                    Blockchain Record
                                                    <span
                                                        :class="{
                                                            'invisible ml-2 flex-none rounded text-gray-400 group-hover:visible group-focus:visible':
                                                                filters.sort_by !== 'transaction_blockchain_record',
                                                            'ml-2 flex-none rounded bg-gray-200 text-gray-900 group-hover:bg-gray-300':
                                                                filters.sort_by === 'transaction_blockchain_record',
                                                            'rotate-180':
                                                                filters.sort_by === 'transaction_blockchain_record' &&
                                                                filters.sort_order === 'asc',
                                                        }"
                                                    >
                                                        <ChevronDownIcon class="h-5 w-5" aria-hidden="true" />
                                                    </span>
                                                </Link>
                                            </th>
                                            <th
                                                scope="col"
                                                class="py-3.5 pl-4 pr-3 text-left text-sm font-semibold text-gray-900 sm:pl-6"
                                            >
                                                <Link
                                                    class="group inline-flex"
                                                    :href="currentUrl"
                                                    :data="{
                                                        sort_by: 'transaction_amount',
                                                        sort_order: filters.sort_order === 'desc' ? 'asc' : 'desc',
                                                    }"
                                                >
                                                    Withdrawall Adress/Account
                                                    <span
                                                        :class="{
                                                            'invisible ml-2 flex-none rounded text-gray-400 group-hover:visible group-focus:visible':
                                                                filters.sort_by !== 'transaction_amount',
                                                            'ml-2 flex-none rounded bg-gray-200 text-gray-900 group-hover:bg-gray-300':
                                                                filters.sort_by === 'transaction_amount',
                                                            'rotate-180':
                                                                filters.sort_by === 'transaction_amount' &&
                                                                filters.sort_order === 'asc',
                                                        }"
                                                    >
                                                        <ChevronDownIcon class="h-5 w-5" aria-hidden="true" />
                                                    </span>
                                                </Link>
                                            </th>
                                            <th
                                                scope="col"
                                                class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900"
                                            >
                                                <Link
                                                    class="group inline-flex"
                                                    :href="currentUrl"
                                                    :data="{
                                                        sort_by: 'transaction_status',
                                                        sort_order: filters.sort_order === 'desc' ? 'asc' : 'desc',
                                                    }"
                                                >
                                                    Status
                                                    <span
                                                        :class="{
                                                            'invisible ml-2 flex-none rounded text-gray-400 group-hover:visible group-focus:visible':
                                                                filters.sort_by !== 'transaction_status',
                                                            'ml-2 flex-none rounded bg-gray-200 text-gray-900 group-hover:bg-gray-300':
                                                                filters.sort_by === 'transaction_status',
                                                            'rotate-180':
                                                                filters.sort_by === 'transaction_status' &&
                                                                filters.sort_order === 'asc',
                                                        }"
                                                    >
                                                        <ChevronDownIcon class="h-5 w-5" aria-hidden="true" />
                                                    </span>
                                                </Link>
                                            </th>
                                            <th
                                                scope="col"
                                                class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900"
                                            >
                                                <Link
                                                    class="group inline-flex"
                                                    :href="currentUrl"
                                                    :data="{
                                                        sort_by: 'transaction_status',
                                                        sort_order: filters.sort_order === 'desc' ? 'asc' : 'desc',
                                                    }"
                                                >
                                                    Remarks
                                                    <span
                                                        :class="{
                                                            'invisible ml-2 flex-none rounded text-gray-400 group-hover:visible group-focus:visible':
                                                                filters.sort_by !== 'transaction_status',
                                                            'ml-2 flex-none rounded bg-gray-200 text-gray-900 group-hover:bg-gray-300':
                                                                filters.sort_by === 'transaction_status',
                                                            'rotate-180':
                                                                filters.sort_by === 'transaction_status' &&
                                                                filters.sort_order === 'asc',
                                                        }"
                                                    >
                                                        <ChevronDownIcon class="h-5 w-5" aria-hidden="true" />
                                                    </span>
                                                </Link>
                                            </th>
                                            <th
                                                scope="col"
                                                class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900"
                                            >
                                                <Link
                                                    class="group inline-flex"
                                                    :href="currentUrl"
                                                    :data="{
                                                        sort_by: 'created_at',
                                                        sort_order: filters.sort_order === 'desc' ? 'asc' : 'desc',
                                                    }"
                                                >
                                                    Start Time
                                                    <span
                                                        :class="{
                                                            'invisible ml-2 flex-none rounded text-gray-400 group-hover:visible group-focus:visible':
                                                                filters.sort_by !== 'created_at',
                                                            'ml-2 flex-none rounded bg-gray-200 text-gray-900 group-hover:bg-gray-300':
                                                                filters.sort_by === 'created_at',
                                                            'rotate-180':
                                                                filters.sort_by === 'created_at' &&
                                                                filters.sort_order === 'asc',
                                                        }"
                                                    >
                                                        <ChevronDownIcon class="h-5 w-5" aria-hidden="true" />
                                                    </span>
                                                </Link>
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody class="divide-y divide-gray-200 bg-white ">
                                        <tr v-for="transaction in userWithdrawTransactions" :key="transaction.id">
                                            <td
                                                class="whitespace-nowrap py-4 pl-4 pr-3 text-sm font-medium text-gray-900 sm:pl-6"
                                            >
                                                {{ transaction.amount }}
                                            </td>
                                            <td
                                                class="whitespace-nowrap py-4 pl-4 pr-3 text-sm font-medium text-gray-900 sm:pl-6"
                                            >
                                                <!-- {{ transaction.type }} -->
                                                network
                                            </td>
                                            <td
                                                class="whitespace-nowrap py-4 pl-4 pr-3 text-sm font-medium text-gray-900 sm:pl-6"
                                            >
                                                <!-- {{ transaction.fromAccountId }} -->
                                                record
                                            </td>
                                            <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">
                                                <!-- {{ transaction.asset }} -->
                                                withdrawal account
                                            </td>
                                            <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">
                                                {{ transaction.state }}
                                            </td>
                                            <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">
                                                <!-- {{ transaction.toAccountId }} -->
                                                remark
                                            </td>
                                            <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">
                                                {{ UTCToHumanReadable(transaction.createdAt) }}
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </BorderedContainer>
        <!-- <BorderedContainer class="mb-2 bg-wgh-gray-1.5">
            <nav
                class="flex w-full items-center justify-between rounded-lg border-t border-gray-200 bg-white bg-white px-4 py-3 sm:px-6"
                aria-label="Pagination"
            >
                <div class="hidden sm:block">
                    <p class="font-inter text-sm text-gray-700">
                        Showing
                        {{ ' ' }}
                        <span class="font-medium">{{ pagination.meta.from }}</span>
                        {{ ' ' }}
                        to
                        {{ ' ' }}
                        <span class="font-medium">{{ pagination.meta.to }}</span>
                        {{ ' ' }}
                        of
                        {{ ' ' }}
                        <span class="font-medium">{{ pagination.meta.total }}</span>
                        {{ ' ' }}
                        results
                    </p>
                </div>
                <div class="flex flex-1 justify-between space-x-4 sm:justify-end">
                    <Link :href="pagination.links.prev">
                        <ButtonShape v-if="pagination.links.prev" type="gray"> Previous</ButtonShape>
                    </Link>
                    <Link :href="pagination.links.next">
                        <ButtonShape v-if="pagination.links.next" type="gray"> Next</ButtonShape>
                    </Link>
                </div>
            </nav>
        </BorderedContainer> -->
    </div>
</template>
