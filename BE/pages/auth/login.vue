<template>
  <!-- Sign In Start -->
  <div class="container-fluid">
    <div
      class="row h-100 align-items-center justify-content-center"
      style="min-height: 100vh"
    >
      <div class="col-12 col-sm-8 col-md-6 col-lg-5 col-xl-4">
        <div class="bg-light rounded p-4 p-sm-5 my-4 mx-3">
          <div class="d-flex align-items-center justify-content-between mb-3">
            <a href="javascript:" class="">
              <h3 class="text-primary">
                <i class="fa fa-user-edit me-2"></i>
                {{ $config.APP_NAME }}
                <sup>v.{{ $config.CLIENT_VERSION }}</sup>
              </h3>
            </a>
            <h3>Sign In</h3>
          </div>
          <div class="form-floating mb-3">
            <input
              v-model="form.email"
              type="email"
              class="form-control"
              id="floatingInput"
              placeholder="name@example.com"
            />
            <label for="floatingInput">Email address</label>
          </div>
          <div class="form-floating mb-4">
            <input
              v-model="form.password"
              type="password"
              class="form-control"
              id="floatingPassword"
              placeholder="Password"
            />
            <label for="floatingPassword">Password</label>
          </div>
          <!-- <button type="submit" class="btn btn-primary py-3 w-100 mb-4" @click.prevent="login">Sign In</button> -->
          <button-loading
            @on-click="login"
            :is-loading="isLoading"
            :btn-class="'btn-primary py-3 w-100 mb-4'"
            :icon="'fa-user'"
            :text="'Sign In'"
          />
        </div>
      </div>
    </div>
  </div>
  <!-- Sign In End -->
</template>
 <script>
import ButtonLoading from "../../components/ButtonLoading.vue";

//@todo add global config vars for name and other stuff
export default {
  components: { ButtonLoading },
  middleware: ["guest"],
  layout: "login.layout",
  name: "LoginPage",
  data() {
    return {
      form: {
        email: "",
        password: "",
      },
      isLoading: false,
    };
  },
  methods: {
    async login() {
      this.isLoading = true;
      try {
        const data = await this.$auth.loginWith("local", {
          data: {
            ...this.form,
            client_id: this.$config.passport.clientID,
            client_secret: this.$config.passport.clientSecret,
            grant_type: this.$config.passport.clientGrantType,
          },
        });

        if (this.$auth.loggedIn) {
          this.toastSuccess("Welcome " + this.$auth.user.name);
          this.$router.push({ name: "dashboard" });
        }

        this.isLoading = false;
      } catch (err) {
        if (
          typeof err.response !== "undefined" &&
          typeof err.response.data !== "undefined"
        ) {
          this.isLoading = false;
          return this.toastError(err.response.data.error);
        }
        this.toastError("Invalid Credentials");
        this.isLoading = false;
      }
    },
  },
};
</script>
<style>
body {
  background: #fff;
}
</style>
