@extends('admin.layouts.admin')

@section('title')
    show coupons
@endsection

@section('content')

    <!-- Content Row -->
    <div class="row">

        <div class="col-xl-12 col-md-12 mb-4 p-4 bg-white">
            <div class="mb-4 text-center text-md-right">
                <h5 class="font-weight-bold">تگ : {{ $coupon->name }}</h5>
            </div>
            <hr>

            <div class="row">
                <div class="form-group col-md-3">
                    <label>نام</label>
                    <input class="form-control" type="text" value="{{ $coupon->name }}" disabled>
                </div>
                <div class="form-group col-md-3">
                    <label>کد</label>
                    <input class="form-control" type="text" value="{{ $coupon->code }}" disabled>
                </div>
                <div class="form-group col-md-3">
                    <label>وضعیت</label>
                    <input class="form-control {{ $coupon->status['class'] }}" type="text" value="{{ $coupon->status['value'] }}" disabled>
                </div>
                <div class="form-group col-md-3">
                    <label>نوع</label>
                    <input class="form-control" type="text" value="{{ $coupon->type }}" disabled>
                </div>
                <div class="form-group col-md-3">
                    <label>مبلغ</label>
                    <input class="form-control" type="text" value="{{ $coupon->amount }}" disabled>
                </div>
                <div class="form-group col-md-3">
                    <label>درصد</label>
                    <input class="form-control" type="text" value="{{ $coupon->percentage }}" disabled>
                </div>
                <div class="form-group col-md-3">
                    <label>حداکثر مبلغ برای نوع درصدی</label>
                    <input class="form-control" type="text" value="{{ $coupon->max_percentage_amount }}" disabled>
                </div>
                <div class="form-group col-md-3">
                    <label>تاریخ انقضا</label>
                    <input class="form-control" type="text" value="{{ verta($coupon->expired_at) }}" disabled>
                </div>
                <div class="form-group col-md-3">
                    <label>تاریخ ایجاد</label>
                    <input class="form-control" type="text" value="{{ verta($coupon->created_at) }}" disabled>
                </div>

            </div>

            <a href="{{ route('admin.coupons.index') }}" class="btn btn-dark mt-5">بازگشت</a>

        </div>

    </div>

@endsection
