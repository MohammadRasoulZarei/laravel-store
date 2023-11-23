<?php

namespace App\Models;

use App\Models\User;
use App\Models\Product;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Comment extends Model
{
    use HasFactory;
    protected $table = "comments";
    protected $guarded = [];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function product()
    {
        return $this->belongsTo(Product::class);
    }
    public function getApproveAttribute()
    {
        switch ($this->approved) {
            case 0:
               return 'بررسی نشده';
                break;
            case 1:
               return 'تایید شده';
                break;
            case 2:
               return 'تایید نشده';
                break;
        }
    }


}
