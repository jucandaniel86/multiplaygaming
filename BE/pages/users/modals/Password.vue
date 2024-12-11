<template>
  <v-form
    ref="form"
    v-model="valid"
    class="custom-form"
    lazy-validation
    data-app
    autocomplete="off"
  >
    <h4>Update Password</h4>
    <v-btn elevation="2" small @click="generatePassword">
      Random password
    </v-btn>
    <v-text-field
      v-model="form.old_password"
      :type="'password'"
      name="input-10-1"
      label="Old Password"
    ></v-text-field>

    <v-text-field
      v-model="form.new_password"
      :type="showPassword ? 'text' : 'password'"
      name="input-10-1"
      label="New  Password"
    ></v-text-field>

    <v-text-field
      v-model="form.new_password_confirmation"
      :type="'password'"
      name="input-10-1"
      label="Retype Password"
    ></v-text-field>

    <button
      :disabled="!valid"
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
    item: {
      type: Object,
      required: true,
    },
  },
  data: () => ({
    valid: true,
    showPassword: false,
    form: {
      old_password: "",
      new_password: "",
      new_password_confirmation: "",
      id: 0,
    },
  }),
  created() {
    this.form.id = this.item.id;
  },
  methods: {
    generatePassword() {
      var chars =
        "0123456789abcdefghijklmnopqrstuvwxyz!@#$%^&*()ABCDEFGHIJKLMNOPQRSTUVWXYZ";
      var passwordLength = 6;
      var password = "";

      for (var i = 0; i <= passwordLength; i++) {
        var randomNumber = Math.floor(Math.random() * chars.length);
        password += chars.substring(randomNumber, randomNumber + 1);
      }
      this.form.new_password = password;
      this.showPassword = true;
    },
    async validate() {
      const response = this.$refs.form.validate();
      if (response) {
        try {
          const { data } = await this.$axios.post(
            `/users/change-password`,
            this.form
          );

          if (data.success) {
            this.toastSuccess(data.message);
            this.$root.$emit("close-modal", {});
          } else {
            this.toastError(data.message);
          }
        } catch (err) {
          if (err.response.data.message) {
            return this.toastError(err.response.data.message);
          }
          this.toastError("Something went wrong!");
        }
      }
    },
  },
};
</script>
