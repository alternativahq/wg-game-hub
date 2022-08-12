<script setup>
import { ChevronDownIcon } from '@heroicons/vue/solid';
import { defineProps, reactive, ref, watch } from 'vue';
import BorderedContainer from '@/Shared/BorderedContainer';
import ButtonShape from '@/Shared/ButtonShape';
import Pagination from '@/Models/Pagination';
import { Link } from '@inertiajs/inertia-vue3';
import { Inertia } from '@inertiajs/inertia';
import { throttle } from 'lodash';

let props = defineProps({
    assets: Object,
    userAssetAccounts: Object,
    filters: Object,
    current_url: String,
});

let filters = reactive({ ...props.filters });
let currentUrl = window.location.toString();

watch(
    () => filters,
    throttle(() => {
        Inertia.get(currentUrl, { filter_by_asset: filters.filter_by_asset, q: filters.q }, { preserveState: true });
    }, 1000),
    {
        deep: true,
    }
);
</script>
<template>
    <div>
        <div class="mb-6 flex flex-row items-center justify-between">
            <h2 class="font-grota text-2xl font-extrabold uppercase text-wgh-gray-6">Asset Accounts</h2>
            <div class="filters">
                <div class="mt-1">
                    <input
                        type="text"
                        name="search"
                        id="search"
                        class="block w-full rounded-md border border-wgh-gray-1.5 border-gray-300 py-3 px-2 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                        placeholder="Search"
                        v-model="filters.q"
                    />
                </div>
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
                                                class="py-3.5 pl-4 pr-3 text-left text-sm font-semibold text-gray-900 sm:pl-6"
                                            >
                                                <Link
                                                    class="group inline-flex"
                                                    :href="currentUrl"
                                                    :data="{
                                                        sort_by: 'asset_name',
                                                        sort_order: filters.sort_order === 'desc' ? 'asc' : 'desc',
                                                    }"
                                                >
                                                    Name
                                                    <span
                                                        :class="{
                                                            'invisible ml-2 flex-none rounded text-gray-400 group-hover:visible group-focus:visible':
                                                                filters.sort_by !== 'asset_name',
                                                            'ml-2 flex-none rounded bg-gray-200 text-gray-900 group-hover:bg-gray-300':
                                                                filters.sort_by === 'asset_name',
                                                            'rotate-180':
                                                                filters.sort_by === 'asset_name' &&
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
                                                        sort_by: 'asset_symbol',
                                                        sort_order: filters.sort_order === 'desc' ? 'asc' : 'desc',
                                                    }"
                                                >
                                                    <span class="group inline-flex">Symbol</span>
                                                    <span
                                                        :class="{
                                                            'invisible ml-2 flex-none rounded text-gray-400 group-hover:visible group-focus:visible':
                                                                filters.sort_by !== 'asset_symbol',
                                                            'ml-2 flex-none rounded bg-gray-200 text-gray-900 group-hover:bg-gray-300':
                                                                filters.sort_by === 'asset_symbol',
                                                            'rotate-180':
                                                                filters.sort_by === 'asset_symbol' &&
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
                                                        sort_by: 'user_asset_balance',
                                                        sort_order: filters.sort_order === 'desc' ? 'asc' : 'desc',
                                                    }"
                                                >
                                                    Balance
                                                    <span
                                                        :class="{
                                                            'invisible ml-2 flex-none rounded text-gray-400 group-hover:visible group-focus:visible':
                                                                filters.sort_by !== 'user_asset_balance',
                                                            'ml-2 flex-none rounded bg-gray-200 text-gray-900 group-hover:bg-gray-300':
                                                                filters.sort_by === 'user_asset_balance',
                                                            'rotate-180':
                                                                filters.sort_by === 'user_asset_balance' &&
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
                                                <span class="group inline-flex">Description</span>
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody class="divide-y divide-gray-200 bg-white">
                                        <tr v-for="assetAccount in userAssetAccounts.data" :key="assetAccount.id">
                                            <td
                                                class="whitespace-nowrap py-4 pl-4 pr-3 text-sm font-medium text-gray-900 sm:pl-6"
                                            >
                                                {{ assetAccount.name }}
                                            </td>
                                            <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">
                                                {{ assetAccount.symbol }}
                                            </td>
                                            <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">
                                                {{ assetAccount.balance }}
                                            </td>
                                            <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">
                                                {{ assetAccount.description }}
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
        <BorderedContainer class="mb-2 bg-wgh-gray-1.5" v-if="props.userAssetAccounts.meta.from">
            <nav
                class="flex w-full items-center justify-between rounded-lg border-t border-gray-200 bg-white bg-white px-4 py-3 sm:px-6"
                aria-label="Pagination"
            >
                <div class="hidden sm:block">
                    <p class="font-inter text-sm text-gray-700">
                        Showing
                        {{ ' ' }}
                        <span class="font-medium">{{ props.userAssetAccounts.meta.from }}</span>
                        {{ ' ' }}
                        to
                        {{ ' ' }}
                        <span class="font-medium">{{ props.userAssetAccounts.meta.to }}</span>
                        {{ ' ' }}
                        of
                        {{ ' ' }}
                        <span class="font-medium">{{ props.userAssetAccounts.meta.total }}</span>
                        {{ ' ' }}
                        results
                    </p>
                </div>
                <div class="flex flex-1 justify-between space-x-4 sm:justify-end">
                    <Link :href="props.userAssetAccounts.links.prev">
                        <ButtonShape v-if="props.userAssetAccounts.links.prev" type="gray"> Previous</ButtonShape>
                    </Link>
                    <Link :href="props.userAssetAccounts.links.next">
                        <ButtonShape v-if="props.userAssetAccounts.links.next" type="gray"> Next</ButtonShape>
                    </Link>
                </div>
            </nav>
        </BorderedContainer>
    </div>
</template>
