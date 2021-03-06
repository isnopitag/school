<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Tymon\JWTAuth\Contracts\JWTSubject;
use Illuminate\Support\Facades\Storage;

class BaseModelForUser extends Authenticatable implements JWTSubject
{

    use Notifiable;

    protected $fillable = ['id_role', 'email', 'password', 'username', 'publications' ,'name', 'birth', 'sex','banned','validated','rfc', 'mobile_phone', 'state', 'municipality', 'street', 'locality','suburb', 'cp', 'profile_picture', 'remember_token', 'created_at', 'updated_at'];

    protected $hidden = [
        'password', 'remember_token',
    ];

    /********************************************LO QUE DEBE LLEVAR*********************************************/

    /**
     * Sets the user password
     *
     * @param string $value
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function setPasswordAttribute($value)
    {
        $this->attributes['password'] = bcrypt($value);
    }


    /**
     * Sets the user password
     *
     * @param array $permissions
     *
     * @return boolean
     */
    public  function hasAccess(array $permissions)
    {

        foreach ($this->roles as $role) {
            if ($role->hasAccess($permissions) ) {
                return true;
            }
        }
        return false;
    }

    /**
     * Returns users where slug is the same as the
     * parameter
     *
     * @param string $roleSlug
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function inRole($roleSlug)
    {
        return $this->roles()->where(
                'slug', $roleSlug
            )->count()==1;
    }


    //TODO: SOLO SI LLEVA UN ESQUEMA COMO AGRONEXO DE PLANES
    public function inPlan($roleSlug)
    {
        return $this->roles()->where(
                'slug', $roleSlug
            )->count()==1;
    }

    /**
     * Sets the user password
     *
     * @param string ...$roles
     *
     * @return boolean
     */
    public function inRoles(...$roles)
    {
        return in_array($this->role->slug, $roles);
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


    /********************************************LO QUE PUEDE LLEVAR*********************************************/


    public function isFreeUser()
    {
        if ($this->inRoles('client', 'guest')) {
            $subscription = $this->subscription;

            return $subscription ? $subscription->plan->name === 'free' : true;
        } else {
            return false;
        }
    }

    public function isSuperAdminOrAdminOrEditor()
    {
        if ($this->inRoles('superadmin', 'admin', 'editor')) {
            return true;
        } else {
            return false;
        }
    }

    public function isStandardUser()
    {
        if ($this->inRoles('client')) {
            $subscription = $this->subscription;

            return $subscription ? $subscription->plan->name === 'standard' : true;
        } else {
            return false;
        }
    }

    public function isPremiumUser()
    {
        if ($this->inRoles('client')) {
            $subscription = $this->subscription;

            return $subscription ? $subscription->plan->name === 'premium' : true;
        } else {
            return false;
        }
    }

    public function isStandardOrPremiumUser()
    {
        if ($this->inRoles('client')) {
            $subscription = $this->subscription;
            if($subscription->plan->name =='premium' || $subscription->plan->name =='standard'){
                return true;
            }
            return false;
        }
        return false;
    }
}
