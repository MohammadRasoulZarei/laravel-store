@extends('admin.layouts.admin')

@section('title')
    show comments
@endsection

@section('content')
    <!-- Content Row -->
    <div class="row">

        <div class="col-xl-12 col-md-12 mb-4 p-4 bg-white">
            <div class="mb-4 text-center text-md-right">
                <h5 class="font-weight-bold">کامنت مربوط به : {{ $comment->product->name }}</h5>
            </div>
            <hr>

            <div class="row">
                <div class="form-group col-md-3">
                    <label>نام کاربر</label>
                    <input class="form-control" type="text" value="{{ $comment->user->name }}" disabled>
                </div>
                <div class="form-group col-md-3">
                    <label>وضعیت</label>
                    <input class="form-control" type="text" value="{{ $comment->approve }}" disabled>
                </div>
                <div class="form-group col-md-3">
                    <label>تاریخ ایجاد</label>
                    <input class="form-control" type="text" value="{{ verta($comment->created_at) }}" disabled>
                </div>
                <div class="form-group col-md-12">
                    <label>متن کامنت</label>
                    <textarea class="form-control" disabled>{{ $comment->text }}</textarea>

                </div>


            </div>

            <a href="{{ route('admin.comments.index') }}" class="btn btn-dark mt-5">بازگشت</a>
            @if ($comment->approved == 0)
                <a href="{{ route('admin.comment.changeApprove', ['comment' => $comment->id,'action'=>1]) }}"
                    class="btn btn-success mt-5">تایید</a>

                <a href="{{ route('admin.comment.changeApprove', ['comment' => $comment->id,'action'=>2]) }}"
                    class="btn btn-danger mt-5">عدم تایید</a>
            @elseif ($comment->approved == 1)
                <a href="{{ route('admin.comment.changeApprove', ['comment' => $comment->id,'action'=>2]) }}"
                    class="btn btn-danger mt-5">عدم تایید</a>
            @elseif ($comment->approved == 2)
            <a href="{{ route('admin.comment.changeApprove', ['comment' => $comment->id,'action'=>1]) }}"
                class="btn btn-success mt-5">تایید</a>
            @endif


        </div>

    </div>
@endsection
