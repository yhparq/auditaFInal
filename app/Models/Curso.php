<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Curso extends Model
{
    use HasFactory;

    protected $fillable = [
        'nombre_curso',
        'fecha_curso',
        'hora_inicio',
        'hora_fin',
        'link_reunion',
        'material_pdf',
        'descripcion',
        'activo',
    ];

    protected $casts = [
        'fecha_curso' => 'date',
        'hora_inicio' => 'datetime:H:i',
        'hora_fin' => 'datetime:H:i',
        'activo' => 'boolean',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Get the full URL for the PDF material
     */
    public function getMaterialUrlAttribute()
    {
        return $this->material_pdf ? asset('storage/' . $this->material_pdf) : null;
    }

    /**
     * Get formatted date
     */
    public function getFechaFormateadaAttribute()
    {
        return $this->fecha_curso->format('d/m/Y');
    }

    /**
     * Get formatted time range
     */
    public function getHorarioAttribute()
    {
        if ($this->hora_inicio && $this->hora_fin) {
            return $this->hora_inicio->format('H:i') . ' - ' . $this->hora_fin->format('H:i');
        }
        return $this->hora_inicio ? $this->hora_inicio->format('H:i') : 'Sin horario';
    }

    /**
     * Check if course is today
     */
    public function getEsHoyAttribute()
    {
        return $this->fecha_curso->isToday();
    }

    /**
     * Check if course is upcoming
     */
    public function getEsProximoAttribute()
    {
        return $this->fecha_curso->isFuture();
    }

    /**
     * Check if course is past
     */
    public function getEsPasadoAttribute()
    {
        return $this->fecha_curso->isPast();
    }

    /**
     * Scope para cursos activos
     */
    public function scopeActivos($query)
    {
        return $query->where('activo', true);
    }

    /**
     * Scope para cursos próximos
     */
    public function scopeProximos($query)
    {
        return $query->where('fecha_curso', '>=', now()->toDateString());
    }

    /**
     * Scope para cursos pasados
     */
    public function scopePasados($query)
    {
        return $query->where('fecha_curso', '<', now()->toDateString());
    }
}