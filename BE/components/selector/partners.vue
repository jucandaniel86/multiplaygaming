<template>
  <div>
    <v-autocomplete
      v-model="model"
      :items="items"
      label="Partner"
      item-text="name"
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
  name: "PartnersSelector",
  props: {
    defaultValue: {
      type: Number | String,
      required: false,
      default: -1,
    },
  },
  data() {
    return {
      customKey: "PartnersSelector",
      items: [],
      model: this.defaultValue !== -1 ? this.defaultValue : [],
      isLoading: false,
    };
  },
  watch: {
    model() {
      this.$emit("input", this.model);
    },
    defaultValue() {
      this.model = this.defaultValue;
    },
  },
  mounted() {
    this.getItems();
  },
  methods: {
    onModelOpdate(value) {
      this.$emit("input", value);
    },
    async getItems() {
      this.isLoading = true;
      try {
        const { data } = await this.$axios.$get("/partners/list");

        this.items = data.data;

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
