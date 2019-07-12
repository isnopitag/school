<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Tymon\JWTAuth\Contracts\JWTSubject;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\SoftDeletes;

/*
 * TODO Ok, el modelo de usuario es diferente, no es como tal un modelo, es un modelo++, ¿Por que?  mira el Extends
 */


/*************** Te preguntaras ¿Porque esto es de a huevo? bueno resulta que el Krlove solo trabaja con relaciones no con modelos de usuario asi que
 *************** pon atencion y copia lo que tengas que copiar ya que neta que le vale madre al Krlove **********************/

class BaseModelForUser extends Authenticatable implements JWTSubject
{

    //TODO dividire este basemodel en dos, primero todo lo que debe llevar y despues lo que no es tan urgente.
    use Notifiable;

    //TODO: Esta estructura es una copia de EJEMPLO del Agronexo
    protected $fillable = ['id_role', 'email', 'password', 'username', 'publications' ,'name', 'birth', 'sex','banned','validated','rfc', 'mobile_phone', 'state', 'municipality', 'street', 'locality','suburb', 'cp', 'profile_picture', 'remember_token', 'created_at', 'updated_at'];

    //TODO Este Hidden lo debe de llevar si o si pues si no va a salir la contraseña cifrada en las queries
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

    //TODO ¿Por que estos metodos pueden o no ir? Estos metodos en el Agronexo III funcionan para hacer comprobaciones
    //TODO por ejemplo si un user free  es determinado por su tabla de suscripcion bueno se busca esa relacion y el accesor hace una chamba
    //TODO Y de esta manera te ahorras ese jale de codear esto en cada lugar que lo requieras


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
