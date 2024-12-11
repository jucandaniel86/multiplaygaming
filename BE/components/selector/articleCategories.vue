<template>
  <div>
    <v-autocomplete
      v-model="category"
      :items="categories"
      label="Category"
      item-text="label"
      item-value="id"
      :key="customKey"
      @change="onModelOpdate"
      class="lbl-white"
      :disabled="isLoading"
    ></v-autocomplete>
  </div>
</template>
<script>
export default {
  name: "GameCategories",
  props: {
    defaultValue: {
      type: Number | String,
      required: false,
      default: -1,
    },
  },
  data() {
    return {
      customKey: "ArticleCategoriesSelector",
      categories: [],
      category: this.defaultValue !== -1 ? this.defaultValue : [],
      isLoading: false,
    };
  },
  watch: {
    category() {
      this.$emit("input", this.category);
    },
    defaultValue() {
      this.category = this.defaultValue;
    },
  },
  mounted() {
    this.getCategories();
    this.$root.$on("categoies:save-category", this.getCategories);
  },
  methods: {
    onModelOpdate(value) {
      this.$emit("input", value);
    },
    async getCategories() {
      this.isLoading = true;
      try {
        const { data } = await this.$axios.$get("/selector/article-categories");

        this.categories = data;

        this.isLoading = false;
      } catch (err) {
        this.isLoading = false;
        console.log(err);
      }
    },
  },
};
</script>
<style scoped>
.text-right {
  text-align: right;
}
</style>
