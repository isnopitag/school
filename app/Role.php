<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property string $name
 * @property string $slug
 * @property string $permissions
 * @property string $created_at
 * @property string $updated_at
 * @property User[] $users
 */
class Role extends Model
{
    /**
     * @var array
     */
    protected $fillable = ['name', 'slug', 'permissions', 'created_at', 'updated_at'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function users()
    {
        return $this->hasMany('App\User', 'id_role');
    }
}
