import axios from 'axios';
import router from '../router'; // Asegúrate de que apunte bien a tu carpeta router

// Configurar la URL base global de Axios para no tener que escribirla siempre
axios.defaults.baseURL = 'http://localhost:8000/api';

// Interceptor de Petición: Inserta el Token automáticamente si existe
axios.interceptors.request.use((config) => {
  const token = localStorage.getItem('token');
  if (token) {
    config.headers.Authorization = `Bearer ${token}`;
  }
  return config;
}, (error) => {
  return Promise.reject(error);
});

// Interceptor de Respuesta: Si el Backend responde 401 (No autorizado), te echa al login
axios.interceptors.response.use(
  (response) => response,
  (error) => {
    if (error.response?.status === 401) {
      localStorage.removeItem('token'); // Limpiamos token vencido
      router.push({ name: 'login' });  // Redirección al login
    }
    return Promise.reject(error);
  }
);