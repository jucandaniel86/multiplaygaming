<template>
  <v-select
    v-model="model"
    :item-title="'label'"
    :item-value="'id'"
    :items="jurisdictions"
    :hide-details="true"
    label="Jurisdiction"
    clearable
  >
  </v-select>
</template>

<script setup>
import useSelectors from "../../composables/selectors";
import {ref, onMounted, defineProps, watch} from "vue";

const props = defineProps({
  type: {
    required: false,
    default: '',
    type: String,
  },
  game_id: {
    required: false,
    default: 0,
    type: Number,
  }
});

const {jurisdictions, jurisdictionLoader, getJurisdictions} = useSelectors();
const model = ref('');

onMounted(() => {
  getJurisdictions(props);
});

watch((jurisdictions) => {
  console.log('JJJ', jurisdictions)
})
</script>

<style scoped>

</style>
