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
    gameTemplate:Object,
    assets:Object,
    game:Object,
    gameTypes:Object,
    gameStatuss:Object,
});

let AddLobbyFromTemplateForm = useForm({
    name: props.gameTemplate.name,
    description: props.gameTemplate.description,
    image: props.gameTemplate.image,
    theme_color: props.gameTemplate.theme_color,
    type: '',
    status: '',
    rules: props.gameTemplate.rules,
    base_entrance_fee: props.gameTemplate.base_entrance_fee,
    min_players: props.gameTemplate.min_players,
    max_players: props.gameTemplate.max_players,
    scheduled_at: '',
    asset_id:props.gameTemplate.asset_id,
});

function addLobbyFromGameTemplate(){
    AddLobbyFromTemplateForm.post(route('admin-gameTemplates-lobby-store', props.game.id));
}
</script>
<template>
    <div class="w-96 mx-auto">
         <form @submit.prevent="addLobbyFromGameTemplate()" >
            <div class="font-semibold">name</div>
            <TextInput
                v-model="AddLobbyFromTemplateForm.name"
                placeholder="name"
                type="text"
                id="name"
                name="name"
                class="mt-4"
            />
            <InputError class="mt-2">
                <div v-if="AddLobbyFromTemplateForm.errors.name" class="mt-2">
                    {{ AddLobbyFromTemplateForm.errors.name }}
                </div>
            </InputError>
             <div>
                <label for="description" class="font-semibold">description</label>
                <div class="mt-1">
                <textarea 
                    placeholder="description"
                    v-model="AddLobbyFromTemplateForm.description"
                    rows="4" 
                    name="description" 
                    id="description" 
                    class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md" />
                </div>
            </div>
            <InputError class="mt-2">
                <div v-if="AddLobbyFromTemplateForm.errors.description" class="mt-2">
                    {{ AddLobbyFromTemplateForm.errors.description }}
                </div>
            </InputError>

            <div class="font-semibold">image_url</div>
            <TextInput
                v-model="AddLobbyFromTemplateForm.image"
                placeholder="image_url"
                type="text"
                id="image_url"
                name="image_url"
                class="mt-4"
            />
            <InputError class="mt-2">
                <div v-if="AddLobbyFromTemplateForm.errors.image_url" class="mt-2">
                    {{ AddLobbyFromTemplateForm.errors.image_url }}
                </div>
            </InputError>
            <div class="font-semibold">theme_color</div>
            <TextInput
                v-model="AddLobbyFromTemplateForm.theme_color"
                placeholder="theme_color"
                type="text"
                id="theme_color"
                name="theme_color"
                class="mt-4"
            />
            <InputError class="mt-2">
                <div v-if="AddLobbyFromTemplateForm.errors.theme_color" class="mt-2">
                    {{ AddLobbyFromTemplateForm.errors.theme_color }}
                </div>
            </InputError>
            <div class="font-semibold">type</div>
            <select
                id="asset_name"
                name="asset_name"
                class="flex w-full flex-none rounded border border-wgh-gray-1 px-4 py-2 pr-10 font-grota text-sm font-normal
                text-wgh-gray-6 placeholder-wgh-gray-3 outline-none mb-5"
                v-model="AddLobbyFromTemplateForm.type"
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
                v-model="AddLobbyFromTemplateForm.status"
                >
                <option class="my-2" :key="index" v-for="(gameStatus, index) in gameStatuss" :value="gameStatus.value">
                    {{ gameStatus.label }}
                </option>
            </select>
  
            <div class="font-semibold">rules</div>
            <TextInput
                v-model="AddLobbyFromTemplateForm.rules"
                placeholder="rules"
                type="text"
                id="rules"
                name="rules"
                class="mt-4"
            />
            <InputError class="mt-2">
                <div v-if="AddLobbyFromTemplateForm.errors.rules" class="mt-2">
                    {{ AddLobbyFromTemplateForm.errors.rules }}
                </div>
            </InputError>
            <div class="font-semibold">base_entrance_fee</div>
            <TextInput
                v-model="AddLobbyFromTemplateForm.base_entrance_fee"
                placeholder="base_entrance_fee"
                type="text"
                id="base_entrance_fee"
                name="base_entrance_fee"
                class="mt-4"
            />
            <InputError class="mt-2">
                <div v-if="AddLobbyFromTemplateForm.errors.base_entrance_fee" class="mt-2">
                    {{ AddLobbyFromTemplateForm.errors.base_entrance_fee }}
                </div>
            </InputError>
            <div class="font-semibold">min_players</div>
            <TextInput
                v-model="AddLobbyFromTemplateForm.min_players"
                placeholder="min_players"
                type="text"
                id="min_players"
                name="min_players"
                class="mt-4"
            />
            <InputError class="mt-2">
                <div v-if="AddLobbyFromTemplateForm.errors.min_players" class="mt-2">
                    {{ AddLobbyFromTemplateForm.errors.min_players }}
                </div>
            </InputError>
            <div class="font-semibold">max_players</div>
            <TextInput
                v-model="AddLobbyFromTemplateForm.max_players"
                placeholder="max_players"
                type="text"
                id="max_players"
                name="max_players"
                class="mt-4"
            />
            <InputError class="mt-2">
                <div v-if="AddLobbyFromTemplateForm.errors.max_players" class="mt-2">
                    {{ AddLobbyFromTemplateForm.errors.max_players }}
                </div>
            </InputError>
            <div class="font-semibold">schedualed_at</div>
            <TextInput
                v-model="AddLobbyFromTemplateForm.scheduled_at"
                placeholder="scheduled_at"
                type="datetime-local"
                id="scheduled_at"
                name="scheduled_at"
                class="mt-4"
            />
            <InputError class="mt-2">
                <div v-if="AddLobbyFromTemplateForm.errors.scheduled_at" class="mt-2">
                    {{ AddLobbyFromTemplateForm.errors.scheduled_at }}
                </div>
            </InputError>
            <div class="font-semibold">Asset</div>
            <select
                id="asset_name"
                name="asset_name"
                class="flex w-full flex-none rounded border border-wgh-gray-1 px-4 py-2 pr-10 font-grota text-sm font-normal
                text-wgh-gray-6 placeholder-wgh-gray-3 outline-none mb-5"
                v-model="AddLobbyFromTemplateForm.asset_id"
                >
                <option :key="asset.id" v-for="asset in assets" :value="asset.id">
                    {{ asset.name }}
                </option>
            </select>
            <button
                type="submit"
                class="w-full"
                :disabled="AddLobbyFromTemplateForm.processing"
            >
                <ButtonShape type="purple">
                    <span class="w-full uppercase">Add Lobby</span>
                </ButtonShape>
            </button>
        </form> 
    </div>
</template>
