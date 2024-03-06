@extends('layout')
@section('content')
    @if (Auth::check() && $cart->isNotEmpty())
        {!! Form::open([
            'route' => 'order.store',
            'method' => 'POST',
            'class' => 'bg-light p-4',
            'style' => 'margin-top: 1rem;',
        ]) !!}
        {!! Form::hidden('user_id', auth()->user()->id) !!}
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
        <div class="container">
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
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($cart as $key => $item)
                                    <tr>
                                        <td>
                                            <div class="how-itemcart1">
                                                <img src="{{ asset('uploads/product/' . $item->image) }}" alt="IMG"
                                                    class="img-fluid">
                                            </div>
                                        </td>
                                        <td>
                                            <p style="font-weight: 700">{{ $item->product->title }}</p>
                                            <div>
                                                <span style="font-size: .7rerm;color: 444"> {{ $item->color }} /
                                                    {{ $item->size }}</span>
                                            </div>
                                        </td>
                                        <td>{{ number_format($item->product->price) }} VNĐ</td>
                                        <td>
                                            <div class="input-group">
                                                <input type="number" class="form-control num-product"
                                                    value="{{ $item->quantity }}" readonly>
                                            </div>
                                        </td>
                                        <td>
                                            {{ number_format($item->product->price * $item->quantity, 0, ',', '.') }}
                                            VNĐ
                                        </td>
                                        <input type="hidden" name="product[{{ $key }}][id]"
                                            value="{{ $item->product->id }}">
                                        <input type="hidden" name="product[{{ $key }}][size]"
                                            value="{{ $item->size }}">
                                        <input type="hidden" name="product[{{ $key }}][color]"
                                            value="{{ $item->color }}">
                                        <input type="hidden" name="product[{{ $key }}][quantity]"
                                            value="{{ $item->quantity }}">
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="col-lg-5 mt-lg-0 mt-4">
                    <div class="border p-4">
                        <h4 class="mb-4">Tổng giỏ hàng</h4>

                        <div class="flex-w flex-t p-t-27 p-b-33">
                            <div class="size-208">
                                <span class="text-muted">Thành Tiền</span>
                            </div>
                            <div class="size-209 p-t-1">
                                @php
                                    $totalPrice = app('App\Http\Controllers\CartController')->getTotalPrice();
                                @endphp
                                <input type="text" class="mtext-110 cl2 font-weight-bold" name="total"
                                    value="{{ number_format($totalPrice, 0, ',', '.') }} VNĐ" readonly>
                            </div>
                        </div>

                        <div class="flex-w flex-t bor12 p-t-15 p-b-30">
                            <div class="size-208 w-full-ssm">
                                <span class="stext-110 cl2">
                                    Thông tin
                                </span>
                            </div>

                            <div class="size-209 p-r-18 p-r-0-sm w-full-ssm">
                                <div class="p-t-15">
                                    <span class="stext-112 cl8">
                                        Vui lòng nhập đúng địa chỉ giao hàng!
                                    </span>
                                    @php
                                        $userId = Auth::id();
                                        $user = App\Models\User::find($userId);
                                    @endphp
                                    <div class="bor8 bg0 m-b-12">
                                        <input type="text" class="stext-111 cl8 plh3 size-111 p-lr-15" name="total"
                                            value="{{ $user->name }}" readonly>
                                    </div>
                                    <div class="bor8 bg0 m-b-12">
                                        <input type="text" class="stext-111 cl8 plh3 size-111 p-lr-15" name="total"
                                            value="{{ $user->email }}" readonly>
                                    </div>
                                    <div class="rs1-select2 rs2-select2 bor8 bg0 m-b-12 m-t-9">
                                        <select class="js-select2" name="province">
                                            <option>Chọn tỉnh thành</option>
                                            @foreach ($provinces as $province)
                                                <option value="{{ $province['name'] }}">
                                                    {{ $province['name'] }}
                                                </option>
                                            @endforeach
                                        </select>
                                        <div class="dropDownSelect2"></div>
                                    </div>

                                    <div class="bor8 bg0 m-b-12">
                                        <input class="stext-111 cl8 plh3 size-111 p-lr-15" type="text"
                                            placeholder="Thành Phố" name="city">
                                    </div>

                                    <div class="bor8 bg0 m-b-22">
                                        <input class="stext-111 cl8 plh3 size-111 p-lr-15" type="text"
                                            placeholder="Địa Chỉ" name="address">
                                    </div>
                                    <div class="bor8 bg0 m-b-22">
                                        <input class="stext-111 cl8 plh3 size-111 p-lr-15" type="text"
                                            placeholder="Số Điện Thoại" name="phone">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <input type="hidden" name="status" value="0">

                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <button type="submit" class="btn btn-success btn-block">Xác nhận mua hàng</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        {!! Form::close() !!}
    @else
        @include('pages.404')
    @endif
@endsection
