<script setup>
import { defineProps} from 'vue';
import BorderedContainer from '@/Shared/BorderedContainer';
import { Link } from '@inertiajs/inertia-vue3';
import GameLobbySteps from '@/Shared/GameLobbySteps.vue';

let props = defineProps({
    gameLobbie: Object,,
});
</script>
<template>
    <div>
        <div class=""> 
            <BorderedContainer class="mb-8 bg-wgh-purple-3">
                <div class="p-6 space-y-8">
                    <div class="w-full text-3xl font-bold">
                        Lobby Info
                    </div>
                    <div class="w-full flex justify-around items-center text-gray-700 gap-10 ">
                        <div class="mt-4 font-inter text-base font-normal bg-gray-100 w-1/4 p-4 rounded-lg">
                            the game lobby will be available at datetime
                        </div>
                        <div class="mt-4 font-inter text-base font-normal bg-gray-100 w-1/4 p-4 rounded-lg">
                            the game lobby will start at datetime
                        </div>
                        <div class="mt-4 font-inter text-base font-normal bg-gray-100 w-1/4 p-4 rounded-lg">
                            current lobby users
                        </div>
                        <div class="mt-4 font-inter text-base font-normal bg-gray-100 w-1/4 p-4 rounded-lg">
                            gamplay duration
                        </div>
                    </div>
                </div>
            </BorderedContainer>
        </div>


        <GameLobbySteps class="mb-5"/>
        <!-- <Steps :steps="transactionSteps" class="mb-5" /> -->
        <!-- <div>steps</div> -->
    </div>
</template>
