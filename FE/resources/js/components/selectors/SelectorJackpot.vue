<template>
  <v-select
    v-model="model"
    :item-title="'label'"
    :item-value="'id'"
    :items="[
      { 'id': -1, 'label': 'ALL' },
      { 'id': 0, 'label': 'NO' },
      { 'id': 1, 'label': 'YES' },
    ]"
    :hide-details="true"
    label="Jackpot"
  >
  </v-select>
</template>

<script setup>
import {ref, onMounted} from "vue";

const model = ref('');
</script>
