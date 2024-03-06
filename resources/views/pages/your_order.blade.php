@extends('layout')
@section('content')
    @if (Auth::id())
        <div class="container">
            <div class="bread-crumb flex-w p-r-15 p-t-30 p-lr-0-lg"> <a href="{{ route('homepage') }}"
                    class="stext-109 cl8 hov-cl1 trans-04">
                    Trang chủ
                    <i class="fa fa-angle-right m-l-9 m-r-10" aria-hidden="true"></i>
                </a>

                <span class="stext-109 cl4">
                    Đơn hàng của bạn
                </span>
            </div>
        </div>
        <div class="bg0 p-t-23">
            <div class="container-fluid">
                <div class="row justify-content-center">
                    <div class="col-lg-10 col-xl-10 m-b-50">
                        <div class="m-lr-auto m-lr-0-xl">
                            <div class="wrap-table-shopping-cart">
                                <table class="table-bordered table">
                                    <thead class="thead-light">
                                        <tr>
                                            <th scope="col">#</th>
                                            <th scope="col">Người Đặt</th>
                                            <th scope="col">Tổng Tiền</th>
                                            <th scope="col">Địa Chỉ</th>
                                            <th scope="col">Ngày Tạo</th>
                                            <th scope="col">Trạng Thái</th>
                                            <th scope="col">Chi tiết</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($list as $key => $order)
                                            <tr>
                                                <th scope="row">{{ $key }}</th>
                                                <td>{{ $order->user->name }}</td>
                                                <td>{{ $order->total }}</td>
                                                <td>
                                                    {{ $order->address }}
                                                    <div class="text-sm">
                                                        <span>{{ $order->province }} /
                                                        </span><span>{{ $order->city }}</span>
                                                    </div>
                                                </td>
                                                <td>{{ $order->date_order }}</td>
                                                <td>
                                                    @if ($order->status == 0)
                                                        <p style="color: red; font-weight: 700">Đợi Xác Nhận</p>
                                                    @elseif ($order->status == 1)
                                                        <p style="color:yellow;font-weight: 700">Đang Đóng Hàng</p>
                                                    @elseif ($order->status == 2)
                                                        <p style="color: blue;font-weight: 700">Đang vận chuyển</p>
                                                    @elseif ($order->status == 3)
                                                        <p style="color:#f39c12;font-weight: 700">Xác nhận</p>
                                                        <span>
                                                            {!! Form::open(['url' => url('/order-comfirm', [$order->id]), 'method' => 'PUT']) !!}
                                                            {!! Form::hidden('status', 4) !!}
                                                            {!! Form::submit('Đã Nhận', ['class' => 'btn btn-primary btn-sm bg-blue-500', 'style' => 'cursor: pointer;']) !!}
                                                            {!! Form::close() !!}
                                                        </span>
                                                    @elseif ($order->status == 4)
                                                        @php
                                                            $matchingReview = $review->where('order_id', $order->id)->first();
                                                        @endphp

                                                        @if ($matchingReview)
                                                            <p style="color:green;font-weight: 700">Thành công</p>
                                                        @else
                                                            <a href="{{ route('review.create', $order->id) }}"
                                                                class="btn btn-danger btn-sm">Đánh Giá</a>
                                                        @endif
                                                    @endif
                                                </td>
                                                <td>
                                                    <a href="{{ route('order_detail', $order->id) }}"
                                                        class="btn btn-warning btn-sm">Xem</a>
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

        </div>
        <div style="display: flex; justify-content: center; margin-bottom: 2rem">{!! $list->links('vendor.pagination.bootstrap-4') !!}</div>
    @else
        @include('pages.404')
    @endif
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.1/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
@endsection
