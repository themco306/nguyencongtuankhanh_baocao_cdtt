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
                            <a class="btn btn-sm btn-success" href="{{ route("product.create_sale") }}" name="ADD">
                                <i class="fas fa-plus"></i> Thêm giảm giá
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
                                <th class="text-center" style="width:15%">%</th>
                                <th class="text-center" style="width:30%">Thời hạn</th>
                                <th class="text-center" style="width:15%">Người nhập</th>
                                <th class="text-center" style="width:5%">ID</th>
                            </tr>
                        </thead>
                        <tbody>
                           @foreach ($product_sale as $row)
                               
                           
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
                                    <a 
                                    href="{{ route('product.edit_sale', ['product' => $row->id]) }}">
                                    @if($row->date_begin <= \Carbon\Carbon::now() && $row->date_end >= \Carbon\Carbon::now())
                                            <p  class="text-success" title="Nhấn vào để nhập thêm">Giảm {{ $row->sale->discount }}%</p>
                                        @else
                                            <p class="text-danger" title="Nhấn vào để gia hạn">Hết hạn giảm</p>
                                     
                                        @endif
                                    </a>
                                    

                                </td>

                                <td class="text-center">
                                    <span>Giảm từ: <span class="text-success">{{ $row->date_begin }}</span><br/>
                                            đến: <span  class="text-danger">{{ $row->date_end }}</span>
                                    </span>
                                  

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
