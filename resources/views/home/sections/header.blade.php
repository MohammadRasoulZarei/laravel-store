<header class="header-area sticky-bar">
    <div class="main-header-wrap">
        <div class="container">
            <div class="row">
                <div class="col-xl-2 col-lg-2">
                    <div class="logo pt-40">
                        <a href="{{route('home.index')}}">
                            <h3 class="font-weight-bold">journab.com</h3>
                        </a>
                    </div>
                </div>

                <div class="col-xl-7 col-lg-7">
                    <div class="main-menu text-center">
                        <nav>
                            <ul>
                                <li class="angle-shape">
                                    <a href="{{url('/about-us')}}">  درباره ما </a>
                                </li>

                                <li><a href="{{url('/contact-us')}}"> تماس با ما </a></li>

                                <li class="angle-shape">
                                    <a href="{{route('home.shop.index')}}"> فروشگاه </a>

                                    <ul class="mega-menu">
                                        @php
                                             $category_parents=App\Models\Category::where('parent_id',0)->get();
                                        @endphp
                                        @foreach ($category_parents as $parent )
                                        <li>
                                            <a class="menu-title" href="{{route('home.category.showParent',['category'=>$parent->slug])}}">{{$parent->name}}</a>

                                            <ul>

                                                @foreach ($parent->children as $child_category )
                                                <li><a href="{{route('home.category.show',['category'=>$child_category->slug])}}">{{$child_category->name}}</a></li>
                                                @endforeach



                                            </ul>
                                        </li>
                                        @endforeach



                                    </ul>
                                </li>

                                <li class="angle-shape">
                                    <a href="{{route('home.index')}}"> صفحه اصلی </a>
                                </li>
                            </ul>
                        </nav>
                    </div>
                </div>

                <div class="col-xl-3 col-lg-3">
                    <div class="header-right-wrap pt-40">
                        <div class="header-search">
                            <a class="search-active" href="#"><i class="sli sli-magnifier"></i></a>
                        </div>
                        <div class="cart-wrap">
                            <button class="icon-cart-active">
                                <span class="icon-cart">
                                    <i class="sli sli-bag"></i>
                                    <span class="count-style">{{\Cart::isEmpty()?0:\Cart::getContent()->count()}}</span>
                                </span>

                                @if (!\Cart::isEmpty())
                                <span class="cart-price">
                                    {{number_format(\Cart::getTotal())}}
                                </span>
                                <span>تومان</span>
                                @endif

                            </button>
                            <div class="shopping-cart-content">
                                <div class="shopping-cart-top">
                                    <a class="cart-close" href="#"><i class="sli sli-close"></i></a>
                                    <h4>سبد خرید</h4>
                                </div>
                                @if (\Cart::isEmpty())
                                <p class="alert alert-info">سبد خرید شما خالی است!</p>
                                @else
                                <ul>
                                    @foreach (\Cart::getContent() as $item )
                                    <li class="single-shopping-cart">
                                        <div class="shopping-cart-title">
                                            <h4><a href="{{route('home.product.show',['product'=>$item->associatedModel->slug])}}">  {{$item->name}} </a></h4>
                                            <span> {{$item->quantity}} x  {{number_format($item->price)}}</span>
                                            <div style="direction: rtl">
                                                <p class="mb-0" style="font-size:12px">
                                                    {{App\Models\Attribute::find($item->attributes->attribute_id)->name}}
                                                    :
                                                    {{$item->attributes->value}}
                                                </p>
                                              @php
                                                  //$productVariation=App\Models\ProductVariation::find($item->attributes->id);
                                              @endphp
                                                @if ($item->attributes->is_sale)
                                                <p class="mb-0" style="font-size:12px ; color:red">
                                                    {{$item->attributes->percent_off}}%
                                                    تخفیف
                                                </p>
                                                @endif
                                            </div>
                                        </div>

                                        <div class="shopping-cart-img">
                                            <a href="{{route('home.product.show',['product'=>$item->associatedModel->slug])}}"><img alt="" src="{{asset(env('PRODUCT_IMAGES_UPLOAD_PATH').$item->associatedModel->primary_image)}}" /></a>
                                            <div class="item-close">
                                                <a href="{{route('home.cart.delete',['delete'=>$item->id])}}"><i class="sli sli-close"></i></a>
                                            </div>
                                        </div>
                                    </li>

                                    @endforeach

                                </ul>


                                <div class="shopping-cart-bottom">
                                    <div class="shopping-cart-total d-flex justify-content-between align-items-center"
                                        style="direction: rtl;">
                                        <h4>
                                            جمع کل :
                                        </h4>
                                        <span class="shop-total">
                                            {{number_format(\Cart::getTotal())}} تومان
                                        </span>
                                    </div>
                                    <div class="shopping-cart-btn btn-hover text-center">
                                        <a class="default-btn" href="{{route('home.order.checkout')}}">
                                            ثبت سفارش
                                        </a>
                                        <a class="default-btn" href="{{route('home.cart.index')}}">
                                            سبد خرید
                                        </a>
                                    </div>
                                </div>
                                @endif
                            </div>
                        </div>

                        <div class="setting-wrap">
                            <button class="setting-active">
                                <i class="sli sli-settings"></i>
                            </button>
                            <div class="setting-content">
                                <ul class="text-right">
                                    @auth
                                    <li >{{auth()->user()->name}}</li>
                                    <li><a href="{{route('user.profile.index')}}">پروفایل</a></li>
                                    @else
                                    <li><a href="{{route('login')}}">ورود</a></li>
                                    <li>
                                        <a href="{{route('register')}}">ایجاد حساب</a>
                                    </li>
                                    @endauth


                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- main-search start -->
        <div class="main-search-active">
            <div class="sidebar-search-icon">
                <button class="search-close">
                    <span class="sli sli-close"></span>
                </button>
            </div>
            <div class="sidebar-search-input">
                <form>
                    <div class="form-search">
                        <input id="search" class="input-text" value="" placeholder=" ...جستجو " type="search" />
                        <button>
                            <i class="sli sli-magnifier"></i>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="header-small-mobile">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-6">
                    <div class="mobile-logo">
                        <a href="{{route('home.index')}}">
                            <h4 class="font-weight-bold">journab.com</h4>
                        </a>
                    </div>
                </div>
                <div class="col-6">
                    <div class="header-right-wrap">
                        <div class="cart-wrap">
                            <button class="icon-cart-active">
                                <span class="icon-cart">
                                    <i class="sli sli-bag"></i>
                                    <span class="count-style">{{\Cart::isEmpty()?0:\Cart::getContent()->count()}}</span>
                                </span>

                                @if (!\Cart::isEmpty())
                                <span class="cart-price">
                                    {{number_format(\Cart::getTotal())}}
                                </span>
                                <span>تومان</span>
                                @endif

                            </button>
                            <div class="shopping-cart-content">
                                <div class="shopping-cart-top">
                                    <a class="cart-close" href="#"><i class="sli sli-close"></i></a>
                                    <h4>سبد خرید</h4>
                                </div>
                                @if (\Cart::isEmpty())
                                <p class="alert alert-info">سبد خرید شما خالی است!</p>
                                @else
                                <ul>
                                    @foreach (\Cart::getContent() as $item )
                                    <li class="single-shopping-cart">
                                        <div class="shopping-cart-title">
                                            <h4><a href="{{route('home.product.show',['product'=>$item->associatedModel->slug])}}">  {{$item->name}} </a></h4>
                                            <span> {{$item->quantity}} x  {{number_format($item->price)}}</span>
                                            <div style="direction: rtl">
                                                <p class="mb-0" style="font-size:12px">
                                                    {{App\Models\Attribute::find($item->attributes->attribute_id)->name}}
                                                    :
                                                    {{$item->attributes->value}}
                                                </p>
                                              @php
                                                  //$productVariation=App\Models\ProductVariation::find($item->attributes->id);
                                              @endphp
                                                @if ($item->attributes->is_sale)
                                                <p class="mb-0" style="font-size:12px ; color:red">
                                                    {{$item->attributes->percent_off}}%
                                                    تخفیف
                                                </p>
                                                @endif
                                            </div>
                                        </div>

                                        <div class="shopping-cart-img">
                                            <a href="{{route('home.product.show',['product'=>$item->associatedModel->slug])}}"><img alt="" src="{{asset(env('PRODUCT_IMAGES_UPLOAD_PATH').$item->associatedModel->primary_image)}}" /></a>
                                            <div class="item-close">
                                                <a href="#"><i class="sli sli-close"></i></a>
                                            </div>
                                        </div>
                                    </li>

                                    @endforeach

                                </ul>


                                <div class="shopping-cart-bottom">
                                    <div class="shopping-cart-total d-flex justify-content-between align-items-center"
                                        style="direction: rtl;">
                                        <h4>
                                            جمع کل :
                                        </h4>
                                        <span class="shop-total">
                                            {{number_format(\Cart::getTotal())}} تومان
                                        </span>
                                    </div>
                                    <div class="shopping-cart-btn btn-hover text-center">
                                        <a class="default-btn" href="{{route('home.order.checkout')}}">
                                            ثبت سفارش
                                        </a>
                                        <a class="default-btn" href="{{route('home.cart.index')}}">
                                            سبد خرید
                                        </a>
                                    </div>
                                </div>
                                @endif
                            </div>
                        </div>
                        <div class="mobile-off-canvas">
                            <a class="mobile-aside-button" href="#"><i class="sli sli-menu"></i></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</header>
