<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductColor extends Model
{
    use HasFactory;

    protected $table = 'products_color';

    protected  $fillable = [
        'product_id',
        'color_id',
        'quantity',
    ];
}