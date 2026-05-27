<script setup lang="ts">
// Aquí más adelante podrás importar tu <ProductoForm /> y <ProductoList />
import { ref } from 'vue'

const mensaje = ref('Zona de Administración del catálogo de productos.')
</script>

<template>
  <div class="admin-productos-view">
    <div class="header-section">
      <div>
        <h2>📦 Gestión de Inventario</h2>
        <p class="text-muted">{{ mensaje }}</p>
      </div>
    </div>

    <div class="crud-placeholder">
      <div class="placeholder-content">
        <p>🛸 Aquí va tu CRUD de productos (Formulario y Lista de la Práctica 1)</p>
        <span class="tip">Tip: Al estar dentro del AdminLayout, todo este módulo ya está protegido automáticamente por token.</span>
      </div>
    </div>
  </div>
</template>

<style scoped>
.header-section {
  display: flex;
  justify-content: space-between;
  align-items: center;
  margin-bottom: 25px;
}
.header-section h2 { color: #111827; margin: 0; }
.text-muted { color: #6b7280; margin: 5px 0 0 0; }

.crud-placeholder {
  background: white;
  border: 2px dashed #d1d5db;
  border-radius: 12px;
  padding: 60px 20px;
  text-align: center;
}
.placeholder-content p {
  font-size: 18px;
  font-weight: 500;
  color: #4b5563;
  margin-bottom: 10px;
}
.tip {
  font-size: 13px;
  color: #9ca3af;
  background: #f9fafb;
  padding: 4px 10px;
  border-radius: 4px;
}
</style>
