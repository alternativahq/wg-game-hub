<script setup>
import TextInput from '@/Shared/Inputs/TextInput';
import InputError from '@/Shared/InputError';
import ButtonShape from '@/Shared/ButtonShape';
import { useForm } from '@inertiajs/inertia-vue3';
import { Link } from '@inertiajs/inertia-vue3';

let props = defineProps({
    gameTemplate: Object,
    assets: Object,
    gameAlgorithms: Object,
});

let updateTemplateForm = useForm({
    name: props.gameTemplate.data.name,
    description: props.gameTemplate.data.description,
    image: props.gameTemplate.data.image,
    theme_color: props.gameTemplate.data.theme_color,
    rules: props.gameTemplate.data.rules,
    base_entrance_fee: props.gameTemplate.data.base_entrance_fee,
    min_players: props.gameTemplate.data.min_players,
    max_players: props.gameTemplate.data.max_players,
    game_play_duration: props.gameTemplate.data.game_play_duration ?? null,
    asset_id: props.gameTemplate.data.asset_id,
    game_id: props.gameTemplate.data.game_id,
    algorithm_id: props.gameTemplate.data.algorithm_id,
});

function updateGameLobbyTemplate() {
    updateTemplateForm.put(`/admin/gameTemplates/${props.gameTemplate.data.id}`, { preserveScroll: true });
}
</script>
<template>
    <div class="mx-auto w-96">
        <form @submit.prevent="updateGameLobbyTemplate">
            <div class="font-semibold">name</div>
            <TextInput
                v-model="updateTemplateForm.name"
                placeholder="name"
                type="text"
                id="name"
                name="name"
                class="mt-4"
            />
            <InputError class="mt-2">
                <div v-if="updateTemplateForm.errors.name" class="mt-2">
                    {{ updateTemplateForm.errors.name }}
                </div>
            </InputError>
            <div>
                <label for="description" class="font-semibold">description</label>
                <div class="mt-1">
                    <textarea
                        placeholder="description"
                        v-model="updateTemplateForm.description"
                        rows="4"
                        name="description"
                        id="description"
                        class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                    />
                </div>
            </div>
            <InputError class="mt-2">
                <div v-if="updateTemplateForm.errors.description" class="mt-2">
                    {{ updateTemplateForm.errors.description }}
                </div>
            </InputError>

            <div class="font-semibold">image_url</div>
            <TextInput
                v-model="updateTemplateForm.image"
                placeholder="image_url"
                type="text"
                id="image_url"
                name="image_url"
                class="mt-4"
            />
            <InputError class="mt-2">
                <div v-if="updateTemplateForm.errors.image_url" class="mt-2">
                    {{ updateTemplateForm.errors.image_url }}
                </div>
            </InputError>
            <div class="font-semibold">theme_color</div>
            <TextInput
                v-model="updateTemplateForm.theme_color"
                placeholder="theme_color"
                type="text"
                id="theme_color"
                name="theme_color"
                class="mt-4"
            />
            <InputError class="mt-2">
                <div v-if="updateTemplateForm.errors.theme_color" class="mt-2">
                    {{ updateTemplateForm.errors.theme_color }}
                </div>
            </InputError>
            <div class="font-semibold">rules</div>
            <TextInput
                v-model="updateTemplateForm.rules"
                placeholder="rules"
                type="text"
                id="rules"
                name="rules"
                class="mt-4"
            />
            <InputError class="mt-2">
                <div v-if="updateTemplateForm.errors.rules" class="mt-2">
                    {{ updateTemplateForm.errors.rules }}
                </div>
            </InputError>
            <div class="font-semibold">base_entrance_fee</div>
            <TextInput
                v-model="updateTemplateForm.base_entrance_fee"
                placeholder="base_entrance_fee"
                type="text"
                id="base_entrance_fee"
                name="base_entrance_fee"
                class="mt-4"
            />
            <InputError class="mt-2">
                <div v-if="updateTemplateForm.errors.base_entrance_fee" class="mt-2">
                    {{ updateTemplateForm.errors.base_entrance_fee }}
                </div>
            </InputError>
            <div class="font-semibold">min_players</div>
            <TextInput
                v-model="updateTemplateForm.min_players"
                placeholder="min_players"
                type="text"
                id="min_players"
                name="min_players"
                class="mt-4"
            />
            <InputError class="mt-2">
                <div v-if="updateTemplateForm.errors.min_players" class="mt-2">
                    {{ updateTemplateForm.errors.min_players }}
                </div>
            </InputError>
            <div class="font-semibold">max_players</div>
            <TextInput
                v-model="updateTemplateForm.max_players"
                placeholder="max_players"
                type="text"
                id="max_players"
                name="max_players"
                class="mt-4"
            />
            <InputError class="mt-2">
                <div v-if="updateTemplateForm.errors.max_players" class="mt-2">
                    {{ updateTemplateForm.errors.max_players }}
                </div>
            </InputError>
            <div class="font-semibold">Game Play Duration</div>
            <TextInput
                v-model="updateTemplateForm.game_play_duration"
                placeholder="game_play_duration"
                type="text"
                id="game_play_duration"
                name="game_play_duration"
                class="mt-4"
            />
            <InputError class="mt-2">
                <div v-if="updateTemplateForm.errors.game_play_duration" class="mt-2">
                    {{ updateTemplateForm.errors.game_play_duration }}
                </div>
            </InputError>
            <div class="font-semibold">Asset</div>
            <select
                id="asset_name"
                name="asset_name"
                class="mb-5 flex w-full flex-none rounded border border-wgh-gray-1 px-4 py-2 pr-10 font-grota text-sm font-normal text-wgh-gray-6 placeholder-wgh-gray-3 outline-none"
                v-model="updateTemplateForm.asset_id"
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
                v-model="updateTemplateForm.algorithm_id"
            >
                <option class="my-2" :key="index" v-for="(gameAlgorithm, index) in gameAlgorithms" :value="gameAlgorithm.value">
                    {{ gameAlgorithm.label }}
                </option>
            </select>
            <button type="submit" class="w-full mb-2" :disabled="updateTemplateForm.processing">
                <ButtonShape type="purple">
                    <span class="w-full uppercase">Update</span>
                </ButtonShape>
            </button>
            <Link :href="`/admin/games/${props.gameTemplate.data.game_id}/templates`">
                <ButtonShape type="red" class="w-full">
                    <span class="w-full uppercase">Cancel</span>
                </ButtonShape>
            </Link>
        </form>
    </div>
</template>
