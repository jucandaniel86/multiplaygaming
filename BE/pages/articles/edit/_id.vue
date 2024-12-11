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
        <articles-form
          :page-title="pageTitle"
          :default-form="item"
          @articles:back="goBackToList"
        />
      </div>
    </v-col>
  </v-row>
</template>
<script>
export default {
  layout: "backend",
  middleware: ["auth"],
  name: "ArticlesEdit",
  data: () => ({
    pageTitle: "Edit article",
    loading: true,
    item: {},
  }),
  created() {
    this.getItem();
  },
  methods: {
    async getItem() {
      const id = this.$route.params.id;
      try {
        const { data } = await this.$axios.get("/articles/game-by-id", {
          params: {
            id,
          },
        });
        if (data.success) {
          this.item = data.data;
        } else {
          this.goBackToList();
        }
      } catch (err) {
        console.warn("[GameController]", err);
        this.toastError("Article found!");
        this.goBackToList();
      }
      this.loading = false;
    },
    goBackToList() {
      this.$router.push({ name: "articles" });
    },
  },
};
</script>
