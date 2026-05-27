<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User; // <-- IMPORTANTE: Faltaba importar el modelo User
use Illuminate\Support\Facades\Hash; // <-- IMPORTANTE: Para verificar y encriptar contraseñas
use Illuminate\Support\Facades\Auth; // <-- IMPORTANTE: Para manejar la autenticación

class AuthController extends Controller
{
    // register() - Valida y crea el usuario, retorna token
    public function register(Request $request) {
        $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|unique:users',
            'password' => 'required|min:8|confirmed', // Espera que mandes 'password_confirmation'
        ]);

        // Es vital usar Hash::make para que la contraseña no se guarde en texto plano
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        $token = $user->createToken('auth-token')->plainTextToken;

        return response()->json(['token' => $token, 'user' => $user], 201);
    }
     
    // login() - Verifica credenciales y retorna token
    public function login(Request $request) {
        $request->validate([
            'email'    => 'required|email',
            'password' => 'required',
        ]);

        // Buscamos si el usuario existe
        $user = User::where('email', $request->email)->first();

        // Verificamos si existe y si la contraseña coincide con el Hash de la BD
        if (!$user || !Hash::check($request->password, $user->password)) {
            return response()->json([
                'message' => 'Las credenciales proporcionadas son incorrectas.'
            ], 401);
        }

        // Generamos el nuevo token
        $token = $user->createToken('auth-token')->plainTextToken;

        return response()->json(['token' => $token, 'user' => $user], 200);
    }

    // logout() - Elimina el token actual (requiere middleware auth:sanctum)
    public function logout(Request $request) {
        // Revoca (elimina) el token que el usuario usó para hacer esta petición
        $request->user()->currentAccessToken()->delete();

        return response()->json(['message' => 'Sesión cerrada con éxito.'], 200);
    }

    // me() - Retorna el usuario autenticado (requiere middleware auth:sanctum)
    public function me(Request $request) {
        // Retorna la información del usuario que tiene el token activo
        return response()->json($request->user(), 200);
    }
}