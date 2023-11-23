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
                        <a href="index.html"> صفحه ای اصلی </a>
                    </li>
                    <li class="active"> مقایسه محصول </li>
                </ul>
            </div>
        </div>
    </div>

    <!-- compare main wrapper start -->
    <div class="compare-page-wrapper pt-100 pb-100" style="direction: rtl;">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <!-- Compare Page Content Start -->
                    <div class="compare-page-content-wrap">
                        <div class="compare-table table-responsive">
                            <table class="table table-bordered mb-0">
                                <tbody>
                                    <tr>
                                        <td class="first-column"> محصول </td>
                                        @foreach ($products as $product)
                                            <td class="product-image-title">
                                                <a href="single-product.html" class="image">
                                                    <img class="img-fluid"
                                                        src="{{ url(env('PRODUCT_IMAGES_UPLOAD_PATH') . $product->primary_image) }}"
                                                        alt="Compare Product">
                                                </a>
                                                <a href="{{ route('home.category.show', ['category' => $product->category->slug]) }}"
                                                    class="category"> {{ $product->category->name }} </a>
                                                <a href="{{ route('home.product.show', ['product' => $product->slug]) }}"
                                                    class="title"> {{ $product->name }}</a>
                                            </td>
                                        @endforeach

                                    </tr>
                                    <tr>
                                        <td class="first-column"> توضیحات </td>
                                        @foreach ($products as $product)
                                            <td class="pro-desc">
                                                <p class="text-right">
                                                    {{ $product->description }}
                                                </p>
                                            </td>
                                        @endforeach
                                    </tr>

                                    <tr>
                                        <td class="first-column"> ویژگی متغییر </td>
                                        @foreach ($products as $product)
                                            <td class="pro-color">
                                                {{ App\Models\Attribute::find($product->variations->first()->attribute_id)->name }}
                                                :

                                                @foreach ($product->variations->where('quantity', '>', 0) as $variation)
                                                    {{ $variation->value }}{{ $loop->last ? '' : ',' }}
                                                @endforeach
                                            </td>
                                        @endforeach

                                    </tr>
                                    <tr>
                                        <td class="first-column"> ویژگی </td>
                                        @foreach ($products as $product)
                                            <td class="pro-stock">
                                                @foreach ($product->attributes as $attribute)
                                                    - {{ $attribute->attribute->name }} : {{ $attribute->value }}
                                                    <br>
                                                @endforeach


                                            </td>
                                        @endforeach


                                    </tr>
                                    <tr>
                                        <td class="first-column"> امتیاز </td>
                                        @foreach ($products as $product )
                                        <td class="pro-ratting">
                                            <div data-rating-stars="5" data-rating-readonly="true"
                                                data-rating-value="{{ ceil($product->rates->avg('rate')) }}">
                                            </div>
                                        </td>

                                        @endforeach

                                    </tr>
                                    <tr>
                                        <td class="first-column"> حذف </td>
                                        @foreach ($products as $product )
                                        <td class="pro-remove">
                                            <a href="{{route('product.compare.delete',['product'=>$product->id])}}"><i class="sli sli-trash"></i></a>
                                        </td>

                                        @endforeach

                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <!-- Compare Page Content End -->
                </div>
            </div>
        </div>
    </div>
    <!-- compare main wrapper end -->
@endsection
@section('script')
    <script></script>
@endsection
