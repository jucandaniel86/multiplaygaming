<script setup>
import {mdiCashRegister, mdiFileChartOutline, mdiDownload} from '@mdi/js';
import Cashback from './cashback.png';

import {defineProps} from "vue";

const props = defineProps({
  title: {
    type: String,
    required: true
  },
  text: {
    type: String,
  },
  icon: {
    type: String,
  }
})
</script>
<template>
  <div class="w-100 w-md-75">
    <v-row>
      <v-col cols="12">
        <div class="d-flex mb-2 align-center">
          <v-icon :icon="icon" color="primary" class="mr-2"/>
          <span class="text-18">{{ props.title }}</span>
        </div>
      </v-col>
    </v-row>
    <div class="promotions-tools-item rounded-md mt-20">
      <v-row>
        <v-col cols="12" md="7">
          <div class="pa-2 promotions-tools-text" v-html="text"></div>
        </v-col>
        <v-col cols="12" md="5">
          <div class="d-flex justify-center align-center h-100">
            <v-img :src="Cashback" :max-width="'70%'"/>
          </div>
        </v-col>
      </v-row>
    </div>
  </div>
</template>

<style scoped>
.promotions-tools-item {
  border: 1px solid rgb(var(--v-theme-darkText));
}

.promotions-tools-text {
  line-height: 1.5rem;
}

.promotions-tools-text p {
  margin-bottom: 1rem;
}
</style>
