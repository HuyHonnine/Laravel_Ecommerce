<div class="tab-pane fade" id="reviews" role="tabpanel">
    <div class="row">
        <div class="col-sm-10 col-md-8 col-lg-6 m-lr-auto">
            <div class="p-b-30 m-lr-15-sm">
                <!-- Review -->
                @if ($review->isEmpty())
                    <div class="alert alert-warning text-center" role="alert">
                        Không có đánh giá nào cho sản phẩm này!
                    </div>
                @else
                    <div class="m-b-50 d-flex justify-content-between">
                        @php
                            $totalStars = $review->sum('star');
                            $reviewCount = $review->count();
                            $averageRating = $reviewCount > 0 ? $totalStars / $reviewCount : 0;
                        @endphp

                        <div class="">
                            <p class="flex items-center">
                                @for ($i = 1; $i <= 5; $i++)
                                    @if ($i <= $averageRating)
                                        <i class="zmdi zmdi-star" style="color: #f9ba48;"></i>
                                    @elseif ($i - $averageRating <= 0.5)
                                        <i class="zmdi zmdi-star-half" style="color: #f9ba48;"></i>
                                    @else
                                        <i class="zmdi zmdi-star-outline" style="color: #f9ba48;"></i>
                                    @endif
                                @endfor
                                {{ number_format($averageRating, 1) }}/5
                                <span class="m-b-10 text-secondary-emphasis">
                                    ({{ $reviewCount }} đánh giá)
                                </span>
                            </p>
                        </div>
                        <div class="">
                            <a href="#" style="color: #717fe0; font-weight: 700">Xem tất cả
                                ></a>
                        </div>
                    </div>
                    @foreach ($review as $key => $list)
                        <div class="flex-w flex-t p-b-68">
                            <div class="wrap-pic-s size-109 bor0 of-hidden m-r-18 m-t-6">
                                <img src="{{ asset('uploads/user/' . $list->user->image) }}" alt="AVATAR">
                            </div>

                            <div class="size-207">
                                <div class="flex-w flex-sb-m">
                                    <span style="font-weight: 600; font-size: 1.25rem" class="mtext-107 cl2 p-r-20">
                                        {{ $list->user->name }}
                                    </span>

                                    <span class="fs-18 cl11">
                                        @for ($i = 1; $i <= 5; $i++)
                                            @if ($i <= $list->star)
                                                <i class="fas fa-star text-yellow-500"></i>
                                            @else
                                                <i class="far fa-star text-yellow-500"></i>
                                            @endif
                                        @endfor
                                    </span>
                                </div>

                                <p style="font-size: 1.2rem; font-weight: 500" class="stext-102 cl6">
                                    {{ $list->content }}
                                </p>

                                <p class="card-text mt-1 text-gray-500"><i class="fa fa-clock-o"></i>
                                    Thời gian: {{ $list->date_review }}</p>

                            </div>
                        </div>
                    @endforeach
                @endif
                {!! $review->links('vendor.pagination.bootstrap-4') !!}

            </div>
        </div>
    </div>
</div>
