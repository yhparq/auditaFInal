<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Participante extends Model
{
    protected $fillable = [
        'nombres',
        'apellidos',
        'dni',
        'departamento',
        'provincia',
        'distrito',
        'direccion_actual',
        'tipo_participante',
        'nombre_corporativo',
        'codigo_pago',
        'foto_voucher',
        'comprobante',
        'numero_ruc',
        'estado',
    ];
}
