<?php

namespace App\Console\Commands\User;

use App\Models\User;
use Illuminate\Console\Command;
use Spatie\Permission\Models\Role;

class AssignRoleCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'user:give-role';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Give role to user based on their email address.';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $username = $this->ask('What is the username?');
        $user = User::whereUsername($username)->firstOrFail();

        $role = $this->choice('What is the role?', Role::get()->pluck('name')->toArray());

        if($user->hasRole($role)) {
            $this->info('Role '.$role.' has already been assigned to '.$username);
            return Command::SUCCESS;
        }

        $user->assignRole($role);
        $this->info('Role '.$role.' has been assigned to '.$username);

        return Command::SUCCESS;
    }
}
