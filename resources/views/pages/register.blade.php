@extends('layout')
@section('content')
    <div class="p-t-60 p-b-20">

        <section class="bg-img1 txt-center p-lr-15 p-tb-92"
            style="background-image:url('{{ asset('frontend/images/bg-01.jpg') }}') ;">
            <h2 class="ltext-105 cl0 txt-center">
                Đăng Ký Tài Khoản
            </h2>
        </section>
        <section class="bg0 p-t-104 p-b-116">
            <div class="container">
                <div class="flex-w flex-tr">
                    <div class="size-210 bor10 p-lr-70 p-t-55 p-b-70 p-lr-15-lg w-full-md">
                        {!! Form::open(['url' => url('/store-customer'), 'method' => 'POST']) !!}

                        <h4 class="mtext-105 cl2 txt-center p-b-30">
                            Thông tin tài khoản
                        </h4>
                        <div class="bor8 m-b-20 how-pos4-parent">
                            <i class="ri-user-line how-pos4 pointer-none"></i>
                            {!! Form::text('name', old('name', isset($user) ? $user->name : ''), [
                                'class' => 'stext-111 cl2 plh3 size-116 p-l-62 p-r-30' . ($errors->has('name') ? ' is-invalid' : ''),
                                'required',
                                'autocomplete' => 'name',
                                'autofocus',
                                'placeholder' => 'Nhập dữ liệu...',
                                'id' => 'slug',
                                'onkeyup' => 'ChangeToSlug()',
                            ]) !!}

                            @error('name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="bor8 m-b-20 how-pos4-parent">
                            <i class="ri-mail-line how-pos4 pointer-none"></i>
                            {!! Form::email('email', old('email', isset($user) ? $user->email : ''), [
                                'class' => 'stext-111 cl2 plh3 size-116 p-l-62 p-r-30' . ($errors->has('email') ? ' is-invalid' : ''),
                                'required',
                                'autocomplete' => 'email',
                                'placeholder' => 'Nhập email',
                            ]) !!}

                            @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="bor8 m-b-20 how-pos4-parent">
                            <i class="ri-lock-line how-pos4 pointer-none"></i>
                            {!! Form::password('password', [
                                'class' =>
                                    'stext-111 cl2 plh3 size-116 p-l-62 p-r-30  toggle-password-field' .
                                    ($errors->has('password') ? ' is-invalid' : ''),
                                'required',
                                'autocomplete' => 'new-password',
                                'placeholder' => 'Nhập mật khẩu',
                            ]) !!}
                            <span class="eye-icon toggle-password cursor-pointer">&#128065;</span>


                            @error('password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="bor8 m-b-20 how-pos4-parent">
                            <i class="ri-lock-line how-pos4 pointer-none"></i>
                            {!! Form::password('password_confirmation', [
                                'class' => 'stext-111 cl2 plh3 size-116 p-l-62 p-r-30  toggle-password-field',
                                'required',
                                'autocomplete' => 'new-password',
                                'placeholder' => 'Nhập mật khẩu xác nhận',
                            ]) !!}
                            <span class="eye-icon toggle-password cursor-pointer">&#128065;</span>

                        </div>
                        {!! Form::submit('Đăng Ký', [
                            'class' => 'flex-c-m stext-101 cl0 size-121 bg3 bor1 hov-btn3 p-lr-15 trans-04 pointer',
                        ]) !!}
                        {!! Form::close() !!}
                    </div>

                    <div class="size-210 bor10 flex-w flex-col-m p-lr-93 p-tb-30 p-lr-15-lg w-full-md">
                        <img style="height: 100%; width: 100%; object-fit: cover"
                            src="{{ asset('frontend/images/gallery-09.jpg') }}" alt="">
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection
