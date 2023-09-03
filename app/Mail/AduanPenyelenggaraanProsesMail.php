<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class AduanPenyelenggaraanProsesMail extends Mailable
{
    use Queueable, SerializesModels;
    public $aduan_penyelenggaraan;
    public $to_vendor;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($aduan_penyelenggaraan, $to_vendor = false)
    {
        $this->aduan_penyelenggaraan = $aduan_penyelenggaraan;
        $this->to_vendor = $to_vendor;
    }

    /**
     * Get the message envelope.
     *
     * @return \Illuminate\Mail\Mailables\Envelope
     */
    public function envelope()
    {
        return new Envelope(
            subject: 'Aduan Penyelenggaraan Diproses #' . $this->aduan_penyelenggaraan->no_siri,
        );
    }

    /**
     * Get the message content definition.
     *
     * @return \Illuminate\Mail\Mailables\Content
     */
    public function content()
    {
        return new Content(
            markdown: 'emails.aduan_penyelenggaraan.aduan_proses',
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array
     */
    public function attachments()
    {
        return [];
    }
}
