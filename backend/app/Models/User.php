<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use App\Models\Order;

#[Fillable([
    'name',
    'email',
    'password',
    'address',
    'city',
    'zip_code',
    'country',
    'phone_number',
    'profile_image',
    'profile_completed'
])]
#[Hidden(['password', 'remember_token'])]

/**
 * Appendsにカラムとしては追加しないが、$user->image_pathとして、表示用の項目を追加している
 */
#[Appends(['image_path'])]

class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

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

    public function orders()
    {
        return $this->hasMany(Order::class)
            ->with('product')
            ->latest();
    }

    /**
     * profile_imageがあった場合に、ブラウザから見られるURLに変換する
     */
    public function getImagePathAttribute()
    {
        if($this->profile_image) {
            return asset($this->profile_image);
        }else {
            return "https://pixabay.com/ja/images/download/raphaelsilva-user-2935527_1920.png";
        }
    }
}
