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
     * Summary of Ad
     * @return \Illuminate\Database\Eloquent\Relations\HasMany<Ad, Category>
     */
    public function ad()
    {
        return $this->hasMany(Ad::class, 'category_id', 'id');
    }
}
