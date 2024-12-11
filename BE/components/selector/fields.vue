<template>
  <v-autocomplete
    v-model="model"
    :items="items"
    label="Hide Columns"
    :item-text="'text'"
    :item-value="'value'"
    :key="customKey"
    @change="onModelUpdate"
    class="selector-fields"
    :disabled="isLoading"
    multiple
  ></v-autocomplete>
</template>
<script>
export default {
  name: "ColumnsSelector",
  props: {
    defaultValue: {
      type: Number | String,
      required: false,
      default: -1,
    },
    items: {
      required: true,
      type: Array,
      default: () => [],
    },
  },
  data() {
    return {
      customKey: "DepartmentsSelector",
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
  methods: {
    onModelUpdate(value) {
      this.$emit("input", value);
    },
  },
};
</script>
 <style>
.selector-fields .v-select__selections {
  max-height: 30px;
  overflow: hidden;
  font-size: 0.8rem;
}
</style>