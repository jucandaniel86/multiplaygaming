<template>
  <div class="d-flex align-center gap-2">
    <v-btn
      v-if="displayExchangeButton"
      elevation="0"
      small
      :color="activeOption === 'exchange' ? 'primary' : ''"
      @click.prevent="changeMode"
    >
      <v-icon :color="activeOption === 'exchange' ? 'white' : ''"
        >mdi-swap-horizontal</v-icon
      >
    </v-btn>
    <v-autocomplete
      v-model="model"
      :items="activeOptions"
      label="Currency"
      :key="customKey"
      class="lbl-white"
      :disabled="isLoading"
      item-text="label"
      item-value="value"
      :multiple="multiple"
      :return-object="!multiple"
    ></v-autocomplete>
  </div>
</template>
<script>
export default {
  name: "CurrencySelector",
  props: {
    defaultValue: {
      type: Number | String,
      required: false,
      default: -1,
    },
    displayExchangeButton: {
      type: Boolean,
      required: false,
      default: true,
    },
    multiple: {
      type: Boolean,
      required: false,
      default: false,
    },
  },
  data() {
    return {
      customKey: "DepartmentsSelector",
      items: [],
      model: this.defaultValue !== -1 ? this.defaultValue : [],
      isLoading: false,
      activeOption: "currency",
    };
  },
  computed: {
    activeOptions() {
      if (this.activeOption === "currency") return this.items.currencies;
      else if (this.activeOption === "exchange") return this.items.exchange;
    },
  },
  watch: {
    model() {
      if (!this.model) return;

      if (this.activeOption !== "exchange") {
        if (Array.isArray(this.model) && this.model.length) {
          this.$emit("input", this.model);
        } else {
          this.$emit("input", this.model.value);
        }
      } else {
        this.$emit("currency:exchange", this.model);
      }
    },
    defaultValue() {
      this.model = this.defaultValue;
    },
  },
  mounted() {
    this.getItems();
  },
  methods: {
    changeMode() {
      this.activeOption =
        this.activeOption === "currency" ? "exchange" : "currency";
      this.model = "";
    },

    async getItems() {
      this.isLoading = true;
      try {
        const { data } = await this.$axios.$get("/reports/currencies");

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
<style scoped>
.text-right {
  text-align: right;
}
</style>
