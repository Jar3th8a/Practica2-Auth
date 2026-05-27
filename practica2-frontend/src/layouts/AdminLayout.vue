<script setup lang="ts">
import { useAuthStore } from '../stores/auth'
import { useRouter } from 'vue-router'

const authStore = useAuthStore()
const router = useRouter()

// Función para cerrar sesión usando la acción de nuestro Pinia Store
const handleLogout = async () => {
  if (confirm('¿Estás seguro de que deseas salir del panel de administración?')) {
    await authStore.logout()
    router.push({ name: 'login' }) // Al limpiar los datos, lo botamos al Login
  }
}
</script>

<template>
  <div class="admin-container">
    <aside class="sidebar">
      <div class="brand">
        <h3>Admin Panel 🛒</h3>
      </div>
      
      <nav class="menu">
        <router-link to="/admin" exact-active-class="active" class="menu-item">
          📊 Dashboard
        </router-link>
        <router-link to="/admin/productos" exact-active-class="active" class="menu-item">
          📦 Gestionar Productos
        </router-link>
        <hr class="menu-divider" />
        <router-link to="/" class="menu-item public-link">
          🏠 Ver Tienda Pública
        </router-link>
      </nav>
    </aside>

    <div class="main-content">
      <header class="topbar">
        <div class="user-info">
          <span>Bienvenido, <strong>{{ authStore.user?.name || 'Administrador' }}</strong></span>
        </div>
        <button @click="handleLogout" class="btn-logout">
          Cerrar Sesión 🚪
        </button>
      </header>

      <main class="view-container">
        <router-view />
      </main>
    </div>
  </div>
</template>

<style scoped>
.admin-container {
  display: flex;
  min-height: 100vh;
  background-color: #f3f4f6;
  font-family: system-ui, -apple-system, sans-serif;
}

/* Sidebar */
.sidebar {
  width: 260px;
  background-color: #1f2937;
  color: #f9fafb;
  display: flex;
  flex-direction: column;
}
.brand {
  padding: 20px;
  text-align: center;
  background-color: #111827;
  border-bottom: 1px solid #374151;
}
.brand h3 { margin: 0; color: #10b981; }

.menu {
  display: flex;
  flex-direction: column;
  padding: 15px 10px;
  gap: 5px;
}
.menu-item {
  color: #d1d5db;
  text-decoration: none;
  padding: 12px 15px;
  border-radius: 6px;
  font-size: 15px;
  transition: all 0.2s;
}
.menu-item:hover {
  background-color: #374151;
  color: white;
}
.menu-item.active {
  background-color: #4f46e5;
  color: white;
  font-weight: bold;
}
.menu-divider {
  border: 0;
  height: 1px;
  background: #374151;
  margin: 15px 0;
}
.public-link {
  color: #9ca3af;
  font-size: 14px;
}

/* Área de contenido */
.main-content {
  flex-grow: 1;
  display: flex;
  flex-direction: column;
}

/* Topbar */
.topbar {
  background-color: white;
  height: 65px;
  display: flex;
  justify-content: space-between;
  align-items: center;
  padding: 0 30px;
  box-shadow: 0 1px 3px rgba(0,0,0,0.05);
}
.user-info { color: #374151; font-size: 15px; }

.btn-logout {
  background-color: #fee2e2;
  color: #991b1b;
  border: none;
  padding: 8px 15px;
  border-radius: 6px;
  cursor: pointer;
  font-weight: 500;
  transition: background 0.2s;
}
.btn-logout:hover { background-color: #fca5a5; }

/* Contenedor de subvistas */
.view-container {
  padding: 30px;
  flex-grow: 1;
  overflow-y: auto;
}
</style>
