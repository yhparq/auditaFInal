<?php

// app/Models/Asistencia.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Asistencia extends Model
{
    use HasFactory;

    protected $table = 'asistencias';

    protected $fillable = [
        'participante_id',
        'nombres',
        'apellidos',
        'dni',
        'tipo_participante_categoria',
        'fecha',
        'hora'
    ];

    protected $casts = [
        'fecha' => 'date',
        'hora' => 'datetime:H:i:s',
    ];

    // Relación con Participante
    public function participante()
    {
        return $this->belongsTo(Participante::class);
    }

    // Accessor para nombre completo
    public function getNombreCompletoAttribute()
    {
        return $this->nombres . ' ' . $this->apellidos;
    }
}
