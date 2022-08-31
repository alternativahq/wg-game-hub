<script setup>
import { ChevronDownIcon } from '@heroicons/vue/solid';
import { defineProps, reactive, watch } from 'vue';
import BorderedContainer from '@/Shared/BorderedContainer';
import ButtonShape from '@/Shared/ButtonShape';
import Pagination from '@/Models/Pagination';
import { Link } from '@inertiajs/inertia-vue3';
import { Inertia } from '@inertiajs/inertia';
import dayjs from 'dayjs';
import utc from 'dayjs/plugin/utc';
import timezone from 'dayjs/plugin/timezone';
import relativeTime from 'dayjs/plugin/relativeTime';
import duration from 'dayjs/plugin/duration';
import { throttle } from 'lodash';

dayjs.extend(utc);
dayjs.extend(timezone);
dayjs.extend(relativeTime);
dayjs.extend(duration);

let props = defineProps({
    gameTemplates: Object,
    game: Object,
    filters: Object,
    current_url: String,
});

let filters = reactive({ ...props.filters });
let currentUrl = window.location.toString();
let pagination = reactive(new Pagination(props.gameTemplates));

function UTCToHumanReadable(u) {
    return dayjs(u).utc().local().tz(dayjs.tz.guess()).format('MMMM DD, YYYY hh:mm A');
}

watch(
    () => filters,
    throttle(() => {
        Inertia.get(currentUrl, { filter_by_asset: filters.filter_by_asset, q: filters.q }, { preserveState: true });
    }, 1000),
    {
        deep: true,
    }
);

