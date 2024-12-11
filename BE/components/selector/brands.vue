<template>
  <div>
    <v-autocomplete
      v-model="model"
      :items="items"
      label="Brand"
      :item-text="'name'"
      :item-value="'id'"
      :key="customKey"
      @change="onModelUpdate"
      :disabled="isLoading"
      return-object
    ></v-autocomplete>
  </div>
</template>
<script>
export default {
  name: "BrandsSelector",
  props: {
    defaultValue: {
      type: Number | String,
      required: false,
      default: -1,
    },
    client: {
      required: true,
      type: Number,
    },
  },
  data() {
    return {
      customKey: "BrandsSelector",
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
      console.log(this.cliendId);
      try {
        const { data } = await this.$axios.$get("/selector/brands", {
          params: {
            client_id: this.client,
          },
        });

        this.items = data;
        this.isLoading = false;
      } catch (err) {
        this.isLoading = false;
        console.warn(`[${this.customKey}]::`, err);
      }
    },
  },
};
</script>