<script setup lang="ts">
import { ref, onMounted } from 'vue'
import axios from 'axios'

const totalProductos = ref(0)
const cargando = ref(true)

onMounted(async () => {
  try {
    const response = await axios.get('/productos')
    totalProductos.value = response.data.length
  } catch (error) {
    console.error('Error al cargar métricas del dashboard:', error)
  } finally {
    cargando.value = false
  }
})
</script>

<template>
  <div class="dashboard-view">
    <h2>📊 Panel de Control</h2>
    <p class="text-muted">Vista general del estado de tu tienda online.</p>

    <div class="metrics-grid">
      <div class="metric-card">
        <div class="card-icon">📦</div>
        <div class="card-info">
          <h3>{{ cargando ? '...' : totalProductos }}</h3>
          <p>Productos en Inventario</p>
        </div>
      </div>

      <div class="metric-card johan-style">
        <div class="card-icon">💰</div>
        <div class="card-info">
          <h3>$12,450.00</h3>
          <p>Ventas del Mes (Simulado)</p>
        </div>
      </div>

      <div class="metric-card">
        <div class="card-icon">👥</div>
        <div class="card-info">
          <h3>4</h3>
          <p>Usuarios del Sistema</p>
        </div>
      </div>
    </div>
  </div>
</template>

<style scoped>
.dashboard-view h2 { color: #111827; margin-bottom: 5px; }
.text-muted { color: #6b7280; margin-bottom: 25px; }

.metrics-grid {
  display: grid;
  grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
  gap: 20px;
}
.metric-card {
  background: white;
  padding: 20px;
  border-radius: 10px;
  border: 1px solid #e5e7eb;
  display: flex;
  align-items: center;
  gap: 15px;
  box-shadow: 0 1px 3px rgba(0,0,0,0.02);
}
.card-icon {
  font-size: 2rem;
  background: #f3f4f6;
  padding: 10px;
  border-radius: 8px;
}
.card-info h3 { margin: 0; font-size: 1.8rem; color: #111827; }
.card-info p { margin: 2px 0 0 0; color: #4b5563; font-size: 14px; }
.johan-style .card-icon { background: #e0f2fe; }
</style>
