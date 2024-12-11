<script setup>
import {onMounted, ref, shallowRef} from 'vue';
import {mdiDownload} from '@mdi/js';
import {useMainStore} from "../../stores/main";
import useOptions from "../../composables/options";

const loading = ref(true);
const breadcrumbs = shallowRef([
  {
    title: 'Client Area',
    disabled: false,
    to: {name: 'ca.index'}
  },
  {
    title: 'Brand Assets',
    disabled: true,
    href: '#'
  },
]);
const {getOptions, options} = useOptions();
const mainStore = useMainStore();
mainStore.SET_BREADCRUMBS(breadcrumbs);

onMounted(async () => {
  loading.value = true;
  await getOptions(['promo_assets_name', 'promo_assets_link']);
  loading.value = false;
});

const openDownloads = () => {
  if (!options.value.promo_assets_link) return;

  window.open(options.value.promo_assets_link, '_blank');
}

</script>
<template>
  <v-progress-linear indeterminate v-if="loading" color="primary"/>
  <v-table class="custom-table" v-else>
    <tbody>
    <tr>
      <td style="width: 80%;">
        <v-btn icon color="primary" class="mr-2">
          <v-icon
            :icon="mdiDownload"
            color="white"
            size="large"
          >
          </v-icon>
        </v-btn>

        <b>{{ options.promo_assets_name }}</b>
      </td>
      <td style="width: 20%; text-align: right">
        <v-btn
          color="primary"
          @click="openDownloads"
        >See link
        </v-btn>
      </td>
    </tr>
    </tbody>
  </v-table>
</template>
