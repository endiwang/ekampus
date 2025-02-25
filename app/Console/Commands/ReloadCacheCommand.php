<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class ReloadCacheCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'reload:cache';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Reload all caches';

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        $this->call('event:clear');
        $this->call('optimize:clear');
        $this->call('route:clear');
        $this->call('view:clear');
        $this->call('config:clear');
        $this->call('cache:clear');

        $this->info('Successfully reload caches.');
    }
}
