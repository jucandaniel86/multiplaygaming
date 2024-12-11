<template>
  <v-card elevation="3" class="mb-3 ml-2" :style="`max-width: ${maxWidth}`">
    <v-card-text>
      <v-img
        class="mb-4"
        :max-height="150"
        :src="props.game.thumbnail_url || GameThumbnail"/>
      <span class="text-black">
        {{ props.game.release_date ? formatDate(props.game.release_date) : 'Coming Soon' }}
      </span>
      <h3 class="text-h6 text-black mt-0 mb-6">{{ props.game.game_name }}</h3>

      <v-btn
        color="primary"
        flat
        class="outlined"
        size="small"
        @click.prevent="seeDemo"
      >Play demo game
      </v-btn>
    </v-card-text>
  </v-card>
</template>

<script setup>
import GameThumbnail from './game-thumbnail.png';
import {computed, defineProps} from "vue";
import moment from 'moment';
import {useDisplay} from "vuetify";

const props = defineProps({
  game: {
    type: Object,
    required: true,
  }
});
const seeDemo = () => {
  if (!props.game.demo_url) return;
  window.open(props.game.demo_url, '_blank');
}
const formatDate = (_date) => moment(_date).format("Mo MMM YYYY");

const {mobile} = useDisplay();
const maxWidth = computed(() => {
  if (mobile.value) {
    return '100%';
  }
  return '250px'
}, mobile)
</script>
