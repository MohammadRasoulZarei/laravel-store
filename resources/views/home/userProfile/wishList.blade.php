@extends('home.layouts.home')

@section('title')
    پروفایل کاربر
@endsection

@section('content')
    <div class="breadcrumb-area pt-35 pb-35 bg-gray" style="direction: rtl;">
        <div class="container">
            <div class="breadcrumb-content text-center">
                <ul>
                    <li>
                        <a href="{{route('home.index')}}">صفحه ای اصلی</a>
                    </li>
                    <li class="active"> نظرات </li>
                </ul>
            </div>
        </div>
    </div>

    <!-- my account wrapper start -->
    <div class="my-account-wrapper pt-100 pb-100">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <!-- My Account Page Start -->
                    <div class="myaccount-page-wrapper">
                        <!-- My Account Tab Menu Start -->
                        <div class="row text-right" style="direction: rtl;">
                            <div class="col-lg-3 col-md-4">
                                @include('home.sections.profile_sidebar')
                            </div>
                            <!-- My Account Tab Menu End -->
                            <!-- My Account Tab Content Start -->
                            <div class="col-lg-9 col-md-8">
                                <div class="tab-content" id="myaccountContent">

                                    <div class="myaccount-content">
                                        <h3> لیست علاقه مندی ها </h3>
                                       @if ($wishes)
                                       <div class="table-content table-responsive cart-table-content">
                                        <table>
                                            <thead>
                                                <tr>
                                                    <th> تصویر محصول </th>
                                                    <th> نام محصول </th>
                                                    <th> حذف </th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($wishes as $wish )
                                                <tr>
                                                    <td class="product-thumbnail">
                                                        <a href="{{route('home.product.show',['product'=>$wish->product->slug])}}"><img
                                                                src="{{url(env('PRODUCT_IMAGES_UPLOAD_PATH').$wish->product->primary_image)}}"
                                                                alt=""></a>
                                                    </td>
                                                    <td class="product-name"><a href="{{route('home.product.show',['product'=>$wish->product->slug])}}">
                                                        {{$wish->product->name}}
                                                        </a>
                                                    </td>
                                                    <td class="product-name">
                                                        <a href="{{route('user.dellete.wish',['product'=>$wish->product->id])}}"> <i class="sli sli-trash" style="font-size: 20px"></i> </a>
                                                    </td>
                                                </tr>
                                                @endforeach


                                            </tbody>
                                        </table>
                                    </div>
                                       @else
                                       <div class="alert alert-danger">
                                        لیست علاقمندی های شما خالی است
                                       </div>

                                       @endif


                                    </div>




                                </div>
                            </div> <!-- My Account Tab Content End -->
                        </div>
                    </div> <!-- My Account Page End -->
                </div>
            </div>
        </div>
    </div>
    <!-- my account wrapper end -->


@endsection
