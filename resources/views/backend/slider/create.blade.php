@extends('layouts.backend.admin')
@section('title', $title ?? 'Trang Quản Lý')
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
                                <li class="breadcrumb-item"><a href="{{ route('slider.index') }}"
                                        style="text-transform: capitalize;">Tất cả thương hiệu</a></li>
                                <li class="breadcrumb-item active ">{{ $title }}</li>
                            </ol>
                        </div>
                    </div>
                </div><!-- /.container-fluid -->

            </section>
            <!-- Main content -->
            <section class="content">
                <form action="{{ route('slider.store') }}" name="form1" method="post" enctype="multipart/form-data">
                    <!-- Default box --> @csrf
                    <div class="card">
                        <div class="card-header">
                            <div class="row">
                                <div class="col-md-12 text-right">
                                    <button name="THEM" type="submit" class="btn btn-sm btn-success">
                                        <i class="fas fa-save"></i> Lưu[Thêm]
                                    </button>
                                    <a class="btn btn-sm btn-info" href="{{ route('slider.index') }}">
                                        <i class="fas fa-arrow-circle-left"></i> Quay về danh sách
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            @includeIf('backend.message_alert')

                
                                <div class="mb-3">
                                    <label for="name">Tên slider</label>
                                    <input name="name" id="name" type="text" class="form-control "  placeholder="vd: " value="{{ old('name') }}">
                                    @if ($errors->has('name'))
                                    <div class="text-danger">
                                        {{ $errors->first('name') }}
                                    </div>
                                @endif
                                </div>
                                <div class="mb-3">
                                    <label for="link">Liên kết</label>
                                    <input name="link" id="link" type="text" class="form-control " placeholder="#"  value="{{ old('link') }}">
                                    @if ($errors->has('link'))
                                    <div class="text-danger">
                                        {{ $errors->first('link') }}
                                    </div>
                                @endif
                                </div>
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="position">Vị trí</label>
                                        <select name="position" id="position"  class="form-control">
                                            <option value="slideshow">slideshow</option>
                                        </select>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="sort_order">Sắp xếp</label>
                                        <select name="sort_order" id="sort_order" class="form-control">
                                            <option value="0">--chon vị trí--</option>
                                            {!! $html_sort_order !!} 
                                        </select>
                                    </div>
                                </div>
            
                                <div class="mb-3">
                                    <label for="image">Hình ảnh</label>
                                    <input name="image" id="image" type="file" class="form-control btn-sm">
                                    @if ($errors->has('image'))
                                    <div class="text-danger">
                                        {{ $errors->first('image') }}
                                    </div>
                                @endif
                                </div>
                                <div class="mb-3">
                                    <label for="status">Trạng thái</label>
                                    <select name="status" id="status" class="form-control">
                                        <option value="1" {{ old('status') == 1 ? 'selected' : ' ' }}>Xuất bản</option>
                                        <option value="2" {{ old('status') == 2 ? 'selected' : ' ' }}>Không xuất bản
                                        </option>
            
                                    </select>
                                </div>
                       


                        </div>
                        <!-- /.card-body -->
                        <div class="card-footer">
                            <div class="row">
                                <div class="col-md-12 text-right">
                                    <button name="THEM" type="submit" class="btn btn-sm btn-success">
                                        <i class="fas fa-save"></i> Lưu[Thêm]
                                    </button>
                                    <a class="btn btn-sm btn-info" href="{{ route('slider.index') }}">
                                        <i class="fas fa-arrow-circle-left"></i> Quay về danh sách
                                    </a>
                                </div>
                            </div>
                            <!-- /.card-footer-->
                        </div>
                    </div>
                    <!-- /.card -->
                </form>
            </section>
            <!-- /.content -->
        </div>
    </section>

@endsection
