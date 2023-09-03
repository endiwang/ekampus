<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use Illuminate\Mail\Mailables\Attachment;

class BilYuranMail extends Mailable
{
    use Queueable, SerializesModels;
    public $bil;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($bil)
    {
        $this->bil = $bil;
    }

    /**
     * Get the message envelope.
     *
     * @return \Illuminate\Mail\Mailables\Envelope
     */
    public function envelope()
    {
        return new Envelope(
            subject: 'Darul Quran Bil #' . $this->bil->doc_no,
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
            markdown: 'emails.pemohon.bil_yuran',
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array
     */
    public function attachments()
    {
        if(!empty($this->bil) && !empty($this->bil->invois))
        {
            $invois = (array) json_decode($this->bil->invois);
            
            return [
                Attachment::fromPath(public_path('storage/' . $invois['invois_path'])),
            ];
        }
        else {
            return [];
        }
    }
}
