<script setup lang="ts">
import { ref, onMounted } from 'vue'
import { useRouter } from 'vue-router'
import axios from 'axios'

// Definimos las props. El ':id' de la ruta llega automáticamente como string o número
const props = defineProps<{
  id: string | number
}>()

interface Producto {
  id: number;
  nombre: string;
  descripcion: string;
  precio: number;
  stock: number;
}

const producto = ref<Producto | null>(null)
const cargando = ref(true)
const errorMsg = ref('')

const router = useRouter()

onMounted(async () => {
  try {
    // Hacemos la petición GET dinámica usando la prop id
    const response = await axios.get(`/productos/${props.id}`)
    producto.value = response.data
  } catch (error: any) {
    console.error('Error al cargar el detalle del producto:', error)
    errorMsg.value = 'El producto no existe o hubo un problema al cargar los detalles.'
  } finally {
    cargando.value = false
  }
})

// 4.5 Función para regresar usando el historial del navegador
const volver = () => {
  router.back()
}
</script>

<template>
  <div class="detalle-container">
    <button @click="volver" class="btn-back">
      ← Volver al catálogo
    </button>

    <div v-if="cargando" class="status-card loading">
      Cargando información del producto...
    </div>

    <div v-else-if="errorMsg" class="status-card error">
      <p>{{ errorMsg }}</p>
      <router-link to="/catalogo" class="btn-link">Ir al catálogo principal</router-link>
    </div>

    <div v-else-if="producto" class="product-detail-card">
      <div class="info-header">
        <h1>{{ producto.nombre }}</h1>
        <span class="badge-id">Ref ID: #{{ producto.id }}</span>
      </div>
      
      <hr class="divider" />

      <div class="info-body">
        <p class="label">Descripción del producto:</p>
        <p class="description">{{ producto.descripcion }}</p>

        <div class="meta-grid">
          <div class="meta-item">
            <span class="meta-label">Precio</span>
            <span class="meta-value price">${{ producto.precio }}</span>
          </div>
          
          <div class="meta-item">
            <span class="meta-label">Disponibilidad</span>
            <span class="meta-value stock" :class="{ 'no-stock': producto.stock === 0 }">
              {{ producto.stock > 0 ? `${producto.stock} unidades` : 'Agotado' }}
            </span>
          </div>
        </div>
      </div>

      <div class="info-footer">
        <button class="btn-cart" :disabled="producto.stock === 0">
          {{ producto.stock > 0 ? 'Añadir al carrito 🛒' : 'No disponible' }}
        </button>
      </div>
    </div>
  </div>
</template>

<style scoped>
.detalle-container {
  max-width: 800px;
  margin: 30px auto;
  padding: 0 20px;
}

/* Botón volver */
.btn-back {
  background: none;
  border: none;
  color: #4f46e5;
  font-size: 16px;
  font-weight: bold;
  cursor: pointer;
  margin-bottom: 20px;
  padding: 5px 0;
  transition: color 0.2s;
}
.btn-back:hover {
  color: #4338ca;
  text-decoration: underline;
}

/* Tarjeta principal */
.product-detail-card {
  background: white;
  border: 1px solid #e5e7eb;
  border-radius: 12px;
  box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
  padding: 30px;
}
.info-header {
  display: flex;
  justify-content: space-between;
  align-items: center;
  flex-wrap: wrap;
  gap: 10px;
}
.info-header h1 {
  margin: 0;
  color: #111827;
  font-size: 2rem;
}
.badge-id {
  background: #f3f4f6;
  color: #4b5563;
  padding: 4px 10px;
  border-radius: 20px;
  font-size: 13px;
  font-weight: 500;
}
.divider {
  border: 0;
  height: 1px;
  background: #e5e7eb;
  margin: 20px 0;
}

/* Cuerpo de información */
.label {
  color: #6b7280;
  font-size: 14px;
  font-weight: 600;
  text-transform: uppercase;
  margin-bottom: 5px;
}
.description {
  color: #374151;
  font-size: 16px;
  line-height: 1.6;
  margin-bottom: 30px;
}

/* Grid de detalles */
.meta-grid {
  display: grid;
  grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
  gap: 20px;
  background: #f9fafb;
  padding: 20px;
  border-radius: 8px;
  margin-bottom: 30px;
}
.meta-item {
  display: flex;
  flex-direction: column;
}
.meta-label {
  font-size: 13px;
  color: #6b7280;
  margin-bottom: 4px;
}
.meta-value {
  font-size: 22px;
  font-weight: bold;
}
.meta-value.price {
  color: #4f46e5;
}
.meta-value.stock {
  color: #10b981;
}
.meta-value.stock.no-stock {
  color: #ef4444;
}

/* Botón carrito */
.btn-cart {
  width: 100%;
  padding: 14px;
  background: #4f46e5;
  color: white;
  border: none;
  border-radius: 8px;
  font-size: 16px;
  font-weight: bold;
  cursor: pointer;
  transition: background 0.2s;
}
.btn-cart:hover:not(:disabled) {
  background: #4338ca;
}
.btn-cart:disabled {
  background: #d1d5db;
  color: #9ca3af;
  cursor: not-allowed;
}

/* Estados */
.status-card {
  text-align: center;
  padding: 40px;
  background: white;
  border-radius: 12px;
  border: 1px solid #e5e7eb;
  color: #6b7280;
}
.status-card.error {
  border-color: #fee2e2;
  color: #991b1b;
}
.btn-link {
  display: inline-block;
  margin-top: 15px;
  color: #4f46e5;
  text-decoration: none;
  font-weight: 500;
}
</style>