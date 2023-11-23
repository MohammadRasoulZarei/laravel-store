@extends('home.layouts.home')

@section('title')
    صفحه سفارش
@endsection

@section('content')
    <div class="breadcrumb-area pt-35 pb-35 bg-gray" style="direction: rtl;">
        <div class="container">
            <div class="breadcrumb-content text-center">
                <ul>
                    <li>
                        <a href="index.html">صفحه ای اصلی</a>
                    </li>
                    <li class="active"> سفارش </li>
                </ul>
            </div>
        </div>
    </div>


    <!-- compare main wrapper start -->
    <div class="checkout-main-area pt-70 pb-70 text-right" style="direction: rtl;">

        <div class="container">

            <div class="customer-zone mb-20">
                <p class="cart-page-title">
                    کد تخفیف دارید؟
                    <a class="checkout-click3" href="#"> میتوانید با کلیک در این قسمت کد خود را اعمال کنید </a>
                </p>
                <div class="checkout-login-info3">
                    <form action="{{ route('home.cart.checkCoupon') }}" method="post">
                        @csrf
                        <input name="code" type="text" placeholder="کد تخفیف">
                        <input type="submit" value="اعمال کد تخفیف">
                    </form>
                </div>
            </div>

            <div class="checkout-wrap pt-30">
                <div class="row">

                    <div class="col-lg-7">
                        <div class="billing-info-wrap mr-50">
                            <h3> آدرس تحویل سفارش </h3>

                            <div class="row">
                                <p>
                                    لورم ایپسوم متن ساختگی با تولید سادگی نامفهوم از صنعت چاپ و با استفاده از طراحان
                                    گرافیک است. چاپگرها و متون بلکه روزنامه و مجله در ستون و سطرآنچنان که لازم است
                                </p>
                                <div class="col-lg-6 col-md-6">
                                    <div class="billing-info tax-select mb-20">
                                        <label> انتخاب آدرس تحویل سفارش <abbr class="required"
                                                title="required">*</abbr></label>

                                        <select  class="email s-email s-wid" id="address-select">
                                            @foreach ($addresses as $address)
                                                <option value="{{ $address->id }}">{{ $address->title }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-6 col-md-6 pt-30">
                                    <button class="collapse-address-create" type="submit"> ایجاد آدرس جدید </button>
                                </div>

                                <div class="col-lg-12">
                                    <div class="collapse-address-create-content"
                                        style="{{ count($errors->create) > 0 ? 'display:block' : '' }}">

                                        <form action="{{ route('user.addresses.index') }}" method="post">
                                            @csrf

                                            <div class="row">

                                                <div class="tax-select col-lg-6 col-md-6">
                                                    <label>
                                                        عنوان
                                                    </label>
                                                    <input value="{{ old('title') }}" type="text" name="title">
                                                    @error('title', 'create')
                                                        <p class="input-error-validation">
                                                            <strong>{{ $message }}</strong>
                                                        </p>
                                                    @enderror
                                                </div>
                                                <div class="tax-select col-lg-6 col-md-6">
                                                    <label>
                                                        شماره تماس
                                                    </label>
                                                    <input type="text" name='cellphone' value="{{ old('cellphone') }}">
                                                    @error('cellphone', 'create')
                                                        <p class="input-error-validation">
                                                            <strong>{{ $message }}</strong>
                                                        </p>
                                                    @enderror
                                                </div>
                                                <div class="tax-select col-lg-6 col-md-6">
                                                    <label>
                                                        استان
                                                    </label>
                                                    <select name='province_id' class="email s-email s-wid province-select">
                                                        <option requierd value="">انتخاب استان</option>
                                                        @foreach ($provinces as $province)
                                                            <option value="{{ $province->id }}">{{ $province->name }}
                                                            </option>
                                                        @endforeach

                                                    </select>
                                                    @error('province_id', 'create')
                                                        <p class="input-error-validation">
                                                            <strong>{{ $message }}</strong>
                                                        </p>
                                                    @enderror
                                                </div>
                                                <div class="tax-select col-lg-6 col-md-6">
                                                    <label>
                                                        شهر
                                                    </label>
                                                    <select name='city_id' class="email s-email s-wid city-select">


                                                    </select>
                                                    @error('city_id', 'create')
                                                        <p class="input-error-validation">
                                                            <strong>{{ $message }}</strong>
                                                        </p>
                                                    @enderror
                                                </div>
                                                <div class="tax-select col-lg-6 col-md-6">
                                                    <label>
                                                        آدرس
                                                    </label>
                                                    <input type="text" name='address' value="{{ old('address') }}">
                                                    @error('address', 'create')
                                                        <p class="input-error-validation">
                                                            <strong>{{ $message }}</strong>
                                                        </p>
                                                    @enderror
                                                </div>
                                                <div class="tax-select col-lg-6 col-md-6">
                                                    <label>
                                                        کد پستی
                                                    </label>
                                                    <input type="text" name='postal_code'
                                                        value="{{ old('postal_code') }}">
                                                    @error('postal_code', 'create')
                                                        <p class="input-error-validation">
                                                            <strong>{{ $message }}</strong>
                                                        </p>
                                                    @enderror
                                                </div>

                                                <div class=" col-lg-12 col-md-12">

                                                    <button class="cart-btn-2" type="submit"> ثبت آدرس
                                                    </button>
                                                </div>



                                            </div>

                                        </form>

                                    </div>
                                </div>

                            </div>

                        </div>
                    </div>

                    <div class="col-lg-5">
                        <form action="{{ route('home.payment') }}" method="post">
                            @csrf
                            <input type="hidden" id="address-input" name="address_id">
                            <div class="your-order-area">
                                <h3> سفارش شما </h3>
                                <div class="your-order-wrap gray-bg-4">
                                    <div class="your-order-info-wrap">
                                        <div class="your-order-info">
                                            <ul>
                                                <li> محصول <span> جمع </span></li>
                                            </ul>
                                        </div>
                                        <div class="your-order-middle">
                                            <ul>
                                                @foreach (\Cart::getContent() as $item)
                                                    @php

                                                        $productVariaton = App\Models\ProductVariation::findOrFail($item->attributes->id);
                                                    @endphp
                                                    <li class='d-flex justify-content-between'>
                                                        <div>
                                                            {{ $item->name }} <span
                                                                style="font-size: 11px;float:none;color:red">(تعداد:{{ $item->quantity }})
                                                            </span>
                                                            <p style="font-size: 12px;color:red">
                                                                {{ App\Models\Attribute::find($item->attributes->attribute_id)->name }}
                                                                : {{ $item->attributes->value }}
                                                            </p>
                                                        </div>
                                                        @if ($item->attributes->is_sale)
                                                            <span>

                                                                {{ number_format($item->price) }}
                                                                تومان<br>
                                                                <span
                                                                    style="text-decoration:line-through;color:red">{{ number_format($item->attributes->price) }}</span>

                                                            </span>
                                                        @else
                                                            <span>

                                                                {{ number_format($item->price) }}
                                                                تومان
                                                            </span>
                                                        @endif
                                                    </li>
                                                @endforeach

                                            </ul>
                                        </div>
                                        <div class="your-order-info order-subtotal">
                                            <ul>
                                                <li> مبلغ تخفیف کالا ها
                                                    <span>
                                                        {{ number_format(discountAmount()) }}
                                                        تومان
                                                    </span>
                                                </li>
                                            </ul>
                                        </div>
                                        <div class="your-order-info order-subtotal">
                                            <ul>
                                                <li> مبلغ
                                                    <span>
                                                        {{ number_format(\Cart::getTotal()) }}
                                                        تومان
                                                    </span>
                                                </li>
                                            </ul>
                                        </div>

                                        <div class="your-order-info order-subtotal">
                                            <ul>
                                                <li>مبلغ کد تخفیف
                                                    <span>
                                                        @if (session('coupon.discount'))
                                                            {{ number_format(session('coupon.discount')) }}
                                                            تومان
                                                        @else
                                                            ندارد
                                                        @endif
                                                    </span>
                                                </li>
                                            </ul>
                                        </div>

                                        <div class="your-order-info order-shipping">
                                            <ul>
                                                <li> هزینه ارسال
                                                    <span>
                                                        {{ number_format(cartTotalDelivery()) }}
                                                        تومان
                                                    </span>
                                                </li>
                                            </ul>
                                        </div>
                                        <div class="your-order-info order-total">
                                            <ul>
                                                <li>جمع کل
                                                    <span>
                                                        {{ number_format(CartFinalTotal()) }}
                                                        تومان </span>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                    <div class="payment-method">
                                        <div class="pay-top sin-payment">
                                            <input id="zarinpal" class="input-radio" type="radio" value="zarinpal"
                                                checked="checked" name="payment_method">
                                            <label for="zarinpal"> درگاه پرداخت زرین پال </label>
                                            <div class="payment-box payment_method_bacs">
                                                <p>
                                                    لورم ایپسوم متن ساختگی با تولید سادگی نامفهوم از صنعت چاپ و با استفاده
                                                    از طراحان گرافیک است.
                                                </p>
                                            </div>
                                        </div>
                                        <div class="pay-top sin-payment">
                                            <input id="pay" class="input-radio" type="radio" value="pay"
                                                name="payment_method">
                                            <label for="pay">درگاه پرداخت پی</label>
                                            <div class="payment-box payment_method_bacs">
                                                <p>
                                                    لورم ایپسوم متن ساختگی با تولید سادگی نامفهوم از صنعت چاپ و با استفاده
                                                    از طراحان گرافیک است.
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="Place-order mt-40">
                                    <button type="submit">ثبت سفارش</button>
                                </div>
                            </div>
                        </form>
                    </div>

                </div>
            </div>

        </div>

    </div>

    <!-- compare main wrapper end -->
@endsection
@section('script')
    <script>
        $('#address-input').val($('#address-select').val());
        $('#address-select').on('change', function(){
            $('#address-input').val($('#address-select').val());
        })
        $('.province-select').on('change', function() {
            var provinceID = $(this).val();
            $.get('{{ url('profile/get-cities/') }}' + '/' + provinceID, function(response, status) {
                console.log(response);
                $('.city-select').empty();
                response.forEach(city => {


                    $('.city-select').append(`<option value="${city.id}">${city.name}</option> `);

                });

            }).fail(function(response, status) {
                console.log('failed', response);
            });
        })
    </script>
@endsection
