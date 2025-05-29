<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Image extends Model
{
    //
    protected  $table = "images";
    protected  $fillable = ['path', 'imageable_id', 'imageable_type'];

    /**
     * Summary of imagebale
     * @return \Illuminate\Database\Eloquent\Relations\MorphTo<Model, Image>
     */
    public function imageable()
    {
        return $this->morphTo();
    }
}
