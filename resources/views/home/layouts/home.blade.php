<!DOCTYPE html>
<html class="no-js" lang="fa">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>journab.com - @yield('title')</title>

    <!-- Custom styles for this template-->
    <link href="{{ asset('/css/home.css') }}" rel="stylesheet">
    <link href="{{ asset('/css/mystyle.css') }}" rel="stylesheet">
    @yield('style')
    {!! SEO::generate() !!}
</head>

<body>

    {{-- @yield('content') --}}

    <div class="wrapper">

        <div class="text-center">
            <div id="overlayer"></div>
            <span class="loader">
                <span class="loader-inner"></span>
            </span>
        </div>

        @include('home.sections.header')

        @include('home.sections.mobile_off_canvas')

        @yield('content')

        @include('home.sections.footer')



    </div>


    <!-- JavaScript-->

    <script src="{{ asset('/js/home/jquery-1.12.4.min.js') }}"></script>
    <script>
        $(window).load(function(){
            $('#overlayer').fadeOut('slow');
            $('.loader').fadeOut('fast');
        });
    </script>
    <script src="{{ asset('/js/home/plugins.js') }}"></script>
    <script src="{{ asset('/js/home.js') }}"></script>
    <script src="{{ asset('/js/home/rating.js') }}"></script>

    @include('sweetalert::alert')


    {!! GoogleReCaptchaV3::init() !!}
    @yield('script')
    <
</body>

</html>
