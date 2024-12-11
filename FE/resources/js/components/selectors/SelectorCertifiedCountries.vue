<template>
  <v-select
    v-model="model"
    :item-title="'label'"
    :item-value="'id'"
    :items="volatility"
    :hide-details="true"
    label="Certified Countries"
    :disabled="volatilityLoading"
    color="primary"
  >
  </v-select>
</template>

<script setup>
import useSelectors from "../../composables/selectors";
import {ref, onMounted, watch} from "vue";

const {volatility, volatilityLoading, getVolatility} = useSelectors();
const model = ref('');

// onMounted(getVolatility);

</script>

<style scoped>

</style>
