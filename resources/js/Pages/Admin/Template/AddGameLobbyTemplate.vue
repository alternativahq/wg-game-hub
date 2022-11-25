<script setup>
import TextInput from '@/Shared/Inputs/TextInput';
import InputError from '@/Shared/InputError';
import ButtonShape from '@/Shared/ButtonShape';
import { useForm } from '@inertiajs/inertia-vue3';
import { Link } from '@inertiajs/inertia-vue3';

let props = defineProps({
    assets: Object,
    game: Object,
    gameAlgorithms: Object,
});

let AddTemplateForm = useForm({
    name: '',
    description: '',
    image: '',
    theme_color: '',
    rules: '',
    base_entrance_fee: '',
    min_players: '',
    max_players: '',
    game_play_duration: '',
    asset_id: '',
    algorithm_id: '',
    game_start_delay_time : '',
    game_start_delay_limit : '',
    commission : '',
});

function addGameLobbyTemplate() {
    AddTemplateForm.post(`/admin/game/${props.game.id}/gameTemplates`);
}
</script>
<template>
    <div class="mx-auto w-96">
        <form @submit.prevent="addGameLobbyTemplate()">
            <div class="font-semibold">name</div>
            <TextInput
                v-model="AddTemplateForm.name"
                placeholder="name"
                type="text"
                id="name"
                name="name"
                class="mt-4"
            />
            <InputError class="mt-2">
                <div v-if="AddTemplateForm.errors.name" class="mt-2">
                    {{ AddTemplateForm.errors.name }}
                </div>
            </InputError>
            <div>
                <label for="description" class="font-semibold">description</label>
                <div class="mt-1">
                    <textarea
                        placeholder="description"
                        v-model="AddTemplateForm.description"
                        rows="4"
                        name="description"
                        id="description"
                        class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                    />
                </div>
            </div>
            <InputError class="mt-2">
                <div v-if="AddTemplateForm.errors.description" class="mt-2">
                    {{ AddTemplateForm.errors.description }}
                </div>
            </InputError>

            <div class="font-semibold">image_url</div>
            <TextInput
                v-model="AddTemplateForm.image"
                placeholder="image_url"
                type="text"
                id="image_url"
                name="image_url"
                class="mt-4"
            />
            <InputError class="mt-2">
                <div v-if="AddTemplateForm.errors.image_url" class="mt-2">
                    {{ AddTemplateForm.errors.image_url }}
                </div>
            </InputError>
            <div class="font-semibold">theme_color</div>
            <TextInput
                v-model="AddTemplateForm.theme_color"
                placeholder="theme_color"
                type="text"
                id="theme_color"
                name="theme_color"
                class="mt-4"
            />
            <InputError class="mt-2">
                <div v-if="AddTemplateForm.errors.theme_color" class="mt-2">
                    {{ AddTemplateForm.errors.theme_color }}
                </div>
            </InputError>
            <div class="font-semibold">rules</div>
            <TextInput
                v-model="AddTemplateForm.rules"
                placeholder="rules"
                type="text"
                id="rules"
                name="rules"
                class="mt-4"
            />
            <InputError class="mt-2">
                <div v-if="AddTemplateForm.errors.rules" class="mt-2">
                    {{ AddTemplateForm.errors.rules }}
                </div>
            </InputError>
            <div class="font-semibold">commission (%)</div>
            <TextInput
                v-model="AddTemplateForm.commission"
                placeholder="commission"
                type="text"
                id="commission"
                name="commission"
                class="mt-4"
            />
            <InputError class="mt-2">
                <div v-if="AddTemplateForm.errors.commission" class="mt-2">
                    {{ AddTemplateForm.errors.commission }}
                </div>
            </InputError>
            <div class="font-semibold">base_entrance_fee</div>
            <TextInput
                v-model="AddTemplateForm.base_entrance_fee"
                placeholder="base_entrance_fee"
                type="text"
                id="base_entrance_fee"
                name="base_entrance_fee"
                class="mt-4"
            />
            <InputError class="mt-2">
                <div v-if="AddTemplateForm.errors.base_entrance_fee" class="mt-2">
                    {{ AddTemplateForm.errors.base_entrance_fee }}
                </div>
            </InputError>
            <div class="font-semibold">min_players</div>
            <TextInput
                v-model="AddTemplateForm.min_players"
                placeholder="min_players"
                type="text"
                id="min_players"
                name="min_players"
                class="mt-4"
            />
            <InputError class="mt-2">
                <div v-if="AddTemplateForm.errors.min_players" class="mt-2">
                    {{ AddTemplateForm.errors.min_players }}
                </div>
            </InputError>
            <div class="font-semibold">max_players</div>
            <TextInput
                v-model="AddTemplateForm.max_players"
                placeholder="max_players"
                type="text"
                id="max_players"
                name="max_players"
                class="mt-4"
            />
            <InputError class="mt-2">
                <div v-if="AddTemplateForm.errors.max_players" class="mt-2">
                    {{ AddTemplateForm.errors.max_players }}
                </div>
            </InputError>
            <div class="font-semibold">Game Play Duration</div>
            <TextInput
                v-model="AddTemplateForm.game_play_duration"
                placeholder="game_play_duration"
                type="text"
                id="game_play_duration"
                name="game_play_duration"
                class="mt-4"
            />
            <InputError class="mt-2">
                <div v-if="AddTemplateForm.errors.game_play_duration" class="mt-2">
                    {{ AddTemplateForm.errors.game_play_duration }}
                </div>
            </InputError>
            <div class="font-semibold">Asset</div>
            <select
                id="asset_name"
                name="asset_name"
                class="mb-5 flex w-full flex-none rounded border border-wgh-gray-1 px-4 py-2 pr-10 font-grota text-sm font-normal text-wgh-gray-6 placeholder-wgh-gray-3 outline-none"
                v-model="AddTemplateForm.asset_id"
            >
                <option :key="asset.id" v-for="asset in assets" :value="asset.id">
                    {{ asset.name }}
                </option>
            </select>
            <div class="font-semibold">Algorithm</div>
            <select
                id="asset_name"
                name="asset_name"
                class="mb-5 flex w-full flex-none rounded border border-wgh-gray-1 px-4 py-2 pr-10 font-grota text-sm font-normal text-wgh-gray-6 placeholder-wgh-gray-3 outline-none"
                v-model="AddTemplateForm.algorithm_id"
            >
                <option :key="index" v-for="(gameAlgorithm, index) in gameAlgorithms" :value="gameAlgorithm.value">
                    {{ gameAlgorithm.label }}
                </option>
            </select>
            <div class="font-semibold mt-4">Game Start Delay Time (min)</div>
            <TextInput
                v-model="AddTemplateForm.game_start_delay_time"
                placeholder="Game Start Delay Time"
                type="text"
                id="game_start_delay_time"
                name="game_start_delay_time"
                class="mb-5"
            />
            <InputError class="mt-2">
                <div v-if="AddTemplateForm.errors.game_start_delay_time" class="mt-2">
                    {{ AddTemplateForm.errors.game_start_delay_time }}
                </div>
            </InputError>
            <div class="font-semibold mt-4">Game Start Delay Limit (times)</div>
            <TextInput
                v-model="AddTemplateForm.game_start_delay_limit"
                placeholder="Game Start Delay Limit"
                type="text"
                id="game_start_delay_limit"
                name="game_start_delay_limit"
                class="mb-5"
            />
            <InputError class="mt-2">
                <div v-if="AddTemplateForm.errors.game_start_delay_limit" class="mt-2">
                    {{ AddTemplateForm.errors.game_start_delay_limit }}
                </div>
            </InputError>
            <button type="submit" class="w-full mb-2" :disabled="AddTemplateForm.processing">
                <ButtonShape type="purple">
                    <span class="w-full uppercase">Add</span>
                </ButtonShape>
            </button>
            <Link :href="`/admin/games/${game.id}/templates`">
                <ButtonShape type="red" class="w-full">
                    <span class="w-full uppercase">Cancel</span>
                </ButtonShape>
            </Link>
        </form>
    </div>
</template>
