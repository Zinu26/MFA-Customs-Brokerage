<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Shipment;
use App\Models\Consignee;
use App\Models\Dataset;
use Illuminate\Support\Facades\DB;


class ShipmentController extends Controller
{
    function index(){
        $shipments = Shipment::all();
        $consignees = Consignee::all();
        $shipping_lines = DB::table('datasets')->pluck('shipping_line')->unique();

        return view('admin.shipmentPanel.index', compact('shipments', 'consignees', 'shipping_lines'));
    }

    function close_shipment(){
        $shipments = Dataset::all();
        $consignees = Consignee::all();
        return view('admin.shipmentPanel.close_shipments', compact('shipments', 'consignees'));
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

        if($shipment->process_started == null){
            $shipment->process_started = $request->input('process_started');
        }
        if($shipment->process_finished == null){
            if($request->input('process_ended') != null){
                $shipment->process_finished = $request->input('process_ended');
            }
        }
        $shipment->shipment_status = $request->input('shipment_status');
        $shipment->do_status = $request->input('do_status');
        $shipment->billing_status = $request->input('billing_status');
        $shipment->delivery_status = $request->input('delivery_status');
        $shipment->save();

        if($shipment->process_started != null && $shipment->process_finished != null && $shipment->shipment_status == 'AG' && $shipment->billing_status == 'Done' && $shipment->delivery_status == 'Done' && $shipment->do_status == 'Done'){
            $shipment->status = '1';
            $shipment->save();

            $dataset = new Dataset;
            $dataset->consignee_name = $shipment->consignee_name;
            $dataset->bl_number = $shipment->bl_number;
            $dataset->arrival_date = $shipment->arrival;
            $dataset->process_started = $shipment->process_started;
            $dataset->process_finished = $shipment->process_finished;
            $dataset->shipment_size = $shipment->size;
            $dataset->shipment_details = $shipment->item_description;
            $dataset->shipping_line = $shipment->shipping_line;
            $dataset->weight = $shipment->weight;
            $dataset->status = false;
            $dataset->save();
        }

        return redirect()->back()->with('success', 'Shipment data have been updated successfully.');
    }
}
