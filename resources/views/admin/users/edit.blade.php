@extends('admin.layouts.admin')

@section('title')
    edit users
@endsection

@section('content')
    <!-- Content Row -->
    <div class="row">

        <div class="col-xl-12 col-md-12 mb-4 p-4 bg-white">
            <div class="mb-4 text-center text-md-right">
                <h5 class="font-weight-bold">ویرایش دسترسی {{ $user->name }}</h5>
            </div>
            <hr>

            @include('admin.sections.errors')

            <form action="{{ route('admin.users.update', ['user' => $user->id]) }}" method="POST">
                @csrf
                @method('put')
                <div class="form-row">
                    <div class="form-group col-md-3">
                        <label for="name">نام</label>
                        <input class="form-control" name="name" type="text" value="{{ $user->name }}">
                    </div>
                    <div class="form-group col-md-3">
                        <label for="name">شماره تلفن</label>
                        <input class="form-control" name="cellphone" type="text" value="{{ $user->cellphone }}">
                    </div>
                    <div class="form-group col-md-3">
                        <label for="name">نقش کاربر</label>
                        <select name="role" class="form-control">
                            <option value=""></option>
                            @foreach ($roles as $role)
                                <option value="{{ $role->name }}"
                                    {{ in_array($role->id, $userRoles->pluck('id')->toArray()) ? 'selected' : '' }}>
                                    {{ $role->display_name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-row col-12">
                        @foreach ($permissions as $permission)
                            <div class="form-check col-md-3 mb-1 ">
                                <input class="form-check-input  " name='permissions[{{ $permission->name }}]'
                                    {{ in_array($permission->id, $userPermissionsIDs) ? 'checked' : '' }} type="checkbox"
                                    value="{{ $permission->name }}" id="flexCheckDefault-{{ $permission->id }}}">
                                <label class="form-check-label mr-4" style="cursor: pointer;"
                                    for="flexCheckDefault-{{ $permission->id }}}">
                                    {{ $permission->display_name }}
                                </label>
                            </div>
                        @endforeach
                    </div>
                </div>

                <button class="btn btn-outline-primary mt-5" type="submit">ویرایش</button>
                <a href="{{ route('admin.users') }}" class="btn btn-dark mt-5 mr-3">بازگشت</a>
            </form>
        </div>

    </div>
@endsection
