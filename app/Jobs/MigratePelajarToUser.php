<?php

namespace App\Jobs;

use App\Models\OldDatabase\sis_tblpelajar;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class MigratePelajarToUser implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $student_id;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($student_id)
    {
        $this->student_id = $student_id;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        //password = 123

        $password_hash = '$2y$10$DYl/XAwUYLdFk4BDUD0lkO12yxz0ZO.YpwySx0ZV9.OBVF2o/vi2y';

        $student = sis_tblpelajar::where('pelajar_id', $this->student_id)->first();
        $created_user = User::where('username', $student->p_nokp)->first();

        if ($created_user == null) {
            if ($student->is_deleted == 0 && $student->is_berhenti == 0 && $student->is_alumni == 0) {
                // dump('ok');
                User::create([
                    'username' => $student->p_nokp,
                    'password' => $password_hash,
                    'is_student' => 1,
                ]);
            } elseif ($student->is_deleted == 0 && $student->is_berhenti == 1 && $student->is_alumni == 0) {
                // dump('okk');

                User::create([
                    'username' => $student->p_nokp,
                    'password' => $password_hash,
                    'is_berhenti' => 1,
                ]);

            } elseif ($student->is_deleted == 0 && $student->is_berhenti == 1 && $student->is_alumni == 1) {
                // dump('okkk');

                User::create([
                    'username' => $student->p_nokp,
                    'password' => $password_hash,
                    'is_alumni' => 1,
                ]);
            }
        }

    }
}
