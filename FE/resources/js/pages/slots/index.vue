<script setup>
import {ref, shallowRef, onMounted, reactive, watch} from 'vue';
import {useRouter} from "vue-router";
import {mdiArrowRightThin, mdiArrowLeftThin} from '@mdi/js';
import useGames from '../../composables/games';
import useSelectors from "../../composables/selectors";

import {useMainStore} from "../../stores/main";
import SelectorVolatility from '../../components/selectors/SelectorVolatility';
import SelectorRtp from "../../components/selectors/SelectorRtp";
import GameCard from "../../components/cards/GameCard";
import SelectorJackpot from "../../components/selectors/SelectorJackpot";
import SelectorMechanics from "../../components/selectors/SelectorMechanics";
import SelectorSort from "../../components/selectors/SelectorSort";
import SelectorJurisdiction from "../../components/selectors/SelectorJurisdiction";

const router = useRouter();
const page = ref(1);
const {games, loaders, getGames, totalGames} = useGames();
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
    title: 'Game Library',
    disabled: true,
    href: '#'
  }
]);
const loading = ref(false);
const mainStore = useMainStore();
mainStore.SET_BREADCRUMBS(breadcrumbs);

const {rangeSliders, rangeSlidersLoader, getRangeSliders} = useSelectors();

const filters = reactive({
  'search': '',
  'sort_by': 'date_recent',
  'certified_countries': '',
  'has_jackpot': -1,
  'volatility': '',
  'rtp': '',
  'mechanics': '',
  'has_free_spins': -1,
  'show_upcoming': 0,
  'has_instant_bonus': -1,
  'max_multiplier_win': '',
  'min_bet': '',
});

onMounted(async () => {
  loading.value = true;
  await getGames();
  await getRangeSliders();
  loading.value = false;
});

watch(filters, () => {
  getGames(filters);
});

</script>
<template>
  <v-row>
    <v-col cols="12">
      <v-data-iterator
        :items="games"
        :page="page"
        :loading="loaders.games"
        :items-per-page="10"
        :items-length="totalGames"
      >
        <template v-slot:loader>
          <v-progress-linear indeterminate color="primary"/>
          <v-row>
            <v-col
              v-for="(_, k) in [0, 1, 2, 3]"
              :key="k"
              cols="12"
              sm="12"
              xl="12"
            >
              <v-skeleton-loader
                color="white"
                type="image, article"
              ></v-skeleton-loader>
            </v-col>
          </v-row>
        </template>

        <template v-slot:header>
          <v-row>
            <v-col cols="12" md="12">
              <div class="games-filters">
                <v-row>
                  <v-col cols="4">
                    <v-text-field label="Search" hide-details v-model="filters.search"/>
                  </v-col>
                  <v-col cols="4">
                    <SelectorSort v-model="filters.sort_by"/>
                  </v-col>
                  <v-col cols="4">
                    <SelectorJurisdiction v-model="filters.certified_countries"/>
                  </v-col>
                </v-row>
                <v-row>
                  <v-col cols="6" md="3">
                    <SelectorJackpot v-model="filters.has_jackpot"/>
                  </v-col>
                  <v-col cols="6" md="3">
                    <SelectorVolatility v-model="filters.volatility"/>
                  </v-col>
                  <v-col cols="6" md="3">
                    <SelectorRtp v-model="filters.rtp"/>
                  </v-col>
                  <v-col cols="6" md="3">
                    <SelectorMechanics v-model="filters.mechanics"/>
                  </v-col>
                </v-row>
                <v-row>
                  <v-col cols="4" md="2">
                    <v-switch
                      label="Show upcoming"
                      v-model="filters.show_upcoming"
                      :true-value="1"
                      :false-value="0"
                      color="primary"
                      hide-details></v-switch>
                  </v-col>
                  <v-col cols="4" md="2">
                    <v-switch
                      label="Free spins"
                      v-model="filters.has_free_spins"
                      :true-value="1"
                      :false-value="0"
                      color="primary"
                      hide-details></v-switch>
                  </v-col>
                  <v-col cols="4" md="2">
                    <v-switch
                      label="Instant bonus"
                      v-model="filters.has_instant_bonus"
                      :true-value="1"
                      :false-value="0"
                      color="primary"
                      hide-details></v-switch>
                  </v-col>
                  <v-col cols="6" md="3" v-if="!loading">
                    <div class="d-flex h-100 align-center">
                      <v-range-slider
                        label="Min bet"
                        hide-details
                        :max="rangeSliders ? rangeSliders.min_total_bet : 100"
                        :min="0"
                        @end="(val) => filters.min_bet = val"
                        thumb-label="always"
                        show-ticks
                        color="primary"></v-range-slider>
                    </div>
                  </v-col>
                  <v-col cols="6" md="3" v-if="!loading">
                    <div class="d-flex h-100 align-center">
                      <v-range-slider
                        label="Max multiplier win"
                        hide-details
                        color="primary"
                        :min="0"
                        :max="rangeSliders ? rangeSliders.max_multiplier : 100"
                        @end="(val) => filters.max_multiplier_win = val"
                        thumb-label="always"
                        show-ticks
                      ></v-range-slider>
                    </div>
                  </v-col>
                </v-row>
              </div>
            </v-col>
          </v-row>
        </template>
        <template v-slot:default="{ items }">
          <template
            v-for="(item, i) in items"
            :key="i"
          >
            <GameCard :game="item.raw"/>
          </template>
        </template>
        <template v-slot:footer="{ page, pageCount, prevPage, nextPage }">
          <v-alert
            border="top"
            type="warning"
            variant="outlined"
            prominent
            class="mt-3"
            v-if="totalGames === 0"
          >
            No results
          </v-alert>
          <v-footer
            class="justify-space-between text-body-2 mt-4"
            color="white"
            v-if="!loaders.games && pageCount > 1"
          >
            <v-btn
              :disabled="page === 1"
              density="comfortable"
              color="primary"
              rounded
              @click="prevPage"
            >
              <v-icon :icon="mdiArrowLeftThin" color="white"/>
            </v-btn>
            <div>
              Page {{ page }} of {{ pageCount }}
            </div>
            <v-btn
              :disabled="page >= pageCount"
              density="comfortable"
              rounded
              @click="nextPage"
              color="primary"
            >
              <v-icon :icon="mdiArrowRightThin" color="white"/>
            </v-btn>
          </v-footer>
        </template>
      </v-data-iterator>
    </v-col>
  </v-row>


</template>
<style>
.custom-range .v-slider-thumb {
  color: rgb(var(--v-theme-primary));
}

.custom-range .v-slider-track__fill {
  background: rgb(var(--v-theme-primary));
}
</style>
