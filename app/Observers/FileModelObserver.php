<?php

namespace App\Observers;

use App\FileModel;
use Illuminate\Support\Facades\Storage;

class FileModelObserver
{
    /**
     * Handle the User "updated" event.
     *
     * @param  \App\User  $user
     * @return void
     */
    public function updated(FileModel $model)
    {
        // Get old values
        $old = $model->getOriginal();

        // Get new values
        $media = $model->getFiles();

        foreach($media as $field => $newValue) {
            $oldValue = $old[$field];
            if ($oldValue && $newValue != $oldValue){
                Storage::delete($oldValue);
            }
        }
    }

    /**
     * Handle the User "deleted" event.
     *
     * @param  \App\User  $user
     * @return void
     */
    public function deleted(FileModel $model)
    {
        $media = $model->getFiles();
        foreach($media as $field => $value){
            if($value){
                Storage::delete($value);
            }
        }
    }
}
