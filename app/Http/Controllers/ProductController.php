<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;
use App\Models\Brand;
use App\Models\Library;
use App\Models\product_library;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;
use App\Models\product_color;
use App\Models\Color;
use App\Models\product_size;
use App\Models\Size;
class ProductController extends Controller
{



    public function show_image_product(Request $request)
    {
        $imagePath = $request->file('image')->store('uploads/product');
        return response()->json(['imagePath' => $imagePath]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $category = Category::pluck('title','id');
        $brand = Brand::pluck('title', 'id');
        $list = Product::with('category','product_library', 'brand','library','product_color', 'color', 'size', 'product_size')->orderby('date_update', 'desc')->get();
        return view('admincp.product.index', compact('list','category', 'brand'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $category = Category::pluck('title', 'id');
        $brand = Brand::pluck('title', 'id');

        $library = Library::pluck('image','id');
        $list_library = Library::orderByDesc('id')->get();

        $color = Color::pluck('bg_color','id');
        $list_color = Color::orderByDesc('id')->get();

        $size = Size::pluck('title','id');
        $list_size= Size::orderByDesc('id')->get();

        return view('admincp.product.form', compact('category', 'brand', 'list_library','library', 'list_color', 'color', 'size', 'list_size'));
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
        'title' => 'required|unique:products|max:255',
        'slug' => 'required|unique:products|max:255',
        'description' => 'required',
        'content' => 'required',
        'category_id' => 'required',
        'brand_id' => 'required',
        'hot' => 'required',
        'status' => 'required',
        'price' => 'required',
        'library' => 'required|array', // Assuming 'library' is an array
        'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048', // Adjust the validation rule for images
        'color' => 'required|array',
        'size' => 'required|array',
    ]);
    [
        'title.unique' => 'Tên sản phẩm đã tồn tại',
        'title.required' => 'Tên sản phẩm không được để trống',
        'slug.required' => 'Slug sản phẩm không được để trống',
        'slug.unique' => 'Slug sản phẩm đã tồn tại',
        'description.required' => 'Mô tả sản phẩm không được để trống',
        'content.required' => 'Chi tiết sản phẩm không được để trống',
        'hot.required' => 'Sản phẩm hot không được để trống',
        'status.required' => 'Trạng thái sản phẩm không được để trống',
        'category_id.required' => 'Danh mục sản phẩm không được để trống',
        'brand_id.required' => 'Thương hiệu sản phẩm không được để trống',
        'price.required' => 'Giá thành sản phẩm không được để trống',
        'image.required' => 'Hình ảnh không được bỏ trống',
        'image.mimes' => 'Hình ảnh chỉ phù hợp với jpeg,jpg,gif,svg',
        'image.max' => 'Hình ảnh vượt quá 2MB',
        'color.required' => 'Màu sắc không được bỏ trống',
        'size.required' => 'Kích cỡ không được bỏ trống',
    ];

    if ($validator->fails()) {
        return redirect()->back()->withErrors($validator)->withInput();
    }
    $product = new Product();
    $product->title = $data['title'];
    $product->slug = $data['slug'];
    $product->description = $data['description'];
    $product->content = $data['content'];
    $product->category_id = $data['category_id'];
    $product->brand_id = $data['brand_id'];
    $product->price = $data['price'];
    $product->status = $data['status'];
    $product->hot = $data['hot'];
    $product->date_create = Carbon::now('Asia/Ho_Chi_Minh');
    $product->date_update = Carbon::now('Asia/Ho_Chi_Minh');

    foreach($data['library'] as $key => $lib){
        $product->library_id = $lib[0];
    }

    foreach($data['color'] as $key => $col){
        $product->color_id = $col[0];
    }

    foreach($data['size'] as $key => $siz){
        $product->size_id = $siz[0];
    }

    $get_image = $request->file('image');
    if ($get_image) {
        $get_name_image = $get_image->getClientOriginalName();
        $name_image = current(explode('.', $get_name_image));
        $new_image = $name_image . rand(0, 9999) . '.' . $get_image->getClientOriginalExtension();
        $get_image->move('uploads/product/', $new_image);
        $product->image = $new_image;
    }

    $product->save();
    $product->product_library()->attach($data['library']);
    $product->product_color()->attach($data['color']);
    $product->product_size()->attach($data['size']);
    toastr()->success('Thành Công', 'Thêm sản phẩm thành công');
    return redirect()->route('product.index');
}

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $product = Product::find($id);
        $category = Category::pluck('title', 'id');
        $brand = Brand::pluck('title', 'id');

        $library = Library::pluck('image','id');
        $list_library = Library::orderByDesc('id')->get();

        $color = Color::pluck('name','id');
        $list_color = Color::orderByDesc('id')->get();

        $size = Size::pluck('title','id');
        $list_size= Size::orderByDesc('id')->get();

        $product_size = $product->product_size;
        $product_color = $product->product_color;
        $product_library = $product->product_library;
        return view('admincp.product.form', compact('category', 'brand', 'product','list_library','product_library','list_color','color', 'list_size', 'size', 'product_size', 'product_color'));
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
        $data = $request->validate(
            [
                'title' => 'required|max:255',
                'slug' => 'required|max:255',
                'description' => 'required',
                'content' => 'required',
                'category_id' => 'required',
                'brand_id' => 'required',
                'hot' => 'required',
                'status' => 'required',
                'price' => 'required',
                'library' => 'required|array',
                'image' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
                'color' => 'required|array',
                'size' => 'required|array',
            ],
            [
                'title.required' => 'Tên sản phẩm không được để trống',
                'slug.required' => 'Slug sản phẩm không được để trống',
                'description.required' => 'Mô tả sản phẩm không được để trống',
                'content.required' => 'Chi tiết sản phẩm không được để trống',
                'hot.required' => 'Sản phẩm hot không được để trống',
                'status.required' => 'Trạng thái sản phẩm không được để trống',
                'category_id.required' => 'Danh mục sản phẩm không được để trống',
                'brand_id.required' => 'Thương hiệu sản phẩm không được để trống',
                'price.required' => 'Giá thành sản phẩm không được để trống',
                'image.required' => 'Hình ảnh không được bỏ trống',
                'image.mimes' => 'Hình ảnh chỉ phù hợp với jpeg,jpg,gif,svg',
                'image.max' => 'Hình ảnh vượt quá 2MB',
                'color.required' => 'Màu sắc không được bỏ trống',
                'size.required' => 'Kích cỡ không được bỏ trống',
            ]
        );
        $product = Product::find($id);
        $product->title = $data['title'];
        $product->slug = $data['slug'];
        $product->description = $data['description'];
        $product->content = $data['content'];
        $product->category_id = $data['category_id'];
        $product->brand_id = $data['brand_id'];
        $product->price = $data['price'];
        $product->status = $data['status'];
        $product->hot = $data['hot'];
        $product->date_update = Carbon::now('Asia/Ho_Chi_Minh');

        foreach($data['library'] as $key => $lib){
            $product->library_id = $lib[0];
        }

        foreach($data['color'] as $key => $col){
            $product->color_id = $col[0];
        }

        foreach($data['size'] as $key => $siz){
            $product->size_id = $siz[0];
        }

        $get_image = $request->file('image');

        if ($get_image) {
            $old_image_path = 'uploads/product/' . $product->image;
            if (file_exists($old_image_path)) {
                $get_name_image = $get_image->getClientOriginalName();
                $name_image = current(explode('.', $get_name_image));
                $new_image = $name_image . rand(0, 9999) . '.' . $get_image->getClientOriginalExtension();
                $get_image->move('uploads/product/', $new_image);
                $product->image = $new_image;
                unlink($old_image_path);
            } else {
                $get_name_image = $get_image->getClientOriginalName();
                $name_image = current(explode('.', $get_name_image));
                $new_image = $name_image . rand(0, 9999) . '.' . $get_image->getClientOriginalExtension();
                $get_image->move('uploads/product/', $new_image);
                $product->image = $new_image;
            }
        }

        $product->save();
        $product->product_library()->sync($data['library']);
        $product->product_color()->sync($data['color']);
        $product->product_size()->sync($data['size']);
        toastr()->success('Thành Công', 'Cập nhật sản phẩm thành công');
        return redirect()->route('product.index');
    }



    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $product = Product::find($id);
        if(file_exists('uploads/product/'.$product->image)){
            unlink('uploads/product/'.$product->image);
        }
        product_library::whereIN('product_id', [$product->id])->delete();
        product_color::whereIN('product_id', [$product->id])->delete();
        product_size::whereIN('product_id', [$product->id])->delete();
        $product->delete();
        toastr()->success('Thành Công','Xóa sản phẩm thành công');
        return redirect()->back();
    }
}
