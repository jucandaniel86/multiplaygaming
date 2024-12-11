<template>
  <SharedCardHeader :title="title">
    <template v-slot:content>
      <div class="pa-2">
        <v-text-field
          v-model="form.name"
          label="Brand Name"
          required
        ></v-text-field>
        <v-text-field
          v-model="form.brand_url"
          label="Brand Url"
          required
        ></v-text-field>
        <v-text-field
          v-model="form.brand_rgs_id"
          label="Brand RGS ID"
          required
        ></v-text-field>
      </div>
    </template>
    <template v-slot:footer>
      <div class="d-flex justify-center align-center">
        <button-loading
          :is-loading="isLoading"
          :icon="'fa-save'"
          style="max-width: 200px"
          :text="'Save'"
          @on-click="save"
        />
      </div>
    </template>
  </SharedCardHeader>
</template>
<script>
export default {
  props: {
    currentItem: {
      type: Object | null,
      required: false,
    },
  },
  data: () => ({
    valid: true,
    isLoading: false,
    title: "Save Brand",
    form: {
      name: "",
      brand_rgs_id: "",
      brand_url: "",
    },
  }),
  watch: {
    currentItem() {
      this.assignItem();
    },
  },
  created() {
    this.assignItem();
  },
  methods: {
    assignItem() {
      if (
        this.currentItem &&
        typeof this.currentItem === "object" &&
        Object.entries(this.currentItem).length
      ) {
        this.form = {
          ...this.form,
          ...this.currentItem,
        };
        this.form.currencies = this.currentItem.clientCurrencies;
      }
    },
    async save() {
      this.isLoading = true;
      try {
        const { data } = await this.$axios.post("/clients/save-brand", {
          ...this.form,
          client_id: this.$route.params.id,
        });

        if (data.success) {
          this.toastSuccess(data.message);
          this.$root.$emit("brands:close-modal", {});
          this.$root.$emit("brands:refresh-list", {});
        } else {
          this.toastError(data.msg);
        }
      } catch (err) {
        this.toastError("Something went wrong!");
      }
      this.isLoading = false;
    },
  },
};
</script>
