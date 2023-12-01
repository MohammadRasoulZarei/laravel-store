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
                                                    @foreach ($product->variations()->sort()->get() as $var)
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
