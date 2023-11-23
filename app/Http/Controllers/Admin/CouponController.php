<?php

namespace App\Http\Controllers\Admin;

use Carbon\Carbon;
use App\Models\Coupon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Hekmatinasser\Verta\Facades\Verta;

class CouponController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $coupons=Coupon::latest()->paginate(20);
        //dd($coupons);
        return view('admin.coupons.index',compact('coupons'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
      //  dd(Carbon::now());
        return view('admin.coupons.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $req)
    {
       // dd($req->all());
      //  dd(session()->all());
      //  dd(verta(session('time'))->formatDifference());
      // dd(convertShamsiToGregorianDate('1401-05-24 14:12:32'));
     
       $req->validate([
        'name'=>'required',
        'code'=>'required|unique:coupons,code',
        'type'=>'required',
        'expired_at'=>'required',

        'amount'=>'required_if:type,amount',
        'percentage'=>'required_if:type,percentage',
        'max_percentage_amount'=>'required_if:type,percentage'

       ]);
       $data=$req->all();
       $data['expired_at']=Verta::parse($req->expired_at)->datetime();
       Coupon::create($data);
       alert()->success('کوپن مورد نظر ایجاد شد', 'باتشکر');
       return redirect()->route('admin.coupons.index');

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Coupon $coupon)
    {
        return view('admin.coupons.show',compact('coupon'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function delete(Coupon $coupon)
    {
        $coupon->delete();
       return redirect()->back();
    }
}
