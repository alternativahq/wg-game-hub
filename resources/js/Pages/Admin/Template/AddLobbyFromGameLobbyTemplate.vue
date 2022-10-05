<script setup>
import TextInput from '@/Shared/Inputs/TextInput';
import InputError from '@/Shared/InputError';
import ButtonShape from '@/Shared/ButtonShape';
import { useForm } from '@inertiajs/inertia-vue3';
import { computed } from 'vue';
import { addMonths, getMonth, getYear } from 'date-fns';
import '@vuepic/vue-datepicker/dist/main.css';
import Datepicker from '@vuepic/vue-datepicker';
import { Link } from '@inertiajs/inertia-vue3';

let props = defineProps({
    gameTemplate: Object,
    assets: Object,
    game: Object,
    gameTypes: Object,
    gameAlgorithms: Object,
});

let AddLobbyFromTemplateForm = useForm({
    name: props.gameTemplate.name,
    description: props.gameTemplate.description,
    image: props.gameTemplate.image,
    theme_color: props.gameTemplate.theme_color,
    type: '',
    rules: props.gameTemplate.rules,
    base_entrance_fee: props.gameTemplate.base_entrance_fee,
    min_players: props.gameTemplate.min_players,
    max_players: props.gameTemplate.max_players,
    game_play_duration: props.gameTemplate.game_play_duration,
    scheduled_at: '',
    start_at: '',
    asset_id: props.gameTemplate.asset_id,
    algorithm_id: props.gameTemplate.algorithm_id,
});

function addLobbyFromGameTemplate() {
    AddLobbyFromTemplateForm.post('/admin/game/' + props.game.id + '/gameTemplates/lobby');
}

// only 1 month in advance is allowed.
const maxDate = computed(() => addMonths(new Date(getYear(new Date()), getMonth(new Date())), 1));
</script>
<template>
    <div class="mx-auto w-96">
        <form @submit.prevent="addLobbyFromGameTemplate()">
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
                        class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                    />
                </div>
            </div>
            <InputError class="mt-2">
                <div v-if="AddLobbyFromTemplateForm.errors.description" class="mt-2">
                    {{ AddLobbyFromTemplateForm.errors.description }}
                </div>
            </InputError>

            <div class="font-semibold">image url</div>
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
            <div class="font-semibold">theme color</div>
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
                class="mb-5 flex w-full flex-none rounded border border-wgh-gray-1 px-4 py-2 pr-10 font-grota text-sm font-normal text-wgh-gray-6 placeholder-wgh-gray-3 outline-none"
                v-model="AddLobbyFromTemplateForm.type"
            >
                <option :key="index" v-for="(gameType, index) in gameTypes" :value="gameType.value">
                    {{ gameType.label }}
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
            <div class="font-semibold">base entrance fee</div>
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
            <div class="font-semibold">min players</div>
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
            <div class="font-semibold">max players</div>
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
            <div v-if="AddLobbyFromTemplateForm.type != 3">
                <div class="font-semibold">Game Play Duration</div>
                <TextInput
                    v-model="AddLobbyFromTemplateForm.game_play_duration"
                    placeholder="game_play_duration"
                    type="text"
                    id="game_play_duration"
                    name="game_play_duration"
                    disabled
                    class="mt-4"
                />
            </div>
            <div class="font-semibold">schedualed at</div>
            <Datepicker
                required
                class="mt-4"
                utc
                placeholder="Select date and time"
                v-model="AddLobbyFromTemplateForm.scheduled_at"
                :min-date="new Date()"
                :max-date="maxDate"
            ></Datepicker>
            <InputError class="mt-2">
                <div v-if="AddLobbyFromTemplateForm.errors.scheduled_at" class="mt-2">
                    {{ AddLobbyFromTemplateForm.errors.scheduled_at }}
                </div>
            </InputError>
            <div class="font-semibold">start at</div>
            <Datepicker
                required
                class="mt-4"
                utc
                placeholder="Select date and time"
                v-model="AddLobbyFromTemplateForm.start_at"
                :min-date="new Date()"
                :max-date="maxDate"
            ></Datepicker>
            <InputError class="mt-2">
                <div v-if="AddLobbyFromTemplateForm.errors.start_at" class="mt-2">
                    {{ AddLobbyFromTemplateForm.errors.start_at }}
                </div>
            </InputError>
            <div class="font-semibold">Asset</div>
            <select
                id="asset_name"
                name="asset_name"
                class="mb-5 flex w-full flex-none rounded border border-wgh-gray-1 px-4 py-2 pr-10 font-grota text-sm font-normal text-wgh-gray-6 placeholder-wgh-gray-3 outline-none"
                v-model="AddLobbyFromTemplateForm.asset_id"
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
                v-model="AddLobbyFromTemplateForm.algorithm_id"
            >
                <option :key="index" v-for="(gameAlgorithm, index) in gameAlgorithms" :value="gameAlgorithm.value">
                    {{ gameAlgorithm.label }}
                </option>
            </select>
            <button type="submit" class="w-full mb-2" :disabled="AddLobbyFromTemplateForm.processing">
                <ButtonShape type="purple">
                    <span class="w-full uppercase">Add Lobby</span>
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
