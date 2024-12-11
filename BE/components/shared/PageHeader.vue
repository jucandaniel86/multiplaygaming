<template>
  <div class="d-flex align-items-center justify-content-between mb-4">
    <h6 class="mb-0">{{ title }}</h6>
    <slot name="content"></slot>
  </div>
</template>
<script>
export default {
  props: {
    title: {
      type: String,
      required: true,
    },
  },
};
</script>
