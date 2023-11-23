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
                            <a class="active" data-toggle="tab" href="#lg1">
                                <h4> ورود </h4>
                            </a>

                        </div>
                        <div class="tab-content">

                            <div id="lg1" class="tab-pane active">
                                <div class="login-form-container">
                                    <div class="login-register-form">
                                        <form id="login-form">
                                            @csrf
                                            <div class="input">
                                                <input id="phone-input" class="text-left" style="direction:ltr"
                                                    name="phone" placeholder="09********" type="text">

                                                <div class="input-error-validation">
                                                    <strong></strong>
                                                </div>
                                            </div>

                                            <div class="button-box text-center">
                                                <div class="login-toggle-btn d-flex justify-content-between">
                                                    <div>
                                                        <input name="remember" type="checkbox">
                                                        <label> مرا بخاطر بسپار </label>
                                                    </div>

                                                </div>
                                                <button id="submit" class=" btn btn-sm" type="button">دریافت
                                                    پیامک</button>

                                            </div>
                                        </form>
                                        <form id="check-otp-form" class='d-none'>


                                            <div class="input "><input id="check-input" placeholder="رمزیکبار مصرف"
                                                    type="text">

                                                <div class="input-error-validation">
                                                    <strong>

                                                    </strong>
                                                </div>
                                            </div>

                                            <div class="button-box text-center">
                                                <div class="login-toggle-btn d-flex justify-content-between">
                                                    <button id="otp-button" class=" btn btn-sm " type="button">ورود
                                                    </button>
                                                    <button id="timer-btn" class="disabled" type="button"></button>



                                                </div>



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
@section('script')
    <script>


        swal({
            'text': 'این بخش برای محدودیت ارسال پیامک فقط روی  شماره تماسی مشخص کار می کند و در اینجا فقط برای کاربران ثبت نامی هست، چون با احرازهویت اصلی تداخل نداشته باشیم',
            'icon': 'warning',
            'timer': 10000,

        });

        let loginToken;


        function resend(loginToken) {
            //alert('resend');
            $.post("{{ url('resend-otp') }}", {
                '_token': "{{ csrf_token() }}",
                'login_token': loginToken,

            }, function(response, status) {
                //  console.log('sssss', response, status);

                loginToken = response.login_token;
                $('#resendBtn').attr('id', 'timer-btn');

                $('#timer-btn').addClass('disabled');
                timer();
            }).fail(function(response) {
                console.log('fff', response.responseJSON, 'ggg');


            });
        }

        function timer() {
            //  alert('timer');
            let time = "0:10";
            let interval = setInterval(function() {
                let countdown = time.split(':');
                let minutes = parseInt(countdown[0], 10);
                let seconds = parseInt(countdown[1], 10);
                --seconds;
                minutes = (seconds < 0) ? --minutes : minutes;
                if (minutes < 0) {
                    clearInterval(interval);
                    $('#timer-btn').attr('id', 'resendBtn');
                    $('#resendBtn').text('ارسال مجدد');
                    $('#resendBtn').removeClass('disabled');
                    $('#resendBtn').click(function() {

                        if ($(this).attr('id') == 'resendBtn') {
                            resend(loginToken);
                        }

                    });

                };
                seconds = (seconds < 0) ? 59 : seconds;
                seconds = (seconds < 10) ? '0' + seconds : seconds;
                //minutes = (minutes < 10) ?  minutes : minutes;
                $('#timer-btn').html(minutes + ':' + seconds);
                time = minutes + ':' + seconds;
            }, 1000);
        }
        $('#submit').click(function() {
            let phone = $('#phone-input').val();
            console.log(phone);
            if (phone.length > 9) {
                $.post("{{ route('phone.login') }}", {
                    'phone': phone,
                    '_token': "{{ csrf_token() }}"
                }, function(response, status) {
                    if (response.login_token) {
                        loginToken = response.login_token;
                        swal({
                            'text': 'رمز یکبار مصرف برای شما ارسال شد',
                            'icon': 'success',
                            'timer': 1000
                        });

                        $('#login-form').addClass('d-none');
                        timer();
                        $('#check-otp-form').removeClass('d-none');

                    } else {
                        alert('این شماره تماس ثبت نام نشده است');
                    }


                    // console.log(response,status);
                }).fail(function(response) {
                    //console.log(response.responseJSON);

                    $('#login-form strong').html(response.responseJSON.errors.phone);
                });


            } else {
                $('#login-form strong').html('فرمت شماره تماس درست نیست');
            }


        });

        $('#otp-button').click(function() {

            $.post("{{ url('check-otp') }}", {
                '_token': "{{ csrf_token() }}",
                'login_token': loginToken,
                'otp': $('#check-input').val()
            }, function(response, status) {

                 console.log(response,status,'here');
                $(location).attr('href', "{{ route('home.index') }}");
            }).fail(function(response) {
                // console.log('fff',response.responseJSON,'ggg');
                $('#check-otp-form strong').html(response.responseJSON.errors.otp);

            });
        });
    </script>
@endsection
