<template>
  <v-card elevation="4" class="game-card mb-2">
    <v-card-text>
      <v-row>
        <v-col cols="12" md="4">
          <div class="d-flex h-100 align-center">
            <v-img
              :max-height="150"
              :src="props.game.thumbnail_url || GameThumbnail"/>
          </div>
        </v-col>
        <v-col cols="12" md="8">
          <v-row>
            <v-col cols="12" md="12" class="pb-0">
              <h1 class="text-20">{{ props.game.game_name }}</h1>
            </v-col>
            <v-col cols="6" md="6">
              <v-table>
                <tbody>
                <tr v-if="validObjectProp(props.game, 'volatility')">
                  <td><b>Volatility</b></td>
                  <td>{{ props.game.volatility === 'na' ? 'N/A' : props.game.volatility }}</td>
                </tr>
                <tr v-if="validObjectProp(props.game, 'details.bet_per_lines')">
                  <td><b>Minimum bet per line</b></td>
                  <td>{{ props.game.details.bet_per_lines ? props.game.details.bet_per_lines : 'N/A' }}</td>
                </tr>
                <tr v-if="validObjectProp(props.game, 'max_multiplier')">
                  <td><b>Max multiple win</b></td>
                  <td>{{ props.game.max_multiplier }}</td>
                </tr>
                <tr v-if="validObjectProp(props.game, 'details.bet_multiplier')">
                  <td><b>Bet Multiplier</b></td>
                  <td>{{ props.game.details.bet_multiplier ? props.game.details.bet_multiplier : 'N/A' }}</td>
                </tr>
                <tr v-if="validObjectProp(props.game, 'details.max_total_bet')">
                  <td><b>Maximum total bet</b></td>
                  <td>{{ props.game.details.max_total_bet ? props.game.details.max_total_bet : 'N/A' }}</td>
                </tr>
                <tr v-if="validObjectProp(props.game, 'details.max_total_bet')">
                  <td><b>Maximum Total with Ante</b></td>
                  <td>{{ props.game.details.max_total_bet_ante ? props.game.details.max_total_bet_ante : 'N/A' }}</td>
                </tr>
                <tr v-if="validObjectProp(props.game, 'details.max_exposure')">
                  <td><b>Max exposure</b></td>
                  <td>{{ props.game.details.max_exposure ? props.game.details.max_exposure : 'N/A' }}</td>
                </tr>
                <tr v-if="validObjectProp(props.game, 'details.total_bet')">
                  <td><b>Total bet</b></td>
                  <td>{{ props.game.details.total_bet ? props.game.details.total_bet : 'N/A' }}</td>
                </tr>
                </tbody>
              </v-table>
            </v-col>
            <v-col cols="6" md="6">
              <v-table>
                <tbody>
                <tr>
                  <td><b>Release date</b></td>
                  <td>{{ props.game.release_date }}</td>
                </tr>
                <tr v-if="validObjectProp(props.game, 'details.game_symbols')">
                  <td><b>Game symbol</b></td>
                  <td>{{ props.game.details.game_symbols ? props.game.details.game_symbols : 'N/A' }}</td>
                </tr>
                <tr>
                  <td><b>RTP</b></td>
                  <td>{{ props.game.rtp ? props.game.rtp : 'N/A' }}%</td>
                </tr>
                <tr>
                  <td><b>Numeric ID</b></td>
                  <td>{{ props.game.game_id ? props.game.game_id : 'N/A' }}</td>
                </tr>
                <tr>
                  <td><b>Lines</b></td>
                  <td>{{ props.game.lines ? props.game.lines : 'N/A' }}</td>
                </tr>
                <tr v-if="validObjectProp(props.game, 'details.has_replay')">
                  <td><b>Has Replay</b></td>
                  <td>{{ props.game.details.has_replay ? 'YES' : 'NO' }}</td>
                </tr>
                <tr v-if="validObjectProp(props.game, 'details.has_free_spins')">
                  <td><b>Has Free Spins</b></td>
                  <td>{{ props.game.details.has_free_spins ? 'YES' : 'NO' }}</td>
                </tr>
                <tr v-if="validObjectProp(props.game, 'details.has_instant_bonus')">
                  <td><b>Has Instant Bonus</b></td>
                  <td>{{ props.game.details.has_instant_bonus ? 'YES' : 'NO' }}</td>
                </tr>
                </tbody>
              </v-table>
            </v-col>
          </v-row>
        </v-col>
      </v-row>
      <v-row>
        <v-col cols="12">
          <div class="d-flex justify-end ga-2">
            <v-btn
              color="white"
              flat
              class="outlined"
              size="small"
              @click.prevent="seeDemo"
            >Play demo game
            </v-btn>
            <v-btn
              color="white"
              flat class="outlined hidden-sm-and-down"
              size="small">Game overview
            </v-btn>
            <v-btn
              color="primary"
              @click="seeMore"
              size="small">See more
            </v-btn>
          </div>
        </v-col>
      </v-row>
    </v-card-text>
  </v-card>
</template>

<script setup>
import {defineProps} from "vue";
import {useRouter} from "vue-router";
import GameThumbnail from './game-thumbnail.png';
import useHelper from "../../composables/helper";

const {validObjectProp} = useHelper();

const router = useRouter();
const props = defineProps({
  game: {
    required: true,
    type: Object
  }
})
const seeMore = () => {
  router.push({
    name: 'ca.slots.game_page',
    params: {slug: props.game.slug}
  })
}

const seeDemo = () => {
  if (!props.game.demo_url) return;
  window.open(props.game.demo_url, '_blank');
}
</script>

<style scoped>
.game-card .v-table {
  background: transparent;
}

.game-card .v-table > .v-table__wrapper > table > tbody > tr > td, .v-table > .v-table__wrapper > table > thead > tr > td, .v-table > .v-table__wrapper > table > tfoot > tr > td {
  height: auto;
  color: #000;
}

.outlined {
  border: 1px solid rgb(var(--v-theme-primary)) !important;
}

.outlined:hover {
  background: rgb(var(--v-theme-primary)) !important;
  color: #fff !important;
}

.game-card .text-20 {
  color: #000;
}

.game-card:hover {
  box-shadow: 0px 2px 4px -1px var(--v-shadow-key-umbra-opacity, rgba(var(--v-theme-primary), 0.2)),
  0px 4px 5px 0px var(--v-shadow-key-penumbra-opacity, rgba(var(--v-theme-primary), 0.14)),
  0px 1px 10px 0px var(--v-shadow-key-ambient-opacity, rgba(var(--v-theme-primary), 0.12)) !important;
}
</style>
