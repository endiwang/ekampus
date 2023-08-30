<?php

namespace App\Policies\PusatIslam;

use App\Models\PusatIslam\KelasOrangAwam;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class KelasOrangAwamPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     *
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function viewAny(User $user)
    {
        return $user->can('view-pi-kelas-orang-awam');
    }

    /**
     * Determine whether the user can view the model.
     *
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function view(User $user, KelasOrangAwam $kelasOrangAwam)
    {
        return $user->can('view-pi-kelas-orang-awam');
    }

    /**
     * Determine whether the user can create models.
     *
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function create(User $user)
    {
        return $user->can('create-pi-kelas-orang-awam');
    }

    /**
     * Determine whether the user can update the model.
     *
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function update(User $user, KelasOrangAwam $kelasOrangAwam)
    {
        return $user->can('update-pi-kelas-orang-awam');
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function delete(User $user, KelasOrangAwam $kelasOrangAwam)
    {
        return $user->can('delete-pi-kelas-orang-awam');
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function restore(User $user, KelasOrangAwam $kelasOrangAwam)
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function forceDelete(User $user, KelasOrangAwam $kelasOrangAwam)
    {
        return false;
    }
}
