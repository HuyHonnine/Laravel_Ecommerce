<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class order_product extends Model
{
    use HasFactory;
    protected $table = 'order_product';
    protected $fillable = [
        'product_id',
        'order_id',
        'quantity',
        'color',
        'size',
    ];
    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }
}