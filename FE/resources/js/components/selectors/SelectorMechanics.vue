<template>
  <v-select
    v-model="model"
    :item-title="'label'"
    :item-value="'id'"
    :items="mechanics"
    :hide-details="true"
    label="Mechanics"
    :disabled="mechanicsLoader"
    clearable
  >
  </v-select>
</template>

<script setup>
import useSelectors from "../../composables/selectors";
import {ref, onMounted, watch} from "vue";

const {mechanics, mechanicsLoader, getMechanics} = useSelectors();
const model = ref('');

onMounted(getMechanics);

</script>

<style scoped>

</style>
