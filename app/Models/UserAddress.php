<?php

namespace App\Models;

use App\Models\User;
use App\Models\Province;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class UserAddress extends Model
{
    use HasFactory;
    protected $table = "user_addresses";
    protected $guarded = [];
    function user()
    {
        return $this->belongsTo(User::class);
    }
    public function province(Type $var = null)
    {
        return $this->belongsTo(Province::class);
    }
    public function city(Type $var = null)
    {
        return $this->belongsTo(City::class);
    }
}
