<?php

namespace App\Models;

use App\Models\Order;
use App\Models\Comment;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasFactory, Notifiable, HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'avatar',
        'provider_name',
        'email_verified_at',
        'login_token',
        'otp'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function hadRate($productID)
    {

        return $this->rates()->where('product_id',$productID)->exists();

    }
    public function rates(){
        return $this->hasMany(ProductRate::class);
    }
    public function comments(){
        return $this->hasMany(Comment::class);
    }
    public function wishes(){

        return $this->belongsToMany(Product::class,'wishlist');

    }
    public function orders() {
        return $this->hasMany(Order::class);
    }
}
