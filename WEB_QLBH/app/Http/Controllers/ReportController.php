<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReportController extends Controller
{
    function sale()
    {
        $revenue = DB::table('orders')
            ->select(
                DB::raw('DATE(created_at) as date'),
                DB::raw('SUM(total) as total')
            )
            ->where('created_at', '>=', Carbon::now()->subDays(6)->startOfDay())
            ->where('status', 'Hoàn thành') // Chỉ lấy đơn đã hoàn thành
            ->groupBy(DB::raw('DATE(created_at)'))
            ->orderBy('date', 'asc')
            ->get();
        
            $dates = collect();

        for ($i = 6; $i >= 0; $i--) {
            $date = Carbon::now()->subDays($i)->toDateString();
            $dates->put($date, 0);
        }

        foreach ($revenue as $row) {
            $dates->put($row->date, (int) $row->total);
        }

        $final = $dates->map(function ($total, $date) {
            return [
                'day' => Carbon::parse($date)->day,
                'total' => $total,
            ];
        })->values()->toArray();


        $statusCounts = DB::table('orders')
            ->select('status', DB::raw('count(*) as total'))
            ->where('created_at', '>=', Carbon::now()->subDays(6)->startOfDay())
            ->groupBy('status')
            ->pluck('total', 'status');
        return view('admin.repost.saleReport',[
            'final' => $final,
            'statusCounts' => $statusCounts
        ]);
    }


}
