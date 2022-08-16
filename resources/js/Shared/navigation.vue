<script setup>
import Pagination from '@/Models/Pagination';
import { useCurrentUser } from '@/Composables/useCurrentUser';
import { reactive } from 'vue';
import { Link } from '@inertiajs/inertia-vue3';

let currentUser = useCurrentUser();
let pagination = reactive(new Pagination(currentUser.notifications));
console.log(pagination)
</script>

<template>
  <nav class="border-t border-gray-200 px-4 flex items-center justify-between sm:px-0">
    <div class="-mt-px w-0 flex-1 flex">
      <Link class="mt-4 px-6" :href="pagination.prev_page_url">
          <button v-if="pagination.prev_page_url" type="gray"> Previous</button>
      </Link>
    </div>
    <div class="-mt-px w-0 flex-1 flex justify-end">
      <Link class="mt-4 px-6" :href="pagination.next_page_url">
          <button v-if="pagination.next_page_url" type="gray"> Next</button>
      </Link>
      <a href="#" class="border-t-2 border-transparent pt-4 pl-1 inline-flex items-center text-sm font-medium text-gray-500 hover:text-gray-700 hover:border-gray-300">
      </a>
    </div>
  </nav>
</template>

