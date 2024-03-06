@extends('layout')
@section('content')
    <div class="container">
        <div class="bread-crumb flex-w p-r-15 p-t-30 p-lr-0-lg"> <a href="{{ route('homepage') }}"
                class="stext-109 cl8 hov-cl1 trans-04">
                Trang chủ
                <i class="fa fa-angle-right m-l-9 m-r-10" aria-hidden="true"></i>
            </a>

            <span class="stext-109 cl4">
                Giỏ Hàng
            </span>
        </div>
    </div>

    <div class="container mt-4" style="margin-bottom: 16rem">
        <div class="bg-light p-4">
            <div class="row">
                <div class="col-lg-7">
                    <div class="wrap-table-shopping-cart">
                        <table class="table-bordered table">
                            <thead class="thead-light">
                                <tr>
                                    <th scope="col">Hình ảnh</th>
                                    <th scope="col">Sản phẩm</th>
                                    <th scope="col">Giá</th>
                                    <th scope="col">Số Lượng</th>
                                    <th scope="col">Tổng Tiền</th>
                                    <th scope="col">Quản Lý</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($cartItems as $key => $item)
                                    <tr>
                                        <td>
                                            <div class="how-itemcart1">
                                                <img src="{{ asset('uploads/product/' . $item->image) }}" alt="IMG"
                                                    class="img-fluid">
                                            </div>
                                        </td>
                                        <td>
                                            {{ $item->product->title }}
                                            <div>
                                                <span> {{ $item->color }} / </span><span> {{ $item->size }}</span>
                                            </div>
                                        </td>
                                        <td>{{ number_format($item->product->price) }} VNĐ</td>
                                        <td>
                                            <div class="wrap-num-product flex-w m-l-auto m-r-0">
                                                <div class="btn-num-product-down cl8 hov-btn3 trans-04 flex-c-m">
                                                    <i class="fs-16 zmdi zmdi-minus"></i>
                                                </div>

                                                <input class="mtext-104 cl3 txt-center num-product" type="number"
                                                    name="quantity" value="{{ $item->quantity }}">

                                                <div class="btn-num-product-up cl8 hov-btn3 trans-04 flex-c-m">
                                                    <i class="fs-16 zmdi zmdi-plus"></i>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            {{ number_format($item->product->price * $item->quantity, 0, ',', '.') }}
                                            VNĐ
                                        </td>
                                        <td>
                                            {!! Form::open([
                                                'method' => 'DELETE',
                                                'route' => ['cart.destroy', $item->id],
                                                'onsubmit' => 'return confirm("Bạn có muốn xóa không?")',
                                            ]) !!}
                                            {!! Form::submit('Xóa', ['class' => 'btn btn-danger btn-sm', 'style' => 'cursor: pointer']) !!}
                                            {!! Form::close() !!}
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <div class="d-flex justify-content-between align-items-center mt-4">
                        <div class="flex-grow-1">
                            <input class="form-control" type="text" placeholder="Coupon Code">
                        </div>
                        <div>
                            <button type="submit" class="btn btn-secondary">Cập Nhật</button>
                            <button type="button" class="btn btn-primary ml-2">Thêm coupon</button>
                        </div>

                    </div>
                </div>

                <div class="col-lg-5 mt-lg-0 mt-4">
                    <div class="border p-4">
                        <h4 class="mb-4">Tổng giỏ hàng</h4>

                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <span class="text-muted">Thành Tiền</span>
                            <span class="font-weight-bold">{{ number_format($totalPrice, 0, ',', '.') }} VNĐ</span>
                        </div>

                        @php
                            $totalQuantity = app('App\Http\Controllers\CartController')->getTotalQuantity();
                        @endphp

                        @if ($totalQuantity >= 1)
                            @if (Auth::check())
                                <a href="{{ url('/tao-don-hang') }}" class="btn btn-success btn-block">Thanh Toán</a>
                            @else
                                <a href="{{ url('login-customer') }}" class="btn btn-info btn-block">Bạn Cần Đăng
                                    Nhập</a>
                            @endif
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.1/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
@endsection
