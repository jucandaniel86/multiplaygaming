<template>
  <v-app>
    <toolbar/>
    <router-view/>
  </v-app>
</template>

<script>
import Toolbar from "../components/core/Toolbar";

export default {
  name: "default",
  components: {Toolbar}
}
</script>

<style scoped>

</style>
