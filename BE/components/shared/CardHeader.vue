<script>
export default {
  props: {
    title: String,
    required: false,
    default: "",
  },
};
</script>

<template>
  <!-- -------------------------------------------------------------------- -->
  <!-- Card with Header & Footer -->
  <!-- -------------------------------------------------------------------- -->
  <v-card elevation="0" rounded="sm" outlined class="mb-2 pa-2">
    <v-card-title v-if="title" style="flex-direction: column">
      <div class="d-flex flex-column justify-space-between align-center w-100">
        <v-card-title class="text-h6 pa-0">{{ title }}</v-card-title>
        <slot name="header" />
      </div>
    </v-card-title>
    <v-divider></v-divider>
    <v-card-text class="pa-0">
      <slot name="content" />
    </v-card-text>
    <v-card-actions class="pa-0">
      <slot name="footer" />
    </v-card-actions>
  </v-card>
</template>
