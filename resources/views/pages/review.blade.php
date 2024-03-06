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
        @foreach ($orderdt as $key => $list)
            <section class="bg0 p-t-50 p-b-116">
                <div class="container">
                    <div class="flex-w flex-tr">
                        <div class="size-210 bor10 p-lr-70 p-lr-15-lg w-full-md">
                            {!! Form::open([
                                'route' => 'review.store',
                                'method' => 'POST',
                                'class' => 'bg-light p-4',
                                'style' => 'margin-top: 1rem;',
                            ]) !!}
                            {!! Form::hidden('user_id', auth()->user()->id) !!}
                            {!! Form::hidden('status', 0) !!}
                            {!! Form::hidden('product_id', $list->product_id) !!}
                            {!! Form::hidden('order_id', $order->id) !!}
                            @if ($errors->any())
                                <div class="alert alert-danger" style="margin-left: auto; margin-right: auto; width: 70%">
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
                            <h5 class="mtext-108 cl2 p-b-7">
                                Đánh giá sản phẩm
                            </h5>

                            <div class="flex-w flex-m p-t-30 p-b-23">
                                <span class="stext-102 cl3 m-r-16">
                                    Chất lượng sản phẩm
                                </span>

                                <span class="wrap-rating fs-18 cl11 pointer">
                                    <i class="item-rating pointer zmdi zmdi-star-outline"></i>
                                    <i class="item-rating pointer zmdi zmdi-star-outline"></i>
                                    <i class="item-rating pointer zmdi zmdi-star-outline"></i>
                                    <i class="item-rating pointer zmdi zmdi-star-outline"></i>
                                    <i class="item-rating pointer zmdi zmdi-star-outline"></i>
                                    <input class="dis-none" type="number" name="rating">
                                    {!! Form::select(
                                        'star',
                                        ['' => 'Chọn', '1' => '1 sao', '2' => '2 sao', '3' => '3 sao', '4' => '4 sao', '5' => '5 sao'],
                                        '',
                                        [
                                            'class' => 'form-control h-100',
                                        ],
                                    ) !!}
                                </span>

                            </div>

                            <div class="row p-b-25">
                                <div class="col-12 p-b-5">
                                    {!! Form::label('content', 'Đánh giá của bạn', ['class' => 'stext-102 cl3']) !!}
                                    {!! Form::textarea('content', '', [
                                        'class' => 'size-110 bor8 stext-102 cl2 p-lr-20 p-tb-10',
                                    ]) !!}
                                </div>
                            </div>

                            {!! Form::submit('Gửi đánh giá', [
                                'class' => 'flex-c-m stext-101 cl0 size-112 bg7 bor11 hov-btn3 p-lr-15 trans-04 m-b-10',
                                'style' => 'cursor: pointer',
                            ]) !!}

                            {!! Form::close() !!}

                        </div>

                        <div class="size-210 bor10 flex-w flex-col-m p-lr-93 p-tb-30 p-lr-15-lg w-full-md">
                            <div>
                                <div class="text-center">
                                    <div class="m-b-20 mx-auto" style="max-width: 200px;">
                                        <img src="{{ asset('uploads/product/' . $list->product->image) }}" alt="IMG"
                                            class="img-fluid">
                                    </div>
                                </div>
                                <div>
                                    <p>
                                        Tên sản phẩm: <span style="font-size: 1.25rem; font-weight: 700">
                                            {{ $list->product->title }}
                                        </span>
                                    </p>

                                    <div style="line-height: 2">
                                        Chi tiết:
                                        <span style="font-size: 1rem">{{ $list->color }}
                                            /
                                            {{ $list->size }}</span>
                                    </div>
                                </div>
                                <div>
                                    <p>Giá tiền: <span>{{ number_format($list->product->price) }} VNĐ</span></p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        @endforeach
    @endif
@endsection
