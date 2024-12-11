<script setup>
import {ref, onMounted} from 'vue';
// Icon Imports
import {SettingsIcon, Menu2Icon} from 'vue-tabler-icons';

import {useMainStore} from '../../stores/main';
import useUsers from "../../composables/users";

const mainStore = useMainStore();

// dropdown imports
import ProfileDD from './ProfileDD.vue';
import BaseBreadcrumb from "../../components/shared/BaseBreadcrumb";

const showSearch = ref(false);
const loading = ref(false);
const {user, getUser} = useUsers();

function searchbox() {
  showSearch.value = !showSearch.value;
}

const loadUser = async () => {
  loading.value = true;
  await getUser();
  loading.value = false;
}

onMounted(loadUser);
</script>

<template>
  <v-app-bar elevation="0">
    <v-btn
      class="text-secondary"
      color="primary"
      icon
      rounded="sm"
      variant="flat"
      size="x-small"
      @click="mainStore.SET_SIDEBAR_DRAWER(true)"
    >
      <Menu2Icon size="20" stroke-width="1.5" style="color: #FFF"/>
    </v-btn>


    <BaseBreadcrumb :breadcrumbs="mainStore.breadcrumbs"></BaseBreadcrumb>


    <v-spacer/>
    <!-- ---------------------------------------------- -->
    <!---right part -->
    <!-- ---------------------------------------------- -->


    <!-- ---------------------------------------------- -->
    <!-- User Profile -->
    <!-- ---------------------------------------------- -->
    <v-menu :close-on-content-click="false">
      <template v-slot:activator="{ props }">
        <v-skeleton-loader
          :loading="loading"
          type="avatar"
        >
          <v-btn
            v-if="user"
            class="profileBtn text-primary hidden-md-and-down"
            color="lightprimary"
            size="x-small"
            v-bind="props">
            <span>{{ user.email }}</span>
            <SettingsIcon stroke-width="1.5"/>
          </v-btn>
        </v-skeleton-loader>

      </template>
      <v-sheet rounded="md" width="330" elevation="12">
        <ProfileDD :user="user"/>
      </v-sheet>
    </v-menu>
  </v-app-bar>
</template>
