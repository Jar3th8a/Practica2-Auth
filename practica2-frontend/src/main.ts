import { createApp } from 'vue';
import { createPinia } from 'pinia';
import App from './App.vue';
import router from './router';
import './plugins/axios'; // Inicializa los interceptores globales

const app = createApp(App);

app.use(createPinia());
app.use(router); // Habilita el router en la app

app.mount('#app');