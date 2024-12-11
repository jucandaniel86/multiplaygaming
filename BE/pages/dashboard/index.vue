<template>
  <v-row>
    <v-col cols="12">
      <div class="bg-light rounded h-100 p-4">
        <SharedCardHeader :title="'Dashboard'">
          <template v-slot:content>
            <p>In Progress</p>
          </template>
        </SharedCardHeader>
      </div>
    </v-col>
  </v-row>
</template>
<script>
export default {
  layout: "backend",
  middleware: ["auth"],
};
</script>
