<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Ads extends Model
{
    //

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
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo<User, Ads>
     */
    public function user()
    {
        return  $this->belongsTo(User::class, 'user_id', 'id');
    }
    /**
     * Summary of category
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo<Category, Ads>
     */
    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id', 'id');
    }
    /**
     * Summary of images
     * @return \Illuminate\Database\Eloquent\Relations\MorphMany<Image, Ads>
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
     * @return Ads
     */
    public function loadRelations()
    {
        return $this->load(['images', 'user', 'category']);
    }
    /**
     * Summary of reviews
     * @return \Illuminate\Database\Eloquent\Relations\HasMany<Review, Ads>
     */
    public function reviews()
    {
        return $this->hasMany(Review::class, 'ad_id', 'id');
    }
    /**
     * Summary of mainImage
     * @return \Illuminate\Database\Eloquent\Relations\MorphOne<Image, Ads>
     */
    public function mainImage()
    {
        return $this->morphOne(Image::class, 'imageable')->ofMany('created_at', 'min');
    }
}
