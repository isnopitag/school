<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Tymon\JWTAuth\Contracts\JWTSubject;

class User extends Authenticatable implements JWTSubject
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /***
     * This method its for create the realationship between role and users
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */

    public function roles(){
        return $this->belongsToMany(Role::class,'role_users');
    }

    public  function hasAccess(array $permissions){

        foreach ($this->roles as $role){
            if($role->hasAccess($permissions)){
                return true;
            }
        }
        return false;
    }

    public function inRole($roleSlug){
        return $this->roles()->where('slug',$roleSlug)->count()==1;
    }

    /**
     * Get the identifier that will be stored in the subject claim of the JWT.
     *
     * @return mixed
     */
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims()
    {
        return [];
    }

}
