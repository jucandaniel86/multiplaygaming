<template>
  <v-flex xs6>
    <v-carousel
      height="420"
      hide-delimiter-background
      :show-arrows="false"
      color="primary"
    >
      <v-carousel-item
        v-for="(item,i) in items"
        :key="i"
        height="380"
      >
        <v-img
          :src="item.src"
          height="300"
          cover
          rounded="md"
        >

        </v-img>
        <v-layout class="d-flex justify-end align-end h-100 w-100" style="position: absolute; bottom: 0; left: 0;">
          <v-card color="white" class="pa-2 w-100 promotion-slide-description mb-2" rounded="0" elevation="2">
            <v-row>
              <v-col cols="12" md="9">
                <h1 class="text-18">
                  <v-chip color="primary">Running</v-chip>
                  Drops & Wins Italy 2024-2025
                </h1>
                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Duis pulvinar, arcu ut maximus sagittis, mi
                  quam tempus lacus, eu bibendum ligula turpis vel ex. Donec facilisis mauris id tortor commodo
                  venenatis</p>
              </v-col>
              <v-col cols="12" md="3">
                <div class="promotion-time-left d-flex flex-column">
                  <h2 class="text-13 text-center">Time left:</h2>
                  <div class="d-flex time-left_component mb-4 justify-center">
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

                  <v-btn color="primary" @click="goToPromotion">See more</v-btn>
                </div>
              </v-col>
            </v-row>
          </v-card>
        </v-layout>
      </v-carousel-item>
    </v-carousel>
  </v-flex>

  <v-tabs
    v-model="tab"
    align-tabs="center"
    class="mt-4 mb-5"
    color="primary"
  >
    <v-tab :value="category.id" v-for="category in categories" :key="category.id">{{ category.name }}</v-tab>
  </v-tabs>

  <v-card color="white" elevation="2" v-for="i in 4" :key="`Promotion${i}`" class="mb-4 pa-2">
    <v-row>
      <v-col cols="12" md="3">
        <v-img src="https://cdn.vuetifyjs.com/images/carousel/sky.jpg" rounded="md"></v-img>
      </v-col>
      <v-col cols="12" md="6">
        <h1 class="text-18">
          <v-chip color="primary">Running</v-chip>
          Drops & Wins Italy 2024-2025
        </h1>
        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Duis pulvinar, arcu ut maximus sagittis, mi
          quam tempus lacus, eu bibendum ligula turpis vel ex. Donec facilisis mauris id tortor commodo
          venenatis</p>
      </v-col>
      <v-col cols="12" md="3">
        <div class="promotion-time-left d-flex flex-column">
          <h2 class="text-13 text-center">Time left:</h2>
          <div class="d-flex time-left_component mb-4 justify-center">
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

          <v-btn color="primary" @click="goToPromotion">See more</v-btn>
        </div>
      </v-col>
    </v-row>
  </v-card>
</template>
<script setup>
import {ref, shallowRef} from 'vue';
import {useRouter} from 'vue-router';

const router = useRouter();
const tab = ref(null);
const categories = [{name: 'Running'}, {name: 'Upcoming'}, {name: 'Ended'}]

import {useMainStore} from "../../stores/main";

const breadcrumbs = shallowRef([
  {
    title: 'Client Area',
    disabled: false,
    to: {name: 'ca.index'}
  },
  {
    title: 'Promotions',
    disabled: true,
    to: {name: 'ca.promotions'}
  },
]);

const mainStore = useMainStore();
mainStore.SET_BREADCRUMBS(breadcrumbs);

import Photo from './components/1266x380-.png';

const items = ref([
  {
    src: Photo
  },
  {
    src: 'https://cdn.vuetifyjs.com/images/carousel/sky.jpg'
  },
  {
    src: 'https://cdn.vuetifyjs.com/images/carousel/bird.jpg'
  },
  {
    src: 'https://cdn.vuetifyjs.com/images/carousel/planet.jpg'
  }
]);

const goToPromotion = () => {
  router.push({
    name: 'ca.promotions.single',
    params: {slug: 'promotion-test'}
  })
}

</script>

<style scoped>
@import "./styles/promotion_page.css";
</style>
