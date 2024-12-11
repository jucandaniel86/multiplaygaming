<template>
  <v-app>
    <div class="container-fluid position-relative d-flex p-0">
      <app-sidebar />

      <div class="content">
        <!-- Navbar Start -->
        <nav class="navbar navbar-expand sticky-top px-4 py-0">
          <a href="#" class="navbar-brand d-flex d-lg-none me-4">
            <h2 class="text-primary mb-0"><i class="fa fa-user-edit"></i></h2>
          </a>
          <a
            href="#"
            class="sidebar-toggler flex-shrink-0"
            @click.prevent="toggleSidebar"
          >
            <i class="fa fa-bars"></i>
          </a>
          <div class="navbar-nav align-items-center ms-auto">
            <div class="nav-item dropdown" v-if="$auth.loggedIn">
              <a
                href="#"
                class="nav-link dropdown-toggle"
                @click="ddOpen = !ddOpen"
              >
                <span class="d-none d-lg-inline-flex">{{
                  $auth.user.name
                }}</span>
              </a>
              <div
                class="dropdown-menu dropdown-menu-end bg-secondary border-0 rounded-0 rounded-bottom m-0"
                :class="{ open: ddOpen }"
              >
                <a href="#" class="dropdown-item" @click.prevent="logout"
                  >Log Out</a
                >
              </div>
            </div>
          </div>
        </nav>
        <!-- Navbar End -->

        <Nuxt />

        <!-- Footer Start -->
        <div class="container-fluid pt-4 px-4">
          <div class="bg-light rounded-top p-4">
            <v-row>
              <v-col cols="12">
                <div class="d-flex justify-end">
                  &copy; <a href="#">{{ $config.APP_NAME }}</a
                  >, All Right Reserved.
                </div>
              </v-col>
            </v-row>
          </div>
        </div>
        <!-- Footer End -->
      </div>

      <!-- Back to Top -->
      <a href="#" class="btn btn-lg btn-primary btn-lg-square back-to-top"
        ><i class="bi bi-arrow-up"></i
      ></a>
    </div>
  </v-app>
</template>
<script>
import AppSidebar from "../components/App.Sidebar";
export default {
  components: { AppSidebar },
  data: () => ({
    ddOpen: false,
  }),
  methods: {
    async logout() {
      try {
        this.$nuxt.$loading.start();
        await this.$auth.logout();
        this.$nuxt.$loading.finish();
        this.$router.push({ name: "auth-login" });
      } catch (err) {
        console.warn("[SYSTEM]", err);
      }
    },
    toggleSidebar() {
      this.$root.$emit("sidebar:toggle");
    },
  },
};
</script>
