<?php

namespace App\Models;

use Carbon\Carbon;
use App\Models\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ProductVariation extends Model
{
    use HasFactory;
    protected $appends=['is_sale','percent_off'];
    protected $table = "product_variations";
    protected $guarded = [];
    public function getIsSaleAttribute(){
        return ($this->sale_price!=null and $this->date_on_sale_from < Carbon::now() and $this->date_on_sale_to > Carbon::now())?true:false;
    }
    public function attribute(){
        return $this->belongsTo(Attribute::class);
    }
    public function getPercentOffAttribute(){
        return $this->is_sale? round((($this->price - $this->sale_price)/$this->price)*100):null;
    }

}
