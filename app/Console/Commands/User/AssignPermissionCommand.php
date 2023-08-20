<?php

namespace App\Console\Commands\User;

use App\Models\User;
use Illuminate\Console\Command;
use Spatie\Permission\Models\Permission;

class AssignPermissionCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'user:give-permission';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Give permission to user based on their email address.';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $username = $this->ask('What is the username?');
        $user = User::whereUsername($username)->firstOrFail();

        $permissions = Permission::get()->pluck('name')->toArray();

        array_unshift($permissions, 'All');

        $selected_permission = $this->choice('What is the permission?', $permissions);

        if($selected_permission === 'All') {
            unset($permissions[0]);
            $selected_permission = $permissions;
        } else {
            $selected_permission = [$selected_permission];
        }

        foreach ($selected_permission as $permission) {
            if ($user->hasPermissionTo($permission)) {
                $this->comment('Permission '.$permission.' has already been assigned to '.$username);
            } else {
                $user->givePermissionTo($permission);
                $this->info('Permission '.$permission.' has been assigned to '.$username);
            }
        }

        return Command::SUCCESS;
    }
}
