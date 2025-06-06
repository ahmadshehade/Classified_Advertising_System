<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Ad extends Model
{
    use HasFactory, Notifiable;

    protected  $table = "ads";

    protected $fillable = [
        'title',
        'description',
        'price',
        'category_id',
        'status',

    ];


    protected  $guarded = ['user_id'];

    /**
     * Summary of user
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo<User, Ad>
     */
    public function user()
    {
        return  $this->belongsTo(User::class, 'user_id', 'id');
    }
    /**
     * Summary of category
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo<Category, Ad>
     */
    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id', 'id');
    }
    /**
     * Summary of images
     * @return \Illuminate\Database\Eloquent\Relations\MorphMany<Image, Ad>
     */
    public function  images()
    {
        return $this->morphMany(Image::class, 'imageable');
    }

    /**
     * Summary of getPriceAttribute
     * @param mixed $value
     * @return string
     */
    public function getPriceAttribute($value)
    {
        return ($value) . ' SYR';
    }
    /**
     * Summary of setTitleAttribute
     * @param mixed $value
     * @return void
     */
    public function setTitleAttribute($value): void
    {
        $this->attributes['title'] = strtolower($value);
    }
    /**
     * Summary of scopeActive
     * @param mixed $query
     */
    public function scopeActive($query)
    {

        return $query->where('status', 'active');
    }
    /**
     * Summary of scopeWithRelations
     * @param mixed $query
     */
    public function scopeWithRelations($query)
    {
        return $query->with(['mainImage', 'images', 'user', 'category', 'reviews'])->withCount('images')
            ->withCount('reviews');
    }
    /**
     * Summary of loadRelations
     * @return Ad
     */
    public function loadRelations()
    {
        return $this->load(['images', 'user', 'category']);
    }
    /**
     * Summary of reviews
     * @return \Illuminate\Database\Eloquent\Relations\HasMany<Review, Ad>
     */
    public function reviews()
    {
        return $this->hasMany(Review::class, 'ad_id', 'id');
    }
    /**
     * Summary of mainImage
     * @return \Illuminate\Database\Eloquent\Relations\MorphOne<Image, Ad>
     */
    public function mainImage()
    {
        return $this->morphOne(Image::class, 'imageable')->ofMany('created_at', 'min');
    }
}
