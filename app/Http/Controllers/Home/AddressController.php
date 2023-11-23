<?php

namespace App\Http\Controllers\Home;

use App\Models\City;
use App\Models\Province;
use App\Models\UserAddress;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;



class AddressController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function index()
    {



        $addresses=UserAddress::where('user_id',auth()->id())->with(['user','province','city'])->get();

        $provinces=Province::all();
     //   dd($addresses);
       return view('home.userProfile.addresses.index',compact('provinces','addresses'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $req)
    {
        if (!auth()->check()) {
            alert()->error("لطفا ابتدا وارد سایت شوید",'تشکر');
            return redirect()->back();
        }

    $req->validateWithBag('create',[
        'title'=>'required',
        'cellphone'=>'required|iran_mobile',
        'province_id'=>'required',
        'city_id'=>'required',
        'postal_code'=>'required|iran_postal_code',
        'address'=>'required',
    ]);

        $data=$req->only('title','cellphone','province_id','city_id','postal_code' ,'address');
       $data['user_id']=auth()->id();
    UserAddress::create($data);
    alert()->success("آدرس با موفقیت ثبت شد",'تشکر');
    return redirect()->back();

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
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
    public function update(Request $req, UserAddress $address)
    {
       // $validate=Validator::make. cation cation cation remmerber!
       $validate= validator($req->all(),[
        'title'=>'required',
        'cellphone'=>'required|iran_mobile',
        'province_id'=>'required',
        'city_id'=>'required',
        'postal_code'=>'required|iran_postal_code',
        'address'=>'required',
       ]);
       if ($validate->fails()) {
        $validate->errors()->add('address_id',$address->id);
        return redirect(url()->previous()."?id=".$address->id."#collaps-target-".$address->id)->withErrors($validate,'edit');
       }
       $data=$req->only('title','cellphone','province_id','city_id','postal_code' ,'address');
       $data['user_id']=auth()->id();
       $address->update($data);
       alert()->success("آدرس با موفقیت ویرایش شد");
       return redirect()->back();

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
    public function getCities($id)
    {
        return City::where('province_id',$id)->get();
    }
}
