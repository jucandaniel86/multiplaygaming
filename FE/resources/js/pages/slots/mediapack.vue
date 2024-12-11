<script setup>
import {computed, onMounted, ref, shallowRef, watch} from 'vue';

import {useMainStore} from "../../stores/main";
import SelectorGamesAutocomplete from "../../components/selectors/SelectorGamesAutocomplete";
import useSelectors from "../../composables/selectors";

import {mdiDownload} from '@mdi/js';

const {getGames, games, gamesLoading} = useSelectors();

const page = ref({title: 'Media Pack'});
const breadcrumbs = shallowRef([
  {
    title: 'Client Area',
    disabled: false,
    to: {name: 'ca.index'}
  },
  {
    title: 'Slots',
    disabled: true,
    href: '#'
  },
  {
    title: 'Media Pack',
    disabled: true,
    href: '#'
  }
]);
const mainStore = useMainStore();
mainStore.SET_BREADCRUMBS(breadcrumbs);

const game_id = ref(null);

onMounted(() => {
  getGames('media-pack');
});


const activeGames = computed(() => {

  if (!game_id.value) return games.value;
  return games.value.filter(game => game.id === game_id.value)
}, game_id)

const goToDownload = (link) => window.open(link, '_blank');

</script>
<template>
  <v-row>
    <v-col cols="12">
      <SelectorGamesAutocomplete :type="'media-pack'" v-model="game_id"/>
    </v-col>
  </v-row>
  <v-progress-linear indeterminate v-if="gamesLoading" color="primary"/>
  <v-row>
    <v-col cols="12">
      <v-table class="custom-table">
        <tbody>
        <tr v-for="(game, i) in activeGames" :key="i">
          <td style="width: 80%;">
            <v-btn icon color="primary" class="mr-2">
              <v-icon
                :icon="mdiDownload"
                color="white"
                size="large"
              >
              </v-icon>
            </v-btn>
            <b>{{ game.label }}</b>
          </td>

          <td style="width: 20%">
            <v-btn color="primary" @click="goToDownload(game.mediapack_url)">Download</v-btn>
          </td>
        </tr>
        </tbody>
      </v-table>
    </v-col>
  </v-row>
</template>
