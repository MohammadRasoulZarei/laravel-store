<?php

namespace App\Models;

use Carbon\Carbon;
use App\Models\User;
use Hekmatinasser\Verta\Facades\Verta;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Transaction extends Model
{
    use HasFactory;
    protected $table = "transactions";
    protected $guarded = [];
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function getStatusAttribute($field)
    {
        return $field==1?'موفق':"ناموفق";
    }

    public function scopeGetData($query,$month,$status)
    {
        $date =verta()->subMonths($month)->startMonth()->toCarbon();

       // dd($date,$month,$status,$query->where('created_at','>',$date)->where('status',$status)->get());
      return $query->where('created_at','>',$date)->where('status',$status)->orderBy('created_at')->get();
    }

}
