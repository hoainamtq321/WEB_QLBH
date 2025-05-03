<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class stock_adjustment_item extends Model
{
    use HasFactory;
    protected $primaryKey = 'stock_adjustment_item_id';
    protected $fillable = [
        'stock_adjustment_id',
        'product_id',
        'system_inventory',
        'physical_inventory',
        'note',
    ];
}
