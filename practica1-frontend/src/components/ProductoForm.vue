<script setup lang="ts">
import { ref, watch, defineProps, defineEmits } from 'vue';
// Cambia la línea 17 para que quede exactamente así:
import { createProducto, updateProducto, type Producto } from '../../productosevice';

const props = defineProps<{
  productoEditando: Producto | null;
}>();

const emit = defineEmits(['actualizarLista', 'cancelarEdicion']);

// Estado inicial del formulario vacío
const formularioInicial = () => ({
  nombre: '',
  descripcion: '',
  precio: 0,
  stock: 0
});

const form = ref<Producto>(formularioInicial());
const mensaje = ref({ texto: '', tipo: '' }); // Para éxitos o errores

// Detectar si cambia el producto a editar (Modo Dual)
watch(() => props.productoEditando, (nuevoValor) => {
  if (nuevoValor) {
    form.value = { ...nuevoValor };
  } else {
    form.value = formularioInicial();
  }
}, { immediate: true });

const guardar = async () => {
  try {
    if (form.value.id) {
      // Modo Editar
      await updateProducto(form.value.id, form.value);
      mensaje.value = { texto: '¡Producto actualizado con éxito!', tipo: 'exito' };
    } else {
      // Modo Crear
      await createProducto(form.value);
      mensaje.value = { texto: '¡Producto creado con éxito!', tipo: 'exito' };
    }
    
    emit('actualizarLista');
    cancelar();
  } catch (error) {
    mensaje.value = { texto: 'Hubo un error al guardar el producto.', tipo: 'error' };
  }
};

const cancelar = () => {
  form.value = formularioInicial();
  emit('cancelarEdicion');
  setTimeout(() => { mensaje.value = { texto: '', tipo: '' }; }, 3000); // Limpia mensaje tras 3 seg
};
</script>

<template>
  <div class="formulario-contenedor">
    <h3>{{ form.id ? 'Editar Producto' : 'Crear Nuevo Producto' }}</h3>
    
    <p v-if="mensaje.texto" :class="mensaje.tipo">{{ mensaje.texto }}</p>

    <form @submit.prevent="guardar">
      <div>
        <label>Nombre:</label>
        <input v-model="form.nombre" type="text" required />
      </div>

      <div>
        <label>Descripción:</label>
        <textarea v-model="form.descripcion"></textarea>
      </div>

      <div>
        <label>Precio:</label>
        <input v-model.number="form.precio" type="number" step="0.01" required />
      </div>

      <div>
        <label>Stock:</label>
        <input v-model.number="form.stock" type="number" required />
      </div>

      <button type="submit">{{ form.id ? 'Actualizar' : 'Guardar' }}</button>
      <button type="button" @click="cancelar" v-if="form.id">Cancelar</button>
    </form>
  </div>
</template>

<style scoped>
.exito { color: green; font-weight: bold; }
.error { color: red; font-weight: bold; }
.formulario-contenedor { margin-bottom: 20px; padding: 15px; border: 1px solid #ccc; border-radius: 5px; }
form div { margin-bottom: 10px; }
label { display: inline-block; width: 100px; }
input, textarea { width: 200px; padding: 4px; }
button { margin-right: 5px; cursor: pointer; }
</style>