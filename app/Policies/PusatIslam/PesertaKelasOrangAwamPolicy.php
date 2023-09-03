<?php

namespace App\Policies\PusatIslam;

use App\Models\PusatIslam\PesertaKelasOrangAwam;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class PesertaKelasOrangAwamPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     *
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function viewAny(User $user)
    {
        return $user->can('view-pi-peserta-kelas-orang-awam');
    }

    /**
     * Determine whether the user can view the model.
     *
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function view(User $user, PesertaKelasOrangAwam $pesertaKelasOrangAwam)
    {
        return $user->can('view-pi-peserta-kelas-orang-awam');
    }

    /**
     * Determine whether the user can create models.
     *
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function create(User $user)
    {
        return $user->can('create-pi-peserta-kelas-orang-awam');
    }

    /**
     * Determine whether the user can update the model.
     *
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function update(User $user, PesertaKelasOrangAwam $pesertaKelasOrangAwam)
    {
        return $user->can('update-pi-peserta-kelas-orang-awam');
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function delete(User $user, PesertaKelasOrangAwam $pesertaKelasOrangAwam)
    {
        return $user->can('delete-pi-peserta-kelas-orang-awam');
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function restore(User $user, PesertaKelasOrangAwam $pesertaKelasOrangAwam)
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function forceDelete(User $user, PesertaKelasOrangAwam $pesertaKelasOrangAwam)
    {
        return false;
    }
}
