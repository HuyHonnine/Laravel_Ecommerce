<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
class Cart extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $table = 'carts';
    protected $fillable = [
        'session_id',
        'product_id',
        'quantity',
        'size',
        'color',
        'price',
        'name',
        'image',
        'user_id',
    ];
    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }
    public function user(){
        return $this->belongsTo(User::class, 'user_id');
    }
    public function getCartItems($userId, $sessionId)
    {
        return $this->where('user_id', $userId)->orWhere('session_id', $sessionId)->orderBy('id', 'desc')->get();
    }

    public function getTotalPrice($userId, $sessionId)
    {
        return $this->where('user_id', $userId)->orWhere('session_id', $sessionId)->sum(DB::raw('quantity * price'));
    }

    public function getTotalQuantity($userId, $sessionId)
    {
        return $this->where('user_id', $userId)->orWhere('session_id', $sessionId)->sum(DB::raw('quantity'));
    }

    public static function updateOrCreateCart($sessionId, $productId, $size, $color, $quantity, $price, $name, $image, $userId)
    {
        // Kiểm tra xem người dùng đã đăng nhập hay chưa
        if (auth()->check()) {
            // Nếu đã đăng nhập, sử dụng user_id
            $userId = auth()->user()->id;
            $cartKey = 'cart_' . $userId;
        } else {
            // Nếu chưa đăng nhập, sử dụng session_id
            $cartKey = 'cart_' . $sessionId;
        }

        // Kiểm tra xem sản phẩm đã tồn tại trong giỏ hàng hay chưa
        $existingCartItem = self::where([
            'session_id' => $sessionId,
            'product_id' => $productId,
            'size' => $size,
            'color' => $color,
        ])->first();

        // Nếu sản phẩm đã tồn tại, cập nhật số lượng
        if ($existingCartItem) {
            $existingCartItem->update([
                'quantity' => DB::raw('quantity + ' . $quantity),
            ]);
        } else {
            // Nếu sản phẩm chưa tồn tại, tạo mới giỏ hàng
            self::create([
                'session_id' => $sessionId,
                'product_id' => $productId,
                'size' => $size,
                'color' => $color,
                'quantity' => $quantity,
                'price' => $price,
                'name' => $name,
                'user_id' => $userId,
                'image' => $image,
            ]);
        }

        // Lưu giỏ hàng vào session
        Session::put($cartKey, self::where('session_id', $sessionId)->get());

        return true;
    }

}