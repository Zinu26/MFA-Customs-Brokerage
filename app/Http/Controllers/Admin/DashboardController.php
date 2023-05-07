<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Dataset;
use App\Models\Shipment;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function dashboard()
    {
        // this is for delivery status evaluation
        $data = Dataset::select('delivery_status', DB::raw('count(*) as count'))
            ->groupBy('delivery_status')
            ->get();

        $labels = [];
        $values = [];

        foreach ($data as $item) {
            $labels[] = $item->delivery_status;
            $values[] = $item->count;
        }

        $shipments = Shipment::orderBy('arrival', 'desc')
            ->take(5)
            ->get();

        return view('admin.dashboard', compact('labels', 'values', 'shipments'));
    }
}
