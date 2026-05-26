<?php

namespace App\Http\Controllers;

use App\Models\Producto; // Asegúrate de que tu modelo se llame así
use Illuminate\Http\Request;

class ProductoController extends Controller
{
    /**
     * Display a listing of the resource.
     * Código 200: OK
     */
    public function index()
    {
        $productos = Producto::all();
        return response()->json($productos, 200);
    }

    /**
     * Store a newly created resource in storage.
     * Código 201: Created
     */
    public function store(Request $request)
    {
        // Validación básica
        $validated = $request->validate([
            'nombre' => 'required|string|max:255',
            'descripcion' => 'nullable|string',
            'precio' => 'required|numeric',
            'stock' => 'required|integer',
        ]);

        $producto = Producto::create($validated);

        return response()->json($producto, 201);
    }

    /**
     * Display the specified resource.
     * Código 200: OK | Código 404: Not Found
     */
    public function show(string $id)
    {
        $producto = Producto::find($id);

        if (!$producto) {
            return response()->json(['message' => 'Producto no encontrado'], 404);
        }

        return response()->json($producto, 200);
    }

    /**
     * Update the specified resource in storage.
     * Código 200: OK | Código 404: Not Found
     */
    public function update(Request $request, string $id)
    {
        $producto = Producto::find($id);

        if (!$producto) {
            return response()->json(['message' => 'Producto no encontrado'], 404);
        }

        $validated = $request->validate([
            'nombre' => 'sometimes|required|string|max:255',
            'descripcion' => 'nullable|string',
            'precio' => 'sometimes|required|numeric',
            'stock' => 'sometimes|required|integer',
        ]);

        $producto->update($validated);

        return response()->json($producto, 200);
    }

    /**
     * Remove the specified resource from storage.
     * Código 204: No Content | Código 404: Not Found
     */
    public function destroy(string $id)
    {
        $producto = Producto::find($id);

        if (!$producto) {
            return response()->json(['message' => 'Producto no encontrado'], 404);
        }

        $producto->delete();

        // 204 No Content no devuelve cuerpo de texto, es el estándar para deletes exitosos
        return response()->json(null, 204); 
    }
}