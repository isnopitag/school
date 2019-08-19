<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property int $id_user
 * @property string $name
 * @property string $description
 * @property string $where
 * @property string $start
 * @property string $finish
 * @property string $created_at
 * @property string $updated_at
 * @property User $user
 */
class Event extends Model
{
    /**
     * @var array
     */
    protected $fillable = ['id_user', 'name', 'description', 'where', 'start', 'finish', 'created_at', 'updated_at'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo('App\User', 'id_user');
    }
}
