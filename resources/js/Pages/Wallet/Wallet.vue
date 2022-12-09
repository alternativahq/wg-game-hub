<script setup>
import BorderedContainer from '@/Shared/BorderedContainer';
import ButtonShape from '@/Shared/ButtonShape';
import { inject, reactive, watch } from 'vue';
import { Link } from '@inertiajs/inertia-vue3';
import WodoTokenIcon from '@/Shared/SVG/WodoTokenIcon';
import BananoCoinIcon from '@/Shared/SVG/BananoCoinIcon';
import SolanaCoinIcon from '@/Shared/SVG/SolanaCoinIcon';
import NanoCoinIcon from '@/Shared/SVG/NanoCoinIcon';
import BNBCoinIcon from '@/Shared/SVG/BNBCoinIcon';
import EthereiumCoinIcon from '@/Shared/SVG/EthereiumCoinIcon';
import AvalancheCoinIcon from '@/Shared/SVG/AvalancheCoinIcon';
import { ChevronDownIcon } from '@heroicons/vue/24/solid';
import { throttle } from 'lodash';
import { Inertia } from '@inertiajs/inertia';
import Pagination from '@/Models/Pagination';

let currentUser = inject('currentUser');

let props = defineProps({
    assetAccounts: Object,
    filters: Object,
    assets: Object,
    current_url: String,
});

let pagination = reactive(new Pagination(props.assetAccounts));
let filters = reactive({ ...props.filters });
let currentUrl = window.location.toString();

function component(account) {
    let assets = {
        XWGT: WodoTokenIcon,
        BAN: BananoCoinIcon,
        SOL: SolanaCoinIcon,
        XNO: NanoCoinIcon,
        BSC: BNBCoinIcon,
        ETH: EthereiumCoinIcon,
        AVAX: AvalancheCoinIcon,
    };

    return assets[account.asset] || null;
}

