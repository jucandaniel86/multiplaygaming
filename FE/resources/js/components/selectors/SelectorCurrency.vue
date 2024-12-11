<template>
  <v-select
    v-model="model"
    :item-title="'label'"
    :item-value="'id'"
    :items="currency"
    :hide-details="true"
  >
  </v-select>
</template>

<script setup>
import useSelectors from "../../composables/selectors";
import {ref, onMounted, watch} from "vue";

// const {volatility, volatilityLoading, getVolatility} = useSelectors();
const model = ref('GBP');

// onMounted(getVolatility);

const currency = ref([
  {id: 'GBP', label: 'GBP'},
  {id: 'USD', label: 'USD'},
  {id: 'EUR', label: 'EUR'},
  {id: 'RON', label: 'RON'},
])

</script>

<style scoped>

</style>
