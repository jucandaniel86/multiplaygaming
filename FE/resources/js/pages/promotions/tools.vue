<script setup>
import {ref, shallowRef, computed} from 'vue';

import {useMainStore} from "../../stores/main";
import {mdiCashRegister, mdiTrophyOutline, mdiGiftOpenOutline, mdiStarCircleOutline, mdiPlaySpeed} from '@mdi/js';

import {PROMOTION_CONTENT} from "./promotions_tools";
//import tabs
import PromotionItem from './components/promotion-item';

const page = ref({title: 'Tools'});
const breadcrumbs = shallowRef([
  {
    title: 'Client Area',
    disabled: false,
    to: {name: 'ca.index'}
  },
  {
    title: 'Promotions',
    disabled: false,
    to: {name: 'ca.promotions'}
  },
  {
    title: 'Tools',
    disabled: true,
    href: '#'
  }
]);
const mainStore = useMainStore();
mainStore.SET_BREADCRUMBS(breadcrumbs);

const tab = ref(null);

const changeActiveTab = (newTab) => {
  tab.value = newTab
}

changeActiveTab(PROMOTION_CONTENT[0]);

</script>
<template>
  <v-row>
    <v-col cols="12">
      <v-img
        src="https://static.vecteezy.com/system/resources/previews/003/126/306/large_2x/futuristic-green-and-black-gaming-banner-and-cover-design-template-free-vector.jpg"
        :max-height="350" :width="'100%'"/>
    </v-col>
  </v-row>

  <v-row>
    <v-col cols="12">
      <h1 class="text-center text-24">Promotion Tools</h1>
    </v-col>
  </v-row>

  <v-row align="center" justify="center">
    <v-col cols="auto">
      <v-btn
        color="white"
        elevation="2"
        size="x-large"
        class="ml-2"
        v-for="(t,i) in PROMOTION_CONTENT"
        :key="t.id"
        text
        @click.prevent="changeActiveTab(t)"
        :active="t.id === tab.id">
        <v-icon :icon="t.icon" color="primary" size="x-large">{{ t.icon }}</v-icon>
        <b>{{ t.title }}</b>
      </v-btn>
    </v-col>

  </v-row>

  <v-row align="center" justify="center">
    <v-col cols="12" class="d-flex justify-center">
      <promotion-item :title="tab.title" :text="tab.text" :icon="tab.icon"/>
    </v-col>
  </v-row>
</template>
