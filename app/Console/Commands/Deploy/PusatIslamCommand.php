<?php

namespace App\Console\Commands\Deploy;

use Illuminate\Console\Command;

class PusatIslamCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'deploy:pusat-islam';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Deploy Pusat Islam module.';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $this->call('migrate', [
            '--path' => 'database/migrations/2023_08_25_042337_create_aktivitis_table.php',
        ]);

        $this->call('migrate', [
            '--path' => 'database/migrations/2023_08_25_042348_create_kelas_orang_awams_table.php',
        ]);

        $this->call('migrate', [
            '--path' => 'database/migrations/2023_08_25_042407_create_rekod_kehadirans_table.php',
        ]);

        $this->call('migrate', [
            '--path' => 'database/migrations/2023_08_25_042417_create_surat_rasmis_table.php',
        ]);

        $this->call('migrate', [
            '--path' => 'database/migrations/2023_08_25_042445_create_jadual_tugasans_table.php',
        ]);

        $this->call('db:seed', [
            '--class' => 'LookupSeeder',
        ]);

        $this->call('db:seed', [
            '--class' => 'PusatIslamSeeder',
        ]);

        $this->info('Pusat Islam  module deployed successfully.');

        return Command::SUCCESS;
    }
}
