<?php

namespace App\Mail;

use App\Models\Veiculo;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class LeilaoCriadoMail extends Mailable
{
    use Queueable, SerializesModels;

    public $veiculo;

    public function __construct(Veiculo $veiculo)
    {
        $this->veiculo = $veiculo;
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Novo Leilão: ' . $this->veiculo->marca . ' ' . $this->veiculo->modelo,
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.leilao_criado',
        );
    }
}