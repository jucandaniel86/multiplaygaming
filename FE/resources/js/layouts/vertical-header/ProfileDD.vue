<script setup>
import {defineProps} from "vue";
import {useRouter} from 'vue-router';
import {SettingsIcon, LogoutIcon} from 'vue-tabler-icons';
import {baseURL} from "../../app";

const router = useRouter();
const props = defineProps({
  user: {
    type: Object,
    required: true
  }
})

const goToAccount = () => {
  router.push({name: 'ca.account'});
}

const logout = () => {
  window.location = baseURL + '/logout';
}

</script>

<template>
  <!-- ---------------------------------------------- -->
  <!-- profile DD -->
  <!-- ---------------------------------------------- -->
  <div class="pa-4">
    <v-divider></v-divider>

    <v-list class="mt-3">
      <v-list-item color="secondary" rounded="md" link @click="goToAccount">
        <template v-slot:prepend>
          <SettingsIcon size="20" class="mr-2"/>
        </template>

        <v-list-item-title class="text-subtitle-2"> Account Settings</v-list-item-title>
      </v-list-item>

      <v-list-item color="secondary" rounded="md" link @click="logout">
        <template v-slot:prepend>
          <LogoutIcon size="20" class="mr-2"/>
        </template>

        <v-list-item-title class="text-subtitle-2"> Logout</v-list-item-title>
      </v-list-item>
    </v-list>
  </div>
</template>
