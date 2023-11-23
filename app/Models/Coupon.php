<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Coupon extends Model
{
    use HasFactory;
    protected $table = "coupons";
    protected $guarded = [];

    public function getTypeAttribute($type)
    {
        if ($type=='percentage') {
            return 'درصدی';
        }else{
            return 'مبلغی';
        }
    }
    public function getStatusAttribute()
    {
       if ($this->expired_at>Carbon::now()) {
            return ['class'=>'text-success','value'=>'معتبر'];
       }else{
        return  ['class'=>'text-danger','value'=>'منقضی شده'];
       }
    }
}
