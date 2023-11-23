@extends('home.layouts.home')

@section('title')
    صفحه ورود
@endsection

@section('content')
    <div class="breadcrumb-area pt-35 pb-35 bg-gray" style="direction: rtl;">
        <div class="container">
            <div class="breadcrumb-content text-center">
                <ul>
                    <li>
                        <a href="index.html">صفحه ای اصلی</a>
                    </li>
                    <li class="active"> ورود </li>
                </ul>
            </div>
        </div>
    </div>

    <div class="login-register-area pt-100 pb-100" style="direction: rtl;">
        <div class="container">
            <div class="row">
                <div class="col-lg-7 col-md-12 ml-auto mr-auto">
                    <div class="login-register-wrapper">
                        <div class="login-register-tab-list nav">

                            <a class="active" data-toggle="tab" href="#lg2">
                                <h4> عضویت </h4>
                            </a>
                        </div>
                        <div class="tab-content">



                            <div id="lg2" class="tab-pane active">
                                <div class="login-form-container">
                                    <div class="login-register-form">
                                        <form action="{{ route('register') }}" method="post">
                                            @csrf
                                            <div class="input"><input name="name" placeholder="نام" type="text"
                                                    value="{{ old('name') }}">
                                                @error('name')
                                                    <div class="input-error-validation">
                                                        <strong>{{ $message }}</strong>
                                                    </div>
                                                @enderror
                                            </div>
                                            <div class="input"><input name="email" value="{{ old('email') }}"
                                                    placeholder="ایمیل" type="email">
                                                @error('email')
                                                    <div class="input-error-validation">
                                                        <strong>{{ $message }}</strong>
                                                    </div>
                                                @enderror
                                            </div>
                                            <div class="input"> <input value="12345678" type="password" name="password"
                                                    placeholder="رمز عبور">
                                                @error('password')
                                                    <div class="input-error-validation">
                                                        <strong>{{ $message }}</strong>
                                                    </div>
                                                @enderror
                                            </div>
                                            <div class="input"> <input value="12345678" type="password" name="password_confirmation"
                                                    placeholder="تکرار رمز عبور">
                                                @error('password_confirmation')
                                                    <div class="input-error-validation">
                                                        <strong>{{ $message }}</strong>
                                                    </div>
                                                @enderror
                                            </div>

                                            <div class="button-box">
                                                <button type="submit">عضویت</button>
                                                <a href="{{ route('provider.login', ['provider' => 'google']) }}"
                                                    class="btn btn-google btn-block mt-4">
                                                    <i class="sli sli-social-google"></i>
                                                    ایجاد اکانت با گوگل
                                                </a>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
