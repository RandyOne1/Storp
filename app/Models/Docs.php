<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Doc extends Model
{
    use HasFactory;

    protected $fillable = [
        'Id',
        'existencia',
        'status',
        'titulo',
        'año',
        'mes',
        'tipo',
        'integrantes',
        'asesores',
        'nombrealumno',
        'liderdeequipo',
        'porcentajeavance',
        'matricula',
        'categoria',
        'carrera',
        'empresa',
        'descripcion',
        'ubicacion_archivo',
        'u_vistaprevia',
        'rservicio',
        'restancias',
        'poster',
    ];

    // Definir la relación con el usuario
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
