<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class purchase_order extends Model
{
    use HasFactory;
    protected $primaryKey = 'purchase_order_id';
    protected $fillable = [
        'supplier_id',
        'create_by',
        'status',
        'total',
    ];
}
