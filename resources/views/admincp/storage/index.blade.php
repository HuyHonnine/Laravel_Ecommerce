@extends('layouts.app')
@section('title', 'Quản lý kho hàng')
@section('content')
    <div class="content-wrapper">
        <section class="content-header">
            <h1>
                Quản lý kho hàng
            </h1>
            <ol class="breadcrumb">
                <li><a href="{{ route('home') }}"><i class="fa fa-dashboard"></i>Trang chủ</a></li>
                <li><a href="#">Quản lý kho hàng</a></li>
                <li class="active">Danh sách kho hàng</li>
            </ol>
        </section>

        <section class="content container-fluid">
            <div class="col-xs-12">
                <div class="box">
                    <div class="box-body table-responsive no-padding">
                        <table class="table-hover table" id='table_panigation'>
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Quản Lý</th>
                                    <th scope="col">Hình ảnh sản phẩm</th>
                                    <th scope="col">Tên sản phẩm</th>
                                    <th scope="col">Màu sắc</th>
                                    <th scope="col">Số lượng</th>
                                </tr>
                            </thead>
                            <tbody class="cate_position">
                                @foreach ($list as $key => $storage)
                                    <tr id="{{ $storage->id }}">
                                        <th scope="row">{{ $key }}</th>
                                        <td>
                                            {!! Form::open([
                                                'method' => 'DELETE',
                                                'route' => ['storage.destroy', $storage->id],
                                                'onsubmit' => 'return confirm("Bạn có muốn xóa không?")',
                                            ]) !!}
                                            {!! Form::submit('Xóa', ['class' => 'btn btn-danger btn-sm bg-red-500']) !!}
                                            {!! Form::close() !!}
                                            <a href="{{ route('storage.edit', $storage->id) }}" style="margin-top: .5rem"
                                                class="btn btn-warning btn-sm">Sửa</a>
                                        </td>
                                        <td>
                                            <img style="margin-top: 1rem; height: 10rem; width: 10rem; object-fit: cover"
                                                src="{{ asset('uploads/product/' . $storage->product->image) }}"
                                                alt="">
                                        </td>
                                        <td>
                                            {{ $storage->product->title }}
                                        </td>
                                        <td>
                                            {{ $storage->product->color->name }}
                                        </td>
                                        <td>{{ $storage->quantity }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

        </section>
    </div>
@endsection
