<?php

namespace App\Models;

use App\Models\User;
use App\Models\Coupon;
use App\Models\Product;
use App\Models\OrderItem;
use App\Models\UserAddress;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Order extends Model
{
    use HasFactory;
    protected $table = "orders";
    protected $guarded = [];

    public function getStatusAttribute($status)
    {
        return $status==1?"موفق":'ناموفق';
    }
    public function getPaymentTypeAttribute($status)
    {
        return $status=='online'?"اینترنتی":'غیر اینترنتی';
    }


    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }
    public function productItems()
    {
        return $this->belongsToMany(Product::class,'order_items');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function address()
    {
        return $this->belongsTo(UserAddress::class);
    }
    public function getCouponAttribute()
    {
        if ($this->coupon_id!=0) {
            return Coupon::find($this->coupon_id)->code;
        }
        return 'استفاده نشده';
    }
}
