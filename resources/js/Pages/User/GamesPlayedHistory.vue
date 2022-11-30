<script setup>
import { ChevronDownIcon } from '@heroicons/vue/24/solid';
import { defineProps, reactive, watch } from 'vue';
import BorderedContainer from '@/Shared/BorderedContainer';
import ButtonShape from '@/Shared/ButtonShape';
import Pagination from '@/Models/Pagination';
import { Link } from '@inertiajs/inertia-vue3';
import { Inertia } from '@inertiajs/inertia';
import Datepicker from '@vuepic/vue-datepicker';
import '@vuepic/vue-datepicker/dist/main.css';
import { throttle } from 'lodash';

let props = defineProps({
    games: Object,
    gameTypes: Object,
    userGamesPlayedHistory: Object,
    filters: Object,
    current_url: String,
});

let filters = reactive({ ...props.filters });
let currentUrl = window.location.toString();
let availableGames = props.games.data;
let pagination = reactive(new Pagination(props.userGamesPlayedHistory));

function UTCToHumanReadable(u) {
    return dayjs(u).utc().local().tz(dayjs.tz.guess()).format('MMMM DD, YYYY hh:mm A');
}

function byGameFilterChanged() {
    Inertia.get(currentUrl, { filter_by_game: filters.filter_by_game });
}
watch(
    () => filters,
    throttle(() => {
        Inertia.get(currentUrl, { ...filters }, { preserveState: true, preserveScroll: true });
    }, 1000),
    {
        deep: true,
    }
);
</script>
<template>
    <div class="my-20">
        <h2 class="mb-6 font-grota text-3xl font-extrabold uppercase text-wgh-gray-6">Games Played History</h2>
        <div class="flex flex-row justify-between">
            <div class="mb-5 flex flex-row justify-between">
                <div class="filters flex items-center gap-8">
                    <div class="mb-3">
                        <label for="Maximum Players" class="form-label mb-2 inline-block text-lg text-gray-700"
                            >Game</label
                        >
                        <select
                            id="asset_name"
                            name="asset_name"
                            v-model="filters.filter_by_game"
                            @change.prevent="byGameFilterChanged"
                            class="flex rounded border border-wgh-gray-1 px-4 py-2 pr-10 font-grota text-sm font-normal text-wgh-gray-6 placeholder-wgh-gray-3 outline-none"
                        >
                            <option :value="undefined">All</option>
                            <option :key="game.id" v-for="game in availableGames" :value="game.id">
                                {{ game.name }}
                            </option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="Maximum Players" class="form-label mb-2 inline-block text-lg text-gray-700"
                            >Mode</label
                        >
                        <select
                            id="asset_name"
                            name="asset_name"
                            v-model="filters.game_gamelobbies_type"
                            class="flex rounded border border-wgh-gray-1 px-4 py-2 pr-10 font-grota text-sm font-normal text-wgh-gray-6 placeholder-wgh-gray-3 outline-none"
                        >
                            <option :value="undefined">All</option>
                            <option :key="index" v-for="(gameType, index) in gameTypes" :value="gameType.value">
                                {{ gameType.label }}
                            </option>
                        </select>
                    </div>
                    <div>
                        <div class="mb-3">
                            <label for="Rank" class="form-label text-md mb-2 inline-block text-gray-700"
                                >Rank</label
                            >
                            <input
                                class="form-control m-0 block rounded border border-solid border-gray-300 bg-white bg-clip-padding px-2 py-1 text-lg font-normal text-gray-700 transition ease-in-out focus:border-blue-600 focus:bg-white focus:text-gray-700 focus:outline-none"
                                type="number"
                                name="Rank"
                                id="Rank"
                                v-model="filters.rank"
                                placeholder="Rank"
                            />
                        </div>
                    </div>
                    <div>
                        <div class="mb-3 xl:w-64">
                            <label for="Date" class="form-label mb-2 inline-block text-lg text-gray-700">Date</label>
                            <Datepicker
                                range
                                required
                                class="block rounded-md border border-wgh-gray-1.5 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                                utc
                                placeholder="Select date and time"
                                v-model="filters.date"
                                :min-date="new Date()"
                                :max-date="maxDate"
                            ></Datepicker>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label
                            for="Minimum Base Entrance Fee"
                            class="form-label mb-2 inline-block text-lg text-gray-700"
                            >Minimum Base Entrance Fee</label
                        >
                        <input
                            class="form-control m-0 block rounded border border-solid border-gray-300 bg-white bg-clip-padding px-2 py-1 text-lg font-normal text-gray-700 transition ease-in-out focus:border-blue-600 focus:bg-white focus:text-gray-700 focus:outline-none"
                            type="number"
                            name="min-base_entrance_fee"
                            id="min-base_entrance_fee"
                            v-model="filters.min_base_entrance_fee"
                            placeholder="Minimum Base Entrance Fee"
                        />
                    </div>
                    <div>
                        <div class="mb-3">
                            <label
                                for="Maximum Base Entrance Fee"
                                class="form-label mb-2 inline-block text-lg text-gray-700"
                                >Maximum Base Entrance Fee</label
                            >
                            <input
                                class="form-control m-0 block rounded border border-solid border-gray-300 bg-white bg-clip-padding px-2 py-1 text-lg font-normal text-gray-700 transition ease-in-out focus:border-blue-600 focus:bg-white focus:text-gray-700 focus:outline-none"
                                type="number"
                                name="max-base_entrance_fee"
                                id="max-base_entrance_fee"
                                v-model="filters.max_base_entrance_fee"
                                placeholder="Maximum Base Entrance Fee"
                            />
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <BorderedContainer class="mb-2 overflow-hidden bg-wgh-gray-1.5">
            <div class="rounded-lg bg-white px-4 sm:px-0 lg:px-0">
                <div class="flex flex-col">
                    <div class="-my-2 -mx-4 overflow-x-auto sm:-mx-6 lg:-mx-8">
                        <div class="inline-block min-w-full py-2 align-middle md:px-6 lg:px-8">
                            <div class="overflow-hidden shadow ring-1 ring-black ring-opacity-5 md:rounded-lg">
                                <table class="min-w-full divide-y divide-gray-300">
                                    <thead class="bg-gray-50">
                                        <tr>
                                            <th
                                                scope="col"
                                                class="py-3.5 pl-4 pr-3 text-left text-sm font-semibold text-gray-900 sm:pl-6"
                                            >
                                                <Link
                                                    class="group inline-flex"
                                                    :href="currentUrl"
                                                    :data="{
                                                        sort_by: 'game_name',
                                                        sort_order: filters.sort_order === 'desc' ? 'asc' : 'desc',
                                                    }"
                                                >
                                                    Name
                                                    <span
                                                        :class="{
                                                            'invisible ml-2 flex-none rounded text-gray-400 group-hover:visible group-focus:visible':
                                                                filters.sort_by !== 'game_name',
                                                            'ml-2 flex-none rounded bg-gray-200 text-gray-900 group-hover:bg-gray-300':
                                                                filters.sort_by === 'game_name',
                                                            'rotate-180':
                                                                filters.sort_by === 'game_name' &&
                                                                filters.sort_order === 'asc',
                                                        }"
                                                    >
                                                        <ChevronDownIcon class="h-5 w-5" aria-hidden="true" />
                                                    </span>
                                                </Link>
                                            </th>
                                            <th
                                                scope="col"
                                                class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900"
                                            >
                                                <Link
                                                    class="group inline-flex"
                                                    :href="currentUrl"
                                                    :data="{
                                                        sort_by: 'score',
                                                        sort_order: filters.sort_order === 'desc' ? 'asc' : 'desc',
                                                    }"
                                                >
                                                    Score
                                                    <span
                                                        :class="{
                                                            'invisible ml-2 flex-none rounded text-gray-400 group-hover:visible group-focus:visible':
                                                                filters.sort_by !== 'score',
                                                            'ml-2 flex-none rounded bg-gray-200 text-gray-900 group-hover:bg-gray-300':
                                                                filters.sort_by === 'score',
                                                            'rotate-180':
                                                                filters.sort_by === 'score' &&
                                                                filters.sort_order === 'asc',
                                                        }"
                                                    >
                                                        <ChevronDownIcon class="h-5 w-5" aria-hidden="true" />
                                                    </span>
                                                </Link>
                                            </th>
                                            <th
                                                scope="col"
                                                class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900"
                                            >
                                                <Link
                                                    class="group inline-flex"
                                                    :href="currentUrl"
                                                    :data="{
                                                        sort_by: 'rank',
                                                        sort_order: filters.sort_order === 'desc' ? 'asc' : 'desc',
                                                    }"
                                                >
                                                    Rank
                                                    <span
                                                        :class="{
                                                            'invisible ml-2 flex-none rounded text-gray-400 group-hover:visible group-focus:visible':
                                                                filters.sort_by !== 'rank',
                                                            'ml-2 flex-none rounded bg-gray-200 text-gray-900 group-hover:bg-gray-300':
                                                                filters.sort_by === 'rank',
                                                            'rotate-180':
                                                                filters.sort_by === 'rank' &&
                                                                filters.sort_order === 'asc',
                                                        }"
                                                    >
                                                        <ChevronDownIcon class="h-5 w-5" aria-hidden="true" />
                                                    </span>
                                                </Link>
                                            </th>
                                            <th
                                                scope="col"
                                                class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900"
                                            >
                                                <Link
                                                    class="group inline-flex"
                                                    :href="currentUrl"
                                                    :data="{
                                                        sort_by: 'played_at',
                                                        sort_order: filters.sort_order === 'desc' ? 'asc' : 'desc',
                                                    }"
                                                >
                                                    Date
                                                    <span
                                                        :class="{
                                                            'invisible ml-2 flex-none rounded text-gray-400 group-hover:visible group-focus:visible':
                                                                filters.sort_by !== 'played_at',
                                                            'ml-2 flex-none rounded bg-gray-200 text-gray-900 group-hover:bg-gray-300':
                                                                filters.sort_by === 'played_at',
                                                            'rotate-180':
                                                                filters.sort_by === 'played_at' &&
                                                                filters.sort_order === 'asc',
                                                        }"
                                                    >
                                                        <ChevronDownIcon class="h-5 w-5" aria-hidden="true" />
                                                    </span>
                                                </Link>
                                            </th>
                                            <th
                                                scope="col"
                                                class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900"
                                            >
                                            Controles
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody class="divide-y divide-gray-200 bg-white">
                                        <tr v-for="item in userGamesPlayedHistory.data" :key="item.id">
                                            <td
                                                class="whitespace-nowrap py-4 pl-4 pr-3 text-sm font-medium text-gray-900 sm:pl-6"
                                            >
                                                {{ item.game.name }}
                                            </td>

                                            <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">
                                                {{ item.score }}
                                            </td>

                                            <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">
                                                #{{ item.rank }}
                                            </td>
                                            <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">
                                                {{ UTCToHumanReadable(item.game_lobby.scheduled_at) }}
                                            </td>
                                            <td
                                                class="flex items-center whitespace-nowrap px-3 py-4 text-sm text-gray-500"
                                            >
                                                <Link :href="`/game-lobbies/${item.game_lobby.id}/details`">
                                                    <ButtonShape type="purple">
                                                        <span class="flex flex-row space-x-2.5">
                                                            <span class="font-bold uppercase">Show</span>
                                                        </span>
                                                    </ButtonShape>
                                                </Link>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </BorderedContainer>
        <BorderedContainer class="mb-2 bg-wgh-gray-1.5">
            <nav
                class="flex w-full items-center justify-between rounded-lg border-t border-gray-200 bg-white px-4 py-3 sm:px-6"
                aria-label="Pagination"
            >
                <div class="hidden sm:block">
                    <p class="font-inter text-sm text-gray-700">
                        Showing
                        {{ ' ' }}
                        <span class="font-medium">{{ pagination.meta.from }}</span>
                        {{ ' ' }}
                        to
                        {{ ' ' }}
                        <span class="font-medium">{{ pagination.meta.to }}</span>
                        {{ ' ' }}
                        of
                        {{ ' ' }}
                        <span class="font-medium">{{ pagination.meta.total }}</span>
                        {{ ' ' }}
                        results
                    </p>
                </div>
                <div class="flex flex-1 justify-between space-x-4 sm:justify-end">
                    <Link :href="pagination.links.prev">
                        <ButtonShape v-if="pagination.links.prev" type="gray"> Previous </ButtonShape>
                    </Link>
                    <Link :href="pagination.links.next">
                        <ButtonShape v-if="pagination.links.next" type="gray"> Next </ButtonShape>
                    </Link>
                </div>
            </nav>
        </BorderedContainer>
    </div>
</template>
