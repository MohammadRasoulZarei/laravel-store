@extends('home.layouts.home')

@section('title')
    صفحه ای اصلی
@endsection

@section('content')
    <div class="slider-area section-padding-1">
        <div class="slider-active owl-carousel nav-style-1">
            @foreach ($sliders as $slider)
                <div class="single-slider slider-height-1 bg-paleturquoise">
                    <div class="container">
                        <div class="row align-items-center">
                            <div class="col-xl-6 col-lg-6 col-md-6 col-12 col-sm-6 text-right">
                                <div class="slider-content slider-animated-1">
                                    <h1 class="animated"> {{ $slider->title }}</h1>
                                    <p class="animated">
                                        {{ $slider->text }}
                                    </p>
                                    <div class="slider-btn btn-hover">
                                        <a class="animated" href="{{ $slider->button_link }}">
                                            <i class="{{ $slider->button_icon }}"></i>
                                            {{ $slider->button_text }}
                                        </a>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-6 col-lg-6 col-md-6 col-12 col-sm-6">
                                <div class="slider-single-img slider-animated-1">

                                    <img class="animated" src="{{ url(env('BANNER_IMAGES_UPLOAD_PATH') . $slider->image) }}"
                                        alt="{{ $slider->title }}" />
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach


        </div>
    </div>

    <div class="banner-area pt-100 pb-65">
        <div class="container">
            <div class="row">
                @foreach ($banners as $banner)
                    @if ($banner->type == 'index-top')
                        <div class="col-lg-4 col-md-4">
                            <div class="single-banner mb-30 scroll-zoom">
                                <a href="{{ $banner->link }}"><img class="animated"
                                        src="{{ url(env('BANNER_IMAGES_UPLOAD_PATH') . $banner->image) }}"
                                        alt="" /></a>
                                <div class="banner-content-2 banner-position-5">
                                    <h4>{{ $banner->title }}</h4>
                                </div>
                            </div>
                        </div>
                    @endif
                @endforeach

            </div>
        </div>
    </div>

    <div class="product-area pb-70">
        <div class="container">
            <div class="section-title text-center pb-40">
                <h2> لورم ایپسوم </h2>
                <p>
                    لورم ایپسوم متن ساختگی با تولید سادگی نامفهوم از صنعت چاپ و با استفاده از طراحان گرافیک است.
                    چاپگرها و متون
                    بلکه روزنامه و مجله
                </p>
            </div>
            <div class="product-tab-list nav pb-60 text-center flex-row-reverse">
                <a class="active" href="#product-1" data-toggle="tab">
                    <h4>مردانه</h4>
                </a>
                <a href="#product-2" data-toggle="tab">
                    <h4>زنانه</h4>
                </a>
                <a href="#product-3" data-toggle="tab">
                    <h4>بچه گانه</h4>
                </a>
            </div>
            <div class="tab-content jump-2">
                <div id="product-1" class="tab-pane active">
                    <div class="ht-products product-slider-active owl-carousel">
                        <!--Product Start-->
                        @foreach ($products as $product)
                            <div class="ht-product ht-product-action-on-hover ht-product-category-right-bottom mb-30">
                                <div class="ht-product-inner">
                                    <div class="ht-product-image-wrap">
                                        <a href="{{ route('home.product.show', ['product' => $product->slug]) }}"
                                            class="ht-product-image">
                                            <img src="{{ url(env('PRODUCT_IMAGES_UPLOAD_PATH') . $product->primary_image) }}"
                                                alt="Universal Product Style" />
                                        </a>
                                        <div class="ht-product-action">
                                            <ul>
                                                <li>
                                                    <a href="#" onclick="setPrice()" data-toggle="modal"
                                                        data-target="#productModal-{{ $product->id }}"><i
                                                            class="sli sli-magnifier"></i><span
                                                            class="ht-product-action-tooltip"> مشاهده سریع
                                                        </span></a>
                                                </li>
                                                <li>
                                                    @auth
                                                        @if ($product->isInWish())
                                                            <a class="wish-link-slidly" product='{{ $product->id }}'><i
                                                                    class="fa fa-heart" style="color:red"></i><span
                                                                    class="ht-product-action-tooltip"> پاک کردن از
                                                                    علاقه مندی ها </span></a>
                                                        @else
                                                            <a class="wish-link-slidly" product='{{ $product->id }}'><i
                                                                    class="sli sli-heart"></i><span
                                                                    class="ht-product-action-tooltip"> افزودن به
                                                                    علاقه مندی ها </span></a>
                                                        @endif
                                                    @else
                                                        <a href="#"><i class="sli sli-heart"></i><span
                                                                class="ht-product-action-tooltip"> ابتدا وارد سایت شوید
                                                            </span></a>
                                                    @endauth
                                                </li>
                                                <li>
                                                    <a
                                                        href="{{ route('product.compare.add', ['product' => $product->id]) }}"><i
                                                            class="sli sli-refresh"></i><span
                                                            class="ht-product-action-tooltip"> مقایسه
                                                        </span></a>
                                                </li>

                                            </ul>
                                        </div>
                                    </div>
                                    <div class="ht-product-content">
                                        <div class="ht-product-content-inner">
                                            <div class="ht-product-categories">
                                                <a href="#">{{ $product->category->name }}</a>
                                            </div>
                                            <h4 class="ht-product-title text-right">
                                                <a href="{{ route('home.product.show', ['product' => $product->slug]) }}">
                                                    {{ $product->name }}</a>
                                            </h4>
                                            <div class="ht-product-price">
                                                @if ($product->quantity_check)
                                                    @if ($product->sale_price)
                                                        <span class="new">
                                                            {{ $product->sale_price->sale_price }}
                                                            تومان
                                                        </span>
                                                        <span class="old">
                                                            {{ $product->sale_price->price }}
                                                            تومان
                                                        @else
                                                            <span class="new">
                                                                {{ $product->real_price->price }}
                                                                تومان
                                                            </span>
                                                    @endif
                                                @else
                                                    <div class="not-in-stock">
                                                        <p>ناموجود</p>
                                                    </div>
                                                @endif

                                            </div>
                                            <div class="ht-product-ratting-wrap">
                                                <div data-rating-stars="5" data-rating-readonly="true"
                                                    data-rating-value="{{ ceil($product->rates->avg('rate')) }}">
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        @endforeach

                        <!--Product End-->



                    </div>
                </div>



            </div>
        </div>
    </div>

    <div class="testimonial-area pt-80 pb-95 section-margin-1"
        style="background-image: url({{ asset('images/home/bg-1.jpg') }});">
        <div class="container">
            <div class="row">
                <div class="col-lg-10 ml-auto mr-auto">
                    <div class="testimonial-active owl-carousel nav-style-1">
                        <div class="single-testimonial text-center">
                            <img src="{{ asset('images/home/testi-1.png') }}" alt="" />
                            <p>
                                لورم ایپسوم متن ساختگی با تولید سادگی نامفهوم از صنعت چاپ و با استفاده از طراحان
                                گرافیک است. چاپگرها و
                                متون بلکه روزنامه و مجله در ستون و سطرآنچنان که لازم است و برای شرایط فعلی تکنولوژی
                                مورد نیاز و
                                کاربردهای متنوع با هدف بهبود ابزارهای کاربردی می باشد. کتابهای زیادی در شصت و سه
                                درصد گذشته، حال و
                                آینده شناخت فراوان جامعه و متخصصان را می طلبد تا با نرم افزارها شناخت
                            </p>
                            <div class="client-info">
                                <img src="{{ asset('images/home/testi.png') }}" alt="" />
                                <h5>لورم ایپسوم</h5>
                            </div>
                        </div>
                        <div class="single-testimonial text-center">
                            <img src="{{ asset('images/home/testi-2.png') }}" alt="" />
                            <p>
                                لورم ایپسوم متن ساختگی با تولید سادگی نامفهوم از صنعت چاپ و با استفاده از طراحان
                                گرافیک است. چاپگرها و
                                متون بلکه روزنامه و مجله در ستون و سطرآنچنان که لازم است و برای شرایط فعلی تکنولوژی
                                مورد نیاز و
                                کاربردهای متنوع با هدف بهبود ابزارهای کاربردی می باشد. کتابهای زیادی در شصت و سه
                                درصد گذشته، حال و
                                آینده شناخت فراوان جامعه و متخصصان را می طلبد تا با نرم افزارها شناخت
                            </p>
                            <div class="client-info">
                                <img src="{{ asset('images/home/testi.png') }}" alt="" />
                                <h5>لورم ایپسوم</h5>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>



    <div class="banner-area pb-120">
        <div class="container">
            <div class="row">
                @php
                    $s = 0;
                @endphp
                @foreach ($banners as $banner)
                    @if ($banner->type == 'index-bottom')
                        <div class="col-lg-6 col-md-6 text-right">
                            <div class="single-banner mb-30 scroll-zoom">
                                <a href="{{ route('home.product.show', ['product' => $product->slug]) }}"><img
                                        src="{{ url(env('BANNER_IMAGES_UPLOAD_PATH') . $banner->image) }}"
                                        alt="" /></a>
                                <div class="banner-content {{ $s ? 'banner-position-3' : 'banner-position-4' }}">
                                    <h3> {{ $banner->title }}</h3>
                                    <h2> {{ $banner->text }} <br />متن </h2>
                                    <a href="{{ route('home.product.show', ['product' => $product->slug]) }}">
                                        {{ $banner->button_text }}</a>
                                </div>
                            </div>
                        </div>
                        @php
                            $s = 1;
                        @endphp
                    @endif
                @endforeach



            </div>
        </div>
    </div>

    <div class="feature-area" style="direction: rtl;">
        <div class="container">
            <div class="row">
                <div class="col-xl-4 col-lg-4 col-md-4">
                    <div class="single-feature text-right mb-40">
                        <div class="feature-icon">
                            <img src="{{ asset('images/home/free-shipping.png') }}" alt="" />
                        </div>
                        <div class="feature-content">
                            <h4>لورم ایپسوم</h4>
                            <p>لورم ایپسوم متن ساختگی</p>
                        </div>
                    </div>
                </div>
                <div class="col-xl-4 col-lg-4 col-md-4">
                    <div class="single-feature text-right mb-40 pl-50">
                        <div class="feature-icon">
                            <img src="{{ asset('images/home/support.png') }}" alt="" />
                        </div>
                        <div class="feature-content">
                            <h4>لورم ایپسوم</h4>
                            <p>24x7 لورم ایپسوم</p>
                        </div>
                    </div>
                </div>
                <div class="col-xl-4 col-lg-4 col-md-4">
                    <div class="single-feature text-right mb-40">
                        <div class="feature-icon">
                            <img src="{{ asset('images/home/security.png') }}" alt="" />
                        </div>
                        <div class="feature-content">
                            <h4>لورم ایپسوم</h4>
                            <p>لورم ایپسوم متن ساختگی</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <!-- Modal -->
    @foreach ($products as $product)
        <div class="modal fade" id="productModal-{{ $product->id }}" tabindex="-1" role="dialog">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">x</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-7 col-sm-12 col-xs-12" style="direction: rtl;">
                                <div class="product-details-content quickview-content">
                                    <h2 class="text-right mb-4">{{ $product->name }} </h2>

                                    <div class="product-details-price price-place-{{ $product->id }}">

                                            @if ($product->quantity_check)
                                                @if ($product->sale_price)
                                                    <span class="new">
                                                        {{ $product->sale_price->sale_price }}
                                                        تومان
                                                    </span>
                                                    <span class="old">
                                                        {{ $product->sale_price->price }}
                                                        تومان
                                                    @else
                                                        <span class="new">
                                                            {{ $product->real_price->price }}
                                                            تومان
                                                        </span>
                                                @endif
                                            @else
                                                <div class="not-in-stock">
                                                    <p>ناموجود</p>
                                                </div>
                                            @endif

                                    </div>

                                    <div class="pro-details-rating-wrap">
                                        <div data-rating-stars="5" data-rating-readonly="true"
                                            data-rating-value="{{ ceil($product->rates->avg('rate')) }}">
                                        </div>
                                        <span class=mx-2>|</span>
                                        <span>{{ $product->approvedComments()->count() }} دیدگاه</span>
                                    </div>
                                    <p class="text-right">
                                        {{ $product->description }}
                                    </p>
                                    <div class="pro-details-list text-right">
                                        <ul class="text-right"
                                            @foreach ($product->attributes()->with('attribute')->get() as $attribute)
                                        <li>-{{ $attribute->attribute->name . ':' . $attribute->value }} </li> @endforeach
                                            </ul>
                                    </div>
                                    <form action="{{ route('product.cart.add') }}" method="post">
                                    @csrf
                                    <input type="hidden" name="productID" value="{{$product->id}}">
                                    @if ($product->quantity_check)
                                        <div class="pro-details-size-color text-right">
                                            <div class="pro-details-size w-50">
                                                <span>{{ App\Models\Attribute::find($product->variations->first()->attribute_id)->name }}</span>
                                                <div class="pro-details-size-content">
                                                    <select name="variation" class='form-control select-variation'
                                                        pointer='price-place-{{ $product->id }}' name=""
                                                        id="">
                                                        @foreach ($product->variations()->orderBy('price')->get() as $var)
                                                            @if ($var->quantity > 0)
                                                                <option
                                                                    value="{{ json_encode($var->only(['id', 'is_sale', 'quantity', 'price', 'sale_price'])) }}">
                                                                    {{ $var->value }}
                                                                </option>
                                                            @endif
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>

                                        </div>

                                        <div class="pro-details-quality">
                                            <div class="cart-plus-minus">
                                                <input class="cart-plus-minus-box quantity-input" type="text"
                                                    name="qtybutton" value="1"
                                                    data-max={{ $product->variations()->where('quantity', '>', '0')->orderBy('price')->first()->quantity }} />
                                            </div>

                                            <div class="pro-details-cart">

                                                <button type="submit">افزودن به سبد خرید</button>


                                            </div>
                                            @auth
                                                @if ($product->isInWish())
                                                    <div class="pro-details-wishlist">
                                                        <a title="Add To Wishlist" class="wish-link-modal"
                                                            product='{{ $product->id }}'><i class="fa fa-heart"
                                                                style="color:red"></i></a>
                                                    </div>
                                                @else
                                                    <div class="pro-details-wishlist">
                                                        <a title="Add To Wishlist" class="wish-link"
                                                            product='{{ $product->id }}'><i class="sli sli-heart"></i></a>
                                                    </div>
                                                @endif
                                            @else
                                                <div class="pro-details-wishlist">
                                                    <a title="Add To Wishlist" onclick="loginAlert()"><i
                                                            class="sli sli-heart"></i></a>
                                                </div>
                                            @endauth
                                            <div class="pro-details-compare">
                                                <a title="Add To Compare" href="#"><i
                                                        class="sli sli-refresh"></i></a>
                                            </div>
                                        </div>
                                    @else
                                        <div class="not-in-stock">
                                            <p>ناموجود</p>
                                        </div>
                                    @endif
                                </form>
                                    <div class="pro-details-meta">
                                        <span>دسته بندی :</span>
                                        <ul <li><a href="#">{{ $product->category->parent->name }}</a></li>
                                            <li><a href="#">{{ $product->category->name }}</a></li>
                                        </ul>
                                    </div>
                                    <div class="pro-details-meta">
                                        <span>تگ ها :</span>
                                        <ul>
                                            @foreach ($product->tags as $tag)
                                                <li><a href="#">{{ $loop->last ? $tag->name : $tag->name . ',' }}
                                                    </a>
                                                </li>
                                            @endforeach


                                        </ul>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-5 col-sm-12 col-xs-12">
                                <div class="tab-content quickview-big-img">
                                    <div id="pri-{{ $product->id }}" class="tab-pane fade show active">
                                        <img src="{{ url(env('PRODUCT_IMAGES_UPLOAD_PATH') . $product->primary_image) }}"
                                            alt="" />
                                    </div>
                                    @foreach ($product->images as $image)
                                        <div id="pro-{{ $image->id }}" class="tab-pane fade">
                                            <img src="{{ url(env('PRODUCT_IMAGES_UPLOAD_PATH') . $image->image) }}"
                                                alt="" />
                                        </div>
                                    @endforeach

                                </div>
                                <!-- Thumbnail Large Image End -->
                                <!-- Thumbnail Image End -->
                                <div class="quickview-wrap mt-15">
                                    <div class="quickview-slide-active owl-carousel nav nav-style-2" role="tablist">
                                        <a class="active" data-toggle="tab" href="#pri-{{ $product->id }}"><img
                                                src="{{ url(env('PRODUCT_IMAGES_UPLOAD_PATH') . $product->primary_image) }}"
                                                alt="" /></a>
                                        @foreach ($product->images as $image)
                                            <a data-toggle="tab" href="#pro-{{ $image->id }}"><img
                                                    src="{{ url(env('PRODUCT_IMAGES_UPLOAD_PATH') . $image->image) }}"
                                                    alt="" /></a>
                                        @endforeach

                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endforeach

    <!-- Modal end -->
