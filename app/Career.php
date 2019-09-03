<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property string $career
 * @property string $profile_image
 * @property string $cover_image
 * @property string $created_at
 * @property string $updated_at
 * @property User[] $users
 */
class Career extends Model
{
    /**
     * @var array
     */
    protected $fillable = ['career', 'profile_image', 'cover_image', 'created_at', 'updated_at'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function users()
    {
        return $this->hasMany('App\User', 'id_career');
    }
}
