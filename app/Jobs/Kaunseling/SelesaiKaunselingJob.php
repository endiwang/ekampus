<?php

namespace App\Jobs\Kaunseling;

use App\Models\Kaunseling;
use App\Notifications\Kaunseling\BorangKepuasanPelanggan;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class SelesaiKaunselingJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(protected Kaunseling $kaunseling)
    {
        $this->onQueue('notifications');

        $kaunseling->load('user');
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $this->kaunseling->user
            ->notify(new BorangKepuasanPelanggan($this->kaunseling));
    }
}
