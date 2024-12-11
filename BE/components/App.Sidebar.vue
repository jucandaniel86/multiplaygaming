<template>
  <!-- Sidebar Start -->
  <div class="sidebar pe-4 pb-3" :class="{ open: isOpen }">
    <nav class="navbar navbar-light">
      <a href="index.html" class="navbar-brand pa-2">
        <h3 class="text-primary app-name">
          <i class="fa fa-user-edit me-2"></i>
          {{ $config.APP_NAME }}
          <sup>v.{{ $config.CLIENT_VERSION }}</sup>
        </h3>
      </a>
      <div class="d-flex align-items-center ms-4 mb-4">
        <div class="position-relative">
          <img
            class="rounded-circle"
            src="../assets/imgs/user.png"
            alt=""
            style="width: 40px; height: 40px"
          />
          <div
            class="bg-success rounded-circle border border-2 border-white position-absolute end-0 bottom-0 p-1"
          ></div>
        </div>
        <div class="ms-3" v-if="$auth.loggedIn">
          <h6 class="mb-0">{{ $auth.user.name }}</h6>
          <v-chip-group mandatory>
            <v-chip
              v-for="(role, i) in $auth.user.roles"
              :key="`role${i}`"
              x-small
              pill
              >{{ role.name }}</v-chip
            >
          </v-chip-group>
        </div>
      </div>
      <div class="navbar-nav w-100" v-if="routes.length">
        <div v-for="(route, i) in routes" :key="`Route${i}`">
          <nuxt-link
            v-if="route.path"
            :to="{ name: route.path }"
            class="nav-item nav-link"
          >
            <i :class="route.icon"></i> {{ route.label }}
          </nuxt-link>
          <div v-else-if="route.child.length" class="nav-item dropdown">
            <a
              href="#"
              class="nav-link dropdown-toggle"
              @click.prevent="setPath(route.id)"
            >
              <i :class="route.icon"></i> {{ route.label }}
            </a>
            <div
              class="dropdown-menu bg-transparent border-0"
              :class="{ open: route.id === currentPath }"
            >
              <nuxt-link
                v-for="(link, index) in route.child"
                :to="{ name: link.path }"
                :key="`AppLink${index}`"
                class="dropdown-item"
              >
                {{ link.label }}
              </nuxt-link>
            </div>
          </div>
          <a v-else href="#" class="nav-item nav-link">
            <i :class="route.icon"></i>{{ route.label }}
          </a>
        </div>
      </div>
    </nav>
  </div>
  <!-- Sidebar End -->
</template>
<script>
import { ADMIN_MENU } from "../config/Sidebar";
export default {
  name: "AppSidebar",
  data() {
    return {
      routes: ADMIN_MENU,
      isOpen: false,
      currentPath: "",
    };
  },
  mounted() {
    this.$root.$on("sidebar:toggle", this.toggleIsOpen);
  },
  methods: {
    setPath(path) {
      if (path === this.currentPath) {
        this.currentPath = "";
        return false;
      }
      this.currentPath = path;
    },
    toggleIsOpen() {
      this.isOpen = !this.isOpen;
    },
  },
};
</script>
<style scoped>
.app-name {
  font-size: 1.5rem;
}
.app-name sup {
  font-size: 0.8rem;
}
</style>
