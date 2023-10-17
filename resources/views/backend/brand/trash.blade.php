@extends('layouts.backend.admin')
@section('title', $title ?? 'Trang Quản Lý')
@section('header')
   <link rel="stylesheet" href="{{ asset('css/Warning.css') }}">
@endsection
@section('footer')
 <script src="{{ asset('js/warning.js') }}"></script>
@endsection
@section('content')

    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6 text-danger">
                        <h1 style="text-transform: uppercase;  ">{{ $title }}</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('brand.index') }}"
                                    style="text-transform: capitalize;">tất cả thương hiệu</a></li>
                            <li class="breadcrumb-item active">{{ $title }}</li>
                        </ol>
                    </div>
                </div>
            </div><!-- /.container-fluid -->

        </section>

        <!-- Main content -->
        <section class="content">

            <!-- Default box -->
            <form action="{{ route('brand.trash_multi') }}" name="form1" method="POST">
                @csrf
                
                <!-- Default box -->
                <div class="card">
                    <div class="card-header">
                        <div class="row">
                            <div class="col-md-8">
                                <button class="btn btn-sm btn-danger del" type="submit" name="DELETE_ALL"
                             >
                                    <i class="fas fa-trash"></i> Xóa vv đã chọn
                                </button>
                                   <span class="text-danger warning"> Lưu ý khi xóa Thương Hiệu thì các Sản Phẩm và Menu liên qua cũng bị xóa theo</span>
                            </div>
                            <div class="col-md-4 text-right">
                                <div class="text-right">

                                    <a class="btn btn-sm btn-info" href="{{ route('brand.index') }}">
                                        <i class="fas fa-arrow-circle-left"></i> Quay về danh sách
                                    </a>
                                    <button name="RESTORE_ALL" class="btn btn-sm btn-info" type="submit">
                                        <i class="fa-solid fa-arrow-rotate-left"></i>Phục hồi đã chọn
                                    </button>
                                </div>

                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        @includeIf('backend.message_alert')
                        <table class="table table-bordered" id="myTable">
                            <thead class="bg-orange">
                                <tr>
                                    <th class="text-center" style="width:5%">
                                        <div class="form-group select-all">
                                            <input type="checkbox" id="select-all">
                                        </div>
                                    </th>
                                    <th class="text-center" style="width: 10%;">Hình</th>
                                    <th class="text-center" style="width: 20%;">Tên thương hiệu</th>
                                    <th class="text-center" style="width: 20%;">Slug</th>
                                    <th class="text-center" style="width: 20%;"> Ngày Tạo</th>
                                    <th class="text-center" style="width: 20%;">Chức Năng</th>
                                    <th class="text-center" style="width: 5%;">ID</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($brand as $row)
                                    <tr>
                                        <td class="text-center" style="width:20px">
                                            <div class="form-group">
                                                <input name="checkId[]" type="checkbox" id="web-developer"
                                                    value="{{ $row->id }}">
                                            </div>
                                        </td>
                                        <td>
                                            <img src="{{ asset('images/brand/' . $row->image) }}" class="img-fluid"
                                                alt="">
                                        </td>
                                        <td>
                                            {{ $row->name }}
                                        </td>
                                        <td>
                                            {{ $row->slug }}

                                        </td>

                                        <td class="text-center">
                                            {{ $row->created_at }}

                                        </td>
                                        <td class="text-center">


                                            <a class="btn btn-sm btn-info"
                                                href="{{ route('brand.show', ['brand' => $row->id]) }}">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            <a class="btn btn-sm btn-primary"
                                                href="{{ route('brand.restore', ['brand' => $row->id]) }}">
                                                <i class="fa-solid fa-arrow-rotate-left"></i>
                                            </a>
                                            <a class="btn btn-sm btn-danger del"
                                                href="{{ route('brand.destroy', ['brand' => $row->id]) }}">
                                                <i class="fas fa-trash"></i>
                                            </a>
                                        </td>
                                        <td class="text-center" style="width:20px">
                                            {{ $row->id }}
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <!-- /.card-body -->
                    <div class="card-footer">
                        <div class="row">
                            <div class="col-md-8">
                                <button class="btn btn-sm btn-danger del" type="submit" name="DELETE_ALL"
                             >
                                    <i class="fas fa-trash"></i> Xóa vv đã chọn
                                </button>
                                   <span class="text-danger warning"> Lưu ý khi xóa Thương Hiệu thì các Sản Phẩm và Menu liên qua cũng bị xóa theo</span>
                            </div>
                            <div class="col-md-4 text-right">
                                <div class="text-right">

                                    <a class="btn btn-sm btn-info" href="{{ route('brand.index') }}">
                                        <i class="fas fa-arrow-circle-left"></i> Quay về danh sách
                                    </a>
                                    <button name="RESTORE_ALL" class="btn btn-sm btn-info" type="submit">
                                        <i class="fa-solid fa-arrow-rotate-left"></i>Phục hồi đã chọn
                                    </button>
                                </div>

                            </div>
                        </div>
                    </div>
                    <!-- /.card-footer-->
                </div>
                <!-- /.card -->
            </form>
            <!-- /.card-footer-->
            <!-- /.card -->
        </section>
        <!-- /.content -->
    </div>

@endsection
