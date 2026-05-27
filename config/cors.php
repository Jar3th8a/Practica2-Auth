<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Cross-Origin Resource Sharing (CORS) Configuration
    |--------------------------------------------------------------------------
    |
    | Here you may configure your settings for cross-origin resource sharing
    | or "CORS". This determines what cross-origin operations may execute
    | in web browsers. You are free to adjust these settings as needed.
    |
    */

    // 🟢 Indicamos que todas las rutas API tengan reglas CORS habilitadas
    'paths' => ['api/*', 'sanctum/csrf-cookie'],

    // 🟢 Permitimos todos los métodos de envío (POST, GET, PUT, DELETE)
    'allowed_methods' => ['*'],

    // 🟢 IMPORTANTE: Permitimos explícitamente el origen de tu servidor de Vue
    'allowed_origins' => [
        'http://localhost:5173',
        'http://127.0.0.1:5173'
    ],

    'allowed_origins_patterns' => [],

    // 🟢 Permitimos que viajen todas las cabeceras estándar (Content-Type, Authorization, etc.)
    'allowed_headers' => ['*'],

    'exposed_headers' => [],

    'max_age' => 0,

    // 🟢 CRUCIAL PARA SANCTUM: Habilitamos el soporte de credenciales y tokens
    'supports_credentials' => true,

];