function deleteLobby(gameTemplate) {
    Inertia.delete("/admin/gameTemplates/"+ gameTemplate.id);
}
</script>
<template>
    <div>
        <div class="flex flex-row justify-between">
            <h2 class="mb-6 font-grota text-2xl font-extrabold uppercase text-wgh-gray-6">Lobby Templates</h2>
            <div class="filters flex">
                <div class="mt-1">
                    <input
                        type="text"
                        name="search"
                        id="search"
                        class="block w-full rounded-md border border-wgh-gray-1.5 py-3 px-2 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                        placeholder="Search"
                        v-model="filters.q"
                    />
                </div>
                <Link :href="`/admin/game/${props.game.id}/gameTemplates/create/`">
                    <ButtonShape type="purple" class="mx-2">
                        <span class="flex flex-row space-x-2.5">
                            <span class="font-bold uppercase">Add</span>
                        </span>
                    </ButtonShape>
                </Link>
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
                                                class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900"
                                            >
                                                <Link
                                                    class="group inline-flex"
                                                    :href="currentUrl"
                                                    :data="{
                                                        sort_by: 'game_templates_name',
                                                        sort_order: filters.sort_order === 'desc' ? 'asc' : 'desc',
                                                        q :filters.q
                                                    }"
                                                >
                                                    Name
                                                    <span
                                                        :class="{
                                                            'invisible ml-2 flex-none rounded text-gray-400 group-hover:visible group-focus:visible':
                                                                filters.sort_by !== 'game_templates_name',
                                                            'ml-2 flex-none rounded bg-gray-200 text-gray-900 group-hover:bg-gray-300':
                                                                filters.sort_by === 'game_templates_name',
                                                            'rotate-180':
                                                                filters.sort_by === 'game_templates_name' &&
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
                                                        sort_by: 'game_templates_asset_symbol',
                                                        sort_order: filters.sort_order === 'desc' ? 'asc' : 'desc',
                                                        q :filters.q
                                                    }"
                                                >
                                                    Symbol
                                                    <span
                                                        :class="{
                                                            'invisible ml-2 flex-none rounded text-gray-400 group-hover:visible group-focus:visible':
                                                                filters.sort_by !== 'game_templates_asset_symbol',
                                                            'ml-2 flex-none rounded bg-gray-200 text-gray-900 group-hover:bg-gray-300':
                                                                filters.sort_by === 'game_templates_asset_symbol',
                                                            'rotate-180':
                                                                filters.sort_by === 'game_templates_asset_symbol' &&
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
                                                        sort_by: 'game_templates_base_entrance_fee',
                                                        sort_order: filters.sort_order === 'desc' ? 'asc' : 'desc',
                                                        q :filters.q
                                                    }"
                                                >
                                                    Entrance Fee
                                                    <span
                                                        :class="{
                                                            'invisible ml-2 flex-none rounded text-gray-400 group-hover:visible group-focus:visible':
                                                                filters.sort_by !== 'game_templates_base_entrance_fee',
                                                            'ml-2 flex-none rounded bg-gray-200 text-gray-900 group-hover:bg-gray-300':
                                                                filters.sort_by === 'game_templates_base_entrance_fee',
                                                            'rotate-180':
                                                                filters.sort_by === 'game_templates_base_entrance_fee' &&
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
                                                        sort_by: 'game_templates_min_players',
                                                        sort_order: filters.sort_order === 'desc' ? 'asc' : 'desc',
                                                        q :filters.q
                                                    }"
                                                >
                                                    Min Players
                                                    <span
                                                        :class="{
                                                            'invisible ml-2 flex-none rounded text-gray-400 group-hover:visible group-focus:visible':
                                                                filters.sort_by !== 'game_templates_min_players',
                                                            'ml-2 flex-none rounded bg-gray-200 text-gray-900 group-hover:bg-gray-300':
                                                                filters.sort_by === 'game_templates_min_players',
                                                            'rotate-180':
                                                                filters.sort_by === 'game_templates_min_players' &&
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
                                                        sort_by: 'game_templates_max_players',
                                                        sort_order: filters.sort_order === 'desc' ? 'asc' : 'desc',
                                                        q :filters.q
                                                    }"
                                                >
                                                    Max Players
                                                    <span
                                                        :class="{
                                                            'invisible ml-2 flex-none rounded text-gray-400 group-hover:visible group-focus:visible':
                                                                filters.sort_by !== 'game_templates_max_players',
                                                            'ml-2 flex-none rounded bg-gray-200 text-gray-900 group-hover:bg-gray-300':
                                                                filters.sort_by === 'game_templates_max_players',
                                                            'rotate-180':
                                                                filters.sort_by === 'game_templates_max_players' &&
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
                                                <span class="group inline-flex">description</span>
                                            </th>
                                            <th
                                                scope="col"
                                                class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900"
                                            >
                                                <span class="group inline-flex">Controles</span>
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody class="divide-y divide-gray-200 bg-white">
                                        <tr v-for="gameTemplate in gameTemplates.data" :key="gameTemplate.id">
                                            <td
                                                class="whitespace-nowrap py-4 pl-4 pr-3 text-sm font-medium text-gray-900 sm:pl-6"
                                            >
                                                {{ gameTemplate.name }}
                                            </td>
                                            <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">
                                                {{ gameTemplate.asset.symbol }}
                                            </td>
                                            <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">
                                                {{ gameTemplate.base_entrance_fee }}
                                            </td>
                                            <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">
                                                {{ gameTemplate.min_players }}
                                            </td>
                                            <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">
                                                {{ gameTemplate.max_players }}
                                            </td>
                                            <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">
                                                {{ gameTemplate.description }}
                                            </td>
                                            <td class="whitespace-nowrap px-3 flex items-center py-4 text-sm text-gray-500">
                                                <Link :href="`/admin/game/${game.id}/gameTemplates/${gameTemplate.id}/lobby/create`">
                                                    <ButtonShape type="purple">
                                                        <span class="flex flex-row space-x-2.5">
                                                            <span class="font-bold uppercase">Make Lobby</span>
                                                        </span>
                                                    </ButtonShape>
                                                </Link>
                                                <Link :href="`/admin/gameTemplates/${gameTemplate.id}/edit`">
                                                    <ButtonShape type="purple">
                                                        <span class="flex flex-row space-x-2.5">
                                                            <span class="font-bold uppercase">Update</span>
                                                        </span>
                                                    </ButtonShape>
                                                </Link>
                                                <button  @click="deleteLobby(gameTemplate)">
                                                    <ButtonShape type="red" class="mx-2">
                                                        <span class="flex flex-row space-x-2.5">
                                                            <span class="font-bold uppercase">Delete</span>
                                                        </span>
                                                    </ButtonShape>
                                                </button>
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
                class="flex w-full items-center justify-between rounded-lg border-t border-gray-200 bg-white bg-white px-4 py-3 sm:px-6"
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
                    <Link :href="pagination.links.prev" preserve-scroll>
                        <ButtonShape v-if="pagination.links.prev" type="gray"> Previous</ButtonShape>
                    </Link>
                    <Link :href="pagination.links.next" preserve-scroll>
                        <ButtonShape v-if="pagination.links.next" type="gray"> Next</ButtonShape>
                    </Link>
                </div>
            </nav>
        </BorderedContainer>
    </div>
</template>

