<script setup>
import { ChevronDownIcon } from '@heroicons/vue/24/solid';
import { defineProps, onMounted, reactive, watch } from 'vue';
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
import { useForm } from '@inertiajs/inertia-vue3';
import { debounce } from 'lodash';
import TransactionDialog from '@/Shared/Modals/TransactionDialog.vue';
import { UTCToHumanReadable} from '@/Helpers/Time'

dayjs.extend(utc);
dayjs.extend(timezone);
dayjs.extend(relativeTime);
dayjs.extend(duration);

let props = defineProps({
    userDepositTransactions: Object,
    userHasAccount: Boolean,
    assetInformation: Object,
    assets: Object,
    _filters: Object,
    _filtersOptions: Object,
    current_url: String,
});

onMounted(() => {
    if (props.assetInformation) {
        DepositForm.network = props.assetInformation.asset;
    }
});

let filters = reactive({ ...props._filters });
let currentUrl = window.location.toString();
let pagination = reactive(new Pagination(props.userDepositTransactions));

let state = reactive({
    open: false,
    transactionShow: null,
    transactionSteps: null,
});

let DepositForm = useForm({
    coin: props.assetInformation.asset,
    network: '',
});

let newUrl = new URL(window.location);
DepositForm.coin = newUrl.searchParams.get('coin');

function gnerateAccount() {
    Inertia.post('/wallet/Account', DepositForm, {preserveState: true});
}

async function show(transaction) {
    state.transactionShow = transaction;
    let response = await axios.get('/api/wallet/transaction/' + transaction.id + '/log').then((r) => r.data.data);
    state.transactionSteps = response;
    state.open = true;
}

watch(
    () => filters,
    debounce(() => {
        Inertia.get(currentUrl, filters, { preserveScroll: true, preserveState: true, replace: true });
    }, 500),
    {
        deep: true,
    }
);

watch(
    () => DepositForm.coin,
    () => {
        Inertia.reload({
            preserveScroll: true,
            preserveState: true,
            replace: true,
            only: ['assetInformation','userHasAccount'],
            data: { coin: DepositForm.coin },
        });
    }
);

