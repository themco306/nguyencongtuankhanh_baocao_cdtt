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
              <li class="breadcrumb-item"><a href="{{ route('page.index') }}" style="text-transform: capitalize;">Tất cả trang đơn</a></li>
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
                        <a class="btn btn-sm btn-info" href="{{ route('page.index') }}">
                            <i class="fas fa-arrow-circle-left"></i> Quay về danh sách
                        </a>
                        <a class="btn btn-sm btn-primary"
                            href="{{ route('page.edit',['page'=>$page->id]) }} ">
                            <i class=" fas fa-edit"></i>
                        </a>
                        <a class="btn btn-sm btn-danger"
                            href="{{ route('page.delete',['page'=>$page->id]) }}">
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
                            <td>{{ $page->id }}</td>
                        </tr>
                        <tr>
                            <th>Tên Trang đơn</th>
                            <td>{{ $page->title }}</td>
                        </tr>
                        <tr>
                            <th>Slug</th>
                            <td>{{ $page->slug }}</td>
                        </tr>
                        <tr>
                            <th>Hình ảnh</th>
                            <td>
                                
                                      <img style="max-width: 400px"  src="{{ asset('images/post/'.$page->image) }}" alt="" />
                                   
                            </td>
                        </tr>
                        <tr>
                            <th>Chi Tiết</th>
                            <td>{{ $page->detail }}</td>
                        </tr>
                        <tr>
                            <th>Ngày tạo</th>
                            <td>{{ $page->created_at }}</td>
                        </tr>
                        <tr>
                            <th>Người tạo</th>
                            <td>{{ $page->created_by }}</td>
                        </tr>
                        <tr>
                            <th>Ngày sửa cuối</th>
                            <td>{{ $page->updated_at }}</td>
                        </tr>
                        <tr>
                            <th>Người sửa cuối</th>
                            <td>{{ $page->updated_by }}</td>
                        </tr>
                        <tr>
                            <th>Trạng thái</th>
                            <td>{{ $page->status }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <!-- /.card-body -->
            <div class="card-footer">
                <div class="row">
                    <div class="col-md-12 text-right">
                        <a class="btn btn-sm btn-info" href="{{ route('page.index') }}">
                            <i class="fas fa-arrow-circle-left"></i> Quay về danh sách
                        </a>
                        <a class="btn btn-sm btn-primary"
                            href="{{ route('page.edit',['page'=>$page->id]) }} ">
                            <i class=" fas fa-edit"></i>
                        </a>
                        <a class="btn btn-sm btn-danger"
                            href="{{ route('page.delete',['page'=>$page->id]) }}">
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


