@extends('layouts.app')
@section('title', 'Chi Tiết Đơn Hàng')
@section('content')
    <div class="content-wrapper">
        <section class="content-header">
            <h1 class="text-2xl font-semibold">
                Quản lý đơn hàng
            </h1>
            <ol class="breadcrumb">
                <li><a href="{{ route('home') }}" class="text-blue-500"><i class="fa fa-dashboard"></i>Trang chủ</a></li>
                <li><a href="{{ url('/list-order') }}" class="text-blue-500">Danh Sách Đơn Hàng</a></li>
                <li class="active">Chi tiết đơn hàng {{ $order->user->name }}</li>
            </ol>
        </section>
        <section class="content container mx-auto mt-8">
            <div class="col-span-12">
                <div class="box">
                    <div class="box-body table-responsive">
                        <table class="w-full table-auto">
                            <thead>
                                <tr>
                                    <th class="px-4 py-2">#</th>
                                    <th class="px-4 py-2">Hình Ảnh</th>
                                    <th class="px-4 py-2">Tên Sản Phẩm</th>
                                    <th class="px-4 py-2">Đơn Giá</th>
                                    <th class="px-4 py-2">Số lượng</th>
                                    <th class="px-4 py-2">Tổng</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($orderdt as $key => $list)
                                    <tr>
                                        <td class="px-4 py-2">{{ $key }}</td>
                                        <td class="px-4 py-2">
                                            <img src="{{ asset('uploads/product/' . $list->product->image) }}"
                                                alt="IMG" class="h-32 object-cover">
                                        </td>
                                        <td class="px-4 py-2">
                                            <p class="text-xl font-semibold">{{ $list->product->title }}</p>
                                            <div class="line-clamp-2">
                                                <span>{{ $list->color }} / {{ $list->size }}</span>
                                            </div>
                                        </td>
                                        <td class="px-4 py-2">{{ number_format($list->product->price) }} VNĐ</td>
                                        <td class="px-4 py-2">{{ $list->quantity }}</td>
                                        <td class="px-4 py-2">
                                            {{ number_format($list->product->price * $list->quantity, 0, ',', '.') }}
                                            VNĐ
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="container mx-auto mt-8 flex items-center leading-10">
                <div class="col-span-12">
                    @if ($order->status == 4)
                        <h2 class="text-2xl font-semibold">Đánh Giá Sản Phẩm</h2>
                        @if ($review->isEmpty())
                            <div class="card mt-4">
                                <div class="card-body">
                                    <p class="text-2xl font-bold">Chưa có đánh giá!</p>
                                </div>
                            </div>
                        @else
                            @foreach ($review as $key => $listReview)
                                <div class="card mt-4">
                                    <div class="card-body">
                                        <div class="mb-2 flex items-center">
                                            @if ($listReview->user->image)
                                                <img src="{{ asset('uploads/user/' . $listReview->user->image) }}"
                                                    class="mr-2 h-20 w-20 rounded-full"
                                                    alt="{{ $listReview->user->name }}">
                                            @else
                                                <div
                                                    class="mr-2 flex h-10 w-10 items-center justify-center rounded-full bg-gray-300">
                                                    <i class="fas fa-user text-gray-600"></i>
                                                </div>
                                            @endif
                                            <h5 class="text-2xl font-semibold">{{ $listReview->user->name }}</h5>
                                            <span class="ml-2 text-gray-500">đã đánh giá
                                                {{ $listReview->product->title }}</span>

                                        </div>
                                        @if (empty($listReview->content))
                                            <p>Chưa có đánh giá</p>
                                        @else
                                            <div>
                                                <p class="card-text mb-2 font-semibold">{{ $listReview->content }}</p>
                                                <div class="flex items-center">
                                                    @for ($i = 1; $i <= 5; $i++)
                                                        @if ($i <= $listReview->star)
                                                            <i class="fa fa-star text-yellow-500"></i>
                                                        @else
                                                            <i class="fa fa-star-o text-yellow-500"></i>
                                                        @endif
                                                    @endfor
                                                </div>
                                            </div>

                                            <p class="card-text mt-1 text-gray-500"><i class="fa fa-clock-o"></i>
                                                Thời gian: {{ $listReview->date_review }}</p>
                                        @endif
                                    </div>
                                </div>
                            @endforeach
                        @endif
                    @endif
                </div>
            </div>
        </section>
    </div>
@endsection
