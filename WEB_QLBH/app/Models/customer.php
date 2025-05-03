<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class customer extends Model
{
    use HasFactory;
    protected $primaryKey = 'customer_id';
    protected $fillable = [
        'name',
        'phone',
        'address',
        'total_spent', // Tổng chi tiêu
        'total_orders',// Tổng số đơn
    ];
}
