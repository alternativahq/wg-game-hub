<script setup>
</script>
<template>
    <div>
        <div v-if="$page.props.flash.success" class="my-4 py-4 px-4 text-white bg-green-700">
            {{ $page.props.flash.success }}
        </div>
        <div v-if="$page.props.flash.error" class="my-4 py-4 px-4 text-white bg-red-700">
            {{ $page.props.flash.error }}
        </div>
    </div>
</template>
