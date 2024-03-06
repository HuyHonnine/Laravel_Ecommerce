<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;

use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Product;
use App\Models\Cart;
use App\Models\Storage;
use App\Models\User;
use App\Models\Order;
use App\Models\Post;
use App\Models\Genre;
use App\Models\Review;
use App\Models\order_product;
use App\Models\Color;
use App\Models\Brand;
use App\Models\size;

use Illuminate\Support\Facades\Http;

class IndexController extends Controller
{
    public function fillter(Request $request){
        $category = Category::orderBy('id', 'ASC')->where('status', 1)->get();
        $color = Color::all();
        $brand = Brand::all();
        $size = Size::all();

        $sapxep = $request->input('order');
        $color_get = $request->input('color');
        $size_get = $request->input('size');
        $brand_get = $request->input('brand');

        $productQuery = Product::where('status', 1);

        if ($brand_get) {
            $productQuery->where('brand_id', $brand_get);
        }
        if ($sapxep) {
            if ($sapxep == 'select_new') {
                $productQuery->orderBy('date_update', 'DESC');
            }
            if ($sapxep == 'select_title') {
                $productQuery->orderBy('title', 'ASC');
            }
        }

        if ($color_get) {
            $productQuery->whereHas('product_color', function ($query) use ($color_get) {
                $query->where('color_id', $color_get);
            });
        }

        if ($size_get) {
            $productQuery->whereHas('product_size', function ($query) use ($size_get) {
                $query->where('size_id', $size_get);
            });
        }

        $product = $productQuery->orderBy('date_create', 'DESC')->paginate(16);

        return view('pages.fillter', compact('product','sapxep','size_get','color_get','brand_get','category','color','brand','size'));
    }

    public function home(){
        $category = Category::orderBy('id', 'ASC')->where('status', 1)->get();
        $product = Product::with('category','product_library', 'brand','library')->orderBy('date_update', 'DESC')->where('status', 1)->paginate(10);
        return view('pages.home', compact('product','category'));
    }

    public function product($slug){
        $product = Product::with('category','product_library', 'brand','library','product_color', 'color', 'size', 'product_size')->where('slug', $slug)->first();
        $review = Review::with('user','product','order')->where('product_id', $product->id)->orderby('date_review', 'DESC')->paginate(2);
        $storage = Storage::with('product','storage_color', 'color', 'size', 'storage_size')->orderby('id', 'DESC')->get();
        $reviewCount = $review->count();
        return view('pages.product', compact('product', 'storage','review','reviewCount'));
    }

    public function order()
    {
        $response = Http::get('https://raw.githubusercontent.com/madnh/hanhchinhvn/master/dist/tinh_tp.json');
        if ($response->successful()) {
            $provinces = $response->json();
        } else {
            $provinces = [];
        }
        $userId = auth()->check() ? auth()->user()->id : null;
        $cart = Cart::where('user_id', $userId)->orderBy('id', 'DESC')->get();
        return view('pages.order', compact('cart','provinces'));
    }

    public function order_detail($id)
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
        return view('pages.order_detail', compact('order','orderdt'));
    }

    public function shop(){
        $color = Color::all();
        $brand = Brand::all();
        $size = Size::all();
        $category = Category::all();
        $list = Product::with('category','product_library', 'brand','library','product_color', 'color', 'size', 'product_size')->where('status', 1)->orderby('date_create','desc')->paginate(16);
        return view('pages.shop', compact('list','color', 'brand', 'category', 'size'));
    }

    public function category($slug){
        $cate_slug = Category::where('slug', $slug)->first();
        $product = Product::where('category_id', $cate_slug->id)->orderBy('id','DESC')->paginate(16);
        return view('pages.category', compact('cate_slug','product'));
    }

    public function Blog(){
        $genre = Genre::orderBy('id', 'ASC')->where('status', 1)->get();
        $list = Post::with('genre', 'user')->where('status', 1)->orderby('date_create','DESC')->paginate(5);
        return view('pages.blog', compact('list','genre'));
    }

    public function genre($slug){
        $gen_slug = Genre::where('slug', $slug)->first();
        $genre = Genre::orderBy('id', 'ASC')->where('status', 1)->get();
        $list = Post::where('genre_id', $gen_slug->id)->orderBy('id','DESC')->paginate(16);
        return view('pages.genre', compact('gen_slug', 'genre', 'list'));
    }

    public function post($slug){
        $post = Post::with('genre','user')->where('slug', $slug)->where('status', 1)->first();
        $user = User::all();
        $genre = Genre::orderby('id', 'DESC')->where('status','1')->get();
        return view('pages.post', compact('genre', 'post','user'));
    }

    // public function getReviewsPage($slug, $page) {
    //     $product = Product::where('slug', $slug)->firstOrFail();
    //     $reviews = Review::with('user')->where('product_id', $product->id)->orderBy('date_review', 'DESC')->paginate(2, ['*'], 'page', $page);

    //     return response()->json(view('partials.reviews', compact('reviews'))->render());
    // }
}