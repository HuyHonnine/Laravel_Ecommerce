@extends('layout')
@section('content')
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
        <div class="bread-crumb flex-w p-l-25 p-r-15 p-t-30 p-lr-0-lg">
            <a href="{{ route('homepage') }}" class="stext-109 cl8 hov-cl1 trans-04">
                Trang Chủ
                <i class="fa fa-angle-right m-l-9 m-r-10" aria-hidden="true"></i>
            </a>

            <a href="{{ route('shop') }}" class="stext-109 cl8 hov-cl1 trans-04">
                Cửa Hàng
                <i class="fa fa-angle-right m-l-9 m-r-10" aria-hidden="true"></i>
            </a>

            <span class="stext-109 cl4">
                {{ $product->title }}
            </span>
        </div>
    </div>
    <div class="container">
        <div class="bg0 p-t-60 p-b-30 p-lr-15-lg how-pos3-parent">
            <button class="how-pos3 hov3 trans-04 js-hide-modal1">
                <img src="{{ asset('frontend/images/icons/icon-close.png') }}" alt="CLOSE">
            </button>
            <div class="row">
                <div class="col-md-6 col-lg-7 p-b-30">
                    <div class="p-l-25 p-r-30 p-lr-0-lg">
                        <div class="wrap-slick3 flex-sb flex-w">
                            <div class="wrap-slick3-dots"></div>
                            <div class="wrap-slick3-arrows flex-sb-m flex-w"></div>
                            <div class="slick3 gallery-lb">
                                @foreach ($product->product_library as $key => $lib)
                                    <div class="item-slick3" data-thumb="{{ asset('uploads/library/' . $lib->image) }}">
                                        <div class="wrap-pic-w pos-relative">
                                            <img style="width: 100%; height: 40rem; object-fit: cover"
                                                src="{{ asset('uploads/library/' . $lib->image) }}" alt="IMG-PRODUCT">

                                            <a class="flex-c-m size-108 how-pos1 bor0 fs-16 cl10 bg0 hov-btn3 trans-04"
                                                href="{{ asset('uploads/library/' . $lib->image) }}">
                                                <i class="fa fa-expand"></i>
                                            </a>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-lg-5 p-b-30">
                    {!! Form::open(['route' => 'cart.store', 'method' => 'POST', 'enctype' => 'multipart/form-data']) !!}
                    {!! Form::hidden('product_id', $product->id) !!}
                    @if (auth()->check())
                        {!! Form::hidden('user_id', auth()->user()->id) !!}
                    @else
                        {!! Form::hidden('user_id', '0') !!}
                    @endif
                    {!! Form::hidden('price', $product->price) !!}
                    {!! Form::hidden('name', $product->title) !!}
                    {!! Form::hidden('image', $product->image) !!}
                    <div class="p-r-50 p-t-5 p-lr-0-lg">
                        <h4 class="mtext-105 cl2 js-name-detail p-b-14">
                            {{ $product->title }}
                        </h4>
                        <span class="mtext-106 cl2">
                            {{ number_format($product->price) }} VNĐ
                        </span>
                        <p class="stext-102 cl3 p-t-23">
                            {{ $product->description }}
                        </p>
                        <div class="p-t-33">

                            <div class="form-group flex-w flex-r-m p-b-10">
                                {!! Form::label('color', 'Màu Sắc', ['class' => 'size-203 flex-c-m respon6']) !!}

                                <div class="size-204 respon6-next">
                                    <div class="rs1-select2 bor8 bg0">
                                        {!! Form::select('color', ['' => 'Lựa chọn'] + $product->product_color->pluck('name', 'name')->toArray(), null, [
                                            'class' => 'js-select2 form-control color-select',
                                            'style' => 'display: none',
                                        ]) !!}
                                        <div class="dropDownSelect2"></div>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group flex-w flex-r-m p-b-10">
                                {!! Form::label('size', 'Kích Cỡ', ['class' => 'size-203 flex-c-m respon6']) !!}

                                <div class="size-204 respon6-next">
                                    <div class="rs1-select2 bor8 bg0">
                                        {!! Form::select('size', ['' => 'Lựa chọn'] + $product->product_size->pluck('title', 'title')->toArray(), null, [
                                            'class' => 'js-select2 form-control size-select',
                                            'style' => 'display: none',
                                        ]) !!}
                                        <div class="dropDownSelect2"></div>
                                    </div>
                                </div>
                            </div>

                            <div class="flex-w flex-r-m p-b-10">
                                <div class="size-204 flex-w flex-m respon6-next">
                                    <div class="wrap-num-product flex-w m-r-20 m-tb-10">
                                        <div class="btn-num-product-down cl8 hov-btn3 trans-04 flex-c-m">
                                            <i class="fs-16 zmdi zmdi-minus"></i>
                                        </div>

                                        <input class="mtext-104 cl3 txt-center num-product" type="number" name="quantity"
                                            value="1" min="1">

                                        <div class="btn-num-product-up cl8 hov-btn3 trans-04 flex-c-m">
                                            <i class="fs-16 zmdi zmdi-plus"></i>
                                        </div>
                                    </div>
                                    {!! Form::submit('Thêm vào giỏ', [
                                        'class' => 'flex-c-m stext-101 cl0 size-101 bg1 bor1 hov-btn1 p-lr-15 trans-04 js-addcart-detail0',
                                        'style' => 'cursor: pointer;',
                                    ]) !!}
                                </div>
                            </div>
                        </div>
                        <div class="flex-w flex-m p-l-100 p-t-40 respon7">
                            <div class="flex-m bor9 p-r-10 m-r-11">
                                <a href="#"
                                    class="fs-14 cl3 hov-cl1 trans-04 lh-10 p-lr-5 p-tb-2 js-addwish-detail tooltip100"
                                    data-tooltip="Add to Wishlist">
                                    <i class="zmdi zmdi-favorite"></i>
                                </a>
                            </div>

                            <a href="#" class="fs-14 cl3 hov-cl1 trans-04 lh-10 p-lr-5 p-tb-2 m-r-8 tooltip100"
                                data-tooltip="Facebook">
                                <i class="fa fa-facebook"></i>
                            </a>

                            <a href="#" class="fs-14 cl3 hov-cl1 trans-04 lh-10 p-lr-5 p-tb-2 m-r-8 tooltip100"
                                data-tooltip="Twitter">
                                <i class="fa fa-twitter"></i>
                            </a>

                            <a href="#" class="fs-14 cl3 hov-cl1 trans-04 lh-10 p-lr-5 p-tb-2 m-r-8 tooltip100"
                                data-tooltip="Google Plus">
                                <i class="fa fa-google-plus"></i>
                            </a>
                        </div>
                    </div>
                    {!! Form::close() !!}

                </div>
            </div>
            <div class="bor10 m-t-50 p-t-43 p-b-40">
                <!-- Tab01 -->
                <div class="tab01">
                    <!-- Nav tabs -->
                    <ul class="nav nav-tabs" role="tablist">
                        <li class="nav-item p-b-10">
                            <a class="nav-link active" data-toggle="tab" href="#description" role="tab">Mô tả</a>
                        </li>

                        <li class="nav-item p-b-10">
                            <a class="nav-link" data-toggle="tab" href="#information" role="tab">Chi tiết sản phẩm</a>
                        </li>

                        <li class="nav-item p-b-10">
                            <a class="nav-link" data-toggle="tab" href="#reviews" role="tab">Đánh giá sản phẩm</a>
                        </li>
                    </ul>

                    <!-- Tab panes -->
                    <div class="tab-content p-t-43">
                        <!-- - -->
                        <div class="tab-pane fade show active" id="description" role="tabpanel">
                            <div class="how-pos2 p-lr-15-md">
                                <p class="stext-102 cl6">
                                    {!! $product->content !!}
                                </p>
                            </div>
                        </div>

                        <!-- - -->
                        <div class="tab-pane fade" id="information" role="tabpanel">
                            <div class="row">
                                <div class="col-sm-10 col-md-8 col-lg-6 m-lr-auto">
                                    <ul class="p-lr-28 p-lr-15-sm">
                                        <li class="flex-w flex-t p-b-7">
                                            <span class="stext-102 cl3 size-205">
                                                Weight
                                            </span>

                                            <span class="stext-102 cl6 size-206">
                                                0.79 kg
                                            </span>
                                        </li>

                                        <li class="flex-w flex-t p-b-7">
                                            <span class="stext-102 cl3 size-205">
                                                Dimensions
                                            </span>

                                            <span class="stext-102 cl6 size-206">
                                                110 x 33 x 100 cm
                                            </span>
                                        </li>

                                        <li class="flex-w flex-t p-b-7">
                                            <span class="stext-102 cl3 size-205">
                                                Materials
                                            </span>

                                            <span class="stext-102 cl6 size-206">
                                                60% cotton
                                            </span>
                                        </li>

                                        <li class="flex-w flex-t p-b-7">
                                            <span class="stext-102 cl3 size-205">
                                                Màu Sắc:
                                            </span>

                                            <span class="stext-102 cl6 size-206">
                                                @foreach ($product->product_color as $key => $color)
                                                    {{ $color->name }},
                                                @endforeach
                                            </span>
                                        </li>

                                        <li class="flex-w flex-t p-b-7">
                                            <span class="stext-102 cl3 size-205">
                                                Kích Cỡ
                                            </span>

                                            <span class="stext-102 cl6 size-206">
                                                @foreach ($product->product_size as $key => $size)
                                                    {{ $size->title }},
                                                @endforeach
                                            </span>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        @include('pages.include.review')
                    </div>
                </div>
            </div>
        </div>
        <div class="bg6 flex-c-m flex-w size-302 m-t-73 p-tb-15">
            <span class="stext-107 cl6 p-lr-25">
                Danh Mục: {{ $product->category->title }}
            </span>
        </div>
    </div>
@endsection
