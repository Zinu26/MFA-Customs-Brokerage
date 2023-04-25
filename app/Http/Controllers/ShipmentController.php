<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Shipment;
use App\Models\Consignee;

class ShipmentController extends Controller
{
    function index(){
        $shipments = Shipment::all();
        $consignees = Consignee::all();
        return view('admin.shipmentPanel.index', compact('shipments', 'consignees'));
    }

    function add(Request $request){
        $shipment = new Shipment;

        $shipment->consignee_name = $request->input('consignee_name');
        $shipment->item_description = $request->input('item_description');
        $shipment->size = $request->input('size');
        $shipment->weight = $request->input('weight');
        $shipment->bl_number = $request->input('BL_number');
        $shipment->shipping_line = $request->input('shipping_line');
        $shipment->arrival = $request->input('arrival_time');
        $shipment->shipment_status = $request->input('shipment_status');
        $shipment->do_status = $request->input('do_status');
        $shipment->billing_status = $request->input('billing_status');
        $shipment->delivery_status = $request->input('delivery_status');
        $shipment->save();


        return redirect()->back()->with('success', 'Shipment data added successfully.');
    }

    function edit(Request $request, $id){
        $shipment = Shipment::findOrFail($id);

        if($shipment->process_started != null){
            $shipment->process_started = $request->input('process_started');
        }
        if($shipment->process_ended != null){
            $shipment->process_ended = $request->input('process_ended');
        }
        $shipment->shipment_status = $request->input('shipment_status');
        $shipment->do_status = $request->input('do_status');
        $shipment->billing_status = $request->input('billing_status');
        $shipment->delivery_status = $request->input('delivery_status');
        $shipment->save();


        return redirect()->back()->with('success', 'Shipment data have been updated successfully.');
    }
}
