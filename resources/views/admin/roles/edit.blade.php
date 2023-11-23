@extends('admin.layouts.admin')

@section('title')
    edit roles
@endsection

@section('content')

    <!-- Content Row -->
    <div class="row">

        <div class="col-xl-12 col-md-12 mb-4 p-4 bg-white">
            <div class="mb-4 text-center text-md-right">
            <h5 class="font-weight-bold">ویرایش مجوز {{ $role->name }}</h5>
            </div>
            <hr>

            @include('admin.sections.errors')

            <form action="{{ route('admin.roles.update' , ['role' => $role->id]) }}" method="POST">
                @csrf
                @method('put')
                <div class="form-row">
                    <div class="form-group col-md-3">
                        <label for="name">نام</label>
                        <input class="form-control"  name="name" type="text" value="{{ $role->name }}">
                    </div>
                    <div class="form-group col-md-3">
                        <label for="name"> نام نمایشی</label>
                        <input class="form-control"  name="display_name" type="text" value="{{ $role->display_name }}">
                    </div>
                </div>
                <div class="form-row">
                    @foreach ($permissions as $permission )
                    <div class="form-check col-md-3 mb-1 ">
                        <input class="form-check-input  " name='permissions[{{$permission->name}}]'
                     {{in_array($permission->name,$rolePermissions)?'checked':''}} type="checkbox" value="{{$permission->name}}" id="flexCheckDefault-{{$permission->id}}}">
                        <label class="form-check-label mr-4" style="cursor: pointer;" for="flexCheckDefault-{{$permission->id}}}">
                            {{$permission->display_name}}
                        </label>
                    </div>
                    @endforeach
                </div>

                <button class="btn btn-outline-primary mt-5" type="submit">ویرایش</button>
                <a href="{{ route('admin.roles.index') }}" class="btn btn-dark mt-5 mr-3">بازگشت</a>
            </form>
        </div>

    </div>

@endsection
