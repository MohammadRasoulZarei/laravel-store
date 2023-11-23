@extends('home.layouts.home')

@section('title')
    آدرس های کاربر
@endsection

@section('content')

    <div class="breadcrumb-area pt-35 pb-35 bg-gray" style="direction: rtl;">
        <div class="container">
            <div class="breadcrumb-content text-center">
                <ul>
                    <li>
                        <a href="{{ route('home.index') }}">صفحه ای اصلی</a>
                    </li>
                    <li class="active"> پروفایل </li>
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

                                    <div class="myaccount-content address-content">
                                        <h3> آدرس ها </h3>
                                        @foreach ($addresses as $address)
                                            <div>
                                                <address>
                                                    <p>
                                                        <strong>{{ $address->user->name }} </strong>
                                                        <span class="mr-2"> عنوان آدرس : <span> {{ $address->title }}
                                                            </span> </span>
                                                    </p>
                                                    <p>
                                                        {{ $address->address }}
                                                        <br>
                                                        <span> استان : {{ $address->province->name }} </span>
                                                        <span> شهر : {{ $address->city->name }} </span>
                                                    </p>
                                                    <p>
                                                        کدپستی :
                                                        {{ $address->postal_code }}
                                                    </p>
                                                    <p>
                                                        شماره موبایل :
                                                        {{ $address->cellphone }}
                                                    </p>

                                                </address>
                                                <a data-toggle="collapse" href="#collaps-target-{{$address->id}}" class="check-btn sqr-btn ">
                                                    <i class="sli sli-pencil"></i>
                                                    ویرایش آدرس
                                                </a>

                                                <div id="collaps-target-{{$address->id}}"
                                                    style="{{(count($errors->edit) >0 and $errors->edit->first('address_id')==$address->id)?'display:block':''}}"
                                                    class="collapse collapse-update-content">

                                                    <form
                                                        action="{{ route('user.addresses.update', ['address' => $address->id]) }}"
                                                        method="post">
                                                        @csrf
                                                        @method('put')
                                                        <div class="row">

                                                            <div class="tax-select col-lg-6 col-md-6">
                                                                <label>
                                                                    عنوان
                                                                </label>
                                                                <input type="text" name="title"
                                                                    value="{{ $address->title }}">
                                                                @error('title', 'edit')
                                                                    <p class="input-error-validation">
                                                                        <strong>{{ $message }}</strong>
                                                                    </p>
                                                                @enderror
                                                            </div>
                                                            <div class="tax-select col-lg-6 col-md-6">
                                                                <label>
                                                                    شماره تماس
                                                                </label>
                                                                <input type="text" name="cellphone"
                                                                    value="{{ $address->cellphone }}">
                                                                @error('cellphone', 'edit')
                                                                    <p class="input-error-validation">
                                                                        <strong>{{ $message }}</strong>
                                                                    </p>
                                                                @enderror
                                                            </div>
                                                            <div class="tax-select col-lg-6 col-md-6">
                                                                <label>
                                                                    استان
                                                                </label>
                                                                <select name="province_id" class="email s-email s-wid province-select">
                                                                    @foreach ($provinces as $province)
                                                                        <option value="{{ $province->id }}"
                                                                            {{ $province->id == $address->province_id ? 'selected' : '' }}>
                                                                            {{ $province->name }}
                                                                        </option>
                                                                    @endforeach
                                                                </select>
                                                                @error('province_id', 'edit')
                                                                    <p class="input-error-validation">
                                                                        <strong>{{ $message }}</strong>
                                                                    </p>
                                                                @enderror
                                                            </div>
                                                            <div class="tax-select col-lg-6 col-md-6">
                                                                <label>
                                                                    شهر
                                                                </label>
                                                                <select name="city_id" class="email s-email s-wid city-select">
                                                                    <option value="{{ $address->city_id }}">
                                                                        {{ $address->city->name }}</option>
                                                                </select>
                                                                @error('city_id', 'edit')
                                                                    <p class="input-error-validation">
                                                                        <strong>{{ $message }}</strong>
                                                                    </p>
                                                                @enderror

                                                            </div>
                                                            <div class="tax-select col-lg-6 col-md-6">
                                                                <label>
                                                                    آدرس
                                                                </label>
                                                                <input type="text" name="address" value="{{ $address->address }}">
                                                                @error('address', 'edit')
                                                                    <p class="input-error-validation">
                                                                        <strong>{{ $message }}</strong>
                                                                    </p>
                                                                @enderror
                                                            </div>
                                                            <div class="tax-select col-lg-6 col-md-6">
                                                                <label>
                                                                    کد پستی
                                                                </label>
                                                                <input type="text" name="postal_code" value="{{ $address->postal_code }}">
                                                                @error('postal_code', 'edit')
                                                                    <p class="input-error-validation">
                                                                        <strong>{{ $message }}</strong>
                                                                    </p>
                                                                @enderror
                                                            </div>

                                                            <div class=" col-lg-12 col-md-12">
                                                                <button class="cart-btn-2" type="submit"> ویرایش
                                                                    آدرس
                                                                </button>
                                                            </div>

                                                        </div>

                                                    </form>

                                                </div>

                                            </div>

                                            <hr>
                                        @endforeach





                                        <button class="collapse-address-create mt-3" type="submit"> ایجاد آدرس
                                            جدید </button>
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
                                                        <input type="text" name='cellphone'
                                                            value="{{ old('cellphone') }}">
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
                                                        <select name='province_id'
                                                            class="email s-email s-wid province-select">
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
                            </div> <!-- My Account Tab Content End -->
                        </div>
                    </div> <!-- My Account Page End -->
                </div>
            </div>
        </div>
    </div>
    <!-- my account wrapper end -->
@endsection
@section('script')
    <script>
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
