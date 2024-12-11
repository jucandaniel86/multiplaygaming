<template>
  <v-select
    v-model="model"
    :item-title="'label'"
    :item-value="'id'"
    :items="rtp"
    :hide-details="true"
    label="RTP"
    :disabled="rtpLoading"
    color="primary"
    clearable
  >
  </v-select>
</template>

<script setup>
import useSelectors from "../../composables/selectors";
import {ref, onMounted, watch} from "vue";

const {rtp, rtpLoading, getRTP} = useSelectors();
const model = ref('');

onMounted(getRTP);

</script>

<style scoped>

</style>
