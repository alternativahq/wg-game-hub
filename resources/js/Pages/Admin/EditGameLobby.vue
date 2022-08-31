<script setup>
import Logo from '@/Shared/SVG/Logo';
import TextInput from '@/Shared/Inputs/TextInput';
import { ref, onMounted } from 'vue';
import InputError from '@/Shared/InputError';
import ButtonShape from '@/Shared/ButtonShape';
import { useForm } from '@inertiajs/inertia-vue3';
import { intersectionTypeAnnotation } from '@babel/types';
import { Inertia } from '@inertiajs/inertia';

let props = defineProps({
    gameLobby:Object,
    assets:Object,
    gameTypes:Object,
    gameStatuss:Object,
});

let updateLobbyForm = useForm({
    name: props.gameLobby.data.name,
    description: props.gameLobby.data.description,
    image: props.gameLobby.data.image_url,
    theme_color: props.gameLobby.data.theme_color,
    type: props.gameLobby.data.type,
    status: props.gameLobby.data.status,
    rules: props.gameLobby.data.rules,
    base_entrance_fee: props.gameLobby.data.base_entrance_fee,
    min_players: props.gameLobby.data.min_players,
    max_players: props.gameLobby.data.max_players,
    scheduled_at: props.gameLobby.data.scheduled_at_date_time,
    asset_id:props.gameLobby.data.asset_id,
    game_id:props.gameLobby.data.game_id,
});

function updateGameLobby(){
    updateLobbyForm.put("/admin/gameLobbies/"+props.gameLobby.data.id, { preserveScroll: true });
}
</script>
<template>
    <div class="w-96 mx-auto">
        <form @submit.prevent="updateGameLobby" >
            <div class="font-semibold">name</div>
            <TextInput
                v-model="updateLobbyForm.name"
                placeholder="name"
                type="text"
                id="name"
                name="name"
                class="mt-4"
            />
            <InputError class="mt-2">
                <div v-if="updateLobbyForm.errors.name" class="mt-2">
                    {{ updateLobbyForm.errors.name }}
                </div>
            </InputError>
             <div>
                <label for="description" class="font-semibold">description</label>
                <div class="mt-1">
                <textarea 
                    placeholder="description"
                    v-model="updateLobbyForm.description"
                    rows="4" 
                    name="description" 
                    id="description" 
                    class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md" />
                </div>
            </div>
            <InputError class="mt-2">
                <div v-if="updateLobbyForm.errors.description" class="mt-2">
                    {{ updateLobbyForm.errors.description }}
                </div>
            </InputError>

            <div class="font-semibold">image_url</div>
            <TextInput
                v-model="updateLobbyForm.image"
                placeholder="image_url"
                type="text"
                id="image_url"
                name="image_url"
                class="mt-4"
            />
            <InputError class="mt-2">
                <div v-if="updateLobbyForm.errors.image_url" class="mt-2">
                    {{ updateLobbyForm.errors.image_url }}
                </div>
            </InputError>
            <div class="font-semibold">theme_color</div>
            <TextInput
                v-model="updateLobbyForm.theme_color"
                placeholder="theme_color"
                type="text"
                id="theme_color"
                name="theme_color"
                class="mt-4"
            />
            <InputError class="mt-2">
                <div v-if="updateLobbyForm.errors.theme_color" class="mt-2">
                    {{ updateLobbyForm.errors.theme_color }}
                </div>
            </InputError>
            <div class="font-semibold">type</div>
            <select
                id="asset_name"
                name="asset_name"
                class="flex w-full flex-none rounded border border-wgh-gray-1 px-4 py-2 pr-10 font-grota text-sm font-normal
                text-wgh-gray-6 placeholder-wgh-gray-3 outline-none mb-5"
                v-model="updateLobbyForm.type"
                >
                <option :key="index" v-for="(gameType, index) in gameTypes" :value="gameType.value">
                    {{ gameType.label }}
                </option>
            </select>
            <div class="font-semibold">status</div>
            <select
                id="asset_name"
                name="asset_name"
                class="flex w-full flex-none rounded border border-wgh-gray-1 px-4 py-2 pr-10 font-grota text-sm font-normal
                text-wgh-gray-6 placeholder-wgh-gray-3 outline-none mb-5"
                v-model="updateLobbyForm.status"
                >
                <option class="my-2" :key="index" v-for="(gameStatus, index) in gameStatuss" :value="gameStatus.value">
                    {{ gameStatus.label }}
                </option>
            </select>
  
            <div class="font-semibold">rules</div>
            <TextInput
                v-model="updateLobbyForm.rules"
                placeholder="rules"
                type="text"
                id="rules"
                name="rules"
                class="mt-4"
            />
            <InputError class="mt-2">
                <div v-if="updateLobbyForm.errors.rules" class="mt-2">
                    {{ updateLobbyForm.errors.rules }}
                </div>
            </InputError>
            <div class="font-semibold">base_entrance_fee</div>
            <TextInput
                v-model="updateLobbyForm.base_entrance_fee"
                placeholder="base_entrance_fee"
                type="text"
                id="base_entrance_fee"
                name="base_entrance_fee"
                class="mt-4"
            />
            <InputError class="mt-2">
                <div v-if="updateLobbyForm.errors.base_entrance_fee" class="mt-2">
                    {{ updateLobbyForm.errors.base_entrance_fee }}
                </div>
            </InputError>
            <div class="font-semibold">min_players</div>
            <TextInput
                v-model="updateLobbyForm.min_players"
                placeholder="min_players"
                type="text"
                id="min_players"
                name="min_players"
                class="mt-4"
            />
            <InputError class="mt-2">
                <div v-if="updateLobbyForm.errors.min_players" class="mt-2">
                    {{ updateLobbyForm.errors.min_players }}
                </div>
            </InputError>
            <div class="font-semibold">max_players</div>
            <TextInput
                v-model="updateLobbyForm.max_players"
                placeholder="max_players"
                type="text"
                id="max_players"
                name="max_players"
                class="mt-4"
            />
            <InputError class="mt-2">
                <div v-if="updateLobbyForm.errors.max_players" class="mt-2">
                    {{ updateLobbyForm.errors.max_players }}
                </div>
            </InputError>
            <div class="font-semibold">schedualed_at</div>
            <TextInput
                v-model="updateLobbyForm.scheduled_at"
                placeholder="scheduled_at"
                type="datetime-local"
                id="scheduled_at"
                name="scheduled_at"
                class="mt-4"
            />
            <InputError class="mt-2">
                <div v-if="updateLobbyForm.errors.scheduled_at" class="mt-2">
                    {{ updateLobbyForm.errors.scheduled_at }}
                </div>
            </InputError>
            <div class="font-semibold">Asset</div>
            <select
                id="asset_name"
                name="asset_name"
                class="flex w-full flex-none rounded border border-wgh-gray-1 px-4 py-2 pr-10 font-grota text-sm font-normal
                text-wgh-gray-6 placeholder-wgh-gray-3 outline-none mb-5"
                v-model="updateLobbyForm.asset_id"
                >
                <option :key="asset.id" v-for="asset in assets" :value="asset.id">
                    {{ asset.name }}
                </option>
            </select>
            <button
                type="submit"
                class="w-full"
                :disabled="updateLobbyForm.processing"
            >
                <ButtonShape type="purple">
                    <span class="w-full uppercase">Update</span>
                </ButtonShape>
            </button>
        </form>
    </div>
</template>

