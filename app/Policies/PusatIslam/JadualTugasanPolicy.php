<?php

namespace App\Policies\PusatIslam;

use App\Models\PusatIslam\JadualTugasan;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class JadualTugasanPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     *
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function viewAny(User $user)
    {
        return $user->can('view-pi-jadual-tugasan');
    }

    /**
     * Determine whether the user can view the model.
     *
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function view(User $user, JadualTugasan $jadualTugasan)
    {
        return $user->can('view-pi-jadual-tugasan');
    }

    /**
     * Determine whether the user can create models.
     *
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function create(User $user)
    {
        return $user->can('view-pi-jadual-tugasan');
    }

    /**
     * Determine whether the user can update the model.
     *
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function update(User $user, JadualTugasan $jadualTugasan)
    {
        return $user->can('update-pi-jadual-tugasan');
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function delete(User $user, JadualTugasan $jadualTugasan)
    {
        return $user->can('delete-pi-jadual-tugasan');
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function restore(User $user, JadualTugasan $jadualTugasan)
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function forceDelete(User $user, JadualTugasan $jadualTugasan)
    {
        return false;
    }
}
