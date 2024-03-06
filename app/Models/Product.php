<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    public $timestamps = false;

    public function category(){
        return $this->belongsTo(Category::class, 'category_id');
    }
    public function brand(){
        return $this->belongsTo(Brand::class, 'brand_id');
    }
    public function library(){
        return $this->belongsTo(Library::class, 'library_id');
    }

    public function cart(){
        return $this->belongsTo(Cart::class);
    }
    public function product_library(){
        return $this->belongsToMany(Library::class, 'product_library', 'product_id','library_id' );
    }

    public function color(){
        return $this->belongsTo(Color::class, 'color_id');
    }

    public function product_color(){
        return $this->belongsToMany(Color::class, 'product_color', 'product_id','color_id' );
    }

    public function size(){
        return $this->belongsTo(Size::class, 'size_id');
    }

    public function product_size(){
        return $this->belongsToMany(Size::class, 'product_size', 'product_id','size_id' );
    }

    public function order_product()
    {
        return $this->belongsTo(Order::class, 'order_product', 'product_id', 'order_id')
            ->withPivot(['quantity', 'color', 'size']);
    }
}