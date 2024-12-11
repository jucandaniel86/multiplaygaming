<template>
  <div>
    <v-autocomplete
      v-model="model"
      :items="items"
      label="Translation Files"
      :key="customKey"
      @change="onModelUpdate"
      class="lbl-white"
      :disabled="isLoading"
    ></v-autocomplete>
  </div>
</template>
<script>
export default {
  name: "TranslationFiles",
  props: {
    defaultValue: {
      type: Number | String,
      required: false,
      default: -1,
    },
  },
  data() {
    return {
      customKey: "TranslationFiles",
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
    onModelUpdate(value) {
      this.$emit("input", value);
    },
    async getItems() {
      this.isLoading = true;
      try {
        const { data } = await this.$axios.$get("/lang/files");

        this.items = data.map((el) => el.label);
        this.isLoading = false;
      } catch (err) {
        this.isLoading = false;
        console.warn(`[${this.customKey}]::`, err);
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
