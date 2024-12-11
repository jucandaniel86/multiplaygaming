<template>
  <v-card>
    <v-card-title>Save Partner</v-card-title>
    <v-card-text style="height: 400px">
      <v-form ref="form" v-model="valid" class="custom-form" lazy-validation>
        <v-text-field
          v-model="form.name"
          :rules="nameRules"
          label="Title"
          required
          hide-details
        ></v-text-field>

        <selector-partner-categories v-model="form.partner_category" />

        <selector-partner-types v-model="form.partner_type" />

        <v-textarea
          v-model="form.external_url"
          label="Link"
          rows="3"
        ></v-textarea>

        <v-file-input v-model="form.logo" label="Logo" />

        <v-checkbox
          v-model="form.is_active"
          label="Active"
          :true-value="1"
          :false-value="0"
        />
      </v-form>
    </v-card-text>
    <v-card-actions>
      <v-btn
        :disabled="!valid || isLoading"
        color="red"
        type="button"
        @click="validate"
      >
        Save
      </v-btn>
    </v-card-actions>
  </v-card>
</template>
<script>
export default {
  data: () => ({
    valid: true,
    isLoading: false,
    form: {
      name: "",
      external_url: "",
      partner_category: "",
      partner_type: "",
      is_active: 1,
      logo: [],
    },
    nameRules: [(v) => !!v || "Name field is requred"],
  }),
  methods: {
    resetForm() {
      this.form = {
        name: "",
        external_url: "",
        is_active: 1,
        logo: null,
      };
    },
    async validate() {
      const response = this.$refs.form.validate();
      if (response) {
        this.isLoading = true;
        try {
          const frmData = new FormData();

          Object.entries(this.form).forEach((e) => {
            frmData.append(e[0], e[1]);
          });

          const { data } = await this.$axios.post("/partners/save", frmData, {
            headers: {
              "Content-Type": "multipart/form-data",
            },
          });

          if (data.success) {
            this.toastSuccess(data.message);
            this.$root.$emit("partners:close-modal", {});
            this.$root.$emit("partners:refresh-list", {});
            this.resetForm();
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
