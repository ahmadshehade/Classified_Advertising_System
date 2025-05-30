<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Review extends Model
{
    use HasFactory,Notifiable;
    //

    protected  $table="reviews";

    protected $fillable=[
        
        'ad_id',
        'rating',
        'comment'
    ];

    protected $guarded=['user_id'];

    /**
     * Summary of user
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo<User, Review>
     */
    public function user(){
        return  $this->belongsTo(User::class,'user_id','id');
    }
    /**
     * Summary of ad
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo<Ad, Review>
     */
    public function ad(){
        return  $this->belongsTo(Ad::class,'ad_id','id');
    }
}
