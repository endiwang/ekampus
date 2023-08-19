<?php

namespace App\Console\Commands\Deploy;

use Illuminate\Console\Command;

class KaunselingCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'deploy:kaunseling';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Deploy Kaunseling Module';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $this->call('migrate', [
            '--path' => 'database/migrations/2023_08_11_184151_create_kaunselings_table.php',
        ]);
        $this->call('db:seed', [
            '--class' => 'KaunselingSeeder',
        ]);

        $this->info('Kaunseling module deployed successfully.');

        return Command::SUCCESS;
    }
}
