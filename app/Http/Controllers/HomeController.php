<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Order;
use App\Models\order_product;
use App\Models\Review;
use App\Models\Product;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('home');
    }

    public function order_list(){
        $list = Order::with('product', 'order_product', 'user')
            ->orderBy('date_order', 'desc')
            ->orderBy('status', 'asc')
            ->paginate(10);
        return $list;
    }

    public function message_list(){
        $list = Review::with('user', 'product')
            ->orderBy('date_review', 'desc')
            ->orderBy('status', 'asc')
            ->paginate(10);
        return $list;
    }

    public function statistical(Request $request){
        // Tính tổng số sao và tổng số đánh giá cho mỗi sản phẩm
        $productStatistics = [];
        $products = Product::all();
        foreach ($products as $product) {
            $totalStars = Review::where('product_id', $product->id)->sum('star');
            $totalReviews = Review::where('product_id', $product->id)->count();
            $productStatistics[$product->id] = [
                'total_stars' => $totalStars,
                'total_reviews' => $totalReviews,
            ];
        }

        // Tính tổng số đơn hàng theo trạng thái
        $allStatus = [0, 1, 2, 3, 4];
        $statusCounts = Order::select('status', DB::raw('COUNT(*) as count'))
            ->groupBy('status')
            ->get()
            ->pluck('count', 'status')
            ->toArray();
        foreach ($allStatus as $status) {
            if (!isset($statusCounts[$status])) {
                $statusCounts[$status] = 0;
            }
        }
        ksort($statusCounts);

        // Lấy danh sách sản phẩm và đánh giá
        $product = Product::with('category','product_library', 'brand','library','product_color', 'color', 'size', 'product_size')->get();
        $review = Review::with('user','product','order')->orderby('date_review', 'DESC')->get();
        $reviewCount = $review->count();

        // Truyền dữ liệu vào view
        return view('admincp.statistical', compact('statusCounts', 'product', 'review', 'reviewCount', 'productStatistics'));
    }

    public function calculateTotalByMonth()
    {
        $totalData = $this->getMonthlyTotal();
        return $totalData;
    }

    private function getMonthlyTotal()
    {
        $year = now()->year;
        $months = range(1, 12); // Tạo mảng chứa các tháng từ 1 đến 12

        // Lấy dữ liệu tổng số đơn hàng theo từng tháng
        $totalData = Order::whereYear('date_order', $year)
                        ->whereIn(DB::raw('MONTH(date_order)'), $months) // Lọc theo tháng
                        ->select(
                            DB::raw('DATE_FORMAT(date_order, "%m-%Y") as month_year'),
                            DB::raw('SUM(total) as total')
                        )
                        ->groupBy('month_year')
                        ->get();

        // Tạo một mảng chứa dữ liệu của tất cả các tháng trong năm
        $result = [];
        foreach ($months as $month) {
            $month_year = sprintf('%02d', $month) . '-' . $year; // Format tháng và năm
            $total = $totalData->where('month_year', $month_year)->first(); // Tìm dữ liệu cho tháng này
            $result[] = [
                'month_year' => $month_year,
                'total' => $total ? $total->total : 0, // Nếu không có dữ liệu, trả về 0
            ];
        }

        return collect($result); // Chuyển đổi mảng thành collection để sử dụng được các phương thức của Laravel
    }
}