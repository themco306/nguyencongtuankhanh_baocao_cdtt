@extends('layouts.backend.admin')
@section('title',$title??'Trang Quản Lý')
@section('content')
<section class="content">
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
                        <li class="breadcrumb-item"><a href="{{ route('product.index') }}" style="text-transform: capitalize;">Tất cả sản phẩm</a></li>
                        <li class="breadcrumb-item active">{{ $title }}</li>
                      </ol>
                    </div>
                  </div>
                </div><!-- /.container-fluid -->
          
              </section>
            <!-- Main content -->
            <section class="content">
                <form action="{{ route('product.update',['product'=>$product->id]) }}" name="form1" method="post" enctype="multipart/form-data">
                   @method('PUT')
                <!-- Default box --> @csrf
                <div class="card">
                    <div class="card-header">
                        <div class="row">
                            <div class="col-md-12 text-right">
                                <button name="THEM" type="submit" class="btn btn-sm btn-success">
                                    <i class="fas fa-save"></i> Lưu[Sửa]
                                </button>
                                <a class="btn btn-sm btn-info" href="{{ route('product.index') }}">
                                    <i class="fas fa-arrow-circle-left"></i> Quay về danh sách
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        @includeIf('backend.message_alert')
                        

                        <ul class="nav nav-tabs" id="myTab" role="tablist">
                            <li class="nav-item" role="presentation">
                                <button class="nav-link active" id="home-tab" data-bs-toggle="tab"
                                    data-bs-target="#home" type="button" role="tab" aria-controls="home"
                                    aria-selected="true">Chính</button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link " id="images-tab" data-bs-toggle="tab" data-bs-target="#images"
                                    type="button" role="tab" aria-controls="images" aria-selected="false">Hình
                                    Ảnh</button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link " id="sales-tab" data-bs-toggle="tab" data-bs-target="#sales"
                                    type="button" role="tab" aria-controls="sales" aria-selected="false">Khuyến
                                    Mãi</button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="details-tab" data-bs-toggle="tab" data-bs-target="#details"
                                    type="button" role="tab" aria-controls="details" aria-selected="false">Chi Tiết
                                    </button>
                            </li>
                        </ul>
                        <div class="tab-content p-3  border-right border-left border-bottom" id="myTabContent">
                            {{-- Chính --}}
                            <div class="tab-pane fade show active " id="home" role="tabpanel"
                                aria-labelledby="home-tab">
                                @includeIf('backend.product.edit.tab_product-home')
                               
                            </div>
                            {{-- Hình Ảnh --}}
                            <div class="tab-pane fade  " id="images" role="tabpanel" aria-labelledby="images-tab">
                                @includeIf('backend.product.edit.tab_product-images')
                              
                               
                            </div>
                            {{-- Khuyến Mãi --}}
                            <div class="tab-pane fade " id="sales" role="tabpanel" aria-labelledby="sales-tab">
                                @includeIf('backend.product.edit.tab_product-sales')
                              
                                
                            </div>
                            {{-- Khách Hàng[Tìm] --}}
                            <div class="tab-pane fade" id="details" role="tabpanel" aria-labelledby="details-tab">
                                @includeIf('backend.product.edit.tab_product-details')
                            </div>
                        </div>


                    </div>
                    <!-- /.card-body -->
                    <div class="card-footer">
                        <div class="row">
                            <div class="col-md-12 text-right">
                                <button name="THEM" type="submit" class="btn btn-sm btn-success">
                                    <i class="fas fa-save"></i> Lưu[Sửa]
                                </button>
                                <a class="btn btn-sm btn-info" href="{{ route('product.index') }}">
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
</section>
<script>
    CKEDITOR.replace('detail')
</script>
    
@endsection