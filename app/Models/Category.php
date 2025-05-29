<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Category extends Model
{
     use HasFactory,Notifiable;
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
