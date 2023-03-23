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
                            <li class="breadcrumb-item"><a href="{{ route('order.index') }}"
                                    style="text-transform: capitalize;">Tất cả đơn hàng</a></li>
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
                            <div class="d-inline-block">
                                <a class="btn btn-sm btn-info" href="{{ route('order.index') }}">
                                    <i class="fas fa-arrow-circle-left"></i> Quay về danh sách
                                </a>
                            </div>
                            <div class="d-inline-block">
                                <a class="btn btn-sm btn-primary"
                                    href="">
                                    <i class="fa-solid fa-clipboard-check"></i>Xác nhận
                                </a>
                            </div>
                            <div class="d-inline-block">
                                <a class="btn btn-sm btn-info"
                                    href="">
                                    <i class="fa-solid fa-box"></i> Đóng gói
                                </a>
                            </div>
                            <div class="d-inline-block">
                                <a class="btn btn-sm btn-warning"
                                    href="">
                                    <i class="fa-solid fa-plane-up"></i> Vận chuyển
                                </a>
                            </div>
                            <div class="d-inline-block">

                                <a class="btn btn-sm btn-success"
                                    href="">
                                    <i class="fa-solid fa-plane-circle-check"></i>Đã giao
                                </a>
                            </div>
                            <div class="d-inline-block">
                                <a class="btn btn-sm btn-danger"
                                    href="">
                                    <i class="fas fa-trash"></i> Hủy
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    @includeIf('backend.message_alert')
                    <div class="row">
                        <div class="col-3">
                            <h5 class="text-info">Thông tin khách hàng</h5>
                            <div>
                                <h6><strong>Tên khách hàng</strong></h6>
                                <input type="text" class="form-control" disabled value="{{$order->name }}">
                            </div>
                            <div class="mt-2">
                                <h6><strong>Điện thoại</strong></h6>
                                <input type="text" class="form-control" disabled value="{{$order->phone }}">
                            </div>
                            <div class="mt-2">
                                <h6><strong>Địa chỉ</strong></h6>
                                <input type="text" class="form-control" disabled value="{{$order->address }}">
                            </div>
                            <div class="mt-2">
                                <h6><strong>Email</strong></h6>
                                <input type="text" class="form-control" disabled value="{{$order->email }}">
                            </div>
                        </div>
                        <div class="col-9">
                            <table class="table table-bordered" id="myTable">
                                <h5 class="text-info">Chi tiết đơn hàng</h5>
                                <thead class="bg-orange">
                                    <tr>
                                        <th class="text-center" style="width:5%">
                                            <div class="form-group select-all">
                                                <input type="checkbox" id="select-all">
                                            </div>
                                        </th>
                                        <th style="width:15%">Hình</th>
                                        <th style="width:30%">Tên sản phẩm</th>
                                        <th style="width:10%">Giá</th>
                                        <th class="text-center" style="width:10%">Số lượng</th>
                                        <th class="text-center" style="width:15%">Thành tiền</th>
                                        <th class="text-center" style="width:5%">ID</th>
                                    </tr>
                                </thead>
                                <tbody>
                                  @foreach ($list_orderdetail as $row)
                                    <tr>

                                        <td class="text-center" style="width:20px">
                                            <div class="form-group">
                                                <input name="checkId[]" type="checkbox" value="{{$row->id }}"
                                                    id="web-developer">
                                            </div>
                                        </td>
                                        <td>
                                            <img src="{{ asset('images/product/'.$row->image) }}"
                                                class="img-fluid" alt="{{ $row->image }}">

                                        </td>
                                        <td>
                                            {{ $row->name }}
                                        </td>
                                        <td>
                                            {{ number_format($row->price) }}
                                        </td>

                                        <td class="text-center">
                                            {{ $row->qty}}
                                        </td>
                                        <td class="text-center">
                                            {{ number_format($row->amount) }}
                                        </td>

                                        <td class="text-center" style="width:20px">
                                            {{ $row->id }}
                                        </td>
                                    </tr>
                                    @php
                                         $tongtien+= $row->amount
                                    @endphp
                                    @endforeach

                                </tbody>
                                <td colspan="7">
                                    <h5 class="text-danger">Tổng tiền: {{number_format($tongtien) }} </h5>
                                </td>

                            </table>
                        </div>
                    </div>
                </div>
                <!-- /.card-body -->
                <div class="card-footer">
                    <div class="row">
                        <div class="col-md-12 text-right">
                            <a class="btn btn-sm btn-info" href="{{ route('order.index') }}">
                                <i class="fas fa-arrow-circle-left"></i> Quay về danh sách
                            </a>
                            <a class="btn btn-sm btn-primary" href="{{ route('order.edit', ['order' => $order->id]) }} ">
                                <i class=" fas fa-edit"></i>
                            </a>
                            <a class="btn btn-sm btn-danger" href="{{ route('order.delete', ['order' => $order->id]) }}">
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
