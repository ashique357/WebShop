<?php

namespace App\Policies;

use App\Models\Admin;
use Illuminate\Auth\Access\HandlesAuthorization;

class AdminPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function viewAny(Admin $admin)
    {
        //
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\User  $user
     * @param  \App\App\Models\Admin  $admin
     * @return mixed
     */
    public function view(Admin $admin)
    {
        //
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function create(Admin $authenticatedAdmin,$permission)
    {
        // return $admin->permissions()->contains("create-".trim($permission));
        return $authenticatedAdmin->id === $admin->id || $authenticatedAdmin->permissions()->contains("create-".trim($permission));
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\User  $user
     * @param  \App\App\Models\Admin  $admin
     * @return mixed
     */
    public function update(Admin $authenticatedAdmin,$permission)
    {
        return $authenticatedAdmin->id === $admin->id || $authenticatedAdmin->permissions()->contains("update-".trim($permission));
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\User  $user
     * @param  \App\App\Models\Admin  $admin
     * @return mixed
     */
    public function delete(Admin $authenticatedAdmin,$permission)
    {
        return $authenticatedAdmin->id === $admin->id || $authenticatedAdmin->permissions()->contains("delete-".trim($permission));
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\User  $user
     * @param  \App\App\Models\Admin  $admin
     * @return mixed
     */
    public function restore(Admin $admin)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\User  $user
     * @param  \App\App\Models\Admin  $admin
     * @return mixed
     */
    public function forceDelete(Admin $admin)
    {
        //
    }
}
