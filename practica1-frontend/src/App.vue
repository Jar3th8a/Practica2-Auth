<script setup lang="ts">
import { ref } from 'vue';
import ProductoForm from './components/ProductoForm.vue';
import ProductoList from './components/ProductoList.vue';
// Apuntamos al archivo real tuyo que se llama productosevice sin la r
import type { Producto } from './productosevice'; 

const listaRef = ref();
const productoEditando = ref<Producto | null>(null);

const seleccionarProducto = (producto: Producto) => {
  productoEditando.value = producto;
};

const limpiarEdicion = () => {
  productoEditando.value = null;
};

const refrescarTabla = () => {
  listaRef.value?.cargarProductos();
};
</script>

<template>
  <div style="padding: 20px; max-width: 800px; margin: 0 auto; background-color: white; color: black;">
    <h1>Gestión de Productos</h1>
    <hr />
    
    <ProductoForm 
      :productoEditando="productoEditando" 
      @actualizarLista="refrescarTabla" 
      @cancelarEdicion="limpiarEdicion"
    />
    
    <ProductoList 
      ref="listaRef" 
      @editarProducto="seleccionarProducto"
      @recargarFormulario="limpiarEdicion"
    />
  </div>
</template>