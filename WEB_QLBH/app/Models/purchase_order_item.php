<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class purchase_order_item extends Model
{
    use HasFactory;
    protected $primaryKey = 'purchase_order_item_id';
    protected $fillable = [
        'purchase_order_id',
        'product_id',
        'import_price',
        'quantity',
    ];
}
