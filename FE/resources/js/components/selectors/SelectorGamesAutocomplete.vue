<template>
  <v-autocomplete
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
  </v-autocomplete>
</template>

<script setup>
import useSelectors from "../../composables/selectors";
import {ref, onMounted, defineProps, defineEmits} from "vue";

const emit = defineEmits('input');
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
