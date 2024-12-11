<script setup>
import {ChevronRightIcon, HomeIcon} from 'vue-tabler-icons';

const props = defineProps({
  title: String,
  breadcrumbs: [],
  icon: String
});
</script>

// ===============================|| Theme Breadcrumb ||=============================== //
<template>
  <v-row class="page-breadcrumb mb-1 mt-1">
    <v-col cols="12" md="12">
      <v-card class="px-4 py-3" elevation="0">
        <v-row no-gutters class="align-center">
          <v-col md="12" sm="12" cols="12">
            <v-breadcrumbs :items="props.breadcrumbs" class="text-h5 justify-md-start pa-1">
              <template v-slot:divider>
                <div class="d-flex align-center">
                  <ChevronRightIcon size="17"/>
                </div>
              </template>
              <template v-slot:prepend>
                <v-icon :icon="HomeIcon" class="text-secondary mr-2" color="white"></v-icon>
                <div class="d-flex align-center">
                  <ChevronRightIcon size="17"/>
                </div>
              </template>
            </v-breadcrumbs>
          </v-col>
        </v-row>
      </v-card>
    </v-col>
  </v-row>
</template>

<style>
.page-breadcrumb .v-toolbar {
  background: transparent;
}
</style>
