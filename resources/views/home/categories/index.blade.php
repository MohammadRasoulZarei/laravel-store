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
                                        @foreach ($categories as $category)

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
                                        @endforeach


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
    @include('home.sections.modal')


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
