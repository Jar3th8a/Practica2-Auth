import { defineStore } from 'pinia'
import axios from 'axios'

export const useAuthStore = defineStore('auth', {
  state: () => ({
    user: null,
    token: localStorage.getItem('token') || null,
  }),
  actions: {
    async login(credenciales: { email: string; password: string }) {
      try {
        // 🟢 CONFIGURACIÓN DIRECTA: Apuntamos al puerto local de tu Laravel
        const respuesta = await axios.post('http://127.0.0.1:8000/api/login', credenciales)
        
        // Si el backend responde con el token
        if (respuesta.data && respuesta.data.access_token) {
          this.token = respuesta.data.access_token
          this.user = respuesta.data.user
          
          // Guardamos el token en el navegador para los Guards de ruta
          localStorage.setItem('token', respuesta.data.access_token)
          
          return true
        }
        return false
      } catch (error) {
        // Lanza el error para que el LoginView.vue lo cachee en la interfaz
        throw error
      }
    }
  }
})