watch(
    () => filters,
    throttle(() => {
        Inertia.get(currentUrl, { ...filters }, { preserveState: true, preserveScroll: true });
    }, 1000),
    {
        deep: true,
    }
);
</script>
<template>
    <section class="overflow-x-auto">
        <!-- <div class="flex gap-10 items-center">
            <div>
                <div class="mb-3">
                    <label for="Asset" class="form-label mb-2 inline-block text-lg text-gray-700">Asset</label>
                    <select
                        id="filter_by_asset"
                        name="filter_by_asset"
                        v-model="filters.filter_by_asset"
                        class="flex rounded border border-wgh-gray-1 px-4 py-2 pr-10 font-grota text-sm font-normal text-wgh-gray-6 placeholder-wgh-gray-3 outline-none"
                    >
                        <option :value="undefined">All</option>
                        <option :key="asset.id" v-for="asset in assets" :value="asset.symbol">
                            {{ asset.name }}
                        </option>
                    </select>
                </div>
            </div>
            <div>
                <div class="mb-3">
                    <label
                        for="Min Balance"
                        class="form-label mb-2 inline-block text-lg text-gray-700"
                        >From Balance</label
                    >
                    <input
                        class="form-control m-0 block rounded border border-solid border-gray-300 bg-white bg-clip-padding px-2 py-1 text-lg font-normal text-gray-700 transition ease-in-out focus:border-blue-600 focus:bg-white focus:text-gray-700 focus:outline-none"
                        type="number"
                        name="Min Balance"
                        id="Min Balance"
                        v-model="filters.balance_from"
                        placeholder="from balance"
                    />
                </div>
            </div>
            <div>
                <div class="mb-3">
                    <label
                        for="Min Balance"
                        class="form-label mb-2 inline-block text-lg text-gray-700"
                        >To Balance</label
                    >
                    <input
                        class="form-control m-0 block rounded border border-solid border-gray-300 bg-white bg-clip-padding px-2 py-1 text-lg font-normal text-gray-700 transition ease-in-out focus:border-blue-600 focus:bg-white focus:text-gray-700 focus:outline-none"
                        type="number"
                        name="Min Balance"
                        id="Min Balance"
                        v-model="filters.balance_to"
                        placeholder="to balance"
                    />
                </div>
            </div>
        </div> -->
        <div class="mb-6 flex flex-col items-center justify-between space-y-2 md:flex-row md:space-y-0">
            <h2 class="truncate font-grota text-2xl font-extrabold uppercase text-wgh-gray-6">Asset Accounts</h2>
            <div class="mb-5 flex flex-row items-center space-x-4">
                <div class="flex flex-row items-center justify-end space-x-4">
                    <Link class="shrink-0" href="/wallet/deposit">
                        <ButtonShape type="red">Deposit</ButtonShape>
                    </Link>
                    <Link class="shrink-0" href="/wallet/withdraw">
                        <ButtonShape type="red">Withdraw</ButtonShape>
                    </Link>
                </div>
                <Link class="shrink-0" href="/wallet/transactions">
                    <ButtonShape type="red">View Transactions</ButtonShape>
                </Link>
            </div>
        </div>
        <BorderedContainer class="bg-wgh-gray-1.5">
            <div class="rounded-lg">
                <div class="flex flex-col">
                    <div class="overflow-x-auto">
                        <div class="inline-block min-w-full align-middle">
                            <div class="overflow-hidden rounded-lg shadow-sm ring-1 ring-black ring-opacity-5">
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
                                                        sort_by: 'asset',
                                                        sort_order: filters.sort_order === 'desc' ? 'asc' : 'desc',
                                                    }"
                                                >
                                                    Name
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
                                                        sort_by: 'symbol',
                                                        sort_order: filters.sort_order === 'desc' ? 'asc' : 'desc',
                                                    }"
                                                >
                                                    Symbol
                                                    <span
                                                        :class="{
                                                            'invisible ml-2 flex-none rounded text-gray-400 group-hover:visible group-focus:visible':
                                                                filters.sort_by !== 'symbol',
                                                            'ml-2 flex-none rounded bg-gray-200 text-gray-900 group-hover:bg-gray-300':
                                                                filters.sort_by === 'symbol',
                                                            'rotate-180':
                                                                filters.sort_by === 'symbol' &&
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
                                                        sort_by: 'balance',
                                                        sort_order: filters.sort_order === 'desc' ? 'asc' : 'desc',
                                                    }"
                                                >
                                                    Balance
                                                    <span
                                                        :class="{
                                                            'invisible ml-2 flex-none rounded text-gray-400 group-hover:visible group-focus:visible':
                                                                filters.sort_by !== 'balance',
                                                            'ml-2 flex-none rounded bg-gray-200 text-gray-900 group-hover:bg-gray-300':
                                                                filters.sort_by === 'balance',
                                                            'rotate-180':
                                                                filters.sort_by === 'balance' &&
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
                                                Controles
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody class="divide-y divide-gray-200 bg-white">
                                        <tr v-for="assetAccount in assetAccounts.data" :key="assetAccount.id">
                                            <td
                                                class="whitespace-nowrap py-4 pl-4 pr-3 text-sm font-medium text-gray-900 sm:pl-6 lg:pl-8"
                                            >
                                                <div class="flex flex-row items-center space-x-2">
                                                    <component :is="component(assetAccount)" class="h-8 w-8 shrink-0" />
                                                    <p>{{ assetAccount.asset }}</p>
                                                </div>
                                            </td>
                                            <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">
                                                {{ assetAccount.asset }}
                                            </td>
                                            <td
                                                class="whitespace-nowrap py-4 pl-4 pr-3 text-sm font-medium text-gray-900 sm:pl-6 lg:pl-8"
                                            >
                                                {{ assetAccount.balance }}
                                            </td>
                                            <td
                                                class="whitespace-nowrap py-4 pl-4 pr-3 text-sm font-medium text-gray-900 sm:pl-6 lg:pl-8"
                                            >
                                                <div class="flex items-center space-x-4">
                                                    <Link class="shrink-0" href="/wallet/deposit" :data="{coin:assetAccount.asset}">
                                                        <ButtonShape type="purple">Deposit</ButtonShape>
                                                    </Link>
                                                    <Link class="shrink-0" href="/wallet/withdraw" :data="{coin:assetAccount.asset}">
                                                        <ButtonShape type="purple">Withdraw</ButtonShape>
                                                    </Link>
                                                </div>
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
        <!-- <BorderedContainer class="mb-2 bg-wgh-gray-1.5 mt-8">
            <nav
                class="flex w-full items-center justify-between rounded-lg border-t border-gray-200 bg-white px-4 py-3 sm:px-6"
                aria-label="Pagination"
            >
                <div class="hidden sm:block">
                    <p class="font-inter text-sm text-gray-700">
                        Showing
                        {{ ' ' }}
                        <span class="font-medium">{{ pagination.from }}</span>
                        {{ ' ' }}
                        to
                        {{ ' ' }}
                        <span class="font-medium">{{ pagination.to }}</span>
                        {{ ' ' }}
                        of
                        {{ ' ' }}
                        <span class="font-medium">{{ pagination.total }}</span>
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
        </BorderedContainer> -->
    </section>
</template>
