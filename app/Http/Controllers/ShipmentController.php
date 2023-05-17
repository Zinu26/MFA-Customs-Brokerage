<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Shipment;
use App\Models\Consignee;
use App\Models\Notification;
use App\Models\User;
use App\Models\Dataset;
use App\Models\CloseShipment;
use App\Models\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Models\ActivityLog;
use DateTime;
use Carbon\Carbon;
use App\Notifications\ShipmentUpdate;


class ShipmentController extends Controller
{
    function index()
    {
        $shipments = Shipment::all();
        $users = User::where('type', 2)->with('consignee')->get();
        $shipping_lines = DB::table('datasets')->pluck('shipping_line')->unique();
        $files = File::all();
        return view('admin.shipmentPanel.index', compact('shipments', 'users', 'shipping_lines', 'files'));
    }

    function close_shipment()
    {
        $shipments = Dataset::all()->merge(CloseShipment::all());
        $consignees = Consignee::all();
        return view('admin.shipmentPanel.close_shipments', compact('shipments', 'consignees'));
    }

    function add(Request $request)
    {
        $shipment = new Shipment;

        $shipment->consignee_name = $request->input('consignee_name');
        $shipment->user_id = User::where('name', $shipment->consignee_name)->first()->id;
        $shipment->shipment_details = $request->input('item_description');
        $shipment->size = $request->input('size');
        $shipment->weight = $request->input('weight');
        $shipment->bl_number = $request->input('BL_number');
        $shipment->entry_number = $request->input('entry_number');
        $shipment->shipping_line = $request->input('shipping_line');
        $shipment->arrival_date = $request->input('arrival_date');
        $shipment->port_of_origin = $request->input('port_of_origin');
        $shipment->shipment_status = $request->input('shipment_status');
        $shipment->do_status = $request->input('do_status');
        $shipment->billing_status = $request->input('billing_status');

        $user = User::where('name', $shipment->consignee_name)->first();
        $consignee = Consignee::where('user_id', $user->id)->first();

        $shipment->destination_address = $consignee->address;
        $shipment->save();

        $consigneeUser = User::find($shipment->user_id);
        $consigneeUser->notify(new ShipmentUpdate($shipment, 'A new shipment has been added.', json_encode($shipment->toArray()), 'add'));


        // log the activity
        $log = new ActivityLog;
        $log->user_id = Auth::id();
        $log->loggable()->associate($shipment);
        $log->activity = 'Shipment Added';
        $log->changes = $shipment->toJson();
        $log->save();

        return redirect()->back()->with('success', 'Shipment data added successfully.');
    }

    function edit(Request $request, $id)
    {
        $shipment = Shipment::findOrFail($id);

        // Check if process start date is earlier than arrival date
        $arrivalDate = Carbon::parse($shipment->arrival_date);
        $processStartDate = Carbon::parse($request->input('process_started'));
        if ($processStartDate->lessThan($arrivalDate)) {
            return redirect()->back()->with('error', 'Process start date cannot be earlier than arrival date.');
        }

        // Check if process finish date is earlier than process start date
        if ($request->has('process_ended')) {
            $processEndDate = Carbon::parse($request->input('process_ended'));
            if ($processEndDate->lessThan($processStartDate)) {
                return redirect()->back()->with('error', 'Process finish date cannot be earlier than process start date.');
            }

            // Check if delivered date is earlier than process finish date
            $deliveredDate = Carbon::parse($request->input('delivered_date'));
            if ($deliveredDate->lessThan($processEndDate)) {
                return redirect()->back()->with('error', 'Delivered date cannot be earlier than process finish date.');
            }
        }
        if ($shipment->process_started == null) {
            $shipment->process_started = $request->input('process_started');
        }
        if ($shipment->process_finished == null) {
            if ($request->input('process_ended') != null) {
                $shipment->process_finished = $request->input('process_ended');
            }
        }

        if ($shipment->process_started != null && $shipment->process_finished != null) {
            $url = 'https://shipmentapi.onrender.com/predict/';
            $data = array(
                'arrival' => $shipment->arrival_date,
                'process_start' => $shipment->process_started,
                'process_finished' => $shipment->process_finished
            );
            $json = json_encode($data);

            // API Call
            $ch = curl_init($url);
            curl_setopt($ch, CURLOPT_CAINFO, storage_path('app/cacert.pem'));
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
            curl_setopt($ch, CURLOPT_POSTFIELDS, $json);
            curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                'Content-Type: application/json',
                'Content-Length: ' . strlen($json)
            ));

            $response = curl_exec($ch);

