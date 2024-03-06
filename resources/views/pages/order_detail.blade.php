@extends('layout')
@section('content')
    @if (Auth::id() == $order->user_id)
        <div class="container">
            <div class="bread-crumb flex-w p-r-15 p-t-30 p-lr-0-lg">
                <a href="{{ route('homepage') }}" class="stext-109 cl8 hov-cl1 trans-04">
                    Trang chủ
                    <i class="fa fa-angle-right m-l-9 m-r-10" aria-hidden="true"></i>
                </a>

                <a href="{{ route('order.index') }}" class="stext-109 cl8 hov-cl1 trans-04">
                    Đơn hàng
                    <i class="fa fa-angle-right m-l-9 m-r-10" aria-hidden="true"></i>
                </a>

                <span class="stext-109 cl4">
                    Chi tiết đơn {{ $order->user->name }}
                </span>

            </div>
        </div>
        <form class="bg0 p-t-30 p-b-85">
            <div class="container-fluid">
                <div class="row justify-content-center">
                    <div class="col-lg-10 col-xl-10 m-b-50">
                        <div class="m-lr-auto m-lr-0-xl">
                            <div class="wrap-table-shopping-cart">
                                <table class="table-bordered table">
                                    <thead class="thead-light">
                                        <tr>
                                            <th scope="col">#</th>
                                            <th scope="col">Hình Ảnh</th>
                                            <th scope="col">Tên Sản Phẩm</th>
                                            <th scope="col">Đơn Giá</th>
                                            <th scope="col">Số lượng</th>
                                            <th scope="col">Tổng</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($orderdt as $key => $list)
                                            <tr>
                                                <th scope="row">{{ $key }}</th>
                                                <td>
                                                    <div class="how-itemcart1">
                                                        <img src="{{ asset('uploads/product/' . $list->product->image) }}"
                                                            alt="IMG" class="img-fluid"
                                                            style="height: 5rem; object-fit: cover">
                                                    </div>
                                                </td>
                                                <td>
                                                    <p style="font-size: 1.25rem; font-weight: 700">
                                                        {{ $list->product->title }}</p>
                                                    <div style="line-height: 2">
                                                        <span style="font-size: 1rem">{{ $list->color }}
                                                            /
                                                            {{ $list->size }}</span>
                                                    </div>
                                                </td>
                                                <td>{{ number_format($list->product->price) }} VNĐ</td>
                                                <td>{{ $list->quantity }}</td>
                                                <td>
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
                </div>
            </div>
        </form>
    @else
        @include('pages.404')
    @endif

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.1/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
@endsection
