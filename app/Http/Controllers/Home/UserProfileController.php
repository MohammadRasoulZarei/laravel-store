<?php

namespace App\Http\Controllers\Home;

use App\Models\Product;
use App\Models\Wishlist;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\User;


class UserProfileController extends Controller
{
    public function ordersIndex()
    {
        $orders=auth()->user()->orders()->latest()->paginate(10);
        // dd($orders);
        return view('home.userProfile.orders',compact('orders'));
    }

    public function index()
    {

        return view('home.userProfile.index');
    }
    public function comments()
    {
        $user=auth()->user();
       // dd($user->comments()->with('product')->get());
        return view('home.userProfile.comments',compact('user'));
    }
    public function addTowish(Product $product)
    {


        try {
            if($product->findInWish()){
                Wishlist::where('product_id',$product->id)->where('user_id',auth()->id())->delete( );
                return response(['success'=>"از لیست علاقه مندی ها پاک شد",'action'=>'delete'],200);
              }else{
                Wishlist::create([
                    'user_id'=>auth()->id(),
                    'product_id'=>$product->id
                ]);
                return response(['success'=>"به لیست علاقه مندی ها اضافه شد",'action'=>'add'],200);
              }
        } catch (\Throwable $th) {
           // dd($th->getMessage());

          // return response($th->getMessage());
            return response(['error'=>'jjjj'],422);
        }


    }
    public function wishList()
    {
        $wishes=Wishlist::where('user_id',auth()->id())->with('product')->get();

        return view('home.userProfile.wishList',compact('wishes'));
    }
    public function deleteWish($product_id)
    {
       Wishlist::where(['user_id'=>auth()->id(),'product_id'=>$product_id])->delete();
      return redirect()->back();
    }


}
