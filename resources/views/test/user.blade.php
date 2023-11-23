@extends('home.layouts.home')

@section('title')
    صفحه تماس با ما
@endsection
@section('style')
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"
        integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin="" />
@endsection

@section('content')
    <div class="breadcrumb-area pt-35 pb-35 bg-gray" style="direction: rtl;">
        <div class="container">
            <div class="breadcrumb-content text-center">
                <ul>
                    <li>
                        <a href="index.html">صفحه ای اصلی</a>
                    </li>
                    <li class="active">فروشگاه </li>
                </ul>
            </div>
        </div>
    </div>

    <form class="text-right " style="direction: rtl" action="{{url('/test')}}" method="POST">
        @csrf
        <div class="col-6 m-auto text-center">

            <select name="user" class="form-control" >
             @foreach (App\Models\User::all() as $user)
             <option {{auth()->id()==$user->id?'selected':''}} value="{{$user->id}}">{{$user->name}}</option>
             @endforeach
            </select>
            <button class="mt-3">اعمال</button>
        </div>
    </form>
@endsection

