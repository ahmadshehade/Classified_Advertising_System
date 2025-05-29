<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    //
    protected  $table = "categories";
    protected $fillable = [
        'name',
        'slug',
    ];

    /**
     * Summary of asd
     * @return \Illuminate\Database\Eloquent\Relations\HasMany<Ads, Category>
     */
    public function asd()
    {
        return $this->hasMany(Ads::class, 'category_id', 'id');
    }
}
