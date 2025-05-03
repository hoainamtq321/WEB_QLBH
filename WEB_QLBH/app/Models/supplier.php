<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class supplier extends Model
{
    use HasFactory;
    protected $primaryKey = 'supplier_id';
    protected $fillable = [
        'name',
        'phone' ,
        'address',
        'current_debt',
    ];
}
