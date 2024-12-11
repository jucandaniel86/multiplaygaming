<template>
  <v-overlay
    v-model="loaders.single_game"
    :opacity="1"
    class="align-center justify-center"
  >
    <div class="d-flex justify-center align-center w-100 h-100">
      <v-progress-circular
        color="primary"
        indeterminate
        size="x-large"
      ></v-progress-circular>
    </div>
  </v-overlay>

  <v-row v-if="!loaders.single_game && single_game">
    <v-col cols="12" md="9">
      <!-- DEMO PLAY -->
      <div class="d-flex justify-center align-center" style="position:relative">
        <v-overlay color="white" opacity=".5"/>
        <iframe
          v-if="single_game.demo_url"
          class="game-demo__iframe"
          :src="single_game.demo_url"
          @load="load"
        ></iframe>
      </div>
      <!-- /DEMO PLAY -->

      <!-- PLAY OPTIONS -->
      <v-row align="center" justify="center">
        <v-col cols="4" md="3">
          <div class="d-flex ga-2 align-center justify-center">
            <span class="font-weight-bold">Currency:</span>
            <SelectorCurrency v-model="demo.currency"/>
          </div>
        </v-col>
        <v-col cols="4" md="3">
          <div class="d-flex ga-2 align-center justify-center">
            <span class="font-weight-bold">Language:</span>
            <SelectorLanguages v-model="demo.language"/>
          </div>
        </v-col>
        <v-col cols="4" md="3">
          <v-btn color="primary" @click="reloadDemo">Reload demo</v-btn>
        </v-col>
      </v-row>
      <!-- /PLAY OPTIONS -->

      <!-- GAME TITLE -->
      <h1 class="text-h5 mt-4 mb-0">{{ single_game.game_name }}</h1>
      <span v-if="validObjectProp(single_game, 'details.game_string_id')" class="text-13 mb-4 text-color-grey">
        {{ single_game.details.game_string_id }}
      </span>

      <div class="game__description" v-html="single_game.description"></div>

      <h1 class="text-h5 mt-4 mb-1" v-if="single_game.trailer_url">Videos</h1>
      <v-row align="center" justify="start">
        <v-col cols="auto">
          <div v-html="single_game.trailer_url"/>
        </v-col>
      </v-row>

      <div v-if="assets.length" class="text-center w-100">
        <h3 class="text-h5 mt-4 mb-1">Marketing assets</h3>
        <v-btn class="mb-8" @click="downloadZip()">
          <v-icon>mdi-download</v-icon>
          Download Complete Pack
        </v-btn>
        <v-row>
          <v-col v-for="(download, i) in assets" :key="`Assets${i}`" cols="12" md="3">
            <span>Size: {{ formatSize(download.width) }}px X {{ formatSize(download.height) }}px</span>
            <v-img v-if="download.download_url" :src="download.download_url" width="auto" class="ma-1">
            </v-img>
          </v-col>
        </v-row>
      </div>

    </v-col>
    <v-col cols="12" md="3">
      <!--      <div class="d-flex justify-space-between align-center mb-4">-->
      <!--        <span class="font-weight-bold">Mini Mode</span>-->
      <!--        <v-btn color="primary" size="small">Launch</v-btn>-->
      <!--      </div>-->

      <v-table class="custom-table pa-0-table" style="--v-table-row-height: 24px;">
        <tbody>
        <tr>
          <td class="pl-0">
            <span class="font-weight-bold">Release Date</span>
          </td>
          <td>{{ validDate(single_game.release_date) ? formatDate(single_game.release_date) : '-' }}</td>
        </tr>
        <tr v-if="validObjectProp(single_game,'details.game_symbols')">
          <td class="pl-0">
            <span class="font-weight-bold">Game Symbol</span>
          </td>
          <td>{{ single_game.details.game_symbols }}</td>
        </tr>
        <tr v-if="validObjectProp(single_game,'game_id')">
          <td class="pl-0">
            <span class="font-weight-bold">Numeric ID</span>
          </td>
          <td>{{ single_game.game_id }}</td>
        </tr>
        <tr v-if="validObjectProp(single_game,'details.bet_per_lines') && single_game.details.bet_per_lines">
          <td class="pl-0">
            <span class="font-weight-bold">Minimum Bet per Line</span>
          </td>
          <td>{{ single_game.details.bet_per_lines }}</td>
        </tr>
        <tr v-if="validObjectProp(single_game, 'details.max_total_bet') && single_game.details.max_total_bet">
          <td class="pl-0">
            <span class="font-weight-bold">Maximum Total Bet</span>
          </td>
          <td>{{ single_game.details.max_total_bet }}</td>
        </tr>
        <tr v-if="validObjectProp(single_game, 'details.max_total_bet_ante') && single_game.details.max_total_bet_ante">
          <td class="pl-0">
            <span class="font-weight-bold">Maximum Total Bet with Ante</span>
          </td>
          <td>{{ single_game.details.max_total_bet_ante }}</td>
        </tr>
        <tr v-if="validObjectProp(single_game, 'details.reels') && single_game.details.reels">
          <td class="pl-0">
            <span class="font-weight-bold">Reels</span>
          </td>
          <td>{{ single_game.details.reels }}</td>
        </tr>
        <tr v-if="validObjectProp(single_game, 'details.rows') && single_game.details.rows">
          <td class="pl-0">
            <span class="font-weight-bold">Rows</span>
          </td>
          <td>{{ single_game.details.rows }}</td>
        </tr>
        <tr v-if="validObjectProp(single_game, 'lines') && single_game.lines">
          <td class="pl-0">
            <span class="font-weight-bold">Lines</span>
          </td>
          <td>{{ single_game.lines }}</td>
        </tr>
        <tr v-if="validObjectProp(single_game, 'details.bet_multiplier') && single_game.details.bet_multiplier">
          <td class="pl-0">
            <span class="font-weight-bold">Bet Multiplier</span>
          </td>
          <td>{{ single_game.details.bet_multiplier }}</td>
        </tr>
        <tr v-if="validObjectProp(single_game, 'max_multiplier') && single_game.max_multiplier">
          <td class="pl-0">
            <span class="font-weight-bold">Max Multiplier Win</span>
          </td>
          <td>{{ single_game.max_multiplier }}</td>
        </tr>
        <tr v-if="validObjectProp(single_game, 'details.rtps')">
          <td class="pl-0" colspan="2">
            <span class="font-weight-bold">RTPs</span>
          </td>
        </tr>
        <tr v-if="validObjectProp(single_game, 'details.rtps')">
          <td class="pl-0">
            <ul class="game-options__list">
              <li
                v-for="(rtp,i) in extractArrayJSON(single_game.details.rtps)" :key="`RTP${i}`">{{ rtp }}
              </li>
            </ul>
          </td>
        </tr>
        <tr v-if="validObjectProp(single_game, 'details.hit_frequency')">
          <td class="pl-0" colspan="2">
            <span class="font-weight-bold">Hit Frequency</span>
          </td>
        </tr>
        <tr v-if="validObjectProp(single_game, 'details.hit_frequency')">
          <td class="pl-0" colspan="2">
            <ul class="game-options__list">
              <li
                v-for="(hit,i) in extractArrayJSON(single_game.details.hit_frequency)" :key="`HIT${i}`">{{ hit }}
              </li>
            </ul>
          </td>
        </tr>
        <tr v-if="validObjectProp(single_game, 'volatility')">
          <td class="pl-0">
            <span class="font-weight-bold">Volatility</span>
          </td>
          <td>{{
              single_game.volatility === "na" ? "N/A" :
                capitalize(single_game.volatility)
            }}
          </td>
        </tr>
        <tr v-if="validObjectProp(single_game, 'details.devices')">
          <td class="pl-0">
            <span class="font-weight-bold">Available On</span>
          </td>
          <td>
            <div class="d-flex justify-center align-center w-100 ga-2">
              <v-icon
                v-if="extractArrayJSON(single_game.details.devices).indexOf('desktop') !== -1"
                :icon="mdiMonitor"
                color="primary"/>
              <v-icon
                v-if="extractArrayJSON(single_game.details.devices).indexOf('tablet') !== -1"
                :icon="mdiTablet"
                color="primary"/>
              <v-icon
                v-if="extractArrayJSON(single_game.details.devices).indexOf('mobile') !== -1"
                :icon="mdiCellphone"
                color="primary"/>
            </div>
          </td>
        </tr>
        <tr v-if="validObjectProp(single_game, 'details.has_replay')">
          <td class="pl-0">
            <span class="font-weight-bold">Has Replay</span>
          </td>
          <td>{{ single_game.details.has_replay ? 'YES' : 'NO' }}</td>
        </tr>
        <tr v-if="validObjectProp(single_game, 'details.has_buy_spins')">
          <td class="pl-0">
            <span class="font-weight-bold">Has Buy Spins</span>
          </td>
          <td>{{ single_game.details.has_buy_spins ? 'YES' : 'NO' }}</td>
        </tr>
        <tr v-if="validObjectProp(single_game, 'details.has_ante_bet')">
          <td class="pl-0">
            <span class="font-weight-bold">Has Ante Bet</span>
          </td>
          <td>{{ single_game.details.has_ante_bet ? 'YES' : 'NO' }}</td>
        </tr>
        </tbody>
      </v-table>

      <div v-if="single_game.downloads && single_game.downloads.length">
        <h3 class="text-18">Downloads</h3>
        <v-list class="mb-4" bg-color="white">
          <v-list-item
            v-for="(download, i) in single_game.downloads"
            :key="`Downloads${i}`"
            :title="download.name"
            class="pa-0 mb-1 text-8"
            v-show="!download.is_certificate && download.download_type !== 'ASSET' "
          >
            <template v-slot:append>
              <v-btn
                color="primary"
                size="small"
                @click.prevent="downloadFile(download.download_url)"
              >Download
              </v-btn>
            </template>
          </v-list-item>
        </v-list>
      </div>

      <h3 class="text-18 mt-2">Certificates</h3>
      <div class="d-flex align-center justify-space-between ga-2 pb-12">
        <SelectorJurisdiction :game_id="single_game.id" :type="'downloads'" v-model="jurisdiction"/>
        <v-btn
          color="primary"
          size="small"
          :disabled="!jurisdiction"
          @click="downloadCertificate"
        >Download
        </v-btn>
      </div>
      <div class="h-25 d-flex w-100"></div>
    </v-col>
  </v-row>
