@extends('layouts.app')
@if (!isset($storage))
    @section('title', 'Thêm sản phẩm vào kho')
@else
    @section('title', 'Sửa sản phẩm trong kho')
@endif
@section('content')
    <div class="content-wrapper">
        <section class="content-header">
            <h1>
                Quản lý kho
            </h1>
            <ol class="breadcrumb">
                <li><a href="{{ route('home') }}"><i class="fa fa-dashboard"></i>Trang chủ</a></li>
                <li><a href="#">Quản lý kho</a></li>
                @if (!isset($storage))
                    <li class="active">Thêm sản phẩm vào kho</li>
                @else
                    <li class="active">Sửa sản phẩm trong kho</li>
                @endif
            </ol>
        </section>
        <section class="content container-fluid">
            <div class="col-md-6">
                <div class="box">
                    <div class="box-header with-border">
                        @if (!isset($storage))
                            <h3 class="box-title">Thêm sản phẩm vào kho</h3>
                        @else
                            <h3 class="box-title">Sửa sản phẩm trong kho</h3>
                        @endif
                    </div>
                    @if ($errors->any())
                        <div class="alert alert-danger" style="padding: 0.75rem 2.25rem; margin-bottom: 0">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                    @if (!isset($storage))
                        {!! Form::open(['route' => 'storage.store', 'method' => 'POST', 'enctype' => 'multipart/form-data']) !!}
                    @else
                        {!! Form::open([
                            'route' => ['storage.update', $storage->id],
                            'method' => 'PUT',
                            'enctype' => 'multipart/form-data',
                        ]) !!}
                    @endif
                    <div class="box-body space-x-auto">
                        <div class="col-md-12 box box-primary px-10 py-4">
                            <div class="form-group row">
                                {!! Form::label('product', 'Tên sản phẩm') !!}
                                {!! Form::select(
                                    'product_id',
                                    ['0' => 'Chọn sản phẩm', 'sản phẩm mới nhất' => $list_title],
                                    isset($storage) ? $storage->product_id : '',
                                    [
                                        'class' => 'form-control h-100',
                                    ],
                                ) !!}
                            </div>
                            <div class="form-group row">
                                {!! Form::label('quantity', 'Số Lượng') !!}

                                {!! Form::text('quantity', isset($storage) ? $storage->quantity : '', [
                                    'class' => 'form-control',
                                    'placeholder' => 'Nhập dữ liệu...',
                                ]) !!}
                            </div>
                        </div>
                    </div>
                    <div class="box-footer">
                        @if (!isset($storage))
                            {!! Form::submit('Thêm Dữ Liệu', ['class' => 'btn btn-success bg-green-600']) !!}
                        @else
                            {!! Form::submit('Cập Nhật', ['class' => 'btn btn-success bg-green-600']) !!}
                        @endif
                    </div>
                    {!! Form::close() !!}
                </div>
            </div>
        </section>
    </div>
@endsection
