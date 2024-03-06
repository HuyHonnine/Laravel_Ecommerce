<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Cart;
use Illuminate\Http\Request;
use App\Models\Review;
use Carbon\Carbon;
use App\Models\order_product;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    public function orderComfirm($id, Request $request)
    {
        $data = $request->all();
        $order = Order::find($id);
        if ($order) {
            $order->status = $data['status'];
            $order->save();
            toastr()->success('Thành Công', 'Cập nhật trạng thái đơn thành công');
            return redirect()->back();
        } else {
            toastr()->error('Lỗi', 'Không thể cập nhật trạng thái đơn');
            return redirect()->back();
        }
    }

    public function orderDetail($id){
        $order = Order::with('product', 'order_product', 'user')->where('id', $id)->first();
        if (!$order) {
            return view('admincp.404.404');
        }
        $orderdt = order_product::where('order_id', $order->id)->get();
        $review = Review::with('user','product','order')->where('order_id', $order->id)->orderby('date_review', 'DESC')->get();
        return view('admincp.order.detail', compact('order','orderdt','review'));
    }

    public function list_order(){
        $list = Order::with('product', 'order_product', 'user')->orderBy('date_order', 'desc')->get();
        return view('admincp.order.index', compact('list'));
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $userId = Auth::id();
        $list = Order::with('product', 'order_product', 'user')
            ->where('user_id', $userId)
            ->orderBy('date_order', 'desc')
            ->paginate(10);
        $review = Review::with('order','user','product')->get();
        $order_pd = order_product::all();

        return view('pages.your_order', compact('list','review','order_pd'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('pages.order', compact('provinces'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $request->validate(
            [
                'user_id' => 'required',
                'product' => 'array',
                'total' => 'required',
                'address' => 'required|max:255',
                'city' => 'required|max:255',
                'province' => 'required|max:255',
                'phone' => 'required|string|max:10',
                'status' => 'required',
            ],
            [
                'address.required' => 'Địa chỉ không được để trống',
                'city.required' => 'Thành phố không được để trống',
                'province.required' => 'Tỉnh không được để trống',
                'province.max' => 'province không được vượt quá ký tự',
                'address.max' => 'Địa chỉ không được vượt quá ký tự',
                'city.max' => 'Thành phố không được vượt quá ký tự',
                'phone.required' => 'Số điện thoại không được để trống',
                'phone.string' => 'Số điện thoại phải là một chuỗi',
                'phone.max' => 'Số điện thoại không được vượt quá 10 ký tự',
            ]
        );
        $order = new Order();
        $order->user_id = $data['user_id'];
        $order->phone = $data['phone'];
        $order->total = $data['total'];
        $order->address = $data['address'];
        $order->city = $data['city'];
        $order->province = $data['province'];
        $order->status = $data['status'];
        $order->date_order = Carbon::now('Asia/Ho_Chi_Minh');

        $order->save();

        foreach ($data['product'] as $key => $product_data) {
            $order->order_product()->attach(
                $product_data['id'], [
                'quantity' => $product_data['quantity'],
                'color' => $product_data['color'],
                'size' => $product_data['size'],
            ]);
        }

        $userId = auth()->user()->id;
        $cart = Cart::where('user_id', $userId)->get();
        foreach ($data['product'] as $productData) {
            $cartItem = $cart->where('product_id', $productData['id'])->first();
            if ($cartItem) {
                $cartItem->delete();
            }
        }
        toastr()->success('Thành Công', 'Tạo đơn hàng thành công');
        return view('pages.order_success');
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
