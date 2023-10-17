@extends('layouts.backend.admin')
@section('title',$title??'Trang Quản Lý')
@section('header')
<link
rel="stylesheet"
href="https://cdn.jsdelivr.net/npm/@splidejs/splide@4.1.4/dist/css/splide.min.css"
/>
@endsection
@section('footer')
<script src="https://cdn.jsdelivr.net/npm/@splidejs/splide@4.1.4/dist/js/splide.min.js"></script>
<script src="{{ asset('js/slider_bar.js') }}"></script>
@endsection
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
              <li class="breadcrumb-item"><a href="{{ route('product.index') }}" style="text-transform: capitalize;">Tất cả sản phẩm</a></li>
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
                        <a class="btn btn-sm btn-info" href="{{ route('product.index') }}">
                            <i class="fas fa-arrow-circle-left"></i> Quay về danh sách
                        </a>
                        <a class="btn btn-sm btn-primary"
                            href="{{ route('product.edit',['product'=>$product->id]) }} ">
                            <i class=" fas fa-edit"></i>
                        </a>
                        <a class="btn btn-sm btn-danger"
                            href="{{ route('product.delete',['product'=>$product->id]) }}">
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
                            <td>{{ $product->id }}</td>
                        </tr>
                        <tr>
                            <th>Tên sản phẩm</th>
                            <td>{{ $product->name }}</td>
                        </tr>
                        <tr>
                            <th>Slug</th>
                            <td>{{ $product->slug }}</td>
                        </tr>
                        <tr>
                            <th>Mã danh mục</th>
                            <td>
                                {{ $product->category_id }}
                            </td>
                        </tr>
                        <tr>
                            <th>Mã thương hiệu</th>
                            <td>
                                {{ $product->brand_id }}
                            </td>
                        </tr>

                        <tr>
                            <th>Hình ảnh</th>
                            <td>
                                <section
                                id="main-carousel"
                                class="splide"
                                aria-label="The carousel with thumbnails. Selecting a thumbnail will change the Beautiful Gallery carousel."
                              >
                                <div style="max-width: 50%;" class="splide__track">
                                  <ul class="splide__list">
                                    @foreach ($product_images as $item)
                                    <li class="splide__slide">
                                        <img src="{{ asset('images/product/'.$item->image) }}" alt="" />
                                      </li>
                                    @endforeach
                                  </ul>
                                </div>
                              </section>
                          
                              <section
                                id="thumbnail-carousel"
                                class="splide"
                                aria-label="The carousel with thumbnails. Selecting a thumbnail will change the Beautiful Gallery carousel."
                              >
                              <div style="" class="splide__track">
                                <ul class="splide__list">
                                  @foreach ($product_images as $item)
                                  <li class="splide__slide">
                                      <img src="{{ asset('images/product/'.$item->image) }}" alt="" />
                                    </li>
                                  @endforeach
                                </ul>
                              </div>
                              </section>









                                
                                
                            </td>
                        </tr>
                        <tr>
                            <th>Chi tiết</th>
                            <td>{{ $product->detail }}</td>
                        </tr>
                        <tr>
                            <th>Số lượng</th>
                            <td>{{ $product->qty }}</td>
                        </tr>
                        <tr>
                            <th>Giá</th>
                            <td>{{ $product->price }}</td>
                        </tr>
                        <tr>
                            @php
                                if (!empty($product->sale->price_sale)) {
                                        $price_sale = $product->sale->price_sale;
                                        } else {
                                            $price_sale='';                                    
                                        }
                            @endphp
                            <th>Giá khuyến mãi</th>
                            <td>{{ $price_sale }}</td>
                        </tr>
                        <tr>
                            <th>Ngày tạo</th>
                            <td>{{ $product->created_at }}</td>
                        </tr>
                        <tr>
                            <th>Người tạo</th>
                            <td>{{ $product->created_by }}</td>
                        </tr>
                        <tr>
                            <th>Ngày sửa cuối</th>
                            <td>{{ $product->updated_at }}</td>
                        </tr>
                        <tr>
                            <th>Người sửa cuối</th>
                            <td>{{ $product->updated_by }}</td>
                        </tr>
                        <tr>
                            <th>Trạng thái</th>
                            <td>{{ $product->status }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <!-- /.card-body -->
            <div class="card-footer">
                <div class="row">
                    <div class="col-md-12 text-right">
                        <a class="btn btn-sm btn-info" href="{{ route('product.index') }}">
                            <i class="fas fa-arrow-circle-left"></i> Quay về danh sách
                        </a>
                        <a class="btn btn-sm btn-primary"
                            href="{{ route('product.edit',['product'=>$product->id]) }} ">
                            <i class=" fas fa-edit"></i>
                        </a>
                        <a class="btn btn-sm btn-danger"
                            href="{{ route('product.delete',['product'=>$product->id]) }}">
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


