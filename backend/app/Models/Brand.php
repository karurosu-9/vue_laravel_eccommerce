<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Product;

class Brand extends Model
{
    protected $fillable = ['name', 'slug'];

    public function products()
    {
        return $this->hasMany(Product::class);
    }

    /**
     * routeをidで設定するのではなく、slugの値で設定する
     */
    public function getRouteKeyName()
    {
        return "slug";
    }
}
