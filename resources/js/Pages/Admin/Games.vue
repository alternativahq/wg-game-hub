<script setup>
import { ChevronDownIcon } from '@heroicons/vue/solid';
import { defineProps, reactive, watch } from 'vue';
import BorderedContainer from '@/Shared/BorderedContainer';
import ButtonShape from '@/Shared/ButtonShape';
import Pagination from '@/Models/Pagination';
import { Link } from '@inertiajs/inertia-vue3';
import { Inertia } from '@inertiajs/inertia';
import { throttle } from 'lodash';

let props = defineProps({
    games: Object,
    filters: Object,
    current_url: String,
});

let filters = reactive({ ...props.filters });
let currentUrl = window.location.toString();
let pagination = reactive(new Pagination(props.games));

watch(
    () => filters,
    throttle(() => {
        Inertia.get(currentUrl, { filter_by_asset: filters.filter_by_asset, q: filters.q }, { preserveState: true });
    }, 1000),
    {
        deep: true,
    }
);
</script>
<template>
    <div>
        <div class="flex flex-row justify-between">
            <h2 class="mb-6 font-grota text-2xl font-extrabold uppercase text-wgh-gray-6">Games</h2>
            <div class="filters">
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
                                                        sort_by: 'game_name',
                                                        sort_order: filters.sort_order === 'desc' ? 'asc' : 'desc',
                                                        q :filters.q
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
                                                        sort_by: 'game_status',
                                                        sort_order: filters.sort_order === 'desc' ? 'asc' : 'desc',
                                                        q :filters.q
                                                    }"
                                                >
                                                    Status
                                                    <span
                                                        :class="{
                                                            'invisible ml-2 flex-none rounded text-gray-400 group-hover:visible group-focus:visible':
                                                                filters.sort_by !== 'game_status',
                                                            'ml-2 flex-none rounded bg-gray-200 text-gray-900 group-hover:bg-gray-300':
                                                                filters.sort_by === 'game_status',
                                                            'rotate-180':
                                                                filters.sort_by === 'game_status' &&
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
                                                        sort_by: 'game_lobbies_count',
                                                        sort_order: filters.sort_order === 'desc' ? 'asc' : 'desc',
                                                        q :filters.q
                                                    }"
                                                >
                                                    Lobbies
                                                    <span
                                                        :class="{
                                                            'invisible ml-2 flex-none rounded text-gray-400 group-hover:visible group-focus:visible':
                                                                filters.sort_by !== 'game_lobbies_count',
                                                            'ml-2 flex-none rounded bg-gray-200 text-gray-900 group-hover:bg-gray-300':
                                                                filters.sort_by === 'game_lobbies_count',
                                                            'rotate-180':
                                                                filters.sort_by === 'game_lobbies_count' &&
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
                                                <span class="group inline-flex">Controles</span>
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody class="divide-y divide-gray-200 bg-white">
                                        <tr v-for="game in games.data" :key="game.id">
                                            <td
                                                class="whitespace-nowrap py-4 pl-4 pr-3 text-sm font-medium text-gray-900 sm:pl-6"
                                            >
                                                {{ game.name }}
                                            </td>
                                            <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">
                                                {{ game.status_readable }}
                                            </td>
                                            <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">
                                                {{ game.game_lobbies_count }}
                                            </td>
                                            <td class=" whitespace-nowrap px-3 py-4 text-sm text-gray-500">
                                                <div class="flex ">
                                                    <Link :href="route('admin-game-templates',game.id)" class="mr-4">
                                                        <ButtonShape type="red">
                                                            <span class="flex flex-row space-x-2.5">
                                                                <span class="font-bold uppercase">Show Templates</span>
                                                            </span>
                                                        </ButtonShape>
                                                    </Link>
                                                    <Link :href="route('admin-game-lobbies',game.id)">
                                                        <ButtonShape type="purple">
                                                            <span class="flex flex-row space-x-2.5">
                                                                <span class="font-bold uppercase">Show Lobbies</span>
                                                            </span>
                                                        </ButtonShape>
                                                    </Link>
                                                </div>
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

