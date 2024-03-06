@extends('layouts.app')
@section('title', 'Danh Sách Sản Phẩm')
@section('content')
    <div class="content-wrapper">
        <section class="content-header">
            <h1>
                Quản lý sản phẩm
            </h1>
            <ol class="breadcrumb">
                <li><a href="{{ route('home') }}"><i class="fa fa-dashboard"></i>Trang chủ</a></li>
                <li><a href="#">Quản lý sản phẩm</a></li>
                <li class="active">Danh sách sản phẩm</li>
            </ol>
        </section>
        <section class="content container-fluid">
            <div class="mb-4">
                <a href="{{ route('color.create') }}" style="margin-top: .5rem" class="btn btn-success btn-sm">Thêm
                    màu</a>
                <a href="{{ route('size.create') }}" style="margin-top: .5rem" class="btn btn-success btn-sm">Thêm
                    size</a>
            </div>
            <div class="col-xs-12">
                <div class="box">
                    <div class="box-body table-responsive no-padding">
                        <table class="table-hover table" id='table_panigation'>
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Quản Lý</th>
                                    <th scope="col">Tên</th>
                                    <th scope="col">Mô tả</th>
                                    <th scope="col">Giá Thành</th>
                                    <th scope="col">Nổi Bật</th>
                                    <th scope="col">Danh Mục</th>
                                    <th scope="col">Thương Hiệu</th>
                                    <th scope="col">Trạng Thái</th>
                                    <th scope="col">Hình Ảnh</th>
                                    <th scope="col">Hình Ảnh Phụ</th>
                                    <th scope="col">Màu sắc</th>
                                    <th scope="col">Kích Cỡ</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($list as $key => $product)
                                    <tr id="{{ $product->id }}">
                                        <th scope="row">{{ $key }}</th>
                                        <td class="row-cols-3" style="line-height: 2.5">
                                            {!! Form::open([
                                                'method' => 'DELETE',
                                                'route' => ['product.destroy', $product->id],
                                                'onsubmit' => 'return confirm("Bạn có muốn xóa không?")',
                                            ]) !!}
                                            <a href="{{ route('product.edit', $product->id) }}"
                                                class="btn btn-warning btn-sm">Sửa</a>
                                            {!! Form::submit('Xóa', ['class' => 'btn btn-danger btn-sm bg-red-500']) !!}
                                            {!! Form::close() !!}
                                        </td>
                                        <td>{{ $product->title }}</td>
                                        <td> {{ substr($product->description, 0, 60) }}</td>
                                        <td>{{ number_format($product->price) }}</td>
                                        <td>
                                            @if ($product->hot == 1)
                                                <span class="label label-success">HOT</span>
                                            @else
                                                <span class="label label-danger">Không</span>
                                            @endif
                                        </td>
                                        <td>
                                            <span class="label label-primary">{{ $product->category->title }}</span>
                                        </td>
                                        <td>
                                            <span class="label label-primary">{{ $product->brand->title }}</span>
                                        </td>

                                        <td>
                                            @if ($product->status == 1)
                                                <span class="label label-success">Hiển thị</span>
                                            @else
                                                <span class="label label-danger">Đóng</span>
                                            @endif
                                        </td>
                                        <td>
                                            <img style="margin-top: 1rem; height: 10rem; width: 10rem; object-fit: cover"
                                                src="{{ asset('uploads/product/' . $product->image) }}" alt="">
                                        </td>
                                        <td>
                                            <div class="flex flex-row flex-wrap gap-x-1 gap-y-1">
                                                @foreach ($product->product_library as $key => $lib)
                                                    <img style="margin-top: 1rem; height: 3rem; width: 3rem"
                                                        src="{{ asset('uploads/library/' . $lib->image) }}" alt="">
                                                @endforeach
                                            </div>
                                        </td>
                                        <td>
                                            @foreach ($product->product_color as $key => $col)
                                                <span
                                                    class="inline-block h-12 w-12 rounded-full bg-[#{{ $col->bg_color }}] p-6">
                                                </span>
                                            @endforeach
                                        </td>
                                        <td>
                                            @foreach ($product->product_size as $key => $size)
                                                <span class="label label-warning">{{ $size->title }}</span>
                                            @endforeach
                                        </td>
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
