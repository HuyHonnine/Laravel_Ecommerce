@extends('layout')
@section('content')
    <div class="container">
        <div class="bread-crumb flex-w p-l-25 p-r-15 p-t-30 p-lr-0-lg">
            <a href="{{ route('homepage') }}" class="stext-109 cl8 hov-cl1 trans-04">
                Trang chủ
                <i class="fa fa-angle-right m-l-9 m-r-10" aria-hidden="true"></i>
            </a>

            <a href="{{ route('blog') }}" class="stext-109 cl8 hov-cl1 trans-04">
                Tin Tức
                <i class="fa fa-angle-right m-l-9 m-r-10" aria-hidden="true"></i>
            </a>

            <span class="stext-109 cl4">
                {{ $post->title }}
            </span>
        </div>
    </div>


    <section class="bg0 p-t-52 p-b-20">
        <div class="container">
            <div class="row">
                <div class="col-md-8 col-lg-9 p-b-80">
                    <div class="p-r-45 p-r-0-lg">
                        <!--  -->
                        <div class="wrap-pic-w how-pos5-parent">
                            <img style="height: 35rem; object-fit: cover" src="{{ asset('uploads/post/' . $post->image) }}"
                                alt="{{ $post->title }}">
                            <div class="flex-col-c-m size-123 bg9 how-pos5">
                                @php
                                    $dateCreate = is_string($post->date_create) ? Carbon\Carbon::parse($post->date_create) : $post->date_create;
                                    $ngay = $dateCreate->toDateString();
                                @endphp
                                <span class="stext-109 cl3 txt-center">
                                    {{ $ngay }}
                                </span>
                            </div>
                        </div>

                        <div class="p-t-32">
                            <span class="flex-w flex-m stext-111 cl2 p-b-19">
                                <span>
                                    <a href=""><span class="cl4">Tác Giả</span> {{ $post->user->name }}</a>
                                    <span class="cl12 m-l-4 m-r-6">|</span>
                                </span>

                                <span>
                                    {{ $post->date_create }}
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

                            <h4 class="ltext-109 cl2 p-b-28">
                                {{ $post->title }}
                            </h4>

                            <blockquote
                                style="padding: 10px 20px;
                            margin: 0 0 20px;
                            font-size: 17.5px;
                            border-left: 5px solid #eee; font-weight: 700">
                                {{ $post->meta }}
                            </blockquote>

                            <p class="stext-117 cl6 p-b-26">
                                {!! $post->content !!}
                            </p>
                        </div>

                        <div class="flex-w flex-t p-t-16">
                            <span class="size-216 stext-116 cl8 p-t-4">
                                Tags
                            </span>

                            <div class="flex-w size-217">
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

                        <!--  -->
                        <div class="p-t-40">
                            <div class="custombox authorbox clearfix" style="background-color: #DCF2F1; padding: 1rem">
                                <h4 class="small-title">Bình Luận</h4>
                                @php
                                    $current_url = Request::url();
                                @endphp
                                <article id="post-38424" class="item-content">
                                    <div class="fb-comments" data-href="{{ $current_url }}" data-width="100%"
                                        data-numposts="10">
                                    </div>
                                </article>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-4 col-lg-3 p-b-80">
                    <div class="side-menu">
                        <div class="bor17 of-hidden pos-relative">
                            <input class="stext-103 cl2 plh4 size-116 p-l-28 p-r-55" type="text" name="search"
                                placeholder="Search">

                            <button class="flex-c-m size-122 ab-t-r fs-18 cl4 hov-cl1 trans-04">
                                <i class="zmdi zmdi-search"></i>
                            </button>
                        </div>

                        <div class="p-t-55">
                            <h4 class="mtext-112 cl2 p-b-33">
                                Danh Mục
                            </h4>

                            <ul>
                                <li class="bor18">
                                    @foreach ($genre as $key => $list)
                                        <a href="{{ route('genre', $list->slug) }}"
                                            class="dis-block stext-115 cl6 hov-cl1 trans-04 p-tb-8 p-lr-4">
                                            {{ $list->title }}
                                        </a>
                                    @endforeach

                                </li>

                            </ul>
                        </div>

                        <div class="p-t-65">
                            <h4 class="mtext-112 cl2 p-b-33">
                                Bài Viết Nổi Bật
                            </h4>

                            <ul>
                                @foreach ($post_hot as $key => $list)
                                    <li class="flex-w flex-t p-b-30">
                                        <a href="{{ route('post', $list->slug) }}"
                                            class="wrao-pic-w size-214 hov-ovelay1 m-r-20">
                                            <img style="height: 6rem;width: 6rem;object-fit: cover"
                                                src="{{ asset('uploads/post/' . $list->image) }}"
                                                alt="{{ $list->title }}">
                                        </a>

                                        <div class="size-215 flex-col-t p-t-8">
                                            <a href="{{ route('post', $list->slug) }}"
                                                class="stext-116 cl8 hov-cl1 trans-04">
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