watch(
    () => props.assetInformation,
    () => {
        DepositForm.network = props.assetInformation.asset;
    }
);
</script>
<template>
    <div>
        <TransactionDialog
            :transaction="state.transactionShow"
            :transactionSteps="state.transactionSteps"
            :open="state.open"
            @close="state.open = false"
        />
        <section class="flex items-center justify-between">
            <h2 class="mb-6 font-grota text-2xl font-extrabold uppercase text-wgh-gray-6">Deposit Crypto</h2>
            <div class="round mx-5 mb-6 bg-gray-300 px-3 py-2 text-lg font-semibold text-black">Deposit Fiat -></div>
        </section>
        <section class="flex">
            <div class="flex w-2/3 items-center justify-center">
                <form @submit.prevent="" class="mb-10 w-full">
                    <div class="mb-5 flex items-center py-4 px-4">
                        <div class="mr-20 w-2/5 text-right">Select a Coin</div>
                        <div class="w-3/5">
                            <div class="mb-2">coin</div>
                            <BorderedContainer class="bg-wgh-gray-1.5">
                                <div class="rounded-lg">
                                    <select
                                        id="location"
                                        name="location"
                                        v-model="DepositForm.coin"
                                        class="mt-1 block w-full rounded-md border-gray-300 py-2 pl-3 pr-10 font-inter text-base focus:border-indigo-500 focus:outline-none focus:ring-indigo-500 sm:text-sm"
                                    >
                                        <option default :value="undefined">All</option>
                                        <option :key="asset.symbol" v-for="asset in assets.data" :value="asset.symbol">
                                            {{ asset.name }}
                                        </option>
                                    </select>
                                </div>
                            </BorderedContainer>
                        </div>
                    </div>
                    <div class="mb-5 flex items-start py-4 px-4" v-if="!userHasAccount && !DepositForm.coin == ''">
                        <div class="mr-20 w-2/5 text-right text-lg font-semibold">No account generated for the given asset yet:</div>
                        <div class="w-3/5">
                            <form @submit.prevent="gnerateAccount()">
                                <button preserve-scroll type="submit" class="w-full">
                                    <ButtonShape type="purple">
                                        <span class="w-full uppercase">generate one</span>
                                    </ButtonShape>
                                </button>
                            </form>
                        </div>
                    </div>
                    <div v-if="assetInformation.id">
                        <div class="mb-5 flex items-center py-4 px-4">
                            <div class="mr-20 w-2/5 text-right">Select a Network</div>
                            <div class="w-3/5">
                                <div class="mb-2">Network</div>
                                <BorderedContainer class="bg-wgh-gray-1.5">
                                    <div class="rounded-lg">
                                        <input
                                            class="mt-1 block w-full rounded-md border-gray-300 py-2 pl-3 pr-10 font-inter text-base focus:border-indigo-500 focus:outline-none focus:ring-indigo-500 sm:text-sm"
                                            type="text"
                                            v-model="DepositForm.network"
                                            disabled
                                        />
                                    </div>
                                </BorderedContainer>
                            </div>
                        </div>
                        <div class="mb-5 flex items-center py-4 px-4">
                            <div class="mr-20 w-2/5 text-right"></div>
                            <div class="w-3/5">
                                <button preserve-scroll type="submit" class="w-full">
                                    <ButtonShape type="purple">
                                        <span class="w-full uppercase">Deposit</span>
                                    </ButtonShape>
                                </button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="ml-8 w-1/3">
                <div class="mb-4 text-lg font-bold">FAQ</div>
                <Link href="" class="mb-6 block text-gray-500 underline">
                    How do i deposit from my KuCoin account?
                </Link>
                <Link href="" class="mb-6 block text-gray-500 underline">
                    What should i do if i didn't receive my deposit or if i made a Deposit to an incorrect address?
                </Link>
                <Link href="" class="mb-6 block text-gray-500 underline">
                    What should i do if i deposit the wrong crypto?
                </Link>
                <Link href="" class="mb-6 block text-gray-500 underline">
                    What should i do if i forget to specif the Memo Tag or Message for my deposit?
                </Link>
                <Link href="" class="mb-6 block text-gray-500 underline"> what are the commen deposit crypto? </Link>
            </div>
        </section>
        <section class="mb-10 flex" v-if="assetInformation != ''">
            <div class="flex w-2/3">
                <div class="mr-20 w-2/5"></div>
                <div class="w-3/5">
                    <div class="font-semibold">Address</div>
                    <div class="w-1/2">{{ assetInformation.address }}</div>
                </div>
            </div>
            <div class="w-1/3"></div>
        </section>
        <section class="mb-10 flex" v-if="assetInformation != ''">
            <div class="flex w-2/3">
                <div class="mr-20 w-2/5"></div>
                <div class="flex w-3/5">
                    <div class="w-1/2">
                        <div class="mb-4">
                            <div class="font-semibold">Recipent Account</div>
                            <div class="text-sm">Main Account</div>
                        </div>
                    </div>
                    <div class="w-1/2">
                        <div class="mb-4">
                            <div class="font-semibold">Deposit Conformation</div>
                            <div>1 block(s)</div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="w-1/3"></div>
        </section>
        <div class="mb-6 flex flex-row flex-wrap justify-between lg:flex-nowrap">
            <h2 class="font-grota text-2xl font-extrabold uppercase text-wgh-gray-6">Deposit History</h2>
            <div class="flex max-w-4xl flex-row flex-wrap justify-end gap-2">
                <TextInput
                    placeholder="Global Tx ID"
                    class="inline-block w-full lg:w-auto"
                    v-model="filters.global_tx_id"
                />
                <TextInput placeholder="Ref ID" class="inline-block w-full lg:w-auto" v-model="filters.ref_id" />
                <TextInput placeholder="Hash" class="inline-block w-full lg:w-auto" v-model="filters.hash" />
                <TextInput
                    placeholder="From Account ID"
                    class="inline-block w-full lg:w-auto"
                    v-model="filters.from_account_id"
                />
                <TextInput
                    placeholder="To Account ID"
                    class="inline-block w-full lg:w-auto"
                    v-model="filters.to_account_id"
                />
                <select
                    class="mt-1 block w-full rounded-md border-gray-300 py-2 pl-3 pr-10 text-base focus:border-indigo-500 focus:outline-none focus:ring-indigo-500 sm:text-sm lg:w-auto"
                    v-model="filters.scope"
                >
                    <option :value="undefined">All Scopes</option>
                    <option
                        :key="index"
                        v-for="(item, index) in _filtersOptions.transactionScopeOptions"
                        :value="item.value"
                    >
                        {{ item.label }}
                    </option>
                </select>
                <select
                    class="mt-1 block w-full rounded-md border-gray-300 py-2 pl-3 pr-10 text-base focus:border-indigo-500 focus:outline-none focus:ring-indigo-500 sm:text-sm lg:w-auto"
                    v-model="filters.asset"
                >
                    <option :value="undefined">All Assets</option>
                    <option
                        :key="index"
                        v-for="(item, index) in _filtersOptions.transactionAssetOptions"
                        :value="item.value"
                    >
                        {{ item.label }}
                    </option>
                </select>
                <select
                    class="mt-1 block w-full rounded-md border-gray-300 py-2 pl-3 pr-10 text-base focus:border-indigo-500 focus:outline-none focus:ring-indigo-500 sm:text-sm lg:w-auto"
                    v-model="filters.state"
                >
                    <option :value="undefined">All States</option>
                    <option
                        :key="index"
                        v-for="(item, index) in _filtersOptions.transactionStateOptions"
                        :value="item.value"
                    >
                        {{ item.label }}
                    </option>
                </select>
            </div>
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
                                                class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900"
                                            >
                                                <Link
                                                    class="group inline-flex"
                                                    :href="currentUrl"
                                                    :data="{
                                                        sort_by: 'hash',
                                                        sort_order: filters.sort_order === 'desc' ? 'asc' : 'desc',
                                                    }"
                                                    :preserve-scroll="true"
                                                >
                                                    Hash
                                                    <span
                                                        :class="{
                                                            'invisible ml-2 flex-none rounded text-gray-400 group-hover:visible group-focus:visible':
                                                                filters.sort_by !== 'hash',
                                                            'ml-2 flex-none rounded bg-gray-200 text-gray-900 group-hover:bg-gray-300':
                                                                filters.sort_by === 'hash',
                                                            'rotate-180':
                                                                filters.sort_by === 'hash' &&
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
                                                        sort_by: 'state',
                                                        sort_order: filters.sort_order === 'desc' ? 'asc' : 'desc',
                                                    }"
                                                    :preserve-scroll="true"
                                                >
                                                    State
                                                    <span
                                                        :class="{
                                                            'invisible ml-2 flex-none rounded text-gray-400 group-hover:visible group-focus:visible':
                                                                filters.sort_by !== 'state',
                                                            'ml-2 flex-none rounded bg-gray-200 text-gray-900 group-hover:bg-gray-300':
                                                                filters.sort_by === 'state',
                                                            'rotate-180':
                                                                filters.sort_by === 'state' &&
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
                                                        sort_by: 'asset',
                                                        sort_order: filters.sort_order === 'desc' ? 'asc' : 'desc',
                                                    }"
                                                    :preserve-scroll="true"
                                                >
                                                    Asset
                                                    <span
                                                        :class="{
                                                            'invisible ml-2 flex-none rounded text-gray-400 group-hover:visible group-focus:visible':
                                                                filters.sort_by !== 'asset',
                                                            'ml-2 flex-none rounded bg-gray-200 text-gray-900 group-hover:bg-gray-300':
                                                                filters.sort_by === 'asset',
                                                            'rotate-180':
                                                                filters.sort_by === 'asset' &&
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
                                                        sort_by: 'fromAccountId',
                                                        sort_order: filters.sort_order === 'desc' ? 'asc' : 'desc',
                                                    }"
                                                    :preserve-scroll="true"
                                                >
                                                    From Account ID
                                                    <span
                                                        :class="{
                                                            'invisible ml-2 flex-none rounded text-gray-400 group-hover:visible group-focus:visible':
                                                                filters.sort_by !== 'fromAccountId',
                                                            'ml-2 flex-none rounded bg-gray-200 text-gray-900 group-hover:bg-gray-300':
                                                                filters.sort_by === 'fromAccountId',
                                                            'rotate-180':
                                                                filters.sort_by === 'fromAccountId' &&
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
                                                        sort_by: 'toAccountId',
                                                        sort_order: filters.sort_order === 'desc' ? 'asc' : 'desc',
                                                    }"
                                                    :preserve-scroll="true"
                                                >
                                                    To Account ID
                                                    <span
                                                        :class="{
                                                            'invisible ml-2 flex-none rounded text-gray-400 group-hover:visible group-focus:visible':
                                                                filters.sort_by !== 'toAccountId',
                                                            'ml-2 flex-none rounded bg-gray-200 text-gray-900 group-hover:bg-gray-300':
                                                                filters.sort_by === 'toAccountId',
                                                            'rotate-180':
                                                                filters.sort_by === 'toAccountId' &&
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
                                                        sort_by: 'amount',
                                                        sort_order: filters.sort_order === 'desc' ? 'asc' : 'desc',
                                                    }"
                                                    :preserve-scroll="true"
                                                >
                                                    Amount
                                                    <span
                                                        :class="{
                                                            'invisible ml-2 flex-none rounded text-gray-400 group-hover:visible group-focus:visible':
                                                                filters.sort_by !== 'amount',
                                                            'ml-2 flex-none rounded bg-gray-200 text-gray-900 group-hover:bg-gray-300':
                                                                filters.sort_by === 'amount',
                                                            'rotate-180':
                                                                filters.sort_by === 'amount' &&
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
                                                        sort_by: 'createdAt',
                                                        sort_order: filters.sort_order === 'desc' ? 'asc' : 'desc',
                                                    }"
                                                    :preserve-scroll="true"
                                                >
                                                    Created At
                                                    <span
                                                        :class="{
                                                            'invisible ml-2 flex-none rounded text-gray-400 group-hover:visible group-focus:visible':
                                                                filters.sort_by !== 'createdAt',
                                                            'ml-2 flex-none rounded bg-gray-200 text-gray-900 group-hover:bg-gray-300':
                                                                filters.sort_by === 'createdAt',
                                                            'rotate-180':
                                                                filters.sort_by === 'createdAt' &&
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
                                                Controlles
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody class="divide-y divide-gray-200 bg-white">
                                        <tr v-for="transaction in userDepositTransactions.data" :key="transaction.id">
                                            <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">
                                                {{ transaction.hash ?? '---' }}
                                            </td>
                                            <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">
                                                {{ transaction.state ?? '---' }}
                                            </td>
                                            <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">
                                                {{ transaction.asset ?? '---' }}
                                            </td>
                                            <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">
                                                {{ transaction.fromAccountId ?? '---' }}
                                            </td>
                                            <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">
                                                {{ transaction.toAccountId ?? '---' }}
                                            </td>
                                            <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">
                                                {{ transaction.amount ?? '---' }}
                                            </td>
                                            <td
                                                class="whitespace-nowrap py-4 pl-4 pr-3 text-sm font-medium text-gray-900 sm:pl-6"
                                            >
                                                {{ UTCToHumanReadable(transaction.createdAt, 'MMMM DD, YYYY hh:mm A') }}
                                            </td>   
                                            <td
                                                class="whitespace-nowrap py-4 pl-4 pr-3 text-sm font-medium text-gray-900 sm:pl-6"
                                            >
                                                <ButtonShape
                                                    class="cursor-pointer"
                                                    type="purple"
                                                    @click="show(transaction)"
                                                >
                                                    <span class="flex flex-row space-x-2.5">
                                                        <span class="font-bold uppercase">Show</span>
                                                    </span>
                                                </ButtonShape>
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
        <BorderedContainer class="mb-2 bg-wgh-gray-1.5">
            <nav
                class="flex w-full items-center justify-between rounded-lg border-t border-gray-200 bg-white px-4 py-3 sm:px-6"
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
                    <Link :href="pagination.links.prev" preserve-scroll>
                        <ButtonShape v-if="pagination.links.prev" type="gray"> Previous</ButtonShape>
                    </Link>
                    <Link :href="pagination.links.next" preserve-scroll>
                        <ButtonShape v-if="pagination.links.next" type="gray"> Next</ButtonShape>
                    </Link>
                </div>
            </nav>
        </BorderedContainer>
    </div>
</template>
