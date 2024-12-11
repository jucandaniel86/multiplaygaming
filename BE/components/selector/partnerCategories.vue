<template>
  <v-autocomplete
    v-model="model"
    :items="items"
    label="Category"
    item-text="label"
    item-value="id"
    :key="customKey"
    @change="onModelOpdate"
    flat
    hide-details
  ></v-autocomplete>
</template>
<script>
export default {
  name: "PartnersCategoriesSelector",
  props: {
    defaultValue: {
      type: Number | String,
      required: false,
      default: -1,
    },
  },
  data() {
    return {
      customKey: "PartnersCategoriesSelector",
      items: [
        { id: "studios", label: "Studios" },
        { id: "media", label: "Media" },
        { id: "affiliates", label: "Affiliates" },
      ],
      model: this.defaultValue !== -1 ? this.defaultValue : [],
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
  methods: {
    onModelOpdate(value) {
      this.$emit("input", value);
    },
  },
};
</script>
