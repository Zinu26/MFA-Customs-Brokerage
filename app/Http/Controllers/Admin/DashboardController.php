<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Shipment;
use App\Models\Dataset;
use App\Models\CloseShipment;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function dashboard()
    {
        $shipments = Shipment::orderBy('arrival_date', 'desc')
            ->take(5)
            ->get();

        $today = Carbon::today();
        $prev_month = $today->copy()->subMonth();
        $next_month = $today->copy()->addMonth();

        $statuses = ['Early', 'On-Time', 'Delayed'];
        $data = [];

        foreach ($statuses as $status) {
            $prev_month_count = CloseShipment::where('delivered_date', '>=', $prev_month)
                ->where('delivered_date', '<', $today)
                ->where('delivery_status', $status)
                ->count();

            $current_month_count = CloseShipment::where('delivered_date', '>=', $today)
                ->where('delivered_date', '<', $next_month)
                ->where('delivery_status', $status)
                ->count();

            $next_month_count = CloseShipment::where('delivered_date', '>=', $next_month)
                ->where('delivered_date', '<', $next_month->copy()->addMonth())
                ->where('delivery_status', $status)
                ->count();

            $data[] = [
                'status' => $status,
                'counts' => [
                    $prev_month_count,
                    $current_month_count,
                    $next_month_count,
                ],
            ];
        }

        return view('admin.dashboard', compact(
            'shipments',
            'data',
            'prev_month',
            'today',
            'next_month',
        ));
    }
}
