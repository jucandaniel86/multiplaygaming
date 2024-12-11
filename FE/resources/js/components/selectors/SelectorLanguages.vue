<template>
  <v-select
    v-model="model"
    :item-title="'label'"
    :item-value="'value'"
    :items="languages"
    :hide-details="true"
    :disabled="languagesLoading"
  >
  </v-select>
</template>

<script setup>
import useSelectors from "../../composables/selectors";
import {ref, onMounted, watch, defineEmits} from "vue";

const {languages, languagesLoading, getLanguages} = useSelectors();
const model = ref(null);
const emits = defineEmits(['input']);

onMounted(getLanguages);
</script>

<style scoped>

</style>
