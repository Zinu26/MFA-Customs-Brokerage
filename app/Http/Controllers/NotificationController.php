<?php

namespace App\Http\Controllers;

use App\Models\Shipment;
use Illuminate\Http\Request;

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
}
