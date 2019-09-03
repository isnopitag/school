<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property int $id_student
 * @property float $price
 * @property string $ticket
 * @property string $created_at
 * @property string $updated_at
 * @property User $user
 */
class Payment extends Model
{
    /**
     * @var array
     */
    protected $fillable = ['id_student', 'price', 'ticket', 'created_at', 'updated_at'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo('App\User', 'id_student');
    }

    public function getTicketAttribute($image){

        if(!$image || starts_with($image, 'http')){
            return $image;
        }
        return Storage::disk('public')->url($image);
    }

    public function imageName()
    {
        return $this->attributes['ticket'];
    }
}
