<?php

namespace App\Http\Controllers\Home;

use App\Models\Product;
use App\Models\Attribute;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CompareController extends Controller
{
   public function add(Product $product)
   {
   // dd($product);
        if (session('compareProduct')) {
            if(!in_array($product->id,session('compareProduct'))){
                session()->push('compareProduct',$product->id);
            }else{
                alert()->warning(' محصول به لیست مقایسه اضافه شده بود! ', 'دقت کنید');
                return redirect()->back();
            }
        }else{
            session(['compareProduct'=>[$product->id]]);
        }
        alert()->success(' محصول به لیست مقایسه اضافه شد ', 'باتشکر');
        return redirect()->back();

   }
   public function index()
   {

    if(session()->has('compareProduct')){
        if(session('compareProduct')==[]){
            session()->forget('compareProduct');
            return redirect()->route('home.index');
        }


        
        $products=Product::findOrFail(session('compareProduct'));


        // dd($prodcts,session('compareProduct'));
        return view('home.compare',compact('products'));
    }else{
        alert()->warning(' محصولی جهت مقایسه انتخاب نشده است ', 'اخطار');
        return redirect()->route('home.index');
    }

   }
   public function delete($id)
   {
    if (session('compareProduct')) {
        foreach (session('compareProduct') as $key => $value) {
           if ($id==$value) {

            session()->pull('compareProduct.'.$key);

            alert()->success('   محصول با موفقیت از لیست مقایسه حذف شد! ', 'تشکر');
              return redirect()->back();
           }
        }
    }
    alert()->danger(' محصولی جهت مقایسه انتخاب نشده است ', 'اخطار');
    return redirect()->back();

   }



}
