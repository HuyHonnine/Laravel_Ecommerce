<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Storage;
use App\Models\Product;
class StorageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $list = Storage::with('product')->orderby('id', 'desc')->get();
        return view('admincp.storage.index', compact('list'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $list_title = Product::orderBy('id','DESC')->pluck('title','id');
        return view('admincp.storage.form', compact('list_title'));
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
                'quantity' => 'required|numeric',
                'product_id' => 'required',
                'color' => 'required',
                'size' => 'required',

            ],
            [
                'quantity.required' => 'Số lượng không được bỏ trống',
                'product_id.required' => 'Tên sản phẩm không được bỏ trống',
                'color.required' => 'Màu sắc không được bỏ trống',
                'size.required' => 'Kích cỡ không được bỏ trống',
                'quantity.numeric' => 'Số lượng phải là một số',

            ]
        );
        $storage = new Storage();
        $storage->quantity = $data['quantity'];
        $storage->product_id = $data['product_id'];
        $storage->color = $data['color'];
        $storage->size = $data['size'];

        $storage->save();
        toastr()->success('Thành Công','Thêm thành công');
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

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $storage = Storage::find($id);
        $list_product = Product::orderBy('id','DESC')->pluck('title','id');
        return view('admincp.storage.form', compact('list_product','storage'));
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
                'quantity' => 'required|numeric',
                'product_id' => 'required',
                'color' => 'required',
                'size' => 'required',
            ],
            [
                'quantity.required' => 'Số lượng không được bỏ trống',
                'product_id.required' => 'Tên sản phẩm không được bỏ trống',
                'quantity.numeric' => 'Số lượng phải là một số',
                'color.required' => 'Màu sắc không được bỏ trống',
                'size.required' => 'Kích cỡ không được bỏ trống',
            ]
        );
        $storage = Storage::find($id);
        $storage->quantity = $data['quantity'];
        $storage->product_id = $data['product_id'];
        $storage->color = $data['color'];
        $storage->size = $data['size'];

        $storage->save();
        toastr()->success('Thành Công','Sửa thành công');
        return redirect()->route('storage.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $storage = Storage::find($id);
        $storage->delete();
        toastr()->success('Thành Công','Xóa sản phẩm thành công');
        return redirect()->back();
    }
}