</template>

<script setup>
import moment from 'moment';
import {onMounted, ref, shallowRef, watch, reactive, computed} from 'vue';
import {useRoute} from 'vue-router';


import useGames from "../../composables/games";
import {useMainStore} from "../../stores/main";
import SelectorCurrency from "../../components/selectors/SelectorCurrency";
import SelectorLanguages from "../../components/selectors/SelectorLanguages";

import {mdiMonitor, mdiTablet, mdiCellphone} from '@mdi/js';
import SelectorJurisdiction from "../../components/selectors/SelectorJurisdiction";
import useHelper from "../../composables/helper";

const downloads = ref([
  {name: 'Drops & Wins Logo pack'},
  {name: 'Drops & Wins Promotional banners'},
  {name: 'Terms & Conditions'}
]);

const demo = reactive({
  currency: 'USD',
  language: 'en',
})

const route = useRoute();

const {getSingleGame, loaders, single_game} = useGames();
const {validObjectProp, extractArrayJSON} = useHelper();

const iframeLoader = ref(true);

watch(single_game, () => {
  if (single_game) {
    const breadcrumbs = shallowRef([
      {
        title: 'Client Area',
        disabled: false,
        to: {name: 'ca.index'}
      },
      {
        title: 'Game Library',
        disabled: false,
        to: {name: 'ca.slots.games'}
      },
      {
        title: single_game.value.game_name,
        disabled: true,
        href: '#'
      }
    ]);
    const mainStore = useMainStore();
    mainStore.SET_BREADCRUMBS(breadcrumbs);
  }
});

const validDate = (_date) => !isNaN(new Date(_date).getTime());
const formatDate = (_date) => moment(_date).format("Mo MMM YYYY");
const capitalize = s => s && s[0].toUpperCase() + s.slice(1)

const jurisdiction = ref('');

const downloadCertificate = () => {
  window.open(jurisdiction.value, '_blank');
}

const downloadFile = (_url) => {
  window.open(_url, '_blank');
}

const downloadZip = () => {
  downloadFile('https://bluejackgaming.com/uploads/assets/' + single_game.value.id + '/assets_download.zip')
}

const reloadDemo = () => {

  const url = new URL(single_game.value.demo_url);

  Object.keys(demo).forEach(key => {
    if (demo[key]) {
      url.searchParams.set(key, demo[key]);
    }
  });

  single_game.value.demo_url = url.toString();
}

const load = () => {
  iframeLoader.value = false;
}

const assets = computed(() => {
  if (single_game.value.downloads) {
    return single_game.value.downloads.filter(el => el.download_type === 'ASSET')
  }
  return [];
});

const formatSize = (size) => Number(size).toFixed(0);

onMounted(() => getSingleGame(route.params.slug))

</script>
<style scoped>
@import "./game_page.css";
</style>