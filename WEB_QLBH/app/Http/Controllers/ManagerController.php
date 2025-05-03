<?php

namespace App\Http\Controllers;

use App\Models\customer;
use App\Models\order;
use App\Models\product;
use App\Models\supplier;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ManagerController extends Controller
{
    function index()
    {
        return view('admin.master');
    }
    

}
