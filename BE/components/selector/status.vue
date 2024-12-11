<template>
  <div>
    <v-autocomplete
      v-model="status"
      :items="statuses"
      label="Status"
      item-text="label"
      item-value="id"
      :key="`ItemStatus`"
      @change="onModelOpdate"
      class="lbl-white"
      :disabled="isLoading"
    ></v-autocomplete>
  </div>
</template>
<script>
export default {
  props: {
    defaultValue: {
      type: Number | String,
      required: false,
      default: -1,
    },
  },
  data() {
    return {
      statuses: [],
      status: this.defaultValue !== -1 ? this.defaultValue : [],
      isLoading: false,
    };
  },
  watch: {
    status() {
      this.$emit("input", this.status);
    },
    defaultValue() {
      this.status = this.defaultValue;
    },
  },
  mounted() {
    this.getStatuses();
  },
  methods: {
    onModelOpdate(value) {
      this.$emit("input", value);
    },
    async getStatuses() {
      this.isLoading = true;
      try {
        const data = await this.$axios.$get("/selector/status");

        this.statuses = data.data;
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