            if (curl_errno($ch)) {
                print_r('Error' . curl_error($ch));
                print_r('API call failed. Please try again later.');
            } else {
                curl_close($ch);
                $response = json_decode($response);
                $response = DateTime::createFromFormat("Y-m-d", $response)->format("Y-m-d");
                $shipment->predicted_delivery_date = $response;
            }
        }

        $shipment->delivered_date = $request->input('delivered_date');
        $delivery_status = '';
        if ($shipment->delivered_date != null) {
            if ($shipment->delivered_date < $shipment->predicted_delivery_date) {
                $delivery_status = 'Early';
            } else if ($shipment->delivered_date == $shipment->predicted_delivery_date) {
                $delivery_status = 'On-Time';
            } else {
                $delivery_status = 'Delayed';
            }
            $shipment->delivery_status = $delivery_status;
        }
        $shipment->shipment_status = $request->input('shipment_status');
        $shipment->do_status = $request->input('do_status');
        $shipment->billing_status = $request->input('billing_status');
        $shipment->save();

        if ($shipment->delivered_date != null && $shipment->shipment_status == 'AP' && $shipment->billing_status == 'Done' && $shipment->do_status == 'Done') {
            $shipment->status = '1';
            $shipment->save();
            $closed = new CloseShipment();
            $closed->shipment_id = $shipment->id;
            $closed->consignee_name = $shipment->consignee_name;
            $closed->entry_number = $shipment->entry_number;
            $closed->bl_number = $shipment->bl_number;
            $closed->arrival_date = $shipment->arrival_date;
            $closed->process_started = $shipment->process_started;
            $closed->process_finished = $shipment->process_finished;
            $closed->predicted_delivery_date = $shipment->predicted_delivery_date;
            $closed->delivered_date = $shipment->delivered_date;
            $closed->size = $shipment->size;
            $closed->weight = $shipment->weight;
            $closed->shipment_details = $shipment->shipment_details;
            $closed->shipping_line = $shipment->shipping_line;
            $closed->port_of_origin = $shipment->port_of_origin;
            $closed->destination_address = $shipment->destination_address;
            $closed->delivery_status = $shipment->delivery_status;
            $closed->status = false;

            $closed->save();
        }

        $changes = $shipment->getChanges();


        if ($shipment->delivered_date == null) {
            $consigneeUser = User::find($shipment->user_id);
            $consigneeUser->notify(new ShipmentUpdate($shipment, 'A shipment has been updated.', json_encode($changes), 'update'));
        }
        if ($shipment->delivered_date != null) {
            $deliveredDate = Carbon::parse($shipment->delivered_date);
            $predictedDeliveryDate = Carbon::parse($shipment->predicted_delivery_date);
            $diffInDays = $deliveredDate->diffInDays($predictedDeliveryDate);
            $formattedDiff = $deliveredDate->diff($predictedDeliveryDate)->format('%r%a day/s');

            $data = [
                'predicted_delivery_date' => $shipment->predicted_delivery_date,
                'delivery_date' => $shipment->delivered_date
            ];
            $consigneeUser = User::find($shipment->user_id);
            if ($shipment->delivery_status === "Early") {
                $consigneeUser->notify(new ShipmentUpdate($shipment, 'The consignment was delivered ' . $formattedDiff . ' ahead of the anticipated delivery schedule.', json_encode($data), 'update'));
            } elseif ($shipment->delivery_status === "On-Time") {
                $consigneeUser->notify(new ShipmentUpdate($shipment, 'The consignment was delivered on time as per the anticipated delivery date.', json_encode($data), 'update'));
            } elseif ($shipment->delivery_status === "Delayed") {
                $consigneeUser->notify(new ShipmentUpdate($shipment, 'The consignment was ' . $formattedDiff . ' delayed from the anticipated delivery date.', json_encode($data), 'update'));
            }
        }

        // Log activity
        $activity = 'Shipment ' . $shipment->id . ' details were updated';
        $logData = [
            'user_id' => Auth::id(),
            'loggable' => $shipment,
            'activity' => $activity,
            'changes' => json_encode($changes),
        ];
        $logData['loggable_type'] = get_class($shipment);
        $logData['loggable_id'] = $shipment->id;

        ActivityLog::create($logData);

        return redirect()->back()->with('success', 'Shipment data have been updated successfully.');
    }

    public function search(Request $request)
    {
        $bl_number = $request->input('bl_number');
        $shipment = Shipment::where('bl_number', $bl_number)->first();

        if ($shipment) {
            return response()->json([
                'bl_number' => $shipment->bl_number,
                'entry_number' => $shipment->entry_number,
                'port_of_origin' => $shipment->port_of_origin,
                'arrival' => Carbon::parse($shipment->arrival_date)->format('F d, Y'),
                'process_started' => Carbon::parse($shipment->process_started)->format('F d, Y'),
                'process_finished' => Carbon::parse($shipment->process_finished)->format('F d, Y'),
                'predicted_delivery_date' => Carbon::parse($shipment->predicted_delivery_date)->format('F d, Y'),
                'delivered_date' => Carbon::parse($shipment->delivered_date)->format('F d, Y'),
                'do_status' => $shipment->do_status,
                'billing_status' => $shipment->billing_status,
                'shipment_status' => $shipment->shipment_status,
            ]);
        } else {
            return response()->json(['message' => 'Sorry, your tracking attempt was unsuccessful! Please check your tracking number and try again']);
        }
    }

    public function uploadFiles(Request $request)
    {
        $shipment_id = $request->input('id');
        $files = $request->file('files');

        foreach ($files as $file) {
            $filename = $file->getClientOriginalName();
            $size = $file->getSize();
            $location = $file->store('public/files');

            $fileData = new File();
            $fileData->shipment_id = $shipment_id;
            $fileData->name = $filename;
            $fileData->size = $size;
            $fileData->location = $location;
            $fileData->save();
        }

        return redirect()->back()->with('success', 'Files uploaded successfully.');
    }

    public function download($id)
    {
        $file = File::findOrFail($id);
        $path = Storage::url($file->location);

        return response()->download(public_path($path), $file->name);
    }

    // Define a controller method to update the read_at column
    public function markAsRead(Notification $notification)
    {
        $notification->read_at = now();
        $notification->save();
        return response()->json(['success' => true]);
    }
}
