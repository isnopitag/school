<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id_student
 * @property int $id_subject
 * @property int $opportunity
 * @property int $semester
 * @property float $grade
 * @property float $average
 * @property string $created_at
 * @property string $updated_at
 * @property User $user
 * @property Subject $subject
 */
class Kardex extends Model
{
    /**
     * @var array
     */
    protected $fillable = ['id_student','id_subject','opportunity', 'semester', 'grade', 'average', 'created_at', 'updated_at'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo('App\User', 'id_student');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function subject()
    {
        return $this->belongsTo('App\Subject', 'id_subject');
    }
}
