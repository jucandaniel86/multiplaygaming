<template>
  <v-sheet
    v-if="loading"
    color="white"
    class="d-flex align-center justify-center flex-wrap text-center mx-auto px-4"
  >
    <v-progress-linear indeterminate color="primary"></v-progress-linear>
  </v-sheet>

  <div v-else>

    <!-- DASHBOARD SLIDER -->
    <v-carousel
      :show-arrows="false"
      color="primary"
      height="450"
      hide-delimiter-background
      class="rounded-lg"
    >
      <v-carousel-item
        v-for="(banner,i) in banners"
        :src="banner.slide_url"
        aspect-ratio="2.3"
        class="rounded-lg"
        max-height="400"
        :tile="true"
        :key="`Banner${i}`">
      </v-carousel-item>
    </v-carousel>
    <!-- END DASHBOARD SLIDER -->

    <!-- UPCOMING -->
    <CustomCarousel title="Ucoming Releases" :items="games">
      <template v-slot:item="{ item }">
        <GameCardSmall :game="item"/>
      </template>
    </CustomCarousel>
    <!-- END UPCOMING -->

    <!-- CATEGORIES WITH GAMES -->
    <CustomCarousel
      v-for="(category, i) in gameCategories"
      :key="`SliderCategory${i}`"
      :title="category.name"
      :items="category.games">
      <template v-slot:item="{ item }">
        <GameCardSmall :game="item"/>
      </template>
    </CustomCarousel>
    <!-- CATEGORIES WITH GAMES -->
    {{ games.items }}
  </div>


</template>

<script setup>
import {onMounted, shallowRef, ref} from "vue";
import {useMainStore} from "../stores/main";
import useGames from "../composables/games";
import useBanners from "../composables/banners";
import GameCardSmall from "../components/cards/GameCardSmall";
import CustomCarousel from "../components/carousel/CustomCarousel";

const {games, loaders, gameCategories, getGames, getCategoriesWithGames} = useGames();
const {banners, getBanners} = useBanners();
const loading = ref(true);

const breadcrumbs = shallowRef([
  {
    title: 'Client Area',
    disabled: true,
    href: '/'
  },
]);
const mainStore = useMainStore();
mainStore.SET_BREADCRUMBS(breadcrumbs);

onMounted(async () => {
  await getBanners();
  await getGames({
    show_upcoming: 1
  });
  await getCategoriesWithGames();
  loading.value = false;
})

</script>

<style scoped>

</style>
