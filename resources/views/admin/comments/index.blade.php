@extends('admin.layouts.admin')

@section('title')
    index comments
@endsection

@section('content')

    <!-- Content Row -->
    <div class="row">

        <div class="col-xl-12 col-md-12 mb-4 p-4 bg-white">
            <div class="d-flex flex-column text-center flex-md-row justify-content-md-between mb-4">
                <h5 class="font-weight-bold mb-3 mb-md-0">لیست کامنت ها ({{ $comments->total() }})</h5>
                <a class="btn btn-sm btn-outline-primary" href="{{ route('admin.comments.create') }}">
                    <i class="fa fa-plus"></i>
                    ایجاد برند
                </a>
            </div>

            <div class="table-responsive">
                <table class="table table-bordered table-striped text-center">

                    <thead>
                        <tr>
                            <th>#</th>
                            <th>نام کاربر</th>
                            <th>نام محصول</th>
                            <th style="min-width:200px"> متن کامنت</th>
                            <th>تاریخ ارسال</th>
                            <th>وضعیت</th>
                            <th>عملیات</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($comments as $key => $comment)
                            <tr>
                                <th>
                                    {{ $comments->firstItem() + $key }}
                                </th>
                                <th>
                                    {{ $comment->user->name }}
                                </th>
                                <th>
                                    <a href="{{route('admin.products.show',['product'=>$comment->product->id])}}">
                                        {{ $comment->product->name }}
                                    </a>

                                </th>
                                <th >
                                    {{ $comment->text }}
                                </th>
                                <th>
                                    {{ verta($comment->created_at) }}
                                </th>
                                <th>
                                    <span
                                        class="">
                                      {{$comment->approve}}

                                    </span>
                                </th>
                                <th nowrap>
                                    <a class="btn btn-sm btn-outline-success"
                                        href="{{ route('admin.comments.show', ['comment' => $comment->id]) }}">نمایش</a>
                                        <form class="d-inline-block" method="post" action="{{route('admin.comments.destroy',['comment'=>$comment->id])}}">
                                        @method('delete')
                                        @csrf
                                        <button class="btn  btn-sm btn-outline-danger" type='submit'>حذف</button>

                                        </form>

                                </th>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="d-flex justify-content-center mt-5">
                {{ $comments->render() }}
            </div>
        </div>
    </div>
@endsection
