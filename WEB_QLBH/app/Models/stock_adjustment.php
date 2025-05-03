<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class stock_adjustment extends Model
{
    use HasFactory;
    protected $primaryKey = 'stock_adjustment_id';
    protected $fillable = [
        'create_by',
	    'completed_by',
        'status',
    ];
}
