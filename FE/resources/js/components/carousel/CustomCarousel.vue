<template>
  <div class="d-flex justify-space-between align-center">
    <h2 class="text-black text-h5 font-weight-bold">{{ props.title || '' }}</h2>
    <div class="d-flex ga-2" v-if="props.items.length > columns">
      <v-btn
        :icon="mdiArrowLeft"
        color="white"
        size="small"
        @click="carousel = Math.max(carousel - 1, 0)"/>
      <v-btn
        :icon="mdiArrowRight"
        color="white"
        size="small"
        @click="nextPage"/>
    </div>
  </div>

  <v-carousel
    v-model="carousel"
    :show-arrows="false"
    :cycle="false"
    :height="'auto'"
    class="mb-3 pb-3"
    hide-delimiter-background
    hide-delimiters>
    <template v-for="(_item, index) in props.items">
      <v-carousel-item
        v-if="(index + 1) % columns === 1 || columns === 1"
        :key="index"
      >
        <v-row class="flex-nowrap" style="height:100%">
          <template v-for="(n,i) in columns">
            <template v-if="(+index + i) < props.items.length">
              <v-col :key="i">
                <div v-if="(+index + i) < props.items.length">
                  <slot name="item" :item="props.items[+index + i]"></slot>
                </div>

              </v-col>
            </template>
          </template>
        </v-row>
      </v-carousel-item>
    </template>
  </v-carousel>
</template>

<script setup>
import {defineProps, computed, ref} from "vue";
import {useDisplay} from 'vuetify'

import {mdiArrowLeft, mdiArrowRight} from '@mdi/js';

const props = defineProps({
  columns: {
    type: Number,
    required: false,
    default: 5,
  },
  items: {
    type: Array,
    required: true,
    default: () => ([])
  },
  title: {
    type: String,
    required: false,
  }
})

const carousel = ref(0);
const {mobile} = useDisplay()

const columns = computed(() => {
  if (mobile.value) {
    return 1;
  }
  return 5;
}, props.columns);

const nextPage = () => {

  if (carousel.value + 1 > Math.floor(props.items.length / columns.value) - (columns.value === 1 ? 1 : 0)) {
    carousel.value = 0;
  } else {
    carousel.value++;
  }

}

</script>

<style scoped>

</style>
