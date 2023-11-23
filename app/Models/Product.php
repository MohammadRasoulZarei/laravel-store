<?php

namespace App\Models;

use Carbon\Carbon;
use App\Models\Comment;
use App\Models\Wishlist;
use App\Models\Attribute;
use App\Models\ProductRate;
use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Product extends Model
{
    use HasFactory, Sluggable;

    protected $table = "products";
    protected $guarded = [];

    protected $appends = ['quantity_check'];


    /**
     * Return the sluggable configuration array for this model.
     *
     * @return array
     */
    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => 'name'
            ]
        ];
    }

    public function getIsActiveAttribute($is_active)
    {
        return $is_active ? 'فعال' : 'غیرفعال';
    }
    public function getQuantityCheckAttribute()
    {
        return $this->variations()->where('quantity', '>', '0')->first() ?? 0;
    }

    public function getSalePriceAttribute()
    {
        return $this->variations()->where('quantity', '>', '0')->where('date_on_sale_from', '<', Carbon::now())->where('date_on_sale_to', '>', Carbon::now())->orderBy('sale_price')->first() ?? 0;
    }
    public function getSaleCheckAttribute()
    {
        return $this->variations()->where('date_on_sale_from', '<', Carbon::now())->where('date_on_sale_to', '>', Carbon::now())->orderBy('sale_price')->first() ?? false;
    }
    public function getRealPriceAttribute()
    {

        if (request()->has('sortBy') and request('sortBy') == 'max') {
            return $this->variations()->where('quantity', '>', '0')->orderBy('price', 'desc')->first();
        } else
            return $this->variations()->where('quantity', '>', '0')->orderBy('price')->first();
    }
    public function getRealPAttribute()
    {
        return $this->variations()->where('quantity', '>', '0')->orderby('price')->first();
    }

    public function scopeFilter($query)
    {
        $query->whereHas('variations', function ($query){
            $query->where('quantity','>',0);
        });

        if (request()->has('variations')) {
            $query->whereHas('variations', function ($query) {
                foreach (explode('-', request('variations')) as $key => $value) {
                    if ($key == 0) {
                        $query->where('value', $value);
                    } else {
                        $query->orWhere('value', $value);
                    }
                }
            });
        }
        //attripute part
        $attributes = [];
        foreach (request()->all() as $key => $value) {

            if (stripos($key, 'attribute') !== false)
                $attributes[] = $value;
        }
        if ($attributes) {
            foreach ($attributes as $attr) {
                $query->whereHas('attributes', function ($query) use($attr) {
                    foreach (explode('-', $attr) as $key2 => $val) {
                        if ($key2 == 0) {
                            $query->where('value', $val);
                        } else {
                            $query->orWhere('value', $val);
                        }
                    }
                });
            }
        }
        //end - attripute part
        //sort part

        if (request()->has('sortBy')) {
            $sortBy = request()->sortBy;
            switch ($sortBy) {
                case 'max':
                    $query->orderByDesc(
                        ProductVariation::select('price')->whereColumn('product_variations.product_id', 'products.id')->orderBy('price', 'desc')->take(1)
                    );

                    break;
                case 'min':
                    $query->orderBy(
                        ProductVariation::select('price')->whereColumn('product_variations.product_id', 'products.id')->orderBy('price', 'asc')->take(1)
                    );

                    break;
                case 'newest':
                    $query->latest();
                    break;
                case 'oldest':
                    $query->oldest();
                    break;

                default:
                    $query;
                    break;
            }
        }
        // end - sort part
        //search -  part
        if (request()->has('search')) {
            $search = request('search');
            $query->where('name', 'like', "%$search%");
        }


        // dd($query->toSql());
        return $query;
    }


    public function tags()
    {
        return $this->belongsToMany(Tag::class, 'product_tag');
    }
    public function comments()
    {
        return $this->hasMany(Comment::class);
    }
    public function approvedComments()
    {
        return $this->hasMany(Comment::class)->where('approved', 1);
    }

    public function brand()
    {
        return $this->belongsTo(Brand::class);
    }


    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function attributes()
    {
        return $this->hasMany(ProductAttribute::class);
    }


    public function variations()
    {
        return $this->hasMany(ProductVariation::class);
    }

    public function images()
    {
        return $this->hasMany(ProductImage::class);
    }
    public function rates()
    {
        return $this->hasMany(ProductRate::class);
    }

    public function findInWish()
    {
        return $this->hasMany(Wishlist::class)->where('user_id', auth()->id())->first();
    }
    public function isInWish()
    {
        return $this->hasMany(Wishlist::class)->where('user_id', auth()->id())->exists();
    }
}
