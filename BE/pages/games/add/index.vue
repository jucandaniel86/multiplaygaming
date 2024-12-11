<template>
  <v-row>
    <v-col cols="12">
      <div class="px-4">
        <v-progress-linear
          v-if="loading"
          indeterminate
          color="primary"
        ></v-progress-linear>
      </div>
      <div :class="{ 'disabled-user-actions': loading }">
        <games-form :page-title="pageTitle" :default-form="item" />
      </div>
    </v-col>
  </v-row>
</template>
<script>
export default {
  layout: "backend",
  middleware: ["auth"],
  data: () => ({
    pageTitle: "Add new game",
    loading: false,
    item: {},
  }),
  created() {
    // this.getLastDraft();
  },
  // methods: {
  //   async getLastDraft() {
  //     try {
  //       const { data } = await this.$axios.get("/games/draft");
  //       this.item = data.data;
  //     } catch (err) {
  //       console.warn("[GameController]", err);
  //     }
  //     this.loading = false;
  //   },
  // },
};
</script>
