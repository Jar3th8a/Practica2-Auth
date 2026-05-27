<script setup lang="ts">
import { ref, computed, onMounted } from 'vue'
import axios from 'axios'

interface Producto {
  id: number;
  nombre: string;
  precio: number;
  descripcion: string;
  stock: number;
}

const productos = ref<Producto[]>([])
const busqueda = ref('')
const cargando = ref(true)

// Al montar el componente, jalamos todos los productos de la API
onMounted(async () => {
  try {
    const response = await axios.get('/productos')
    productos.value = response.data
  } catch (error) {
    console.error('Error al cargar el catálogo:', error)
  } finally {
    cargando.value = false
  }
})

// 4.4 Filtrado reactivo en el cliente usando un computed property
const productosFiltrados = computed(() => {
  return productos.value.filter(producto =>
    producto.nombre.toLowerCase().includes(busqueda.value.toLowerCase()) ||
    producto.descripcion.toLowerCase().includes(busqueda.value.toLowerCase())
  )
})
</script>

<template>
  <div class="catalogo-container">
    <h2>Catálogo de Productos</h2>
    <p class="subtitle">Encuentra lo que buscas al instante</p>

    <div class="search-bar">
      <input 
        type="text" 
        v-model="busqueda" 
        placeholder="🔍 Buscar producto por nombre o descripción..."
      />
    </div>

    <div v-if="cargando" class="status-msg">
      Cargando catálogo de productos...
    </div>

    <div v-else-if="productosFiltrados.length === 0" class="status-msg empty">
      No se encontraron productos que coincidan con "{{ busqueda }}".
    </div>

    <div v-else class="products-grid">
      <div v-for="producto in productosFiltrados" :key="producto.id" class="product-card">
        <div class="card-content">
          <h3>{{ producto.nombre }}</h3>
          <p class="description">{{ producto.descripcion }}</p>
          <div class="meta-info">
            <span class="price">${{ producto.precio }}</span>
            <span class="stock" :class="{ 'low-stock': producto.stock <= 5 }">
              Stock: {{ producto.stock }} u.
            </span>
          </div>
        </div>
        
        <router-link :to="`/catalogo/${producto.id}`" class="btn-detail">
          Ver Detalles →
        </router-link>
      </div>
    </div>
  </div>
</template>

<style scoped>
.catalogo-container {
  max-width: 1200px;
  margin: 0 auto;
  padding: 20px;
}
h2 { color: #1f2937; margin-bottom: 5px; }
.subtitle { color: #6b7280; margin-bottom: 25px; }

/* Buscador */
.search-bar {
  margin-bottom: 30px;
}
.search-bar input {
  width: 100%;
  padding: 14px 20px;
  font-size: 16px;
  border: 2px solid #e5e7eb;
  border-radius: 8px;
  box-sizing: border-box;
  outline: none;
  transition: border-color 0.2s;
}
.search-bar input:focus {
  border-color: #4f46e5;
}

/* Grid y tarjetas */
.products-grid {
  display: grid;
  grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
  gap: 24px;
}
.product-card {
  background: white;
  border: 1px solid #e5e7eb;
  border-radius: 10px;
  box-shadow: 0 2px 5px rgba(0,0,0,0.02);
  display: flex;
  flex-direction: column;
  justify-content: space-between;
  overflow: hidden;
  transition: transform 0.2s, box-shadow 0.2s;
}
.product-card:hover {
  transform: translateY(-4px);
  box-shadow: 0 10px 15px rgba(0,0,0,0.05);
}
.card-content {
  padding: 20px;
}
.product-card h3 {
  margin-top: 0;
  color: #111827;
  font-size: 1.2rem;
}
.description {
  color: #4b5563;
  font-size: 14px;
  line-height: 1.5;
  margin-bottom: 20px;
}
.meta-info {
  display: flex;
  justify-content: space-between;
  align-items: center;
}
.price {
  font-size: 20px;
  font-weight: bold;
  color: #4f46e5;
}
.stock {
  font-size: 12px;
  background: #e0f2fe;
  color: #0369a1;
  padding: 4px 8px;
  border-radius: 12px;
  font-weight: 600;
}
.stock.low-stock {
  background: #fee2e2;
  color: #b91c1c;
}

/* Botón */
.btn-detail {
  display: block;
  text-align: center;
  background: #f9fafb;
  color: #4f46e5;
  padding: 12px;
  text-decoration: none;
  font-weight: bold;
  font-size: 14px;
  border-top: 1px solid #e5e7eb;
  transition: background 0.2s, color 0.2s;
}
.btn-detail:hover {
  background: #4f46e5;
  color: white;
}

.status-msg {
  text-align: center;
  padding: 40px;
  color: #6b7280;
  font-size: 16px;
}
.status-msg.empty {
  background: #f9fafb;
  border-radius: 8px;
  border: 1px dashed #d1d5db;
}
</style>