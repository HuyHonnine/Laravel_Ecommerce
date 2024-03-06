@extends('layout')
@section('content')
    <section class="bg-img1 txt-center p-lr-15 p-tb-92"
        style="background-image: url('{{ asset('frontend/images/bg-01.jpg') }}') ;">
        <h2 class="ltext-105 cl0 txt-center">
            Đăng Nhập Tài Khoản
        </h2>
    </section>
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
    <section class="bg0 p-t-62 p-b-116">
        <div class="container">
            <div class="flex-w flex-tr">
                <div class="size-210 bor10 p-lr-70 p-t-55 p-b-70 p-lr-15-lg w-full-md">
                    <form action="{{ url('/check-customer') }}" method="POST">
                        @csrf
                        <div class="bor8 m-b-20 how-pos4-parent">
                            <i class='ri-mail-line how-pos4 pointer-none'></i>

                            <input id="email" type="email"
                                class="stext-111 cl2 plh3 size-116 p-l-62 p-r-30 @error('email') is-invalid @enderror"
                                name="email" value="{{ old('email') }}" required autocomplete="email" autofocus
                                placeholder="nhập email">

                            @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="bor8 m-b-20 how-pos4-parent">
                            <i class='ri-lock-line how-pos4 pointer-none'></i>
                            <input id="password" type="password"
                                class="stext-111 cl2 plh3 size-116 p-l-62 p-r-30 @error('password') is-invalid @enderror toggle-password-field"
                                name="password" required autocomplete="current-password" placeholder="Enter Your Password*">
                            <span class="eye-icon toggle-password cursor-pointer">&#128065;</span>

                            @error('password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror

                        </div>

                        <button type="submit"
                            class="flex-c-m stext-101 cl0 size-121 bg3 bor1 hov-btn3 p-lr-15 trans-04 pointer">Đăng
                            nhập</button>
                    </form>
                    <p class="stext-115 cl6 p-t-18">
                        Bạn chưa có tài khoản thì hãy <a href="{{ url('/create-customer') }}">đăng ký</a> tại đây!
                    </p>
                </div>

                <div class="size-210 bor10 flex-w flex-col-m p-lr-93 p-tb-30 p-lr-15-lg w-full-md">
                    <div class="flex-w p-b-42 w-full">
                        <span class="fs-18 cl5 txt-center size-211">
                            <span class="lnr lnr-map-marker"></span>
                        </span>

                        <div class="size-212 p-t-2">
                            <span class="mtext-110 cl2">
                                Address
                            </span>

                            <p class="stext-115 cl6 size-213 p-t-18">
                                Coza Store Center 8th floor, 379 Hudson St, New York, NY 10018 US
                            </p>
                        </div>
                    </div>

                    <div class="flex-w p-b-42 w-full">
                        <span class="fs-18 cl5 txt-center size-211">
                            <span class="lnr lnr-phone-handset"></span>
                        </span>

                        <div class="size-212 p-t-2">
                            <span class="mtext-110 cl2">
                                Lets Talk
                            </span>

                            <p class="stext-115 cl1 size-213 p-t-18">
                                +1 800 1236879
                            </p>
                        </div>
                    </div>

                    <div class="flex-w w-full">
                        <span class="fs-18 cl5 txt-center size-211">
                            <span class="lnr lnr-envelope"></span>
                        </span>

                        <div class="size-212 p-t-2">
                            <span class="mtext-110 cl2">
                                Sale Support
                            </span>

                            <p class="stext-115 cl1 size-213 p-t-18">
                                contact@example.com
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
