<script setup>
import {RouterView} from 'vue-router';
import VerticalSidebarVue from './layouts/vertical-sidebar/VerticalSidebar';
import VerticalHeaderVue from './layouts/vertical-header/VerticalHeader';
import FooterPanel from './layouts/footer/FooterPanel.vue';
</script>

<template>
  <v-locale-provider>
    <v-app
      theme="PurpleTheme"
    >
      <VerticalSidebarVue/>
      <VerticalHeaderVue/>

      <v-main style="background: #000;">
        <v-container fluid class="page-wrapper rounded-md mr-2">
          <div>
            <RouterView/>
          </div>
        </v-container>
        <v-container fluid class="pt-0">
          <div>
            <FooterPanel/>
          </div>
        </v-container>
      </v-main>
    </v-app>
  </v-locale-provider>
</template>
