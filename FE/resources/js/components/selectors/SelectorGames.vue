<template>
  <v-select
    v-model="model"
    :item-title="'label'"
    :item-value="'id'"
    :items="games"
    :hide-details="true"
    label="Game"
    :disabled="gamesLoading"
    color="primary"
    clearable
  >
  </v-select>
</template>

<script setup>
import useSelectors from "../../composables/selectors";
import {ref, onMounted, defineProps} from "vue";

const props = defineProps({
  type: {
    required: false,
    default: null,
    type: String,
  }
})
const {games, gamesLoading, getGames} = useSelectors();
const model = ref('');

onMounted(() => {
  getGames(props.type);
});

</script>

<style scoped>

</style>
