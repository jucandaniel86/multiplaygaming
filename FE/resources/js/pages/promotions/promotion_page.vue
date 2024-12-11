<template>
  <v-row>
    <v-col cols="9">
      <v-img
        rounded
        height="300"
        cover
        src="https://cdn.vuetifyjs.com/images/parallax/material.jpg"
        class="mb-3"
      >
        <template v-slot:default>
          <div class="d-flex align-end justify-start fill-height">
            <v-chip color="primary" flat text>Running</v-chip>
          </div>
        </template>
      </v-img>

      <h1 class="text-18">Drops & Wins Italy 2024-2025</h1>
      <div class="promotion_text">
        <p>
          Lorem ipsum dolor sit amet, consectetur adipiscing elit. Duis pulvinar, arcu ut maximus sagittis, mi quam
          tempus lacus, eu bibendum ligula turpis vel ex. Donec facilisis mauris id tortor commodo venenatis.
        </p>
        <p>
          Lorem ipsum dolor sit amet, consectetur adipiscing elit. Duis pulvinar, arcu ut maximus sagittis, mi quam
          tempus lacus, eu bibendum ligula turpis vel ex. Donec facilisis mauris id tortor commodo venenatis. C amet,
          consectetur adipiscing elit. Duis pulvinar, arcu ut maximus sagittis, mi quam
          tempus lacus, eu bibendum ligula turpis vel ex.
          amet, consectetur adipiscing elit. Duis pulvinar, arcu ut maximus sagittis, mi quam
          tempus lacus, eu bibendum ligula turpis vel ex.
        </p>
        <h2 class="text-13">Lorem ipsum dolor sit amet</h2>
        <ul>
          <li>Lorem ipsum dolor sit amet, consectetur adipiscing elit.</li>
          <li>Lorem ipsum dolor sit amet, consectetur adipiscing elit.</li>
          <li>Lorem ipsum dolor sit amet, consectetur adipiscing elit.</li>
        </ul>
        <p>
          Lorem ipsum dolor sit amet, consectetur adipiscing elit. Duis pulvinar, arcu ut maximus sagittis, mi quam
          tempus lacus, eu bibendum ligula turpis vel ex. Donec facilisis mauris id tortor commodo venenatis.
        </p>
      </div>
    </v-col>
    <v-col cols="3">
      <div class="promotion-time-left d-flex flex-column">
        <h3 class="text-18">Promotion Running</h3>
        <h2 class="text-13">Time left:</h2>
        <div class="d-flex time-left_component mb-4">
          <span>
            <span class="time-left-number">319</span>
            <span class="time-left-label">Days</span>
          </span>
          <span>
            <span class="time-left-number">08</span>
            <span class="time-left-label">Hours</span>
          </span>
          <span>
            <span class="time-left-number">33</span>
            <span class="time-left-label">Minutes</span>
          </span>
          <span>
            <span class="time-left-number">11</span>
            <span class="time-left-label">Seconds</span>
          </span>
        </div><!-- time-left_component -->
        <h3 class="text-18">Downloads</h3>
        <v-list class="mb-4" bg-color="white">
          <v-list-item
            v-for="(download, i) in downloads"
            :key="`Downloads${i}`"
            :title="download.name"
            class="pa-0 mb-1 text-8"
          >
            <template v-slot:append>
              <v-btn
                color="primary"
                size="small"
              >Download
              </v-btn>
            </template>
          </v-list-item>
        </v-list>
        <h3 class="text-18">Timeline</h3>

        <v-timeline side="end" align="start">
          <v-timeline-item
            v-for="item in items"
            :key="item.id"
            size="small"
            class="pa-0"
            density="compact"
            :color="item.color"
            :dot-color="item.color"
          >
            <div class="d-flex flex-column">
              <span class="text-16 color_theme">{{ item.title }}</span>
              <span class="text-12 text-color-grey">{{ item.subtitle }}</span>
            </div>
          </v-timeline-item>
        </v-timeline>
      </div>
    </v-col><!-- COLUMN RIGHT -->
  </v-row>
</template>

<script setup>
import {ref, shallowRef, computed} from 'vue';

import {useMainStore} from "../../stores/main";

const breadcrumbs = shallowRef([
  {
    title: 'Client Area',
    disabled: false,
    to: '/client-area'
  },
  {
    title: 'Promotions',
    disabled: false,
    href: '/client-area/promotions'
  },
  {
    title: 'Promotion page',
    disabled: true,
    href: '#'
  }
]);

const mainStore = useMainStore();
mainStore.SET_BREADCRUMBS(breadcrumbs);

const downloads = ref([
  {name: 'Drops & Wins Logo pack'},
  {name: 'Drops & Wins Promotional banners'},
  {name: 'Terms & Conditions'}
])

const items = ref([
  {
    id: 1,
    color: 'primary',
    icon: 'mdi-information',
    title: 'WEEKS 1-4 (from 24 june at 00:01 CET to  21st july 2024 at 23:59 CET)',
    subtitle: '24 June 2024 00:01'
  },
  {
    id: 2,
    color: 'primary',
    icon: 'mdi-alert-circle',
    title: 'WEEKS 5-8 (from 24 june at 00:01 CET to  21st july 2024 at 23:59 CET)',
    subtitle: '24 June 2024 00:01'
  },
  {
    id: 3,
    color: 'grey',
    icon: 'mdi-alert-circle',
    title: 'WEEKS 1-4 (from 24 june at 00:01 CET to  21st july 2024 at 23:59 CET)',
    subtitle: '24 June 2024 00:01'
  },
],)

</script>
<style scoped>
@import "./styles/promotion_page.css";
</style>
