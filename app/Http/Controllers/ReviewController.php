<?php

namespace App\Http\Controllers;

use App\Models\Review;
use Carbon\Carbon;
use App\Models\Order;
use App\Models\order_product;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
class ReviewController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($id)
    {
        $userId = Auth::id();
        $order = Order::with('product', 'order_product', 'user')
            ->where(function ($query) use ($userId, $id) {
                $query->where('user_id', $userId)
                      ->where('id', $id);
            })->first();

        if (!$order) {
            return view('pages.404');
        }
        $orderdt = order_product::where('order_id', $order->id)->get();
        return view('pages.review', compact('order', 'orderdt'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $request->all();

        $validator = Validator::make($data, [
            'user_id' => 'required',
            'product_id' => 'required',
            'order_id' => 'required',
            'content' => 'required|max:500',
            'star' => 'required',
            'status' => 'required',
        ]);
        [
            'star.required' => 'Đánh giá sao không được để trống',
            'content.required' => 'Nội dung không được để trống',
            'content.max' => 'nội dung vượt quá 500 ký tự',
        ];

        $check_review = Review::where('user_id', $data['user_id'])
        ->where('product_id', $data['product_id'])
        ->where('order_id', $data['order_id'])
        ->count();

        if($check_review > 0){
            toastr()->error('Thất Bại','Đã đánh giá rồi!');
        }
        else{
            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput();
            }
            $review = new Review();
            $review->user_id = $data['user_id'];
            $review->product_id = $data['product_id'];
            $review->order_id = $data['order_id'];
            $review->content = $data['content'];
            $review->star = $data['star'];
            $review->status = $data['status'];
            $review->date_review = Carbon::now('Asia/Ho_Chi_Minh');
            $review->save();
            toastr()->success('Thành Công','Đánh giá sản phẩm thành công');
        }
        return redirect()->back();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}