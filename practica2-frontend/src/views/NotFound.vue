<template>
  <div class="not-found">
    <h1>404</h1>
    <h2>Página No Encontrada</h2>
    <p>Lo sentimos, la ruta que buscas no existe o fue movida de lugar.</p>
    <router-link to="/" class="btn-home">🔄 Volver al Inicio seguro</router-link>
  </div>
</template>

<style scoped>
.not-found { text-align: center; padding: 100px 20px; font-family: sans-serif; }
h1 { font-size: 6rem; color: #ef4444; margin: 0; }
h2 { font-size: 2rem; color: #1f2937; margin-top: 10px; }
p { color: #6b7280; margin-bottom: 30px; }
.btn-home { background: #4f46e5; color: white; padding: 12px 20px; text-decoration: none; border-radius: 6px; font-weight: bold; }
</style>