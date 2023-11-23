<?php

namespace App\Models;

use App\Models\ProductAttribute;
use App\Models\ProductVariation;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Attribute extends Model
{
    use HasFactory;

    protected $table = "attributes";
    protected $guarded = [];

    public function categories()
    {
        return $this->belongsToMany(Category::class , 'attribute_category');
    }
    public function values()
    {
        //'attribute_id should be pass to select method becaus the structure of ProductAttribute
        return $this->hasMany(ProductAttribute::class)->select('attribute_id','value')->distinct();
    }
    public function variations()
    {
        //'attribute_id should be pass to select method becaus the structure of ProductAttribute
        return $this->hasMany(ProductVariation::class)->select('attribute_id','value')->distinct();
    }
}
