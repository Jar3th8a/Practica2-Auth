<script setup lang="ts">
import { ref } from 'vue'
import { useAuthStore } from '../stores/auth'
import { useRouter } from 'vue-router'

const authStore = useAuthStore()
const router = useRouter()

// Variables reactivas para el formulario
const email = ref('')
const password = ref('')
const error = ref('')
const cargando = ref(false)

// Función explícita para enviar el formulario sin trabas
const handleLogin = async () => {
  // Limpiamos errores previos y activamos estado de carga
  error.value = ''
  cargando.value = true

  // Validación rápida en el cliente antes de disparar Axios
  if (!email.value || !password.value) {
    error.value = 'Por favor, llena todos los campos.'
    cargando.value = false
    return
  }

  try {
    // Disparamos la acción de Pinia enviando las credenciales
    const exito = await authStore.login({
      email: email.value,
      password: password.value
    })

    if (exito) {
      // Si el backend responde OK y Pinia guarda el token, saltamos al Admin Panel
      router.push({ name: 'admin' })
    } else {
      error.value = 'Las credenciales proporcionadas son incorrectas.'
    }
  } catch (err: any) {
    console.error('Error capturado en el login:', err)
    // Mostramos el mensaje exacto que devuelva tu API de Laravel si falla
    if (err.response && err.response.data && err.response.data.message) {
      error.value = err.response.data.message
    } else {
      error.value = 'No se pudo conectar con el servidor. Revisa tu backend.'
    }
  } finally {
    cargando.value = false
  }
}
</script>

<template>
  <div class="login-wrapper">
    <div class="login-card">
      <h2>Tienda - Iniciar Sesión</h2>
      
      <form @submit.prevent="handleLogin">
        
        <div class="form-group">
          <label for="email">Correo Electrónico:</label>
          <input 
            id="email"
            type="email" 
            v-model="email" 
            placeholder="ejemplo@correo.com"
            :disabled="cargando"
            required
          />
        </div>

        <div class="form-group">
          <label for="password">Contraseña:</label>
          <input 
            id="password"
            type="password" 
            v-model="password" 
            placeholder="********"
            :disabled="cargando"
            required
          />
        </div>

        <p v-if="error" class="error-msg">⚠️ {{ error }}</p>

        <button type="submit" class="btn-submit" :disabled="cargando">
          {{ cargando ? 'Verificando datos... ⏳' : 'Ingresar al Sistema' }}
        </button>
      </form>
    </div>
  </div>
</template>

<style scoped>
.login-wrapper {
  display: flex;
  justify-content: center;
  align-items: center;
  min-height: 80vh;
  font-family: system-ui, -apple-system, sans-serif;
}
.login-card {
  background: white;
  padding: 40px;
  border-radius: 12px;
  box-shadow: 0 4px 15px rgba(0, 0, 0, 0.08);
  width: 100%;
  max-width: 450px;
}
h2 {
  text-align: center;
  color: #1f2937;
  margin-bottom: 30px;
  font-size: 1.8rem;
}
.form-group {
  margin-bottom: 20px;
}
label {
  display: block;
  margin-bottom: 6px;
  color: #4b5563;
  font-weight: 600;
}
input {
  width: 100%;
  padding: 12px;
  border: 1px solid #d1d5db;
  border-radius: 6px;
  box-sizing: border-box;
  font-size: 15px;
  outline: none;
  transition: border-color 0.2s;
}
input:focus {
  border-color: #4f46e5;
}
input:disabled {
  background-color: #f3f4f6;
  cursor: not-allowed;
}
.error-msg {
  color: #ef4444;
  font-size: 14px;
  font-weight: 500;
  margin: 15px 0;
  text-align: center;
}
.btn-submit {
  width: 100%;
  padding: 14px;
  background-color: #4f46e5;
  color: white;
  border: none;
  border-radius: 6px;
  font-size: 16px;
  font-weight: bold;
  cursor: pointer;
  transition: background-color 0.2s;
}
.btn-submit:hover:not(:disabled) {
  background-color: #4338ca;
}
.btn-submit:disabled {
  background-color: #9ca3af;
  cursor: not-allowed;
}
</style>