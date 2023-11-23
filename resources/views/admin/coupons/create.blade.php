@extends('admin.layouts.admin')

@section('title')
    create coupon
@endsection

@section('content')

    <!-- Content Row -->
    <div class="row">

        <div class="col-xl-12 col-md-12 mb-4 p-4 bg-white">
            <div class="mb-4 text-center text-md-right">
                <h5 class="font-weight-bold">ایجاد تگ</h5>
            </div>
            <hr>

            @include('admin.sections.errors')

            <form action="{{ route('admin.coupons.store') }}" method="POST">
                @csrf

                <div class="form-row">
                    <div class="form-group col-md-3">
                        <label for="name">نام</label>
                        <input class="form-control" id="name" name="name" type="text" value="{{old('name') }}" >
                    </div>
                    <div class="form-group col-md-3">
                        <label for="name">کد</label>
                        <input class="form-control"  name="code" type="text" value="{{old('name') }}" >
                    </div>
                    <div class="form-group col-md-3">
                        <label for="name">نوع</label>
                        <select class="form-control"  name="type"  >
                            <option value="percentage">درصدی</option>
                            <option value="amount">مبلغی</option>
                        </select>
                    </div>
                    <div class="form-group col-md-3">
                        <label for="name">مبلغ</label>
                        <input class="form-control" id="amount" name="amount" type="text" value="{{old('amount') }}" >
                    </div>
                    <div class="form-group col-md-3">
                        <label for="name">درصد</label>
                        <input class="form-control" id="percent" name="percentage" type="text" value="{{old('percent') }}" >
                    </div>
                    <div class="form-group col-md-3">
                        <label for="name">حداکثر مبلغ برای نوع درصدی</label>
                        <input class="form-control" id="" name="max_percentage_amount" type="text" value="{{old('max_for_percent') }}" >
                    </div>
                    <div class="form-group col-md-3">
                        <label for="name">تاریخ انقضا</label>
                        <div class="input-group">
                            <div class="input-group-prepend order-2">
                                <span class="input-group-text" id="data-picker">
                                    <i class="fas fa-clock"></i>
                                </span>
                            </div>
                            <input type="text" class="form-control" id="expire" name="expired_at">
                        </div>
                    </div>
                    <div class="form-group col-12">
                        <label for="name">توضیخات</label>
                        <textarea class="form-control"  name="description"  >{{old('description') }}</textarea>
                    </div>
                </div>

                <button class="btn btn-outline-primary mt-5" type="submit">ثبت</button>
                <a href="{{ route('admin.coupons.index') }}" class="btn btn-dark mt-5 mr-3">بازگشت</a>
            </form>
        </div>

    </div>

@endsection
@section('script')
<script >
    $('#data-picker').MdPersianDateTimePicker({
           targetTextSelector: '#expire',
           englishNumber:true,
           enableTimePicker: true,
           textFormat: 'yyyy-MM-dd HH:mm:ss',
       });
  </script>
@endsection
