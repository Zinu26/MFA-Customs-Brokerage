<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Validator;

class PythonController extends Controller
{
    public function predictDeliveryTime(Request $request)
    {
        // Validate the form input
        $validator = Validator::make($request->all(), [
            'arrival_date' => 'required|date|date_format:F d, Y',
            'distance' => 'required|numeric',
        ]);

        if ($validator->fails()) {
            return redirect('/predict')
                        ->withErrors($validator)
                        ->withInput();
        }

        $arrival_date_str = $request->input('arrival_date');
        $distance = $request->input('distance');

        // Call the Python script to make the prediction
        $process_time = exec("python3 resources/views/script.py $arrival_date_str $distance");
        $delivery_time = exec("python3 resources/views/script.py $arrival_date_str $distance $process_time");

        // Convert the delivery time to a date string
        $arrival_date = date_create_from_format('F d, Y', $arrival_date_str);
        $delivery_date = date_add($arrival_date, date_interval_create_from_date_string("$delivery_time days"));
        $delivery_date_str = date_format($delivery_date, 'F d, Y');

        // Pass the results to the view
        return view('predict', ['process_time' => $process_time, 'delivery_date' => $delivery_date_str]);
    }
}
