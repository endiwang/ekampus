<?php

namespace App\Notifications\Kaunseling;

use App\Models\Kaunseling;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class BorangKepuasanPelanggan extends Notification
{
    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(protected Kaunseling $kaunseling)
    {

    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail', 'database'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject('Borang Kepuasan Pelanggan - Penilaian Sesi Kaunseling '.$this->kaunseling->no_permohonan)
            ->markdown('notifications.kaunseling.borang-kepuasan-pelanggan', [
                'kaunseling' => $this->kaunseling,
            ]);
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            'data' => $this->kaunseling->toArray(),
        ];
    }
}
