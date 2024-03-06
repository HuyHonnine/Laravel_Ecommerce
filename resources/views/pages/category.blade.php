@extends('layout')
@section('content')
    <section class="bg0 p-b-140">
        <div class="container">
            <div class="bread-crumb flex-w p-l-25 p-r-15 p-t-30 p-lr-0-lg">
                <a href="{{ route('homepage') }}" class="stext-109 cl8 hov-cl1 trans-04">
                    Trang chủ
                    <i class="fa fa-angle-right m-l-9 m-r-10" aria-hidden="true"></i>
                </a>

                <a href="{{ route('shop') }}" class="stext-109 cl8 hov-cl1 trans-04">
                    Cửa hàng
                    <i class="fa fa-angle-right m-l-9 m-r-10" aria-hidden="true"></i>
                </a>

                <span class="stext-109 cl4">
                    {{ $cate_slug->title }}
                </span>
            </div>

            <div class="flex-w flex-sb-m p-b-52">
                @include('pages.include.filter')
            </div>

            <div class="row isotope-grid">
                @foreach ($product as $key => $cate_product)
                    @php
                        $categoryClass = '';
                        if ($cate_product->category->title == 'Nam Giới') {
                            $categoryClass = 'men';
                        }
                        if ($cate_product->category->title == 'Nữ Giới') {
                            $categoryClass = 'women';
                        }
                        if ($cate_product->category->title == 'Phụ Kiện') {
                            $categoryClass = 'accessories';
                        }
                    @endphp
                    <div
                        class="col-sm-6 col-md-4 col-lg-3 p-b-35 isotope-item {{ $categoryClass ? ' ' . $categoryClass : '' }}">
                        <div class="block2">
                            <div class="block2-pic hov-img0">
                                <img style="height: 17rem; width: 100%; object-fit: cover"
                                    src="{{ asset('uploads/product/' . $cate_product->image) }}" alt="IMG-PRODUCT">

                                <a href="{{ route('product', $cate_product->slug) }}"
                                    class="block2-btn flex-c-m stext-103 cl2 size-102 bg0 bor2 hov-btn1 p-lr-15 trans-04">
                                    Xem Nhanh
                                </a>
                            </div>

                            <div class="block2-txt flex-w flex-t p-t-14">
                                <div class="block2-txt-child1 flex-col-l">
                                    <a href="{{ route('product', $cate_product->slug) }}"
                                        class="stext-104 cl4 hov-cl1 trans-04 js-name-b2 p-b-6">
                                        {{ $cate_product->title }}
                                    </a>

                                    <span class="stext-105 cl3">
                                        {{ number_format($cate_product->price) }} VNĐ
                                    </span>
                                </div>

                                <div class="block2-txt-child2 flex-r p-t-3">
                                    <a href="#" class="btn-addwish-b2 dis-block pos-relative js-addwish-b2">
                                        <img class="icon-heart1 dis-block trans-04"
                                            src="{{ asset('frontend/images/icons/icon-heart-01.png') }}" alt="ICON">
                                        <img class="icon-heart2 dis-block trans-04 ab-t-l"
                                            src="{{ asset('frontend/images/icons/icon-heart-02.png') }}" alt="ICON">
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
            <div class="flex-l-m flex-w p-t-10 m-lr--7 w-full">
                {!! $product->links('vendor.pagination.bootstrap-5') !!}
            </div>
        </div>
    </section>
@endsection
