<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Attachment;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class BayaranYuranMail extends Mailable
{
    use Queueable, SerializesModels;

    public $bil;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($bil, $bayaran)
    {
        $this->bil = $bil;
        $this->bayaran = $bayaran;
    }

    /**
     * Get the message envelope.
     *
     * @return \Illuminate\Mail\Mailables\Envelope
     */
    public function envelope()
    {
        return new Envelope(
            subject: 'Darul Quran Pembayaran Selesai #'.$this->bil->doc_no,
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
            markdown: 'emails.pemohon.bayaran_yuran',
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array
     */
    public function attachments()
    {
        if (! empty($this->bayaran) && ! empty($this->bayaran->resit)) {
            $resit = (array) json_decode($this->bayaran->resit);

            return [
                Attachment::fromPath(public_path('storage/' . $resit['resit_path'])),
            ];
        } else {
            return [];
        }
    }
}
