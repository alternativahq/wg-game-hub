<script setup>
import TextInput from '@/Shared/Inputs/TextInput';
import InputError from '@/Shared/InputError';
import ButtonShape from '@/Shared/ButtonShape';
import { useForm } from '@inertiajs/inertia-vue3';
import Datepicker from '@vuepic/vue-datepicker';
import '@vuepic/vue-datepicker/dist/main.css';
import { computed } from 'vue';
import { addMonths, getMonth, getYear, subMonths } from 'date-fns';

let props = defineProps({
    assets: Object,
    game: Object,
    gameTypes: Object,
    gameStatus: Object,
    gameAlgorithms: Object,
});

let AddLobbyForm = useForm({
    name: '',
    description: '',
    image: '',
    theme_color: '',
    type: '',
    status: '',
    rules: '',
    base_entrance_fee: '',
    min_players: '',
    max_players: '',
    scheduled_at: '',
    start_at: '',
    asset_id: '',
    algorithm_id: '',
});

function addGameLobby() {
    AddLobbyForm.post('/admin/game/' + props.game.id + '/gameLobbies');
}

// only 1 month in advance is allowed.
const maxDate = computed(() => addMonths(new Date(getYear(new Date()), getMonth(new Date())), 1));
</script>
<template>
    <div class="mx-auto w-96">
        <form @submit.prevent="addGameLobby()">
            <div class="font-semibold">name</div>
            <TextInput v-model="AddLobbyForm.name" placeholder="name" type="text" id="name" name="name" class="mt-4" />
            <InputError class="mt-2">
                <div v-if="AddLobbyForm.errors.name" class="mt-2">
                    {{ AddLobbyForm.errors.name }}
                </div>
            </InputError>
            <div>
                <label for="description" class="font-semibold">description</label>
                <div class="mt-1">
                    <textarea
                        placeholder="description"
                        v-model="AddLobbyForm.description"
                        rows="4"
                        name="description"
                        id="description"
                        class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                    />
                </div>
            </div>
            <InputError class="mt-2">
                <div v-if="AddLobbyForm.errors.description" class="mt-2">
                    {{ AddLobbyForm.errors.description }}
                </div>
            </InputError>

            <div class="font-semibold">image</div>
            <TextInput
                v-model="AddLobbyForm.image"
                placeholder="image_url"
                type="text"
                id="image_url"
                name="image_url"
                class="mt-4"
            />
            <InputError class="mt-2">
                <div v-if="AddLobbyForm.errors.image" class="mt-2">
                    {{ AddLobbyForm.errors.image }}
                </div>
            </InputError>
            <div class="font-semibold">theme color</div>
            <TextInput
                v-model="AddLobbyForm.theme_color"
                placeholder="theme_color"
                type="text"
                id="theme_color"
                name="theme_color"
                class="mt-4"
            />
            <InputError class="mt-2">
                <div v-if="AddLobbyForm.errors.theme_color" class="mt-2">
                    {{ AddLobbyForm.errors.theme_color }}
                </div>
            </InputError>
            <div class="font-semibold">type</div>
            <select
                id="asset_name"
                name="asset_name"
                class="mb-5 flex w-full flex-none rounded border border-wgh-gray-1 px-4 py-2 pr-10 font-grota text-sm font-normal text-wgh-gray-6 placeholder-wgh-gray-3 outline-none"
                v-model="AddLobbyForm.type"
            >
                <option :key="index" v-for="(gameType, index) in gameTypes" :value="gameType.value">
                    {{ gameType.label }}
                </option>
            </select>
            <div class="font-semibold">rules</div>
            <TextInput
                v-model="AddLobbyForm.rules"
                placeholder="rules"
                type="text"
                id="rules"
                name="rules"
                class="mt-4"
            />
            <InputError class="mt-2">
                <div v-if="AddLobbyForm.errors.rules" class="mt-2">
                    {{ AddLobbyForm.errors.rules }}
                </div>
            </InputError>
            <div class="font-semibold">base entrance fee</div>
            <TextInput
                v-model="AddLobbyForm.base_entrance_fee"
                placeholder="base_entrance_fee"
                type="text"
                id="base_entrance_fee"
                name="base_entrance_fee"
                class="mt-4"
            />
            <InputError class="mt-2">
                <div v-if="AddLobbyForm.errors.base_entrance_fee" class="mt-2">
                    {{ AddLobbyForm.errors.base_entrance_fee }}
                </div>
            </InputError>
            <div class="font-semibold">min players</div>
            <TextInput
                v-model="AddLobbyForm.min_players"
                placeholder="min players"
                type="text"
                id="min_players"
                name="min_players"
                class="mt-4"
            />
            <InputError class="mt-2">
                <div v-if="AddLobbyForm.errors.min_players" class="mt-2">
                    {{ AddLobbyForm.errors.min_players }}
                </div>
            </InputError>
            <div class="font-semibold">max players</div>
            <TextInput
                v-model="AddLobbyForm.max_players"
                placeholder="max players"
                type="text"
                id="max_players"
                name="max_players"
                class="mt-4"
            />
            <InputError class="mt-2">
                <div v-if="AddLobbyForm.errors.max_players" class="mt-2">
                    {{ AddLobbyForm.errors.max_players }}
                </div>
            </InputError>
            <div class="font-semibold">schedualed at</div>
            <Datepicker
                required
                class="mt-4"
                utc
                placeholder="Select date and time"
                v-model="AddLobbyForm.scheduled_at"
                :min-date="new Date()"
                :max-date="maxDate"
            ></Datepicker>
            <InputError class="mt-2">
                <div v-if="AddLobbyForm.errors.scheduled_at" class="mt-2">
                    {{ AddLobbyForm.errors.scheduled_at }}
                </div>
            </InputError>
            <div class="font-semibold">start at</div>
            <Datepicker
                required
                class="mt-4"
                utc
                placeholder="Select date and time"
                v-model="AddLobbyForm.start_at"
                :min-date="new Date()"
                :max-date="maxDate"
            ></Datepicker>
            <InputError class="mt-2">
                <div v-if="AddLobbyForm.errors.start_at" class="mt-2">
                    {{ AddLobbyForm.errors.start_at }}
                </div>
            </InputError>
            <div class="font-semibold">Asset</div>
            <select
                id="asset_name"
                name="asset_name"
                class="mb-5 flex w-full flex-none rounded border border-wgh-gray-1 px-4 py-2 pr-10 font-grota text-sm font-normal text-wgh-gray-6 placeholder-wgh-gray-3 outline-none"
                v-model="AddLobbyForm.asset_id"
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
                v-model="AddLobbyForm.algorithm_id"
            >
                <option :key="index" v-for="(gameAlgorithm, index) in gameAlgorithms" :value="gameAlgorithm.value">
                    {{ gameAlgorithm.label }}
                </option>
            </select>
            <button type="submit" class="w-full" :disabled="AddLobbyForm.processing">
                <ButtonShape type="purple">
                    <span class="w-full uppercase">Add</span>
                </ButtonShape>
            </button>
        </form>
    </div>
</template>
