<?php

namespace App\Notifications\Kaunseling;

use App\Models\Kaunseling;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class PermohonanBaru extends Notification
{
    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(public Kaunseling $kaunseling)
    {
        //
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
            ->subject('Permohonan untuk Sesi Kaunseling - Rujukan Permohonan: '.$this->kaunseling->no_permohonan)
            ->markdown('notifications.kaunseling.permohonan-baru-kepada-unit-kaunseling', [
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
