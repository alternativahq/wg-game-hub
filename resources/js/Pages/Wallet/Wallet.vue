<script setup>
import BorderedContainer from '@/Shared/BorderedContainer';
import ButtonShape from '@/Shared/ButtonShape';
import { inject } from 'vue';
import { Link } from '@inertiajs/inertia-vue3';

let currentUser = inject('currentUser');

let props = defineProps({
    assetAccounts: Object,
});
</script>
<template>
    <section class="overflow-x-auto">
        <div class="mb-6 flex flex-col items-center justify-between space-y-2 md:flex-row md:space-y-0">
            <h2 class="truncate font-grota text-2xl font-extrabold uppercase text-wgh-gray-6">Asset Accounts</h2>
            <div class="mb-5 flex flex-row items-center space-x-4">
                <div class="flex flex-row items-center justify-end space-x-4">
                    <Link class="shrink-0" :href="route('user.deposit')">
                        <ButtonShape type="red">Deposit</ButtonShape>
                    </Link>
                    <Link class="shrink-0" :href="route('user.withdraw')">
                        <ButtonShape type="red">Withdraw</ButtonShape>
                    </Link>
                </div>
                <Link class="shrink-0" :href="route('user.transactions')">
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
                                                class="py-3.5 pl-4 pr-3 text-left text-sm font-semibold text-gray-900 sm:pl-6 lg:pl-8"
                                            >
                                                Name
                                            </th>
                                            <th
                                                scope="col"
                                                class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900"
                                            >
                                                Symbol
                                            </th>
                                            <th
                                                scope="col"
                                                class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900"
                                            >
                                                Balance
                                            </th>

                                            <th
                                                scope="col"
                                                class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900"
                                            >
                                                Description
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody class="divide-y divide-gray-200 bg-white">
                                        <tr v-for="assetAccount in assetAccounts" :key="assetAccount.id">
                                            <td
                                                class="whitespace-nowrap py-4 pl-4 pr-3 text-sm font-medium text-gray-900 sm:pl-6 lg:pl-8"
                                            >
                                                {{ assetAccount.name }}
                                            </td>
                                            <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">
                                                {{ assetAccount.symbol }}
                                            </td>
                                            <td
                                                class="whitespace-nowrap py-4 pl-4 pr-3 text-sm font-medium text-gray-900 sm:pl-6 lg:pl-8"
                                            >
                                                {{ assetAccount.pivot.balance }}
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
    </section>
</template>
