<?php

namespace App\Observers;

use App\Models\Participante;
use App\Mail\ParticipanteBienvenida;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;

class ParticipanteObserver
{
    /**
     * Handle the Participante "updated" event.
     */
    public function updated(Participante $participante)
    {
        // Verificar si el estado cambió a 1 (activo)
        if ($participante->isDirty('estado') && $participante->estado == 1) {
            $this->enviarEmailBienvenida($participante);
        }
    }

    /**
     * Enviar email de bienvenida cuando se activa
     */
    private function enviarEmailBienvenida(Participante $participante)
    {
        try {
            // La contraseña es su DNI
            $password = $participante->dni;

            // Enviar email de bienvenida
            Mail::to($participante->correo)->send(new ParticipanteBienvenida($participante, $password));
            
            Log::info("Email de bienvenida enviado a: {$participante->correo} (DNI: {$participante->dni})");

        } catch (\Exception $e) {
            Log::error("Error enviando email a {$participante->correo}: " . $e->getMessage());
        }
    }
}