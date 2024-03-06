@extends('layout')
@section('content')
    <div class="container">
        <section class="bg-img1 txt-center p-lr-15 p-tb-92"
            style="background-image:url('{{ asset('frontend/images/bg-01.jpg') }}') ;">
            <h2 class="ltext-105 cl0 txt-center">
                Lọc Sản Phẩm
            </h2>
        </section>


        <section class="bg0 p-t-23 p-b-140">
            <div class="container">
                @if ($product->isEmpty())
                    <div class="alert alert-warning" role="alert">
                        Không tìm thấy sản phẩm phù hợp với bộ lọc đã chọn.
                    </div>
                @else
                    <div class="flex-w flex-sb-m p-b-52">
                        <div class="flex-w flex-l-m filter-tope-group m-tb-10">
                            <button class="stext-106 cl6 hov1 bor3 trans-04 m-r-32 m-tb-5 how-active1" data-filter="*">
                                Tất cả
                            </button>
                            <button class="stext-106 cl6 hov1 bor3 trans-04 m-r-32 m-tb-5" data-filter=".women">
                                Nữ Giới
                            </button>

                            <button class="stext-106 cl6 hov1 bor3 trans-04 m-r-32 m-tb-5" data-filter=".men">
                                Nam Giới
                            </button>

                            <button class="stext-106 cl6 hov1 bor3 trans-04 m-r-32 m-tb-5" data-filter=".accessories">
                                Phụ Kiện
                            </button>
                        </div>
                        @include('pages.include.filter')
                    </div>

                    <div class="row isotope-grid">
                        @foreach ($product as $key => $list)
                            @php
                                $categoryClass = '';
                                if ($list->category->title == 'Nam Giới') {
                                    $categoryClass = 'men';
                                }
                                if ($list->category->title == 'Nữ Giới') {
                                    $categoryClass = 'women';
                                }
                                if ($list->category->title == 'Phụ Kiện') {
                                    $categoryClass = 'accessories';
                                }
                            @endphp
                            <div
                                class="col-sm-6 col-md-4 col-lg-3 p-b-35 isotope-item {{ $categoryClass ? ' ' . $categoryClass : '' }}">
                                <div class="block2">
                                    <div class="block2-pic hov-img0">
                                        <img style="height: 17rem; width: 100%; object-fit: cover"
                                            src="{{ asset('uploads/product/' . $list->image) }}" alt="IMG-PRODUCT">

                                        <a href="{{ route('product', $list->slug) }}"
                                            class="block2-btn flex-c-m stext-103 cl2 size-102 bg0 bor2 hov-btn1 p-lr-15 trans-04">
                                            Xem Nhanh
                                        </a>
                                    </div>

                                    <div class="block2-txt flex-w flex-t p-t-14">
                                        <div class="block2-txt-child1 flex-col-l">
                                            <a href="{{ route('product', $list->slug) }}"
                                                class="stext-104 cl4 hov-cl1 trans-04 js-name-b2 p-b-6">
                                                {{ $list->title }}
                                            </a>

                                            <span class="stext-105 cl3">
                                                {{ number_format($list->price) }} VNĐ
                                            </span>
                                        </div>

                                        <div class="block2-txt-child2 flex-r p-t-3">
                                            <a href="#" class="btn-addwish-b2 dis-block pos-relative js-addwish-b2">
                                                <img class="icon-heart1 dis-block trans-04"
                                                    src="{{ asset('frontend/images/icons/icon-heart-01.png') }}"
                                                    alt="ICON">
                                                <img class="icon-heart2 dis-block trans-04 ab-t-l"
                                                    src="{{ asset('frontend/images/icons/icon-heart-02.png') }}"
                                                    alt="ICON">
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    <div class="flex-l-m flex-w p-t-10 m-lr--7 w-full">
                        @if (isset($sapxep))
                            {!! $movie->appends(['order' => $sapxep, 'color' => $color_get, 'size' => $size_get, 'brand' => $brand_get])->links('vendor.pagination.bootstrap-5') !!}
                        @else
                            {!! $product->links('vendor.pagination.bootstrap-5') !!}
                        @endif
                    </div>
                @endif
            </div>
        </section>
    </div>
@endsection
