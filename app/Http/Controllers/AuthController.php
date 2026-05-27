<?php

namespace App\Http\Controllers;

use App\Models\User; // <-- IMPORTANTE: Usa tu modelo explícito
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    /**
     * Maneja el inicio de sesión seguro y retorna el token de Sanctum.
     */
    public function login(Request $request)
    {
        // 1. Validamos los campos que llegan desde Vue
        $validator = Validator::make($request->all(), [
            'email'    => 'required|email',
            'password' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors()
            ], 422);
        }

        // 2. Buscamos al usuario directamente en la tabla users
        $user = User::where('email', $request->email)->first();

        // 3. Verificamos si existe el usuario y si la contraseña coincide
        if (!$user || !Hash::check($request->password, $user->password)) {
            return response()->json([
                'message' => 'Las credenciales proporcionadas son incorrectas.'
            ], 401);
        }

        // 4. Verificación de seguridad extrema antes de emitir el token
        if (!method_exists($user, 'createToken')) {
            return response()->json([
                'message' => 'Error de configuración: El modelo User no tiene el trait HasApiTokens.'
            ], 500);
        }

        // 5. Generamos el token de Sanctum de forma directa
        $token = $user->createToken('auth_token')->plainTextToken;

        // 6. Respondemos al frontend con éxito
        return response()->json([
            'access_token' => $token,
            'token_type'   => 'Bearer',
            'user'         => [
                'id'    => $user->id,
                'name'  => $user->name,
                'email' => $user->email,
            ]
        ], 200);
    }

    /**
     * Destruye los tokens del usuario al cerrar sesión.
     */
    public function logout(Request $request)
    {
        // Borramos el token activo de la petición
        $request->user()->currentAccessToken()->delete();

        return response()->json([
            'message' => 'Sesión cerrada correctamente'
        ], 200);
    }
}