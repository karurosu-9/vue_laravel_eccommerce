<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Category;
use App\Models\Brand;
use App\Models\Color;
use App\Models\Size;
use App\Models\Order;
use App\Models\Review;

class Product extends Model
{
    protected $fillable = [
        'name',
        'slug',
        'qty',
        'price',
        'desc',
        'thumbnail',
        'first_image',
        'second_image',
        'third_image',
        'status',
        'category_id',
        'brand_id'
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function brand()
    {
        return $this->belongsTo(Brand::class);
    }

    public function colors()
    {
        return $this->belongsToMany(Color::class);
    }

    public function sizes()
    {
        return $this->belongsToMany(Size::class);
    }

    public function orders()
    {
        return $this->belongsToMany(Order::calss);
    }

    public function reviews()
    {
        return $this->hasMany(Review::class)
            ->with('user')
            ->where('approved', 1)
            ->latest();
    }

    /**
     * routeをidで設定するのではなく、slugの値で設定する
     */
    public function getRouteKeyName()
    {
        return "slug";
    }
}
