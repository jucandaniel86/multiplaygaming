<template>
  <div class="logo">
    <RouterLink :to="{ name: 'ca.index' }">
      <div class="d-flex justify-center">
        <img src="./logo.png" style="max-height: 55px;"/>
      </div>
    </RouterLink>
  </div>
</template>
<script setup>
import {RouterLink} from 'vue-router';


</script>
