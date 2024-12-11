<script setup>
import {onMounted, ref, shallowRef} from 'vue';

import useGames from "../../composables/games";
import {useMainStore} from "../../stores/main";
import BasePageTitle from "../../components/shared/BasePageTitle";

const page = ref({title: 'Road map'});
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
    title: 'Roadmap',
    disabled: true,
    href: '#'
  }
]);
const mainStore = useMainStore();
mainStore.SET_BREADCRUMBS(breadcrumbs);

const {games, getGames, loaders} = useGames();

const items = ref([
  {
    coming: 'Coming Soon',
    name: 'Candy Corner',
    media_pack: '7th Sep 2024',
    testing: '9th Sep 2024',
    operators: '31st Oct 2024',
  },
  {
    coming: 'Coming Soon',
    name: 'Candy Corner',
    media_pack: '7th Sep 2024',
    testing: '9th Sep 2024',
    operators: '31st Oct 2024',
  },
  {
    coming: 'Coming Soon',
    name: 'Candy Corner',
    media_pack: '7th Sep 2024',
    testing: '9th Sep 2024',
    operators: '31st Oct 2024',
  },
  {
    coming: 'Coming Soon',
    name: 'Candy Corner',
    media_pack: '7th Sep 2024',
    testing: '9th Sep 2024',
    operators: '31st Oct 2024',
  },
  {
    coming: 'Coming Soon',
    name: 'Candy Corner',
    media_pack: '7th Sep 2024',
    testing: '9th Sep 2024',
    operators: '31st Oct 2024',
  },
  {
    coming: 'Coming Soon',
    name: 'Candy Corner',
    media_pack: '7th Sep 2024',
    testing: '9th Sep 2024',
    operators: '31st Oct 2024',
  }, {
    coming: 'Coming Soon',
    name: 'Candy Corner',
    media_pack: '7th Sep 2024',
    testing: '9th Sep 2024',
    operators: '31st Oct 2024',
  },

  // ... more items
]);

const headers = [
  {key: 'name', colspan: "2", title: 'Upcoming Games'},
  {key: 'media_pack', title: 'Media Pack'},
  {key: 'testing', title: 'Available for testing'},
  {key: 'operators', title: 'Availabe for operators'}
];

onMounted(() => {
  getGames({
    sort_by: 'release_date_recent'
  })
})

</script>
<template>
  <v-row class="pa-0">
    <v-col cols="12" md="8">
      <BasePageTitle :title="page.title" class="mb-2">
        <template v-slot:action>
          <v-btn color="primary">Download list</v-btn>
        </template>
      </BasePageTitle>

      <v-data-table
        density="compact"
        class="custom-table"
        :items="items"
        :headers="headers"></v-data-table>
    </v-col>
    <v-col cols="12" md="4" class="pa-0">
      <div class="d-flex justify-center">
        <v-date-picker
          density="compact"
          color="primary" class="custom-calendar" :max-width="'100%'" hide-header/>
      </div>
    </v-col>
  </v-row>

</template>
