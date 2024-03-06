<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class product_color extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $table = 'product_color';
    protected $fillable = [
        'product_id',
        'size_id',
    ];
    public function cart()
    {
        return $this->belongsTo(Cart::class, 'product_id','id');
    }
}