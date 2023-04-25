<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Consignee;
use App\Models\Shipment;
use App\Models\Dataset;

class ConsigneeController extends Controller
{
    function client_page(){
        $clients = Consignee::all();
        return view('admin.clientPanel.clients', compact('clients'));
    }

    function archive_list(){
        $clients = Consignee::all();
        return view('admin.clientPanel.archive_list', compact('clients'));
    }

    public function add(Request $request)
    {
        // Validate the input data
        $request->validate([
            'name' => 'required|string|max:255',
            'tin' => 'required|string|max:255',
            'contact' => 'required|string|max:255',
            'email' => 'required|string|max:255|email',
            'address' => 'required|string|max:255',
        ]);

        // Create a new Consignee instance with the validated data
        $consignee = new Consignee([
            'name' => $request->name,
            'tin' => $request->tin,
            'contact' => $request->contact,
            'email' => $request->email,
            'address' => $request->address,
        ]);

        // Save the new Consignee instance to the database
        $consignee->save();

        // Redirect to the index page with a success message
        return redirect()->route('client_list')->with('success', 'Consignee added successfully.');
    }

    public function update(Request $request, $id)
    {
        $client = Consignee::findOrFail($id);
        $client->name = $request->input('name');
        $client->tin = $request->input('tin');
        $client->contact = $request->input('contact');
        $client->email = $request->input('email');
        $client->address = $request->input('address');
        $client->save();
        return redirect()->back()->with('success', 'Client details updated successfully');
    }

    function archive_client($id)
    {
        $client = Consignee::findOrFail($id);

        $client->status = true;
        $client->save();

        return redirect()->back()->with('success', 'Client data updated successfully.');
    }

    function restore_client($id)
    {
        $client = Consignee::findOrFail($id);

        $client->status = false;
        $client->save();

        return redirect()->back()->with('success', 'Client data updated successfully.');
    }

    function open_shipment($id){
        $consignee = Consignee::findOrFail($id);
        $shipments = Shipment::where('consignee_name', $consignee->name)->get();

        return view('admin.clientPanel.open_shipments', compact('consignee', 'shipments'));
    }

    function close_shipment($id){
        $consignee = Consignee::findOrFail($id);
        $shipments = Dataset::where('consignee_name', $consignee->name)->get();

        return view('admin.clientPanel.close_shipments', compact('consignee', 'shipments'));
    }
}
