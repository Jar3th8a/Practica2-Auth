<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Producto extends Model
{
    use HasFactory;

    // Agrega esta propiedad de asignación masiva obligatoria:
    protected $fillable = [
        'nombre',
        'descripcion',
        'precio',
        'stock',
    ];
}