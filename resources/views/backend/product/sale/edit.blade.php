@extends('layouts.backend.admin')
@section('title', $title ?? 'Trang Quản Lý')
@section('header')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css">
@endsection
@section('footer')

<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>
    <script>
        $(document).ready(function() {
    $('#product_id').select2();
});
    </script>
@endsection
@section('content')
    <section class="content">
        <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            <section class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6 text-success">
                            <h1 style="text-transform: uppercase;  ">{{ $title }}</h1>
                        </div>
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="{{ route('product.index_sale') }}"
                                        style="text-transform: capitalize;">Tất cả sản phẩm</a></li>
                                <li class="breadcrumb-item active ">{{ $title }}</li>
                            </ol>
                        </div>
                    </div>
                </div><!-- /.container-fluid -->

            </section>
            <!-- Main content -->
            <section class="content">
                <form action="{{ route('product.edit_store_sale') }}" name="form1" id='form_store' method="post" >
                    <!-- Default box --> @csrf
                    <div class="card">
                        <div class="card-header">
                            <div class="row">
                                <div class="col-md-12 text-right">
                                    <button name="THEM" type="submit" id="add_store" class="btn btn-sm btn-success">
                                        <i class="fas fa-save"></i> Lưu[Thêm]
                                    </button>
                                    <a class="btn btn-sm btn-info" href="{{ route('product.index_sale') }}">
                                        <i class="fas fa-arrow-circle-left"></i> Quay về danh sách
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            @includeIf('backend.message_alert')
                            <div class="row">
                                <div class="col-md-6">
                                    <div>
                                        <label for="product_id">Sản phẩm</label>
                                        <input type="hidden" id="product_info_url" value="{{ route('product.get_info', ['product' => '']) }}"/>
                                        <select name="product_id" id="product_id" class="form-control" data-live-search="true" >
                                            {!! $html_product_id !!}
                                        </select>
                                        @if ($errors->has('product_id'))
                                            <div class="text-danger">
                                                {{ $errors->first('product_id') }}
                                            </div>
                                        @endif
                                    </div>
                                    <div>
                                        <label >Số lượng còn</label>
                                        
                                        <input name="qty_base" id="qty_base" type="text" class="form-control" placeholder="0" readonly>
                                    </div>
                                    <div>
                                        <label >Giá nhập gần nhất</label>
                                        <input name="price_base" id="price_base" type="text" class="form-control" placeholder="0" readonly>
                                    </div>
                                    <div>
                                        <label >Giá đang bán</label>
                                        <input name="price_selling" id="price_selling" type="text" class="form-control" placeholder="0" readonly>
                                    </div>
                                </div>
                                <div class="col-md-6">

                                    <div>
                                        <label for="qty">Số lượng giảm</label>
                                        <input name="qty" id="qty" type="number" class="form-control" value="{{ old('qty',$product_sale->qty) }}">
                                        @if ($errors->has('qty'))
                                            <div class="text-danger">
                                                {{ $errors->first('qty') }}
                                            </div>
                                        @endif
                                    </div>
                                    <div >
                                        <div class="clo-6">
                                            <label for="date_begin">Ngày bắt đầu</label>
                                            <input name="date_begin" id="date_begin" type="datetime-local" class="form-control" min="{{ date('Y-m-d\TH:i') }}"  value="{{ old('date_begin',$product_sale->date_begin) }}">
                                            @if ($errors->has('date_begin'))
                                                <div class="text-danger">
                                                    {{ $errors->first('date_begin') }}
                                                </div>
                                            @endif
                                        </div>
                                        <div class="clo-6">
                                            <label for="date_end">Ngày kết thúc</label>
                                            <input name="date_end" id="date_end" value="{{ old('date_end',$product_sale->date_end) }}"
                                                type="datetime-local" class="form-control " min="{{ date('Y-m-d\TH:i') }}">
                                            @if ($errors->has('date_end'))
                                                <div class="text-danger">
                                                    {{ $errors->first('date_end') }}
                                                </div>
                                            @endif
                                        </div>
                                       
                                    </div>
                                    <div >
                                        <label for="discount">Phầm trăm giảm</label>
                                        <div class="input-group ">
                                        <input name="discount" id="discount" type="number" class="form-control" value="{{ old('discount',$product_sale->discount) }}">
                                        <span class="input-group-text">%</span>
                                    </div>
                                        @if ($errors->has('discount'))
                                            <div class="text-danger">
                                                {{ $errors->first('discount') }}
                                            </div>
                                        @endif
                                    </div>
                                    <div>
                                        <label >Giá sau giảm</label>
                                        <input name="price_end" id="price_end" type="number" class="form-control" placeholder="0" readonly>
                                    </div>
                                </div>
                                

                            </div>
                        </div>

                    </div>
                    <!-- /.card-body -->
                    <div class="card-footer">
                        <div class="row">
                            <div class="col-md-12 text-right">
                                <button name="THEM" type="submit" class="btn btn-sm btn-success">
                                    <i class="fas fa-save"></i> Lưu[Thêm]
                                </button>
                                <a class="btn btn-sm btn-info" href="{{ route('product.index_sale') }}">
                                    <i class="fas fa-arrow-circle-left"></i> Quay về danh sách
                                </a>
                            </div>
                        </div>
                    </div>
                    <!-- /.card-footer-->
        </div>
        <!-- /.card -->
        </form>
    </section>
    <!-- /.content -->
    </div>
    <script src="{{ asset('js/change_create_product_sale.js') }}"></script>
    </section>


@endsection
