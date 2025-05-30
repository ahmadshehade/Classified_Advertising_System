<?php

namespace App\Policies;

use App\Models\Ad;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class AdPolicy
{
    /**
     * Summary of before
     * @param \App\Models\User $user
     * @return bool|null
     */
    public function before(User $user){
        if($user->role=="admin"){
            return true;
        }
        return null;
    }
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return  $user->role=='user'||$user->role=='admin';
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Ad $ads): bool
    {
        return $user->role=='user'||$user->role=="admin";
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
         return $user->role=='user'||$user->role=="admin";;
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Ad $ads): bool
    {
        return  $user->role=="user"&&$user->id==$ads->user_id;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Ad $ads): bool
    {
       return  $user->role=="user"&&$user->id==$ads->user_id;
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Ad $ads): bool
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Ad $ads): bool
    {
        return false;
    }
}
