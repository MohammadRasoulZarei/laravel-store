@extends('admin.layouts.admin')

@section('title')
    index roles
@endsection

@section('content')

    <!-- Content Row -->
    <div class="row">

        <div class="col-xl-12 col-md-12 mb-4 p-4 bg-white">
            <div class="d-flex flex-column text-center flex-md-row justify-content-md-between mb-4">
                <h5 class="font-weight-bold mb-3 mb-md-0">لیست نقش ها ({{ $roles->total() }})</h5>
                <a class="btn btn-sm btn-outline-primary" href="{{ route('admin.roles.create') }}">
                    <i class="fa fa-plus"></i>
                    ایجاد نقش
                </a>
            </div>

            <div class="table-responsive">
                @if ($roles->count() == 0)
                    <p class="alert alert-info">
                        نقشی ساخته نشده
                    </p>
                @else
                    <table class="table table-bordered table-striped text-center">

                        <thead>
                            <tr>
                                <th>#</th>
                                <th>نام</th>
                                <th>نام نمایشی</th>
                                <th>عملیات</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($roles as $key => $role)
                                <tr>
                                    <th>
                                        {{ $roles->firstItem() + $key }}
                                    </th>
                                    <th>
                                        {{ $role->name }}
                                    </th>
                                    <th>
                                        {{ $role->display_name }}
                                    </th>
                                    <th>

                                        <a class="btn btn-sm btn-outline-info mr-3"
                                            href="{{ route('admin.roles.edit', ['role' => $role->id]) }}">ویرایش</a>

                                        <button type="button" class="btn btn-sm btn-outline-info " data-toggle="modal"
                                            data-target="#role-{{$role->id}}">
                                          مجوزها
                                        </button>
                                    </th>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @endif
            </div>

            <div class="d-flex justify-content-center mt-5">
                {{ $roles->render() }}
            </div>
        </div>

    </div>

    <!-- Modal -->
    @foreach ($roles  as $role)
    <div class="modal fade" id="role-{{$role->id}}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close text-left" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <h5 class="modal-title" id="exampleModalLabel">مجوزها</h5>
                </div>
                <div class="modal-body">
                   <ul class="row">
                    @foreach ($role->permissions as $permission )
                    <li class="col-md-6">{{$permission->display_name}}</li>
                    @endforeach


                   </ul>
                </div>

            </div>
        </div>
    </div>
    @endforeach

@endsection
