<script setup>
import BananoBalanceIcon from '@/Shared/SVG/BananoBalanceIcon';
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
            <BananoBalanceIcon class="h-14 w-14 shrink-0" />
            <div class="flex shrink grow-0 flex-col truncate">
                <p class="font-grota text-lg font-extrabold text-wgh-gray-6">
                    {{ account.balance.toLocaleString('US') }}
                </p>
            </div>
        </div>
    </div>
</template>
