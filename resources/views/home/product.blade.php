@extends('home.layouts.home')

@section('title')
    نمایش محصول
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

    <div class="product-details-area pt-100 pb-95">
        <div class="container">
            <div class="row">

                <div class="col-lg-6 col-md-6 order-2 order-sm-2 order-md-1" style="direction: rtl;">
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
                        @if ($product->quantity_check)
                            <form action="{{ route('product.cart.add') }}" method="post">
                                @csrf
                                <input type="hidden" name="productID" value="{{ $product->id }}">
                                <div class="pro-details-size-color text-right">
                                    <div class="pro-details-size w-50">
                                        <span>{{ App\Models\Attribute::find($product->variations->first()->attribute_id)->name }}</span>

                                        <div class="pro-details-size-content">
                                            <select name="variation" class='form-control select-variation'
                                                pointer='price-place-{{ $product->id }}' id="">
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
                                        <input class="cart-plus-minus-box quantity-input" type="text" name="qtybutton"
                                            value="1"
                                            data-max={{ $product->variations()->where('quantity', '>', '0')->orderBy('price')->first()->quantity }} />
                                    </div>
                                    <div class="pro-details-cart">
                                        <button type="submit">افزودن به سبد خرید</button>
                                    </div>
                                    @auth
                                        @if ($product->isInWish())
                                            <div class="pro-details-wishlist">
                                                <a title="Add To Wishlist" class="wish-link" product='{{ $product->id }}'><i
                                                        class="fa fa-heart" style="color:red"></i></a>
                                            </div>
                                        @else
                                            <div class="pro-details-wishlist">
                                                <a title="Add To Wishlist" class="wish-link" product='{{ $product->id }}'><i
                                                        class="sli sli-heart"></i></a>
                                            </div>
                                        @endif
                                    @else
                                        <div class="pro-details-wishlist">
                                            <a title="Add To Wishlist" onclick="loginAlert()"><i class="sli sli-heart"></i></a>
                                        </div>
                                    @endauth

                                    <div class="pro-details-compare">
                                        <a title="Add To Compare" href="{{route('product.compare.add',['product'=>$product->id])}}"><i class="sli sli-refresh"></i></a>
                                    </div>
                                </div>
                            </form>
                        @else
                            <div class="not-in-stock">
                                <p>ناموجود</p>
                            </div>
                        @endif
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

                <div class="col-lg-6 col-md-6 order-1 order-sm-1 order-md-2">
                    <div class="product-details-img">
                        <div class="zoompro-border zoompro-span">
                            <img class="zoompro"
                                src="{{ url(env('PRODUCT_IMAGES_UPLOAD_PATH') . $product->primary_image) }}"
                                data-zoom-image="{{ url(env('PRODUCT_IMAGES_UPLOAD_PATH') . $product->primary_image) }}"
                                alt="" />

                        </div>
                        <div id="gallery" class="mt-20 product-dec-slider">
                            <a data-image="{{ url(env('PRODUCT_IMAGES_UPLOAD_PATH') . $product->primary_image) }}"
                                data-zoom-image="{{ url(env('PRODUCT_IMAGES_UPLOAD_PATH') . $product->primary_image) }}">
                                <img src="{{ url(env('PRODUCT_IMAGES_UPLOAD_PATH') . $product->primary_image) }}"
                                    alt="">
                            </a>
                            @foreach ($product->images as $image)
                                <a data-image="{{ url(env('PRODUCT_IMAGES_UPLOAD_PATH') . $image->image) }}"
                                    data-zoom-image="{{ url(env('PRODUCT_IMAGES_UPLOAD_PATH') . $image->image) }}">
                                    <img src="{{ url(env('PRODUCT_IMAGES_UPLOAD_PATH') . $image->image) }}" alt="">
                                </a>
                            @endforeach



                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <div class="description-review-area pb-95">
        <div class="container">
            <div class="row" style="direction: rtl;">
                <div class="col-lg-8 col-md-8">
                    <div class="description-review-wrapper">
                        <div class="description-review-topbar nav">
                            <a class="{{ count($errors) > 0 ? '' : 'active' }}" data-toggle="tab" href="#des-details1">
                                توضیحات
                            </a>
                            <a data-toggle="tab" href="#des-details3"> اطلاعات بیشتر </a>
                            <a class="{{ count($errors) > 0 ? 'active' : '' }}" data-toggle="tab" href="#des-details2">
                                دیدگاه
                                ({{ $product->approvedComments()->count() }})
                            </a>
                        </div>
                        <div class="tab-content description-review-bottom">
                            <div id="des-details1" class="tab-pane {{ count($errors) > 0 ? '' : 'active' }}">
                                <div class="product-description-wrapper">
                                    <p class="text-justify">
                                        {{ $product->description }}
                                    </p>

                                </div>
                            </div>
                            <div id="des-details3" class="tab-pane">
                                <div class="product-anotherinfo-wrapper text-right">
                                    <ul>
                                        @foreach ($product->attributes()->with('attribute')->get() as $attr)
                                            <li>
                                                <span> {{ $attr->attribute->name }} : </span>
                                                {{ $attr->value }}
                                            </li>
                                        @endforeach


                                    </ul>
                                </div>
                            </div>
                            <div id="des-details2" class="tab-pane {{ count($errors) > 0 ? 'active' : '' }}">

                                <div class="review-wrapper">
                                    @foreach ($product->comments()->where('approved', 1)->latest()->with('user')->get() as $comment)
                                        <div class="single-review">
                                            <div class="review-img">
                                                <img src="{{ asset('images/home/testi-1.png') }}" alt="">
                                            </div>
                                            <div class="review-content w-100 text-right">
                                                <p class="text-right">
                                                    {{ $comment->text }}
                                                </p>
                                                <div class="review-top-wrap">
                                                    <div class="review-name">
                                                        <h4>{{ $comment->user->name }} </h4>
                                                    </div>
                                                    <div data-rating-stars="5" data-rating-readonly="true"
                                                        data-rating-value="{{ ceil($comment->user->rates->where('product_id', $product->id)->avg('rate')) }}">
                                                    </div>

                                                </div>
                                            </div>
                                        </div>
                                    @endforeach

                                </div>

                                <div class="ratting-form-wrapper text-right">
                                    <span id='comment'> نوشتن دیدگاه </span>
                                    @auth
                                        @if (!auth()->user()->hadRate($product->id))
                                            <div id="dataReadonlyReview" data-rating-stars="5"
                                                data-rating-input="#rate-input">
                                            </div>
                                        @endif


                                        <div class="ratting-form">
                                            <form action="{{ route('home.comment.store', ['product' => $product->id]) }}"
                                                method="post">
                                                @csrf
                                                @if (!$product->rates()->where('user_id', auth()->id())->exists())
                                                    <input id='rate-input' type="hidden" name='rate' value='0'>
                                                @endif
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <div class="rating-form-style mb-20">
                                                            <label> متن دیدگاه : </label>
                                                            <textarea name="comment"></textarea>
                                                        </div>
                                                    </div>
                                                    <div class="mb-3">
                                                        @include('admin.sections.errors')
                                                    </div>
                                                    <div class="col-lg-12">
                                                        <div class="form-submit">
                                                            <input type="submit" value="ارسال">
                                                        </div>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    @else
                                        <p>جهت ارسال دیدگاه ابتدا وارد سایت شوید</p>
                                    @endauth


                                </div>

                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-4">
                    <div class="pro-dec-banner">
                        <a href="#"><img src="{{ asset('images/home/banner-7.png') }}" alt=""></a>
                    </div>
                </div>
            </div>
        </div>
    </div>







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



        $('.wish-link').click(function() {

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

        function loginAlert() {
            swal({
                'text': 'لطفا ابتدا وارد سایت شوید',
                'icon': 'warning',
                'timer': '2000'
            });

        }
    </script>
@endsection
