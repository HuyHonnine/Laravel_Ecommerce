<body>
    <div class="flex-w flex-c-m m-tb-10">
        <div class="flex-c-m stext-106 cl6 size-104 bor4 pointer hov-btn3 trans-04 m-r-8 m-tb-4 js-show-filter">
            <i class="icon-filter cl2 m-r-6 fs-15 trans-04 zmdi zmdi-filter-list"></i>
            <i class="icon-close-filter cl2 m-r-6 fs-15 trans-04 zmdi zmdi-close dis-none"></i>
            Lọc
        </div>
    </div>

    <div class="dis-none panel-filter p-t-10 w-full">
        {!! Form::open([
            'route' => 'locphim',
            'method' => 'GET',
            'class' => 'wrap-filter flex-w bg6 p-lr-40 p-t-27 p-lr-15-sm w-35',
        ]) !!}
        <div class="col-md-2">
            <div class="form-group">
                <select class="form-control style-filter" name="order" id="exampleFormControlSelect1"
                    style="cursor: pointer;">
                    <option value="">Sắp Xếp</option>
                    <option value="select_new">Ngày đăng mới nhất</option>
                    <option value="select_title">Tên sản phẩm A->Z</option>
                </select>
            </div>
        </div>
        <div class="col-md-2">
            <div class="form-group">
                <select class="form-control style-filter" name="brand" id="exampleFormControlSelect1"
                    style="cursor: pointer;">
                    <option value="">Thương Hiệu</option>
                    @foreach ($brand as $key => $ban)
                        <option {{ isset($_GET['brand']) && $_GET['brand'] == $ban->id ? 'selected' : '' }}
                            value="{{ $ban->id }}">{{ $ban->title }}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="col-md-2">
            <div class="form-group">
                <select class="form-control style-filter" name="color" id="exampleFormControlSelect1"
                    style="cursor: pointer;">
                    <option value="">Màu Sắc</option>
                    @foreach ($color as $key => $col)
                        <option {{ isset($_GET['color']) && $_GET['color'] == $col->id ? 'selected' : '' }}
                            value="{{ $col->id }}">{{ $col->name }}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="col-md-2">
            <div class="form-group">
                <select class="form-control style-filter" name="size" id="exampleFormControlSelect1"
                    style="cursor: pointer;">
                    <option value="">Kích Cỡ</option>
                    @foreach ($size as $key => $sizeval)
                        <option {{ isset($_GET['size']) && $_GET['size'] == $sizeval->id ? 'selected' : '' }}
                            value="{{ $sizeval->id }}">{{ $sizeval->title }}</option>
                    @endforeach
                </select>
            </div>
        </div>
        {!! Form::submit('Lọc', ['class' => 'btn btn-success bg-green-600 form-group', 'style' => 'cursor: pointer']) !!}
    </div>

    {!! Form::close() !!}
</body>
