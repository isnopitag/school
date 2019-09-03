<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Tymon\JWTAuth\Contracts\JWTSubject;
use Illuminate\Support\Facades\Storage;

/**
 * @property int $id
 * @property int $id_role
 * @property int $id_career
 * @property int $id_status
 * @property string $name
 * @property string $email
 * @property string $password
 * @property string $profile_picture
 * @property boolean $banned
 * @property string $birth
 * @property string $remember_token
 * @property string $created_at
 * @property string $updated_at
 * @property Career $career
 * @property Role $role
 * @property Status $status
 * @property Blog[] $blogs
 * @property DeviceUser[] $deviceUsers
 * @property Event[] $events
 * @property Kardex[] $kardexes
 * @property Payment[] $payments
 * @property Subject[] $subjects
 */
class User extends Authenticatable implements JWTSubject
{
    use Notifiable;

    /**
     * @var array
     */
    protected $fillable = ['id_role', 'id_career', 'id_status', 'name', 'email', 'password', 'profile_picture', 'banned', 'birth', 'remember_token', 'created_at', 'updated_at'];

    protected $hidden = [
        'password', 'remember_token',
    ];

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


    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function career()
    {
        return $this->belongsTo('App\Career', 'id_career');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function role()
    {
        return $this->belongsTo('App\Role', 'id_role');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function status()
    {
        return $this->belongsTo('App\Status', 'id_status');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function blogs()
    {
        return $this->hasMany('App\Blog', 'id_user');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function deviceUsers()
    {
        return $this->hasMany('App\DeviceUser');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function events()
    {
        return $this->hasMany('App\Event', 'id_user');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function kardexes()
    {
        return $this->hasMany('App\Kardex', 'id_student');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function payments()
    {
        return $this->hasMany('App\Payment', 'id_student');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function subjects()
    {
        return $this->hasMany('App\Subject', 'id_teacher');
    }

    public function getProfilePictureAttribute($image){

        if(!$image || starts_with($image, 'http')){
            return $image;
        }
        return Storage::disk('public')->url($image);
    }

    public function imageName()
    {
        return $this->attributes['profile_picture'];
    }

    public function isTeacher()
    {
        if ($this->inRoles('teacher')) {
            return true;
        } else {
            return false;
        }
    }

    public function isStudent()
    {
        if ($this->inRoles('student')) {
            return true;
        } else {
            return false;
        }
    }
}
