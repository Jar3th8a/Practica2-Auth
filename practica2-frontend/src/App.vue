<script setup lang="ts">
import { RouterView } from 'vue-router'
</script>

<template>
  <div class="app-container">
    <RouterView />
  </div>
</template>

<style>
/* Estilos globales rápidos opcionales */
body {
  margin: 0;
  font-family: Arial, sans-serif;
  background-color: #f9f9f9;
}
.app-container {
  padding: 20px;
}
</style>