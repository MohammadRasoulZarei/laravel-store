<?php

namespace App\Http\Controllers\Home;

use App\Models\Comment;
use App\Models\Product;
use App\Models\ProductRate;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class CommentsController extends Controller
{


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $req, Product $product)
    {
       // dd($req->all());

        $validator=Validator::make($req->all(),[
            'comment'=>'required|min:6|max:7000',
        'rate'=>'digits_between:0,5'
        ]);
        //dd($validator->errors());
        if($validator->fails()){
            return redirect(url()->previous().'#comment')->withErrors($validator);
        }



      Comment::create([
        'user_id'=>auth()->id(),
        'product_id'=>$product->id,
        'text'=>$req->comment
      ]);
      if (!auth()->user()->hadRate($product->id)){
        ProductRate::create([
            'user_id'=>auth()->id(),
            'product_id'=>$product->id,
            'rate'=>$req->rate
          ]);
      }
      alert()->success('کامنت ثبت شد', 'باتشکر');
        return redirect()->back();



    }


}
