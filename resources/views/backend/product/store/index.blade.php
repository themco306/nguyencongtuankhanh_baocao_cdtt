@extends('layouts.backend.admin')
@section('title',$title??'Trang Quản Lý')
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
              <li class="breadcrumb-item"><a href="{{ route('dashboard.index') }}" style="text-transform: capitalize;">bảng điều khiển</a></li>
              <li class="breadcrumb-item active">{{ $title }}</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->

    </section>

    <!-- Main content -->
    <section class="content">

      <!-- Default box -->
        <form action="{{ route('product.delete_multi') }}" name="form1" method="post"  >
            @csrf
           
            <!-- Default box -->
            <div class="card">
                <div class="card-header">
                    <div class="row">
                        <div class="col-md-6">
                           
                        </div>
                        <div class="col-md-6 text-right">
                            <a class="btn btn-sm btn-success" href="{{ route("product.create_store") }}" name="ADD">
                                <i class="fas fa-plus"></i> Nhập
                            </a>
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
                                <th class="text-center" style="width:20%">Tên sản phẩm</th>
                                <th class="text-center" style="width:10%">Số lượng</th>
                                <th class="text-center" style="width:20%">Giá nhập</th>
                                <th class="text-center" style="width:20%">Ngày nhập</th>
                                <th class="text-center" style="width:20%">Người nhập</th>
                                <th class="text-center" style="width:5%">ID</th>
                            </tr>
                        </thead>
                        <tbody>
                           @foreach ($product_store as $row)
                               
                           
                            <tr>
                                <td class="text-center" style="width:20px">
                                    <div class="form-group">
                                        <input name="checkId[]" type="checkbox" id="web-developer"
                                            value="{{ $row->id }}">
                                    </div>
                                </td>
                                <td>
                                    {{ $row->product->name }}
                                </td>
                                <td>
                                    {{ $row->qty }}

                                </td>
                                <td>
                                    {{ $row->price }}

                                </td>

                                <td class="text-center">
                                    {{ $row->created_at }}

                                </td>
                                <td>
                                    {{ $row->user->name }}
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
                        <div class="col-md-6">
                           
                        </div>
                        <div class="col-md-6 text-right">
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
