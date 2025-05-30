<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable, HasApiTokens;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];
    protected $guarded = ['role'];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /**
     * Summary of image
     * @return \Illuminate\Database\Eloquent\Relations\MorphOne<Image, User>
     */
    public function image()
    {
        return $this->morphOne(Image::class, 'imageable');
    }
    /**
     * Summary of ads
     * @return \Illuminate\Database\Eloquent\Relations\HasMany<Ad, User>
     */
    public function ads()
    {
        return $this->hasMany(Ad::class, 'user_id', 'id');
    }
    /**
     * Summary of reviews
     * @return \Illuminate\Database\Eloquent\Relations\HasMany<Review, User>
     */
    public function reviews()
    {
        return $this->hasMany(Review::class, 'user_id', 'id');
    }
}
