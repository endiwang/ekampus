<?php

namespace App\Jobs\Kaunseling;

use App\Models\Kaunseling;
use App\Models\User;
use App\Notifications\Kaunseling\PermohonanBaru;
use App\Notifications\Kaunseling\PermohonanBaruKepadaPemohon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class PermohonBaruJob implements ShouldQueue
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
            ->notify(new PermohonanBaruKepadaPemohon($this->kaunseling));

        // notify to user with kaunseling role
        User::role('kaunseling')->with('staff')->get()
            ->each(function ($user) {
                $user->notify(new PermohonanBaru($this->kaunseling));
            });
    }
}
