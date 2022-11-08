<script setup>
import {Link} from "@inertiajs/inertia-vue3";

</script>
<template>
    <Link class="text-wgh-gray-6 font-bold text-base font-grota hover:text-wgh-red-2 hover:font-extrabold transition-all duration-150 space-x-2 flex flex-row items-center cursor-pointer">
      <slot />
    </Link>
</template>
