<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

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
class User extends Model
{
    /**
     * @var array
     */
    protected $fillable = ['id_role', 'id_career', 'id_status', 'name', 'email', 'password', 'profile_picture', 'banned', 'birth', 'remember_token', 'created_at', 'updated_at'];

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
}
