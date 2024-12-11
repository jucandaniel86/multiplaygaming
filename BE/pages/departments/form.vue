<template>
  <v-form ref="form" v-model="valid" class="custom-form" lazy-validation>
    <v-text-field
      v-model="form.name"
      :rules="nameRules"
      label="Name"
      required
    ></v-text-field>

    <v-row>
      <v-col cols="6">
        <v-checkbox
          v-model="form.is_active"
          :label="`Active`"
          :true-value="1"
          :false-value="0"
          :value="1"
        ></v-checkbox>
      </v-col>
    </v-row>

    <button
      :disabled="!valid || isLoading"
      color="success"
      class="btn btn-primary"
      type="button"
      @click="validate"
    >
      Save
    </button>
  </v-form>
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
      is_active: 1,
    },
    nameRules: [(v) => !!v || "Name field is requred"],
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
            "/departments/save",
            this.form
          );

          if (data.success) {
            this.toastSuccess(data.message);
            this.$root.$emit("close-modal", {});
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
  },
};
</script>
