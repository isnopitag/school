<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property string $status
 * @property string $created_at
 * @property string $updated_at
 * @property User[] $users
 */
class Status extends Model
{
    /**
     * @var array
     */
    protected $fillable = ['status', 'created_at', 'updated_at'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function users()
    {
        return $this->hasMany('App\User', 'id_status');
    }
}
