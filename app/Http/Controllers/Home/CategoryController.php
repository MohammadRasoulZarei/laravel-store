<?php

namespace App\Http\Controllers\Home;


use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CategoryController extends Controller
{
    public function index()
    {
        $products=product::filter()->paginate(5);
        $categories=Category::where('parent_id',0)->get();
        return view('home.categories.index',compact('products','categories'));
    }

    public function show(Request $request, Category $category)
    {

        $filters = $category->attributes()->where('is_filter', 1)->with('values')->get();

        $variation = $category->attributes()->where('is_variation', 1)->with('variations')->first();



        $products = $category->products()->filter()->paginate(2);

        // dd( $product->real_price->get()->sortByDesc('price'));
        return view('home.categories.show', compact('category', 'filters', 'variation', 'products'));
    }
    function showParentCategory(Category $category) {
        $children=$category->children->pluck('id');

        $products=product::whereIn('category_id',$children)->filter()->paginate(2);


       return view('home.categories.showParent',compact('category','products'));
    }
}

