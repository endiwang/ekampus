<?php

namespace App\Console\Commands\Deploy;

use Illuminate\Console\Command;

class LookupCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'deploy:lookup';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Deploy Lookup Module';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $this->call('migrate', [
            '--path' => 'database/migrations/2023_08_19_230621_create_lookups_table.php',
        ]);
        $this->call('db:seed', [
            '--class' => 'LookupSeeder',
        ]);

        $this->info('Lookup module deployed successfully.');

        return Command::SUCCESS;
    }
}
