<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Mail\Mailables\Address;
use Illuminate\Queue\SerializesModels;
use App\Models\Participante;

class ParticipanteBienvenida extends Mailable
{
    use Queueable, SerializesModels;

    public $participante;
    public $password;

    /**
     * Create a new message instance.
     */
    public function __construct(Participante $participante, string $password)
    {
        $this->participante = $participante;
        $this->password = $password;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: '¡Bienvenido al Aula Virtual AUDITA 2025!',
            from: new Address(
                address: env('MAIL_FROM_ADDRESS', 'opsdev086@gmail.com'),
                name: 'AUDITA 2025'
            ),
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.participante-bienvenida',
            with: [
                'participante' => $this->participante, // Pasar el objeto completo
                'password' => $this->password,
                'loginUrl' => url('/aula-virtual'), // Ajusta según tu ruta de login
            ],
        );
    }

    /**
     * Get the attachments for the message.
     */
    public function attachments(): array
    {
        return [];
    }
}