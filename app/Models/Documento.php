<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Documento extends Model
{
    use HasFactory;
    protected $table = 'docs';
    protected $primaryKey = 'Id'; // Ajusta el nombre de la tabla según tu base de datos
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
    public function users()
    {
        return $this->hasMany(User::class);
    }
}
