<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Session;
use Illuminate\Http\Request;
use App\Models\Cart;
use App\Models\Category;

class CartController extends Controller
{
    public function getTotalQuantity()
    {
        $userId = auth()->check() ? auth()->user()->id : null;
        $sessionId = session()->getId();

        $cartModel = new Cart();
        $totalQuantity = $cartModel->getTotalQuantity($userId, $sessionId);
        return $totalQuantity;
    }
    public function getTotalPrice()
    {
        $userId = auth()->check() ? auth()->user()->id : null;
        $sessionId = session()->getId();

        $cartModel = new Cart();
        $totalPrice = $cartModel->getTotalPrice($userId, $sessionId);
        return $totalPrice;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $userId = auth()->check() ? auth()->user()->id : null;
        $sessionId = session()->getId();

        $cartModel = new Cart();
        $cartItems = $cartModel->getCartItems($userId, $sessionId);
        $totalPrice = $cartModel->getTotalPrice($userId, $sessionId);
        return view('pages.cart', compact('cartItems', 'totalPrice'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('pages.product');
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
                'product_id' => 'required',
                'color' => 'required',
                'size' => 'required',
                'quantity' => 'required',
                'price' => 'required',
                'image' => 'required',
                'name' => 'required',
                'user_id' => 'required',
            ],
            [
                'color.required' => 'Vui lòng chọn màu sắc',
                'size.required' => 'Vui lòng chọn kích cỡ',
            ]
        );

        if (auth()->check()) {
            $sessionId = auth()->user()->id;
        } else {
            $sessionId = session()->getId();
        }
        // Lưu giỏ hàng vào session
        Cart::updateOrCreateCart(
            $sessionId,
            $data['product_id'],
            $data['size'],
            $data['color'],
            $data['quantity'],
            $data['price'],
            $data['name'],
            $data['image'],
            $data['user_id'],
        );

        toastr()->success('Thành Công', 'Thêm vào giỏ hàng thành công');
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
        return view('pages.cart');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Cart $cart)
    {
        $request->validate([
            'quantity' => 'required|integer|min:1',
        ]);
        $cart->update([
            'quantity' => $request->input('quantity'),
        ]);

        return redirect()->route('pages.cart')->with('Thành Công', 'Cập nhật giỏ hàng thành công');
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $cart = Cart::where('user_id', auth()->user()->id)->orWhere('session_id', session()->getId())->find($id);
        if (!$cart) {
            toastr()->error('Lỗi', 'Không tìm thấy sản phẩm');
            return redirect()->back();
        }
        $cart->delete();
        toastr()->success('Thành Công', 'Xóa thành công');
        return redirect()->back();
    }
}