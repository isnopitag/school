<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property int $id_user
 * @property string $title
 * @property string $image
 * @property string $publish_date
 * @property string $summary
 * @property string $content
 * @property string $created_at
 * @property string $updated_at
 * @property User $user
 */
class Blog extends Model
{
    /**
     * @var array
     */
    protected $fillable = ['id_user', 'title', 'image', 'publish_date', 'summary', 'content', 'created_at', 'updated_at'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo('App\User', 'id_user');
    }
}
