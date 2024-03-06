@extends('layout')
@section('content')
    <section class="bg-img1 txt-center p-lr-15 p-tb-92"
        style="background-image: url('{{ asset('frontend/images/bg-02.jpg') }}') ;">
        <h2 class="ltext-105 cl0 txt-center">
            Blog
        </h2>
    </section>
    <section class="bg0 p-t-62 p-b-60">
        <div class="container">
            <div class="row">
                <div class="col-md-8 col-lg-9 p-b-80">
                    <div class="p-r-45 p-r-0-lg">
                        @foreach ($list as $key => $post)
                            <div class="p-b-63">
                                <a href="{{ route('post', $post->slug) }}" class="hov-img0 how-pos5-parent">
                                    <img style="height: 35rem; object-fit: cover"
                                        src="{{ asset('uploads/post/' . $post->image) }}" alt="{{ $post->title }}">

                                    <div class="flex-col-c-m size-123 bg9 how-pos5">
                                        @php
                                            $dateCreate = is_string($post->date_create) ? Carbon\Carbon::parse($post->date_create) : $post->date_create;
                                            $ngay = $dateCreate->toDateString();
                                        @endphp
                                        <span class="stext-109 cl3 txt-center">
                                            {{ $ngay }}
                                        </span>
                                    </div>
                                </a>

                                <div class="p-t-32">
                                    <h4 class="p-b-15">
                                        <a href="{{ route('post', $post->slug) }}" title="{{ $post->title }}"
                                            class="ltext-108 cl2 hov-cl1 trans-04">
                                            {{ $post->title }}
                                        </a>
                                    </h4>

                                    <p class="stext-117 cl6">
                                        {{ $post->meta }}
                                    </p>

                                    <div class="flex-w flex-sb-m p-t-18">
                                        <span class="flex-w flex-m stext-111 cl2 p-r-30 m-tb-10">
                                            <span>
                                                <span class="cl4">Tác Giả</span> {{ $post->user->name }}
                                                <span class="cl12 m-l-4 m-r-6">|</span>
                                            </span>

                                            <span>
                                                {{ $post->genre->title }}
                                                <span class="cl12 m-l-4 m-r-6">|</span>
                                            </span>

                                            <span>
                                                8 Comments
                                            </span>
                                        </span>

                                        <a href="{{ route('post', $post->slug) }}" title="{{ $post->title }}"
                                            class="stext-101 cl2 hov-cl1 trans-04 m-tb-10">
                                            Xem bài viết
                                            <i class="fa fa-long-arrow-right m-l-9"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        @endforeach


                        <!-- Pagination -->
                        <div class="flex-l-m flex-w p-t-10 m-lr--7 w-full">
                            {!! $list->links('vendor.pagination.bootstrap-4') !!}

                        </div>
                    </div>
                </div>

                <div class="col-md-4 col-lg-3 p-b-80">
                    <div class="side-menu">
                        <div class="bor17 of-hidden pos-relative">
                            <input class="stext-103 cl2 plh4 size-116 p-l-28 p-r-55" type="text" name="search"
                                placeholder="Tìm kiếm tại đây...">

                            <button class="flex-c-m size-122 ab-t-r fs-18 cl4 hov-cl1 trans-04">
                                <i class="zmdi zmdi-search"></i>
                            </button>
                        </div>

                        <div class="p-t-55">
                            <h4 class="mtext-112 cl2 p-b-33">
                                Danh Mục
                            </h4>

                            <ul>
                                @foreach ($genre as $key => $list)
                                    <li class="bor18">
                                        <a href="list"
                                            class="dis-block stext-115 cl6 hov-cl1 trans-04 p-tb-8 p-lr-4">
                                            {{ $list->title }}
                                        </a>
                                    </li>
                                @endforeach

                            </ul>
                        </div>

                        <div class="p-t-65">
                            <h4 class="mtext-112 cl2 p-b-33">
                                Bài Viết Nổi Bật
                            </h4>
                            <ul>
                                @foreach ($post_hot as $key => $list)
                                    <li class="flex-w flex-t p-b-30">
                                        <a href="#" class="wrao-pic-w size-214 hov-ovelay1 m-r-20">
                                            <img style="height: 6rem;width: 6rem;object-fit: cover"
                                                src="{{ asset('uploads/post/' . $list->image) }}"
                                                alt="{{ $list->title }}">
                                        </a>

                                        <div class="size-215 flex-col-t p-t-8">
                                            <a href="#" class="stext-116 cl8 hov-cl1 trans-04">
                                                {{ $list->title }}
                                            </a>

                                            <span class="stext-116 cl6 p-t-20">
                                                Tác Giả {{ $list->user->name }}
                                            </span>
                                        </div>
                                    </li>
                                @endforeach

                            </ul>

                        </div>

                        <div class="p-t-50">
                            <h4 class="mtext-112 cl2 p-b-27">
                                Thẻ
                            </h4>

                            <div class="flex-w m-r--5">
                                <a href="#"
                                    class="flex-c-m stext-107 cl6 size-301 bor7 p-lr-15 hov-tag1 trans-04 m-r-5 m-b-5">
                                    Fashion
                                </a>

                                <a href="#"
                                    class="flex-c-m stext-107 cl6 size-301 bor7 p-lr-15 hov-tag1 trans-04 m-r-5 m-b-5">
                                    Lifestyle
                                </a>

                                <a href="#"
                                    class="flex-c-m stext-107 cl6 size-301 bor7 p-lr-15 hov-tag1 trans-04 m-r-5 m-b-5">
                                    Denim
                                </a>

                                <a href="#"
                                    class="flex-c-m stext-107 cl6 size-301 bor7 p-lr-15 hov-tag1 trans-04 m-r-5 m-b-5">
                                    Streetstyle
                                </a>

                                <a href="#"
                                    class="flex-c-m stext-107 cl6 size-301 bor7 p-lr-15 hov-tag1 trans-04 m-r-5 m-b-5">
                                    Crafts
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
