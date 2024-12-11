<template>
  <div class="d-flex justify-space-between">
    <h1 class="text-20">{{ props.title }}</h1>
    <div v-if="$slots.action">
      <slot name="action"></slot>
    </div>
  </div>
</template>

<script setup>
const props = defineProps(
  {
    title: String,
  }
);

</script>

<style scoped>

</style>
