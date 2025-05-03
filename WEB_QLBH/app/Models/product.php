<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class product extends Model
{
    use HasFactory;
    protected $primaryKey = 'product_id';
    protected $fillable = [
        'product_name',
        'import_price' ,
        'sell_price',
        'quantity_in_stock',
        'img',
        'descriptions',
        'create_by',// ID người tạo
    ];
}
