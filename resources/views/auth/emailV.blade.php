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
                    <li class="active"> تایید ایمیل </li>
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

                                    <p>با کلیک روی دکمه زیر لینک حاوی تایید ایمیل برای شما ارسال می شود</p>
                                    <form action="{{ route('verification.send') }}" method="post" >
                                        @csrf
                                        <button class="btn btn-outline-info" id="timer-btn" type="submit">ارسال مجدد ایمیل </button>
                                    </form>
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
//          function timer() {
//           //  alert('timer');
//             let time = "0:10";
//             let interval = setInterval(function() {
//                 let countdown = time.split(':');
//                 let minutes = parseInt(countdown[0], 10);
//                 let seconds = parseInt(countdown[1], 10);
//                 --seconds;
//                 minutes = (seconds < 0) ? --minutes : minutes;
//                 if (minutes < 0) {
//                     clearInterval(interval);
//                     $('#timer-btn').attr('id', 'resendBtn');
//                     $('#resendBtn').text('ارسال مجدد');
//                     $('#resendBtn').removeClass('disabled');
//                     $('#resendBtn').click(function() {

//                         if ($(this).attr('id')=='resendBtn') {
//                             resend(loginToken);
//                         }

//                     });

//                 };
//                 seconds = (seconds < 0) ? 59 : seconds;
//                 seconds = (seconds < 10) ? '0' + seconds : seconds;
//                 //minutes = (minutes < 10) ?  minutes : minutes;
//                 $('#timer-btn').html(minutes + ':' + seconds);
//                 time = minutes + ':' + seconds;
//             }, 1000);
//         }
//  timer();
    </script>
@endsection
