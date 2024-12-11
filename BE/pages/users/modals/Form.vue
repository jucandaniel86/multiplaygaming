<template>
  <v-form
    ref="form"
    v-model="valid"
    class="custom-form"
    lazy-validation
    data-app
    autocomplete="off"
  >
    <v-text-field
      v-model="form.name"
      :rules="[rules.required]"
      label="Name"
    ></v-text-field>

    <v-text-field
      v-model="form.email"
      :rules="[rules.required]"
      label="Email"
      autocomplete="off"
    ></v-text-field>

    <selector-roles v-model="form.roles" :default-value="form.roles" />

    <div v-if="Object.entries(item).length === 0">
      <v-btn elevation="2" small @click="generatePassword">
        Random password
      </v-btn>
      <v-text-field
        v-model="form.password"
        :append-icon="showPassword ? 'mdi-eye' : 'mdi-eye-off'"
        :rules="[rules.required, rules.min]"
        :type="showPassword ? 'text' : 'password'"
        name="input-10-1"
        label="Password"
        hint="At least 8 characters"
        counter
        @click:append="showPassword = !showPassword"
      ></v-text-field>
    </div>

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
      type: Object | null,
      required: false,
      default: () => null,
    },
  },
  data: () => ({
    valid: true,
    showPassword: false,
    form: {
      name: "",
      email: "",
      password: "",
      id: 0,
      roles: [],
    },
    rules: {
      required: (value) => !!value || "Required.",
      min: (v) => String(v).length >= 6 || "Min 8 characters",
    },
  }),
  created() {
    this.form = { ...this.item };
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
      this.form.password = password;
      this.showPassword = true;
    },
    async validate() {
      const response = this.$refs.form.validate();
      const action = typeof this.item.id !== "undefined" ? "update" : "save";
      if (response) {
        try {
          const { data } = await this.$axios.post(
            `/users/${action}`,
            this.form
          );

          if (data.success) {
            this.toastSuccess(data.message);
            this.$root.$emit("close-modal", {});
          }
        } catch (err) {
          this.toastError("Something went wrong!");
        }
      }
    },
  },
};
</script>
