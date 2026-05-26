<script setup lang="ts">
import { ref, onMounted, defineEmits } from 'vue';
// Cambia esa línea de importación por esta:
import { getProductos, deleteProducto, type Producto } from '../../productosevice';

const emit = defineEmits(['editarProducto', 'recargarFormulario']);
const productos = ref<Producto[]>([]);
const cargando = ref(true);

// Cargar la lista al iniciar el componente
const cargarProductos = async () => {
  try {
    cargando.value = true;
    const respuesta = await getProductos();
    productos.value = respuesta.data;
  } catch (error) {
    console.error("Error al obtener los productos:", error);
  } finally {
    cargando.value = false;
  }
};

const eliminar = async (id: number | undefined) => {
  if (!id) return;
  if (confirm('¿Estás seguro de eliminar este producto?')) {
    try {
      await deleteProducto(id);
      await cargarProductos(); // Recarga la tabla
      emit('recargarFormulario'); // Limpia el formulario si se estaba editando ese
    } catch (error) {
      alert('Error al intentar eliminar.');
    }
  }
};

onMounted(() => {
  cargarProductos();
});

// Exponer este método para que el archivo padre pueda recargar la tabla
defineExpose({ cargarProductos });
</script>

<template>
  <div>
    <h3>Lista de Productos</h3>
    <p v-if="cargando">Cargando productos...</p>
    
    <table v-else border="1" style="width: 100%; text-align: left; border-collapse: collapse;">
      <thead>
        <tr>
          <th>ID</th>
          <th>Nombre</th>
          <th>Descripción</th>
          <th>Precio</th>
          <th>Stock</th>
          <th>Acciones</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="producto in productos" :key="producto.id">
          <td>{{ producto.id }}</td>
          <td>{{ producto.nombre }}</td>
          <td>{{ producto.descripcion || 'Sin descripción' }}</td>
          <td>${{ producto.precio }}</td>
          <td>{{ producto.stock }}</td>
          <td>
            <button @click="emit('editarProducto', producto)">Editar</button>
            <button @click="eliminar(producto.id)" style="color: red;">Eliminar</button>
          </td>
        </tr>
        <tr v-if="productos.length === 0">
          <td colspan="6" style="text-align: center;">No hay productos registrados.</td>
        </tr>
      </tbody>
    </table>
  </div>
</template>

<style scoped>
th, td { padding: 8px; }
button { margin-right: 5px; cursor: pointer; }
</style>