@extends('layouts.backend.admin')
@section('title', $title ?? 'Trang Quản Lý')
@section('content')


    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 style="text-transform: uppercase;  ">{{ $title }}</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('user.index') }}"
                                    style="text-transform: capitalize;">Tất cả thương hiệu</a></li>
                            <li class="breadcrumb-item active">{{ $title }}</li>
                        </ol>
                    </div>
                </div>
            </div><!-- /.container-fluid -->

        </section>

        <!-- Main content -->
        <section class="content">

            <!-- Default box -->
            <div class="card">
                <div class="card-header">
                    <div class="row">
                        <div class="col-md-12 text-right">
                            <a class="btn btn-sm btn-info" href="{{ route('user.index') }}">
                                <i class="fas fa-arrow-circle-left"></i> Quay về danh sách
                            </a>
                            <a class="btn btn-sm btn-primary" href="{{ route('user.edit', ['user' => $user->id]) }} ">
                                <i class=" fas fa-edit"></i>
                            </a>
                            <a class="btn btn-sm btn-danger" href="{{ route('user.delete', ['user' => $user->id]) }}">
                                <i class="fas fa-trash"></i>
                            </a>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    @includeIf('backend.message_alert')
                    <table class="table table-bordered border-primary table-hover ">
                        <thead class="bg-orange">
                            <tr class="fs-1">
                                <th width="30%">
                                    Tên trường
                                </th>
                                <th>
                                    Giá trị
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <th>Id</th>
                                <td>{{ $user->id }}</td>
                            </tr>
                            <tr>
                                <th>Họ&Tên</th>
                                <td>{{ $user->name }}</td>
                            </tr>
                            <tr>
                                <th>Tên tài khoản</th>
                                <td>{{ $user->username }}</td>
                            </tr>
                            <tr>
                                <th>Mật Khẩu</th>
                                <td>{{ $user->password }}</td>
                            </tr>
                            <tr>
                                <th>Giới tính</th>

                                <td>{{ $user->gender==0?'Nam':'Nữ' }}</td>
                            </tr>
                            <tr>
                                <th>Điện thoại</th>
                                <td>{{ $user->phone }}</td>
                            </tr>
                            <tr>
                                <th>Email</th>
                                <td>{{ $user->email }}</td>
                            </tr>
                            <tr>
                                <th>Hình đại diện</th>
                                <td class="index-img" >
                                    <img style="max-width: 150px" src="{{asset('images/user/'.$user->image)  }}"
                                        class=" img-fluid" alt="{{ $user->image }}">
                                </td>
                            </tr>
                            <tr>
                                <th>Quyền</th>
                                <td>{{ $user->roles==1?'Quản trị':'Khách hàng' }}</td>
                            </tr>
                            <tr>
                                <th>Địa chỉ</th>
                                <td>{{ $user->address }}</td>
                            </tr>
                            <tr>
                                <th>Ngày tạo</th>
                                <td>{{ $user->created_at }}</td>
                            </tr>
                            <tr>
                                <th>Người tạo</th>
                                <td>{{ $user->created_by }}</td>
                            </tr>
                            <tr>
                                <th>Ngày sửa cuối</th>
                                <td>{{ $user->updated_at }}</td>
                            </tr>
                            <tr>
                                <th>Người sửa cuối</th>
                                <td>{{ $user->updated_by }}</td>
                            </tr>
                            <tr>
                                <th>Trạng thái</th>
                                <td>{{ $user->status }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <!-- /.card-body -->
                <div class="card-footer">
                    <div class="row">
                        <div class="col-md-12 text-right">
                            <a class="btn btn-sm btn-info" href="{{ route('user.index') }}">
                                <i class="fas fa-arrow-circle-left"></i> Quay về danh sách
                            </a>
                            <a class="btn btn-sm btn-primary" href="{{ route('user.edit', ['user' => $user->id]) }} ">
                                <i class=" fas fa-edit"></i>
                            </a>
                            <a class="btn btn-sm btn-danger" href="{{ route('user.delete', ['user' => $user->id]) }}">
                                <i class="fas fa-trash"></i>
                            </a>
                        </div>
                    </div>
                </div>
                <!-- /.card-footer-->
            </div>
            <!-- /.card -->

        </section>
        <!-- /.content -->
    </div>

@endsection
