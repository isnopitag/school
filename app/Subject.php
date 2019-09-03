<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property int $id_teacher
 * @property string $name
 * @property string $description
 * @property string $created_at
 * @property string $updated_at
 * @property User $user
 * @property Kardex[] $kardexes
 */
class Subject extends Model
{
    /**
     * @var array
     */
    protected $fillable = ['id_teacher', 'name', 'description', 'created_at', 'updated_at'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo('App\User', 'id_teacher');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function kardexes()
    {
        return $this->hasMany('App\Kardex', 'id_subject');
    }
}
