<script setup lang="ts">
import { ref, onMounted } from 'vue'
import axios from 'axios'

// Estructura básica de un producto para TypeScript
interface Producto {
  id: number;
  nombre: string;
  precio: number;
  descripcion: string;
}

const ultimosProductos = ref<Producto[]>([])
const cargando = ref(true)

onMounted(async () => {
  try {
    // Petición a tu API de Laravel para obtener los productos
    const response = await axios.get('/productos')
    
    // Obtenemos únicamente los últimos 3 productos del arreglo
    const todos = response.data
    ultimosProductos.value = todos.slice(-3).reverse()
  } catch (error) {
    console.error('Error al cargar los productos en el Home:', error)
  } finally {
    cargando.value = false
  }
})
</script>

<template>
  <div class="home-container">
    <header class="hero">
      <h1>Bienvenido a Nuestra Tienda Online</h1>
      <p>Descubre los mejores productos con la mejor calidad del mercado.</p>
      <router-link to="/catalogo" class="btn-primary">Ver Catálogo Completo</router-link>
    </header>

    <section class="featured-section">
      <h2>Novedades Destacadas</h2>
      
      <div v-if="cargando" class="loading">Cargando novedades...</div>
      
      <div v-else-if="ultimosProductos.length === 0" class="no-products">
        No hay productos disponibles en este momento.
      </div>

      <div v-else class="products-grid">
        <div v-for="producto in ultimosProductos" :key="producto.id" class="product-card">
          <h3>{{ producto.nombre }}</h3>
          <p class="description">{{ producto.descripcion }}</p>
          <p class="price">${{ producto.precio }}</p>
          <router-link :to="`/catalogo/${producto.id}`" class="btn-secondary">
            Ver Detalle
          </router-link>
        </div>
      </div>
    </section>
  </div>
</template>

<style scoped>
.home-container {
  max-width: 1200px;
  margin: 0 auto;
  padding: 20px;
}
.hero {
  background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
  color: white;
  text-align: center;
  padding: 60px 20px;
  border-radius: 12px;
  margin-bottom: 40px;
}
.hero h1 { font-size: 2.5rem; margin-bottom: 10px; }
.hero p { font-size: 1.2rem; margin-bottom: 25px; }

.btn-primary {
  background-color: #42b883;
  color: white;
  padding: 12px 24px;
  text-decoration: none;
  font-weight: bold;
  border-radius: 6px;
  transition: background 0.2s;
}
.btn-primary:hover { background-color: #33a06f; }

.featured-section h2 {
  text-align: center;
  color: #333;
  margin-bottom: 30px;
}
.products-grid {
  display: grid;
  grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
  gap: 20px;
}
.product-card {
  background: white;
  padding: 20px;
  border-radius: 8px;
  box-shadow: 0 4px 6px rgba(0,0,0,0.05);
  border: 1px solid #eee;
  display: flex;
  flex-direction: column;
  justify-content: space-between;
}
.product-card h3 { margin-top: 0; color: #2c3e50; }
.description { color: #666; font-size: 14px; flex-grow: 1; }
.price { font-size: 18px; font-weight: bold; color: #4f46e5; margin: 15px 0; }

.btn-secondary {
  text-align: center;
  background: #f3f4f6;
  color: #1f2937;
  padding: 8px;
  text-decoration: none;
  border-radius: 4px;
  font-weight: 500;
  transition: background 0.2s;
}
.btn-secondary:hover { background: #e5e7eb; }
.loading, .no-products { text-align: center; color: #666; padding: 20px; }
</style>