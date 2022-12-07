<script setup>
import { defineProps } from 'vue';

let props = defineProps({
    item: Object
});
</script>
<template>
<a class="inline-flex cursor-pointer">
    <div class="border border-orange-200 ml-5 mr-4">
        <img :src="item.image_url" :alt="`${item.image_url} art`"
            class="h-5 w-5 object-cover md:h-11 md:w-11"
        />
    </div>
    <div>
        <div class="truncate w-96 text-md">{{item.name}}</div>
        <div class="truncate w-96 text-md">{{item.description}}</div>
    </div>
</a>
</template>
