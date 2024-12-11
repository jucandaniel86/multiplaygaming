<template>
  <v-select
    v-model="model"
    :item-title="'label'"
    :item-value="'id'"
    :items="options"
    :hide-details="true"
    label="Sort"
    :disabled="volatilityLoading"
    color="primary"
  >
  </v-select>
</template>

<script setup>
import {ref} from "vue";

const model = ref('');
const options = ref([
  {
    id: 'date_recent', label: 'Release Date',
  },
  {
    id: 'az', label: 'A-Z'
  }
])
</script>

<style scoped>

</style>
