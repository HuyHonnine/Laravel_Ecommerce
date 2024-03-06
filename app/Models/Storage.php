<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Storage extends Model
{
    use HasFactory;
    public $timestamps = false;
    public function product(){
        return $this->belongsTo(product::class, 'product_id');
    }
}