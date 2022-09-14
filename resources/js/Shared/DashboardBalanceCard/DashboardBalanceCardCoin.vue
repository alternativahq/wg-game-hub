<script setup>
// import BananoBalanceIcon from '@/Shared/SVG/BananoBalanceIcon';
import WodoTokenIcon from '@/Shared/SVG/WodoTokenIcon';
import BananoCoinIcon from '@/Shared/SVG/BananoCoinIcon';
import SolanaCoinIcon from '@/Shared/SVG/SolanaCoinIcon';
import NanoCoinIcon from '@/Shared/SVG/NanoCoinIcon';
import BNBCoinIcon from '@/Shared/SVG/BNBCoinIcon';
import AvalancheCoinIcon from '@/Shared/SVG/AvalancheCoinIcon';
import EthereiumCoinIcon from '@/Shared/SVG/EthereiumCoinIcon';

let props = defineProps({
    account: Object,
});

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
    <div>
        <p class="mb-1 font-inter text-xs font-semibold uppercase text-wgh-gray-2">{{ account.asset }} Balance</p>
        <div class="flex flex-row items-center space-x-4">
            <component :is="component(account)" class="h-10 w-10 shrink-0" />
            <div class="flex shrink grow-0 flex-col truncate">
                <p class="font-grota text-lg font-extrabold text-wgh-gray-6">
                    {{ account.balance.toLocaleString('US') }}
                </p>
            </div>
        </div>
    </div>
</template>
