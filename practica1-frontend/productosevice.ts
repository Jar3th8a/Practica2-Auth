import axios from 'axios';

const api = axios.create({
  baseURL: 'http://localhost:8000/api'
});

// Definimos una interfaz básica para estructurar qué es un producto
export interface Producto {
  id?: number;
  nombre: string;   
  descripcion?: string;
  precio: number;
  stock: number;
  created_at?: string;
  updated_at?: string;
}

export const getProductos = () => api.get<Producto[]>('/productos');
export const createProducto = (data: Producto) => api.post<Producto>('/productos', data);
export const updateProducto = (id: number | string, data: Partial<Producto>) => api.put<Producto>(`/productos/${id}`, data);
export const deleteProducto = (id: number | string) => api.delete(`/productos/${id}`);