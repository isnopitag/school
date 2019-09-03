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

    public function getProfileImageAttribute($image){

        if(!$image || starts_with($image, 'http')){
            return $image;
        }
        return Storage::disk('public')->url($image);
    }

    public function imageNameProfile()
    {
        return $this->attributes['profile_image'];
    }

    public function getCoverImageAttribute($image){

        if(!$image || starts_with($image, 'http')){
            return $image;
        }
        return Storage::disk('public')->url($image);
    }

    public function imageNameCover()
    {
        return $this->attributes['conver_image'];
    }
}
