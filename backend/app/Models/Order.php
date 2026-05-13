<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Product;
use App\Models\User;
use App\Models\Coupon;
use Carbon\Carbon;

class Order extends Model
{
    protected $fillable = [
        'qty',
        'total',
        'deliverd_at',
        'user_id',
        'coupon_id'
    ];

    public function products()
    {
        return $this->belongsToMany(Product::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function coupon()
    {
        return $this->belongsTo(Coupon::class);
    }

    /**
     * DBから取得したcreated_atの値を現在の時刻から何時間経過しているのかを計算して
     * その経過時間の値を返す
     */
    public function getCreatedAtAttribute($value)
    {
        return Carbon::parse($value)->diffForHumans();
    }

    /**
     * DBから値が存在すれば取得したdelivered_atの値を現在の時刻から何時間経過しているのかを計算して
     * その差分の経過時間の値を返す
     */
    public function getDeliveredAtAttribute($value)
    {
        if($value) {
             return Carbon::parse($value)->diffForHumans();
        }else {
            return null;
        }
    }
}
