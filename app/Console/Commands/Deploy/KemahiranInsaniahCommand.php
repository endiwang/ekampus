<?php

namespace App\Console\Commands\Deploy;

use Illuminate\Console\Command;

class KemahiranInsaniahCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'deploy:kemahiran-insaniah';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Deploy Kemahiran Insaniah module.';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $this->call('migrate', [
            '--path' => 'database/migrations/2023_09_01_015801_create_pilihan_rayas_table.php',
        ]);

        $this->call('db:seed', [
            '--class' => 'KemahiranIsaniahSeeder',
        ]);

        $this->info('Kemahiran Insaniah module deployed successfully.');

        return Command::SUCCESS;
    }
}
