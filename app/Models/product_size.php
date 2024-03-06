<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class product_size extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $table = 'product_size';
    protected $fillable = [
        'product_id',
        'color_id',
    ];
}