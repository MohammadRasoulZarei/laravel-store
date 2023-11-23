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

    <div class="contact-area pt-100 pb-100">
        <div class="container">
            <div class="row text-right" style="direction: rtl;">
                <div class="col-lg-5 col-md-6">
                    <div class="contact-info-area">
                        <h2> لورم ایپسوم متن </h2>
                        <p>
                            لورم ایپسوم متن ساختگی با تولید سادگی نامفهوم از صنعت چاپ و با استفاده از طراحان گرافیک
                            است.
                        </p>
                        <div class="contact-info-wrap">
                            <div class="single-contact-info">
                                <div class="contact-info-icon">
                                    <i class="sli sli-location-pin"></i>
                                </div>
                                <div class="contact-info-content">
                                    @foreach ($config['addresses'] as $address)
                                        <p>{{ $address }}</p>
                                    @endforeach

                                </div>
                            </div>
                            <div class="single-contact-info">
                                <div class="contact-info-icon">
                                    <i class="sli sli-envelope"></i>
                                </div>
                                <div class="contact-info-content">
                                    <p>
                                        @foreach ($config['socials'] as $name => $value)
                                            <a href="{{ $value }}">{{ $name }}</a>
                                            {{ $loop->last ? '' : '/' }}
                                        @endforeach
                                    </p>
                                </div>
                            </div>
                            <div class="single-contact-info">
                                <div class="contact-info-icon">
                                    <i class="sli sli-screen-smartphone"></i>
                                </div>
                                <div class="contact-info-content">
                                    <p style="direction: ltr;">
                                        @foreach ($config['telephones'] as $telephone)
                                            {{ $telephone }}
                                            {{ $loop->last ? '' : '/' }}
                                        @endforeach
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-7 col-md-6">
                    <div class="contact-from contact-shadow">
                        @include('home.sections.errors')
                        <form id="contact-form" action="{{ url('/contact-us') }}" method="post">
                            @csrf
                            <input name="name" type="text" placeholder="نام شما">
                            <input name="email" type="email" placeholder="ایمیل شما">
                            <input name="subject" type="text" placeholder="موضوع پیام">
                            <textarea name="text" placeholder="متن پیام"></textarea>
                            <div id="contact_us_id"></div>
                            <button class="submit" type="submit"> ارسال پیام </button>
                        </form>
                        {!!  GoogleReCaptchaV3::render(['contact_us_id'=>'contact_us']) !!}

                    </div>
                </div>
            </div>
            <div class="contact-map pt-100">
                <div id="map"></div>
            </div>
        </div>
    </div>
@endsection
@section('script')
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"
        integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>

    <script>
        var map = L.map('map').setView([{{ $config['longitude'] }}, {{ $config['latitude'] }}], 15);
        L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
            maxZoom: 19,
            attribution: '&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>'
        }).addTo(map);
        var marker = L.marker([{{ $config['longitude'] }}, {{ $config['latitude'] }}]).addTo(map);
        marker.bindPopup("<b>دفتر میدان آزادی</b><br>شعبه یک.").openPopup();
        //   var map = L.map('map').setView([51.505, -0.09], 13);
    </script>
@endsection
