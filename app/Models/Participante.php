<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;

class Participante extends Authenticatable
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

    // Quitamos el cast boolean para que funcione con 0 y 1
    protected $casts = [
        // 'estado' => 'boolean',
    ];

    // CONFIGURACIÓN DE AUTENTICACIÓN CORRECTA

    /**
     * El campo que se usa como identificador único para LOGIN (username)
     * Esto es solo para indicar qué campo usar en el formulario de login
     */
    public function getAuthIdentifierName()
    {
        return 'id'; // IMPORTANTE: Esto debe ser 'id', no 'correo'
    }

    /**
     * Obtener el identificador único del usuario (para sesiones)
     * Esto DEBE devolver el ID numérico para que las sesiones funcionen
     */
    public function getAuthIdentifier()
    {
        return $this->id; // CORREGIDO: devolver ID, no correo
    }

    /**
     * Obtener la contraseña para autenticación
     */
    public function getAuthPassword()
    {
        return $this->dni; // El DNI es la contraseña
    }

    /**
     * Obtener el campo para búsqueda de usuarios (usado en Auth::attempt)
     * Como usamos login manual, este método es menos importante
     */
    public function getEmailAttribute()
    {
        return $this->correo; // Mapear correo a email para compatibilidad
    }

    // MÉTODOS DE REMEMBER TOKEN

    public function getRememberToken()
    {
        return null; // Simplificado
    }

    public function setRememberToken($value)
    {
        // Simplificado
    }

    public function getRememberTokenName()
    {
        return null; // Simplificado
    }

    // MÉTODOS HELPER ÚTILES

    public function isActivo()
    {
        return $this->estado == 1;
    }

    public function scopeActivos($query)
    {
        return $query->where('estado', 1);
    }

    public function getNombreCompletoAttribute()
    {
        return $this->nombres . ' ' . $this->apellidos;
    }
}