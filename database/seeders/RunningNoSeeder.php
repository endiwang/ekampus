<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Pentadbiran\RunningNo;

class RunningNoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    
        $check = RunningNo::find(1);
        // dd($check);
        if($check == null){
            
            $data = new RunningNo;
            $data->fasiliti = 0;
            $data->penginapan = 0;
            $data->kenderaan = 0;
            $data->pelekat = 0;
            $data->kuarters = 0;
            $data->save();

            
            
        }else{
            // remain
            echo 'running no got data';
        }
        
    }
}
