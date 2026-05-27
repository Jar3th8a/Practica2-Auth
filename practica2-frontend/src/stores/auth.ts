import { defineStore } from 'pinia';
import axios from 'axios';

// URL base de tu API de Laravel
const API_URL = 'http://localhost:8000/api';

interface User {
  id: number;
  name: string;
  email: string;
}

export const useAuthStore = defineStore('auth', {
  state: () => ({
    user: null as User | null,
    token: localStorage.getItem('token') || null,
  }),

  getters: {
    isAuthenticated: (state) => !!state.token,
  },

  actions: {
    // Acción para Iniciar Sesión
    async login(credentials: object) {
      try {
        const response = await axios.post(`${API_URL}/login`, credentials);
        this.token = response.data.token;
        this.user = response.data.user;
        localStorage.setItem('token', response.data.token);
        return response.data;
      } catch (error: any) {
        throw error.response?.data || error.message;
      }
    },

    // Acción para Registrar Usuario
    async register(data: object) {
      try {
        const response = await axios.post(`${API_URL}/register`, data);
        this.token = response.data.token;
        this.user = response.data.user;
        localStorage.setItem('token', response.data.token);
        return response.data;
      } catch (error: any) {
        throw error.response?.data || error.message;
      }
    },

    // Acción para Cerrar Sesión
    async logout() {
      try {
        await axios.post(`${API_URL}/logout`);
      } catch (error) {
        console.error('Error al avisar del logout al backend:', error);
      } finally {
        // Limpiamos los datos locales pase lo que pase
        this.user = null;
        this.token = null;
        localStorage.removeItem('token');
      }
    }
  }
});