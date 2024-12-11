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
  data: () => ({
    pageTitle: "Add new article",
    loading: true,
    item: {},
  }),
  created() {
    this.getLastDraft();
  },
  methods: {
    async getLastDraft() {
      try {
        const { data } = await this.$axios.get("/articles/draft", {
          params: {
            article_type: this.$route.query.article_type,
          },
        });
        this.item = data.data;
      } catch (err) {
        console.warn("[ArticleController]", err);
      }
      this.loading = false;
    },
    goBackToList() {
      this.$router.push({ name: "articles" });
    },
  },
};
</script>
