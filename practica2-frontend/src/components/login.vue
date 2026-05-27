<script setup lang="ts">
import { ref } from 'vue'
import { useAuthStore } from '../stores/auth'
import { useRouter } from 'vue-router'

const authStore = useAuthStore()
const router = useRouter()

const email = ref('')
const password = ref('')
const errorMessage = ref('')

const handleLogin = async () => {
  try {
    errorMessage.value = ''
    await authStore.login({ email: email.value, password: password.value })
    router.push({ name: 'productos' }) // Si entra, lo manda al CRUD
  } catch (error: any) {
    errorMessage.value = error.message || 'Credenciales inválidas'
  }
}
</script>

<template>
  <div class="login-box">
    <h2>Iniciar Sesión</h2>
    <form @submit.prevent="handleLogin">
      <div class="input-group">
        <label>Correo:</label>
        <input type="email" v-model="email" required />
      </div>
      <div class="input-group">
        <label>Contraseña:</label>
        <input type="password" v-model="password" required />
      </div>
      <button type="submit">Ingresar</button>
      <p v-if="errorMessage" class="error">{{ errorMessage }}</p>
    </form>
  </div>
</template>

<style scoped>
.login-box {
  max-width: 350px;
  margin: 50px auto;
  padding: 20px;
  background: white;
  border-radius: 8px;
  box-shadow: 0 4px 10px rgba(0,0,0,0.1);
}
.input-group { margin-bottom: 15px; }
.input-group label { display: block; margin-bottom: 5px; }
.input-group input { width: 100%; padding: 8px; box-sizing: border-box; }
button { width: 100%; padding: 10px; background: #42b883; color: white; border: none; border-radius: 4px; cursor: pointer; }
.error { color: red; margin-top: 10px; }
</style>