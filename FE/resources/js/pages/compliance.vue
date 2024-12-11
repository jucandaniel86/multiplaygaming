<script setup>
import {onMounted, ref, shallowRef} from 'vue';

import {useMainStore} from "../stores/main";
import SelectorJurisdiction from "../components/selectors/SelectorJurisdiction";
import useGames from "../composables/games";

const {getCategories, categories} = useGames();
const tab = ref(null);
const categoriesLoader = ref(false);
const breadcrumbs = shallowRef([
  {
    title: 'Client Area',
    disabled: false,
    to: {name: 'ca.index'}
  },
  {
    title: 'Compliance',
    disabled: true,
    href: '#'
  },
]);
const mainStore = useMainStore();
mainStore.SET_BREADCRUMBS(breadcrumbs);

const onCategoriesLoader = async () => {
  categoriesLoader.value = true;
  await getCategories();
  categoriesLoader.value = false;
}

onMounted(() => {
  onCategoriesLoader();
});

</script>
<template>
  <v-progress-linear indeterminate v-if="categoriesLoader" color="primary"/>
  <v-tabs
    v-model="tab"
    align-tabs="center"
    color="deep-purple-accent-4"
  >
    <v-tab :value="category.id" v-for="category in categories" :key="category.id">{{ category.label }}</v-tab>
  </v-tabs>

  <v-row class="mt-3">
    <v-col cols="12" md="3">
      <v-text-field label="Search game..." hide-details single-line/>
    </v-col>
    <v-col cols="12" md="9">
      <v-row align="end">
        <v-col cols="12" md="4">
          <SelectorJurisdiction/>
        </v-col>
        <v-col cols="12" md="8">
          <div class="d-flex flex-column flex-md-row justify-center">
            <v-btn color="primary" class="mb-2 mb-md-0">Download All Certificates</v-btn>
            <v-btn color="primary" class="ml-md-2 ml-0">Download Game Jurisdiction List</v-btn>
          </div>
        </v-col>
      </v-row>
    </v-col>
  </v-row>

  <v-row class="mt-3">
    <v-col cols="12">
      <v-table class="custom-table">
        <thead>
        <tr>
          <th width="70%">Game</th>
          <th colspan="2" width="30%">Jurisdiction</th>
        </tr>
        </thead>
        <tbody>
        <tr v-for="i in 10" :key="i">
          <td>Lucky Dragon</td>
          <td width="20%">
            <SelectorJurisdiction/>
          </td>
          <td>
            <v-btn color="primary">Download</v-btn>
          </td>
        </tr>
        </tbody>
      </v-table>
    </v-col>
  </v-row>
</template>
