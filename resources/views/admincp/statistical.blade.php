@extends('layouts.app')
@section('title', 'Quản lý thống kê')
@section('content')
    <div class="content-wrapper">
        <section class="content-header">
            <h1>
                Quản Lý Thống Kê
            </h1>
            <ol class="breadcrumb">
                <li><a href="{{ route('home') }}"><i class="fa fa-dashboard"></i> Trang chủ</a></li>
                <li class="active">Quản lý thống kê</li>
            </ol>
        </section>

        <!-- Main content -->
        <div class="container-fluid mt-6">
            <div class="box">
                <div class="box-body table-responsive no-padding">
                    <div class="col-xs-12 mt-4 space-y-3">
                        <div>
                            <h2 class="mb-5 text-3xl font-bold">Thống kê số lượng Đơn Hàng</h2>
                        </div>

                        <div class="row">
                            @php
                                $statusColors = [
                                    0 => 'red',
                                    1 => 'yellow',
                                    2 => 'blue',
                                    3 => 'gray',
                                    4 => 'green',
                                ];

                                $statusLabels = [
                                    0 => 'Chưa xác nhận',
                                    1 => 'Đang đóng gói',
                                    2 => 'Đang vận chuyển',
                                    3 => 'Chờ thanh toán',
                                    4 => 'Thành công',
                                ];
                            @endphp
                            @foreach ($statusCounts as $status => $count)
                                <div class="col-lg-2 col-md-4 col-6">
                                    <div class="small-box bg-{{ $statusColors[$status] }}">
                                        <div class="inner">
                                            <h3>Có {{ $count }}</h3>
                                            <p>Đơn hàng {{ $statusLabels[$status] }}</p>
                                        </div>
                                        <div class="icon">
                                            <i class="ri-shopping-bag-3-line"></i>
                                        </div>
                                        <a href="{{ route('list-order', ['status' => $status]) }}"
                                            class="small-box-footer">Xem
                                            thêm
                                            <i class="ri-arrow-right-line"></i>
                                        </a>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        <div class="card-body">
                            <div>
                                <h2 class="mb-2 text-3xl font-bold">Thống kê tiền theo năm {{ now()->year }}</h2>
                            </div>
                            @php
                                $totalData = app('App\Http\Controllers\HomeController')->calculateTotalByMonth();
                            @endphp
                            <div class="position-relative mb-4">
                                <canvas id="total-chart" height="200"></canvas>
                            </div>

                            <script>
                                function formatValue(value) {
                                    if (value >= 1000000) {
                                        return (value / 1000000).toFixed(2) + 'M';
                                    } else if (value >= 1000) {
                                        return (value / 1000).toFixed(2) + 'K';
                                    } else {
                                        return value.toFixed(2);
                                    }
                                }

                                document.addEventListener("DOMContentLoaded", function() {
                                    var ctx = document.getElementById('total-chart').getContext('2d');
                                    var totalChart = new Chart(ctx, {
                                        type: 'bar',
                                        data: {
                                            labels: {!! json_encode($totalData->pluck('month_year')->toArray()) !!},
                                            datasets: [{
                                                label: 'Total (VNĐ)',
                                                data: {!! json_encode($totalData->pluck('total')->toArray()) !!},
                                                backgroundColor: 'rgba(75, 192, 192, 0.5)',
                                                borderColor: 'rgba(75, 192, 192, 1)',
                                                borderWidth: 1,
                                            }],
                                        },
                                        options: {
                                            scales: {
                                                y: {
                                                    beginAtZero: true,
                                                    ticks: {
                                                        callback: function(value, index, values) {
                                                            return formatValue(value);
                                                        }
                                                    }
                                                },
                                            },
                                            responsive: true,
                                            maintainAspectRatio: false,
                                        },
                                    });
                                });
                            </script>
                            <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

                        </div>

                        <div class="rounded-lg bg-white p-6 shadow-md">
                            <h2 class="mb-5 text-3xl font-semibold">Thống kê đánh giá sản phẩm</h2>
                            <div class="grid grid-cols-1 gap-6 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4">
                                @foreach ($product as $key => $list)
                                    <div class="overflow-hidden rounded-lg bg-gray-100 shadow-xl">
                                        <img class="h-[20rem] w-full object-cover"
                                            src="{{ asset('uploads/product/' . $list->image) }}" alt="{{ $list->title }}">
                                        <div class="p-4">
                                            <p class="mb-2 text-xl font-semibold">{{ $list->title }}</p>
                                            @if ($productStatistics[$list->id]['total_reviews'] > 0)
                                                <p class="text-gray-600">Trung bình số sao:
                                                    @php
                                                        $averageRating = $productStatistics[$list->id]['total_stars'] / $productStatistics[$list->id]['total_reviews'];
                                                    @endphp
                                                    @for ($i = 0; $i < 5; $i++)
                                                        @if ($i < floor($averageRating))
                                                            <i class="fa fa-star text-yellow-500"></i>
                                                        @elseif ($i < ceil($averageRating))
                                                            <i class="fa fa-star-half-o text-yellow-500"></i>
                                                        @else
                                                            <i class="fa fa-star-o text-yellow-500"></i>
                                                        @endif
                                                    @endfor
                                                    ({{ number_format($averageRating, 1) }}/5)
                                                </p>
                                            @else
                                                <p class="text-gray-600">Chưa có đánh giá</p>
                                            @endif
                                            <p class="text-gray-600">Tổng số đánh giá:
                                                {{ $productStatistics[$list->id]['total_reviews'] }}</p>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
