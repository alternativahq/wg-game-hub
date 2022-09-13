<script setup>
import ButtonShape from '@/Shared/ButtonShape';
import DashboardBalanceCardCoin from '@/Shared/DashboardBalanceCard/DashboardBalanceCardCoin';
import BorderedContainer from '@/Shared/BorderedContainer';
import { Link } from '@inertiajs/inertia-vue3';
import { take, sortBy, reverse } from 'lodash';

let props = defineProps({
    balance: Array,
    asset_accounts: Object,
});
</script>
<template>
    <BorderedContainer class="bg-wgh-gray-1.5">
        <div class="rounded-lg bg-white p-6">
            <div class="mb-4 flex flex-col space-y-4">
                <DashboardBalanceCardCoin
                    :key="index"
                    v-for="(account, index) in take(reverse(sortBy(props.asset_accounts.data, ['balance'])), 4)"
                    :account="account"
                />
            </div>
            <div>
                <Link href="/wallet" class="w-full outline-none">
                    <ButtonShape type="gray">
                        <span class="w-full text-center font-bold uppercase">My Wallet</span>
                    </ButtonShape>
                </Link>
            </div>
        </div>
    </BorderedContainer>
</template>
