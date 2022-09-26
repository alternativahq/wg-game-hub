<script setup>
import BorderedContainer from '@/Shared/BorderedContainer';
import ButtonShape from '@/Shared/ButtonShape';
import { inject, reactive } from 'vue';
import { Link } from '@inertiajs/inertia-vue3';
import WodoTokenIcon from '@/Shared/SVG/WodoTokenIcon';
import BananoCoinIcon from '@/Shared/SVG/BananoCoinIcon';
import SolanaCoinIcon from '@/Shared/SVG/SolanaCoinIcon';
import NanoCoinIcon from '@/Shared/SVG/NanoCoinIcon';
import BNBCoinIcon from '@/Shared/SVG/BNBCoinIcon';
import EthereiumCoinIcon from '@/Shared/SVG/EthereiumCoinIcon';
import AvalancheCoinIcon from '@/Shared/SVG/AvalancheCoinIcon';
import { ChevronDownIcon } from '@heroicons/vue/solid';

let currentUser = inject('currentUser');

let props = defineProps({
    assetAccounts: Object,
    filters: Object,
    current_url: String,
});

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
</script>
<template>
    <section class="overflow-x-auto">
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
                                                        sort_by: 'name',
                                                        sort_order: filters.sort_order === 'desc' ? 'asc' : 'desc',
                                                    }"
                                                >
                                                    Name
                                                    <span
                                                        :class="{
                                                            'invisible ml-2 flex-none rounded text-gray-400 group-hover:visible group-focus:visible':
                                                                filters.sort_by !== 'name',
                                                            'ml-2 flex-none rounded bg-gray-200 text-gray-900 group-hover:bg-gray-300':
                                                                filters.sort_by === 'name',
                                                            'rotate-180':
                                                                filters.sort_by === 'name' &&
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
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </BorderedContainer>
    </section>
</template>
