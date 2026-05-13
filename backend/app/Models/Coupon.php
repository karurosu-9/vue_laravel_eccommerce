<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Coupon extends Model
{
    protected $fillable = ['name', 'discount', 'valid_until'];

    /**
     * クーポンのname属性は、大文字に変換してDB保存する
     */
    public function setNameAttribute($value)
    {
        return $this->attributes['name'] = Str::upper($value);
    }

    /**
     * クーポンの有効期限のチェック
     */
    public function checkIfValid()
    {
        if($this->valid_util > Carbon::now()) {
            return true;
        }else {
            return false;
        }
    }
}
