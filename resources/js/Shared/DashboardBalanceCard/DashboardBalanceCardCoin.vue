<script setup>
import BananoBalanceIcon from '@/Shared/SVG/BananoBalanceIcon';
import BananoCoinIcon from '@/Shared/SVG/BananoCoinIcon';
import SolanaCoinIcon from '@/Shared/SVG/SolanaCoinIcon';
import BNBCoinIcon from '@/Shared/SVG/BNBCoinIcon';
import EthereiumCoinIcon from '@/Shared/SVG/EthereiumCoinIcon';
import NanoCoinIcon from '@/Shared/SVG/NanoCoinIcon';
import AvalancheCoinIcon from '@/Shared/SVG/AvalancheCoinIcon';
import WodoTokenIcon from '@/Shared/SVG/WodoTokenIcon';


let props = defineProps({
    account: Object,
});
</script>
<template>
    <div>
        <p
            class="mb-1 font-inter text-xs font-semibold uppercase text-wgh-gray-2"
        >
            {{ account.asset }} Balance
        </p>
        <div class="flex flex-row items-center space-x-4">

            <div v-if="props.account.asset === 'SOLANO'">
                <SolanaCoinIcon class="h-14 w-14 shrink-0" />
            </div>
            <div v-else-if="props.account.asset === 'BINANCE SMART CHAIN'">
                 <BNBCoinIcon class="h-14 w-14 shrink-0" />
            </div>
            <div v-else-if="props.account.asset === 'ETHEREUM'">
                 <EthereiumCoinIcon class="h-14 w-14 shrink-0" />
            </div>
             <div v-else-if="props.account.asset === 'ETHEREUM'">
                 <EthereiumCoinIcon class="h-14 w-14 shrink-0" />
            </div>
            <div v-else-if="props.account.asset === 'NANO'">
                 <NanoCoinIcon class="h-14 w-14 shrink-0" />
            </div>
            <div v-else-if="props.account.asset === 'AVALANCHE'">
                 <AvalancheCoinIcon class="h-14 w-14 shrink-0" />
            </div>
            <div v-else-if="props.account.asset === 'BANANO'">
                 <BananoCoinIcon class="h-14 w-14 shrink-0" />
            </div>
            <div v-else-if="props.account.asset === 'WODO TOKEN'">
                 <WodoTokenIcon class="h-14 w-14 shrink-0" />
            </div>
            <div v-else>
                 <BananoCoinIcon class="h-14 w-14 shrink-0" />
            </div>
           
            <div class="flex shrink grow-0 flex-col truncate">
                <p class="font-grota text-lg font-extrabold text-wgh-gray-6">
                    {{ account.balance.toLocaleString('US') }}
                </p>
            </div>
        </div>
    </div>
</template>
