<script setup>
let props = defineProps({
  config: Object
})
</script>
<template>
  <div id="wrapper" class="bg-[#F6F6F7] w-full" :style="{
    backgroundImage: `url(${props.config.main_pattern})`,
    backgroundRepeat: `repeat`,
    backgroundPosition: `center`,
  }">
    <slot/>
  </div>
</template>
