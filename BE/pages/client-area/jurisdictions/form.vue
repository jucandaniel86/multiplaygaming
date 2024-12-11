<template>
  <v-card>
    <v-card-title>Save</v-card-title>
    <v-card-text>
      <v-form ref="form" v-model="valid" class="custom-form" lazy-validation>
        <v-text-field
          v-model="form.name"
          :rules="nameRules"
          label="Name"
          required
        ></v-text-field>

        <v-text-field
          v-model="form.alias"
          :rules="nameRules"
          label="Alias"
          required
        ></v-text-field>
      </v-form>
    </v-card-text>
    <v-card-actions class="d-flex gap-2 justify-center">
      <v-btn :disabled="!valid || isLoading" color="primary" @click="validate">
        <v-icon color="white">mdi-content-save</v-icon>
        Save
      </v-btn>
      <v-btn color="grey" @click="close">
        <v-icon color="white">mdi-close</v-icon>
        Close
      </v-btn>
    </v-card-actions>
  </v-card>
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
    form: {
      name: "",
      alias: "",
    },
    nameRules: [(v) => !!v || "Field is requred"],
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
      }
    },
    async validate() {
      const response = this.$refs.form.validate();
      if (response) {
        this.isLoading = true;
        try {
          const { data } = await this.$axios.post(
            "/jurisdictions/save",
            this.form
          );

          if (data.success) {
            this.toastSuccess(data.message);
            this.close();
            this.$root.$emit("refresh-list", {});
          } else {
            this.toastError(data.msg);
          }
        } catch (err) {
          this.toastError("Something went wrong!");
        }
        this.isLoading = false;
      }
    },
    close() {
      this.$root.$emit("close-modal", {});
    },
  },
};
</script>
