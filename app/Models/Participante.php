<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Participante extends Model
{
    protected $fillable = [
        'nombres',
        'apellidos',
        'dni',
        'correo',
        'celular',
        'colegio_departamental',
        'departamento',
        'provincia',
        'distrito',
        'direccion_actual',
        'tipo_participante',
        'tipo_participante_categoria',
        'modalidad_participacion',
        'nombre_corporativo',
        'codigo_pago',
        'foto_voucher',
        'comprobante',
        'numero_ruc',
        'estado',
    ];

    protected $casts = [
        'estado' => 'boolean',
    ];
}