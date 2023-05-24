<?php

namespace App\Http\Controllers;

use App\Models\Shipment;
use App\Models\Notification;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    public function getShipmentDetails(Request $request)
    {
        $shipmentId = $request->input('shipment_id');
        $shipment = Shipment::find($shipmentId);
        $shipmentDetails = [
            'port_of_origin' => $shipment->port_of_origin,
            'arrival' => $shipment->arrival,
            'predicted_delivery_date' => $shipment->predicted_delivery_date,
        ];
        return response()->json(['shipment_details' => json_encode($shipmentDetails)]);
    }

    public function markAsRead(Request $request, $id)
    {
        $notification = Notification::findOrFail($id);
        $notification->read_at = now();
        $notification->save();

        return response()->json(['message' => 'Notification marked as read.']);
    }
}