@endsection
@section('script')
    <script>
        $('.select-variation').on('change', function() {

            let variation = JSON.parse(this.value);
            let price_place = $(this).attr('pointer');
            price_place = $('.' + price_place);
            price_place.empty();


            if (variation.is_sale) {
                let sale_price = $('<span />', {
                    class: 'new',
                    text: toPersianNum(number_format(variation.sale_price)) + 'تومان'
                });
                let price = $('<span />', {
                    class: 'old',
                    text: toPersianNum(number_format(variation.price)) + 'تومان'
                });

                price_place.append(sale_price);
                price_place.append(price);
            } else {


                let price = $('<span />', {
                    class: 'new',
                    text: toPersianNum(number_format(variation.price)) + 'تومان'
                });

                price_place.append(price);
            }
            $('.quantity-input').attr('data-max', variation.quantity);


        });
        //==================
        $('.wish-link-modal').click(function() {
            var heart = $(this);
            var product_id = heart.attr('product');
            console.log(heart);
            $.get("{{ url('/profile/addTowish') }}" + '/' + product_id, function(response, status) {

                if (response.action == 'delete') {

                    heart.find('i').attr('class', 'sli sli-heart');
                    swal({
                        'text': 'محصول از لیست پاک شد',
                        'icon': 'error',
                        'timer': 1000
                    });


                } else {

                    heart.find('i').attr({
                        'class': 'fa fa-heart',
                        'style': "color:red"
                    });
                    swal({
                        'text': 'محصول به لیست اضافه شد',
                        'icon': 'success',
                        'timer': 1000
                    });



                }

            }).fail(function(response, status) {
                alert(response);
                console.log(response, status);
            });
        });

        //==================
        $('.wish-link-slidly').click(function() {

            var heart = $(this);
            var product_id = heart.attr('product');
            console.log(heart);
            $.get("{{ url('/profile/addTowish') }}" + '/' + product_id, function(response, status) {

                if (response.action == 'delete') {

                    heart.find('i').attr('class', 'sli sli-heart');
                    heart.find('span').html('افزودن به علاقه مندی ها ');
                    swal({
                        'text': 'محصول از لیست پاک شد',
                        'icon': 'error',
                        'timer': 1000
                    });


                } else {

                    heart.find('span').html('پاک کردن از  علاقه مندی ها ');
                    heart.find('i').attr({
                        'class': 'fa fa-heart',
                        'style': "color:red"
                    });
                    swal({
                        'text': 'محصول به لیست اضافه شد',
                        'icon': 'success',
                        'timer': 1000
                    });



                }

            }).fail(function(response, status) {
                alert(response);
                console.log(response, status);
            });




        });
    </script>
@endsection
