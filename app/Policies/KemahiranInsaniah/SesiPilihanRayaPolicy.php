<?php

namespace App\Policies\KemahiranInsaniah;

use App\Models\KemahiranInsaniah\PilihanRaya\Sesi;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class SesiPilihanRayaPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function viewAny(User $user)
    {
        return $user->can('view-ki-pilihan-raya');
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\KemahiranInsaniah\PilihanRaya\Sesi  $sesi
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function view(User $user, Sesi $sesi)
    {
        return $user->can('view-ki-pilihan-raya');
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function create(User $user)
    {
        return $user->can('create-ki-pilihan-raya');
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\KemahiranInsaniah\PilihanRaya\Sesi  $sesi
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function update(User $user, Sesi $sesi)
    {
        return $user->can('update-ki-pilihan-raya');
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\KemahiranInsaniah\PilihanRaya\Sesi  $sesi
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function delete(User $user, Sesi $sesi)
    {
        return $user->can('delete-ki-pilihan-raya');
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\KemahiranInsaniah\PilihanRaya\Sesi  $sesi
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function restore(User $user, Sesi $sesi)
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\KemahiranInsaniah\PilihanRaya\Sesi  $sesi
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function forceDelete(User $user, Sesi $sesi)
    {
        return false;
    }
}
