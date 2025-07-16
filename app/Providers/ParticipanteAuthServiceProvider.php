<?php

namespace App\Auth;

use Illuminate\Contracts\Auth\UserProvider;
use Illuminate\Contracts\Auth\Authenticatable;
use App\Models\Participante;

class ParticipanteAuthProvider implements UserProvider
{
    public function retrieveById($identifier)
    {
        $participante = Participante::find($identifier);
        return $participante && $participante->estado == 1 ? $participante : null;
    }

    public function retrieveByToken($identifier, $token)
    {
        // Para remember token - simplificado por ahora
        return null;
    }

    public function updateRememberToken(Authenticatable $user, $token)
    {
        // No implementado por simplicidad
    }

    public function retrieveByCredentials(array $credentials)
    {
        if (!isset($credentials['correo'])) {
            return null;
        }

        // Buscar participante activo por correo
        $participante = Participante::where('correo', $credentials['correo'])
            ->where('estado', 1) // Solo participantes activos
            ->first();

        return $participante;
    }

    public function validateCredentials(Authenticatable $user, array $credentials)
    {
        // Validar que la contraseña (DNI) coincida
        return isset($credentials['password']) && $credentials['password'] === $user->dni;
    }

    public function rehashPasswordIfRequired(Authenticatable $user, array $credentials, bool $force = false)
    {
        // No aplica para DNI
    }
}