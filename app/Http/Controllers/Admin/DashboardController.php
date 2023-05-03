<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Dataset;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function dashboard(){
        $data = Dataset::select('delivery_status', DB::raw('count(*) as count'))
                ->groupBy('delivery_status')
                ->get();

        $labels = [];
        $values = [];

        foreach ($data as $item) {
        $labels[] = $item->delivery_status;
        $values[] = $item->count;
        }

        return view('admin.dashboard', compact('labels', 'values'));
    }
    //
}
