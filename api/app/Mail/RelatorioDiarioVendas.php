<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class RelatorioDiarioVendas extends Mailable
{
    use Queueable, SerializesModels;

    private array $vendas;
    private string $data;

    /**
     * Create a new message instance.
     */
    public function __construct(array $vendas, string $data)
    {
        $this->vendas = $vendas;
        $this->data = $data;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Relatorio Diario Vendas',
            to: ['matheus.melo.a@hotmail.com']
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: "emails.vendas.relatorio_diario",
            with: [
                "vendas" => $this->vendas,
                "data" => $this->data,
                "total" => $this->calcularTotalDeVendas()
            ]
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [];
    }

    private function calcularTotalDeVendas(){
        return array_reduce($this->vendas, fn($total, $venda): float => $total += $venda->valor, 0);
    }
}
