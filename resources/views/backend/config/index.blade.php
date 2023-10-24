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
                            <li class="breadcrumb-item"><a href="{{ route('dashboard.index') }}"
                                    style="text-transform: capitalize;">bảng điều khiển</a></li>
                            <li class="breadcrumb-item active">{{ $title }}</li>
                        </ol>
                    </div>
                </div>
            </div><!-- /.container-fluid -->

        </section>

        <!-- Main content -->
        <section class="content">

            <!-- Default box -->
            <form action="{{ route('config.addoredit') }}" name="form1" method="post">
                @csrf

                <!-- Default box -->
                <div class="card">
                    <div class="card-header">
                        <div class="row">
                            <div class="col-md-6">
                            </div>
                            <div class="col-md-6 text-right">
                                <div class="text-right">
                                    <button class="btn btn-sm btn-success" type="submit">
                                        <i class="fas fa-plus"></i> Thay đổi
                                    </button>

                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        @includeIf('backend.message_alert')

                        <div class="row">
                            <div class="col-12">
                               
                                   
                                    <input type="hidden" name="id" id="id" 
                                       value="{{$config->id??'0' }}">
                                <div>
                                    <label for="name">Tên shop</label>
                                    <input type="text" name="name" id="name" class="form-control"
                                        placeholder="Việt Nam" value="{{ old('name',$config->name) }}">
                                    @if ($errors->has('name'))
                                        <div class="text-danger">
                                            {{ $errors->first('name') }}
                                        </div>
                                    @endif
                                </div>
                                <div>
                                    <label for="metakey">Từ khóa</label>
                                    <textarea name="metakey" id="metakey" class="form-control" placeholder="Từ khóa">{{ old('metakey',$config->metakey) }}</textarea>
                                    @if ($errors->has('metakey'))
                                        <div class="text-danger">
                                            {{ $errors->first('metakey') }}
                                        </div>
                                    @endif
                                </div>
                                <div>
                                    <label for="metadesc">Mô tả</label>
                                    <textarea name="metadesc" id="metadesc" class="form-control" placeholder="Mô tả">{{ old('metadesc',$config->metadesc) }}</textarea>
                                    @if ($errors->has('metadesc'))
                                        <div class="text-danger">
                                            {{ $errors->first('metadesc') }}
                                        </div>
                                    @endif

                                </div>
                                <div>
                                    <label for="slogan">Slogan</label>
                                    <input type="text" name="slogan" id="slogan" class="form-control"
                                        placeholder="Việt Nam" value="{{ old('slogan',$config->slogan) }}">
                                    @if ($errors->has('slogan'))
                                        <div class="text-danger">
                                            {{ $errors->first('slogan') }}
                                        </div>
                                    @endif
                                </div>
                                <div>
                                    <label for="email">Email</label>
                                    <input type="text" name="email" id="email" class="form-control"
                                        placeholder="Việt Nam" value="{{ old('email',$config->email) }}">
                                    @if ($errors->has('email'))
                                        <div class="text-danger">
                                            {{ $errors->first('email') }}
                                        </div>
                                    @endif
                                </div>
                                <div>
                                    <label for="phone">Phone</label>
                                    <input type="text" name="phone" id="phone" class="form-control"
                                        placeholder="Việt Nam" value="{{ old('phone',$config->phone) }}">
                                    @if ($errors->has('phone'))
                                        <div class="text-danger">
                                            {{ $errors->first('phone') }}
                                        </div>
                                    @endif
                                </div>
                                <div>
                                    <label for="facebook">Facebook</label>
                                    <input type="text" name="facebook" id="facebook" class="form-control"
                                        placeholder="Việt Nam" value="{{ old('facebook',$config->facebook) }}">
                                    @if ($errors->has('facebook'))
                                        <div class="text-danger">
                                            {{ $errors->first('facebook') }}
                                        </div>
                                    @endif
                                </div>
                            </div>


                        </div>
                        <!-- /.card-body -->
                        <div class="card-footer">
                            <div class="row">
                                <div class="col-md-6 text-right">
                                    <div class="text-right">
                                        <button class="btn btn-sm btn-success" type="submit">
                                            <i class="fas fa-plus"></i> Thay đổi
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
