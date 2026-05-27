import { createRouter, createWebHistory } from 'vue-router';
import { useAuthStore } from '../stores/auth';

// Ejemplo de tus vistas (Asegúrate de tener creados estos componentes o cámbialos por tus componentes reales)
import LoginView from '../components/Login.vue'; 
import DashboardProductos from '../App.vue'; 

const routes = [
  {
    path: '/login',
    name: 'login',
    component: LoginView,
    meta: { requiresAuth: false }
  },
  {
    path: '/productos',
    name: 'productos',
    component: DashboardProductos,
    meta: { requiresAuth: true } // <-- Esta ruta queda protegida
  },
  {
    path: '/:pathMatch(.*)*',
    redirect: '/productos' // Si meten cualquier ruta rara, redirige
  }
];

const router = createRouter({
  history: createWebHistory(import.meta.env.BASE_URL),
  routes
});

// 4.7 Guard de navegación global
router.beforeEach((to, from, next) => {
  const authStore = useAuthStore();

  // Si la ruta requiere autenticación y el usuario no está autenticado...
  if (to.meta.requiresAuth && !authStore.isAuthenticated) {
    next({ name: 'login' }); // Pa' tras, al login.
  } else if (to.name === 'login' && authStore.isAuthenticated) {
    next({ name: 'productos' }); // Si ya está logueado y quiere ir al login, lo mandamos al dashboard
  } else {
    next(); // Continúa normalmente
  }
});

export default router;