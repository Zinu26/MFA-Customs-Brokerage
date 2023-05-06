<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ActivityLog;
use App\Models\Shipment;
use League\Csv\Writer;
use League\Csv\CannotInsertRecord;


class ActivityLogController extends Controller
{
    public function download(Request $request)
    {
        // Retrieve the start and end dates from the request
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');

        // Retrieve the activity logs as a collection
        $logs = ActivityLog::query();

        // Filter the logs by the start and end dates, if provided
        if ($startDate && $endDate) {
            $logs->whereBetween('created_at', [$startDate, $endDate]);
        }

        $logs = $logs->get();

        // Create a new CSV writer object
        $csv = Writer::createFromString('');

        // Add the headers to the CSV file
        $csv->insertOne(['User', 'Activity', 'Loggable Type', 'Loggable ID', 'Changes', 'Timestamp']);

        // Loop through each activity log and add it to the CSV file
        foreach ($logs as $log) {
            try {
                $csv->insertOne([
                    $log->user->name,
                    $log->activity,
                    $log->loggable_type,
                    $log->loggable_id,
                    $log->changes,
                    $log->created_at,
                ]);
            } catch (CannotInsertRecord $e) {
                // Handle any errors that occur while adding the log to the CSV file
            }
        }

        // Set the filename and headers for the CSV download
        $filename = 'activity-logs.csv';
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="'.$filename.'"',
        ];

        // Return the CSV file as a download response
        return response($csv->toString(), 200, $headers);
    }

}
