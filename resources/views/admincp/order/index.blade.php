@extends('layouts.app')
@section('title', 'Danh Sách Đơn Hàng')
@section('content')
    <div class="content-wrapper">
        <section class="content-header">
            <h1>
                Quản lý đơn hàng
            </h1>
            <ol class="breadcrumb">
                <li><a href="{{ route('home') }}"><i class="fa fa-dashboard"></i>Trang chủ</a></li>
                <li><a href="#">Quản lý đơn hàng</a></li>
                <li class="active">Danh Sách Đơn Hàng</li>
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
                                    <th scope="col">Người Đặt</th>
                                    <th scope="col">Tổng Tiền</th>
                                    <th scope="col">Địa Chỉ</th>
                                    <th scope="col">Ngày Tạo</th>
                                    <th scope="col">Trạng Thái</th>
                                    <th scope="col">Chi tiết</th>
                                    <th scope="col">Xác Nhận</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($list as $key => $order)
                                    <tr id="{{ $order->id }}">
                                        <th scope="row">{{ $key }}</th>
                                        <td>{{ $order->user->name }}</td>
                                        <td>{{ $order->total }}</td>
                                        <td>
                                            {{ $order->address }}
                                            <div class="text-xl">
                                                <span>{{ $order->province }} /
                                                </span><span>{{ $order->city }}</span>
                                            </div>
                                        </td>
                                        <td>{{ $order->date_order }}</td>
                                        <td>
                                            @if ($order->status == 0)
                                                <p style="color: red; font-weight: 700">Đợi Xác Nhận</p>
                                            @elseif ($order->status == 1)
                                                <p style="font-weight: 700">Đang Đóng Hàng</p>
                                            @elseif ($order->status == 2)
                                                <p style="color: blue;font-weight: 700">Đang vận chuyển</p>
                                            @elseif ($order->status == 3)
                                                <p style="color:#f39c12;font-weight: 700">Đợi xác nhận</p>
                                            @elseif ($order->status == 4)
                                                <p style="color:green;font-weight: 700">Đơn thành công</p>
                                            @endif
                                        </td>
                                        <td>
                                            <a href="{{ route('orderDetail', $order->id) }}"
                                                class="btn btn-warning btn-sm">Xem</a>
                                        </td>

                                        <td>
                                            {!! Form::open(['url' => url('/order-comfirm', [$order->id]), 'method' => 'PUT']) !!}
                                            @if ($order->status == 0)
                                                {!! Form::hidden('status', 1) !!}
                                                {!! Form::submit('Xác Nhận', ['class' => 'btn btn-primary btn-sm bg-blue-500']) !!}
                                            @elseif ($order->status == 1)
                                                {!! Form::hidden('status', 2) !!}
                                                {!! Form::submit('Đã đóng hàng', ['class' => 'btn btn-primary btn-sm bg-blue-500']) !!}
                                            @elseif ($order->status == 2)
                                                {!! Form::hidden('status', 3) !!}
                                                {!! Form::submit('Đã vận chuyển', ['class' => 'btn btn-primary btn-sm bg-blue-500']) !!}
                                            @endif
                                            {!! Form::close() !!}
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
