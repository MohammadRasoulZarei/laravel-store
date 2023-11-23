@extends('home.layouts.home')

@section('title')
    صفحه فروشگاه
@endsection

@section('content')
    <div class="breadcrumb-area pt-35 pb-35 bg-gray" style="direction: rtl;">
        <div class="container">
            <div class="breadcrumb-content text-center">
                <ul>
                    <li>
                        <a href="{{ route('home.index') }}">صفحه ای اصلی</a>
                    </li>
                    <li class="active">فروشگاه </li>
                </ul>
            </div>
        </div>
    </div>
    <form id='filter-form'>
        <div class="shop-area pt-95 pb-100">
            <div class="container">
                <div class="row flex-row-reverse text-right">

                    <!-- sidebar -->
                    <div class="col-lg-3 order-2 order-sm-2 order-md-1">
                        <div class="sidebar-style mr-30">
                            <div class="sidebar-widget">
                                <h4 class="pro-sidebar-title">جستجو </h4>
                                <div class="pro-sidebar-search mb-50 mt-25">
                                    <div class="pro-sidebar-search-form">
                                        <input class="search22" name="search"
                                            value="{{ request()->has('search') ? request()->search : '' }}" type="text"
                                            placeholder="... جستجو ">
                                        <button type="button" onclick="filter()">
                                            <i class="sli sli-magnifier"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                            <div class="sidebar-widget">
                                <h4 class="pro-sidebar-title"> دسته بندی </h4>
                                <div class="sidebar-widget-list mt-30">
                                    <ul>
                                        <li >
                                            @if ($category->parent_id == 0)
                                               <strong> <u>{{ $category->name }} </u></strong>
                                            @else

                                                <a
                                                        href="{{ route('home.category.show', ['category' => $category->parent->slug]) }}">
                                                        {{ $category->parent->name }}
                                                </a>
                                            @endif
                                        </li>
                                        @if ($category->parent_id == 0)
                                            @foreach ($category->children as $child)
                                                <li>
                                                    <a
                                                        href="{{ route('home.category.show', ['category' => $child->slug]) }}">
                                                        {{ $child->name }}
                                                    </a>
                                                </li>
                                            @endforeach
                                        @else
                                            @foreach ($category->parent->children as $child)
                                                <li>
                                                    <a
                                                        href="{{ route('home.category.show', ['category' => $child->slug]) }}">
                                                        {!!$category->name==$child->name? '<strong> <u>' .$child->name . '</u></strong>' :$child->name!!}
                                                    </a>
                                                </li>
                                            @endforeach
                                        @endif


                                    </ul>
                                </div>
                            </div>
                            <hr>



                        </div>
                    </div>


                    <!-- content -->
                    <div class="col-lg-9 order-1 order-sm-1 order-md-2">
                        <!-- shop-top-bar -->
                        <div class="shop-top-bar" style="direction: rtl;">

                            <div class="select-shoing-wrap">
                                <div class="shop-select">

                                    <select id="sort-by" name="sortBy" onchange="filter()">
                                        <option value="0"> مرتب سازی </option>
                                        <option value="max"
                                            {{ (request()->has('sortBy') and request('sortBy') == 'max') ? 'selected' : '' }}>
                                            بیشترین قیمت </option>
                                        <option value="min"
                                            {{ (request()->has('sortBy') and request('sortBy') == 'min') ? 'selected' : '' }}>
                                            کم
                                            ترین قیمت </option>
                                        <option value="newest"
                                            {{ (request()->has('sortBy') and request('sortBy') == 'newest') ? 'selected' : '' }}>
                                            جدیدترین </option>
                                        <option value="oldest"
                                            {{ (request()->has('sortBy') and request('sortBy') == 'oldest') ? 'selected' : '' }}>
                                            قدیمی ترین </option>
                                    </select>
                                </div>

                            </div>

                        </div>

                        <div class="shop-bottom-area mt-35">
                            <div class="tab-content jump">

                                <div class="row ht-products" style="direction: rtl;">
                                    @foreach ($products as $product)
                                        <div class="col-xl-4 col-md-6 col-lg-6 col-sm-6">
                                            <!--Product Start-->
                                            <div
                                                class="ht-product ht-product-action-on-hover ht-product-category-right-bottom mb-30">
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

                                                                    <a href="#" data-toggle="modal"
                                                                        data-target="#productModal-{{ $product->id }}"><i
                                                                            class="sli sli-magnifier"></i><span
                                                                            class="ht-product-action-tooltip"> مشاهده سریع
                                                                        </span></a>

                                                                </li>
                                                                <li>
                                                                    @auth
                                                                        @if ($product->isInWish())
                                                                            <a class="wish-link"
                                                                                product='{{ $product->id }}'><i
                                                                                    class="fa fa-heart"
                                                                                    style="color:red"></i><span
                                                                                    class="ht-product-action-tooltip"> پاک کردن
                                                                                    از
                                                                                    علاقه مندی ها </span></a>
                                                                        @else
                                                                            <a class="wish-link"
                                                                                product='{{ $product->id }}'><i
                                                                                    class="sli sli-heart"></i><span
                                                                                    class="ht-product-action-tooltip"> افزودن به
                                                                                    علاقه مندی ها </span></a>
                                                                        @endif
                                                                    @else
                                                                        <a href="#"><i class="sli sli-heart"></i><span
                                                                                class="ht-product-action-tooltip"> ابتدا وارد
                                                                                سایت شوید
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
                                                                <a
                                                                    href="{{ route('home.product.show', ['product' => $product->slug]) }}">
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
                                            <!--Product End-->
                                        </div>
                                    @endforeach

                                </div>

                            </div>

                            <div class="pro-pagination-style text-center mt-30">
                                {{ $products->withQueryString()->links() }}
                            </div>

                        </div>
                    </div>

                </div>
            </div>
        </div>

    </form>




    <!-- Modal -->
    {{-- @foreach ($products as $product)
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
                                    <div class="product-details-price price-place-{{$product->id}}">
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
                                        <span>{{$product->approvedComments()->count()}} دیدگاه</span>
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
                                        <div class="pro-details-size-color text-right">
                                            <div class="pro-details-size w-50">
                                                <span>{{ App\Models\Attribute::find($product->variations->first()->attribute_id)->name }}</span>
                                                <div class="pro-details-size-content">
                                                    <select class='form-control select-variation' pointer='price-place-{{$product->id}}' name=""
                                                        id="">
                                                        @foreach ($product->variations()->orderBy('price')->get() as $var)
                                                            @if ($var->quantity > 0)
                                                                <option
                                                                    value="{{ json_encode($var->only(['is_sale', 'quantity', 'price', 'sale_price'])) }}">
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
                                                <a href="#">لطفا ابتدا وارد سایت شوید!</a>
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
                                                <a title="Add To Compare" href="#"><i
                                                        class="sli sli-refresh"></i></a>
                                            </div>
                                        </div>
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
    @endforeach --}}
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
                                        <input type="hidden" name="productID" value="{{ $product->id }}">
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
                                                            <a title="Add To Wishlist" class="wish-link"
                                                                product='{{ $product->id }}'><i class="fa fa-heart"
                                                                    style="color:red"></i></a>
                                                        </div>
                                                    @else
                                                        <div class="pro-details-wishlist">
                                                            <a title="Add To Wishlist" class="wish-link"
                                                                product='{{ $product->id }}'><i
                                                                    class="sli sli-heart"></i></a>
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
        function filter() {
            
            // sort part
            if ($('#sort-by').val() == 0) {
                $('#sort-by').removeAttr('name');
            }
            // search part
            if ($('.search22').val() == '') {
                $('.search22').removeAttr('name');

            }



            $('#filter-form').submit();
        }


        //select variation in modal
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
        //go to wish
        $('.wish-link').click(function() {

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
