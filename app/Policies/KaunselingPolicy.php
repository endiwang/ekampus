<?php

namespace App\Policies;

use App\Enums\StatusKaunseling;
use App\Models\Kaunseling;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class KaunselingPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     *
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function viewAny(User $user)
    {
        return $user->can('view-kaunseling');
    }

    /**
     * Determine whether the user can view the model.
     *
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function view(User $user, Kaunseling $kaunseling)
    {
        return $user->can('view-kaunseling');
    }

    /**
     * Determine whether the user can create models.
     *
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function create(User $user)
    {
        return $user->can('create-kaunseling');
    }

    /**
     * Determine whether the user can update the model.
     *
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function update(User $user, Kaunseling $kaunseling)
    {
        return $user->can('update-kaunseling')
            && in_array($kaunseling->status, [
                StatusKaunseling::baru()->value,
                StatusKaunseling::diTerima()->value,
                StatusKaunseling::dalamProcess()->value,
            ]);
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function delete(User $user, Kaunseling $kaunseling)
    {
        return $user->can('delete-kaunseling')
            && $kaunseling->status == StatusKaunseling::belumDihantar()->value;
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function restore(User $user, Kaunseling $kaunseling)
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function forceDelete(User $user, Kaunseling $kaunseling)
    {
        return false;
    }
}
