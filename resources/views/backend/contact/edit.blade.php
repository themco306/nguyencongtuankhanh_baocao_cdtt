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
                                <li class="breadcrumb-item"><a href="{{ route('contact.index') }}"
                                        style="text-transform: capitalize;">Tất cả liên hệ</a></li>
                                <li class="breadcrumb-item active ">{{ $title }}</li>
                            </ol>
                        </div>
                    </div>
                </div><!-- /.container-fluid -->

            </section>
            <!-- Main content -->
            <section class="content">
                <form action="{{ route('contact.update', ['contact' => $contact->id]) }}" name="form1" method="post"
                    enctype="multipart/form-data">
                    @method('PUT')
                    <!-- Default box --> @csrf
                    <div class="card">
                        <div class="card-header">
                            <div class="row">
                                <div class="col-md-12 text-right">
                                    <button name="TRALOI" type="submit" class="btn btn-sm btn-success">
                                        <i class="fas fa-envelope-square"></i> Trả lời
                                    </button>
                                    <a class="btn btn-sm btn-info" href="{{ route('contact.index') }}">
                                        <i class="fas fa-arrow-circle-left"></i> Quay về danh sách
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            @includeIf('backend.message_alert')

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <input type="hidden" name="id" value="{{ $contact->id }}">
                                        <label for="name">Tên khách hàng</label>
                                        <input name="name" id="name" type="text" value="{{ $contact->name }}"
                                            class="form-control " disabled>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="name">Email</label>
                                        <input name="email" id="email" type="email" value="{{ $contact->email }}"
                                            class="form-control " disabled>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="phone">Phone</label>
                                        <input name="phone" id="phone" type="text" value="{{ $contact->phone }}"
                                            class="form-control " disabled>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="title">Tiêu đề</label>
                                        <input name="title" id="title" type="text" value="{{ $contact->title }}"
                                            class="form-control " disabled>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="mb-3">
                                        <label for="detail">Nội dung</label>
                                        <textarea name="detail" id="detail" cols=" 12" rows="2" class="form-control "
                                            disabled>{{ $contact->detail }}</textarea>
        
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="mb-3">
                                        <label for="replaydetail">Nội dung trả lời</label>
                                        <textarea name="replaydetail" id="replaydetail" cols=" 12" rows="2"
                                            class="form-control " >{{ old('replaydetail',trim($contact->replaydetail)) }}</textarea>
                                    </div>
                                </div>
        
                            </div>

                        </div>
                        <!-- /.card-body -->
                        <div class="card-footer">
                            <div class="row">
                                <div class="col-md-12 text-right">
                                    <button name="TRALOI" type="submit" class="btn btn-sm btn-success">
                                        <i class="fas fa-envelope-square"></i> Trả lời
                                    </button>
                                    <a class="btn btn-sm btn-info" href="{{ route('contact.index') }}">
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
