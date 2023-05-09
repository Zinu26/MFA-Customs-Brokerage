<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Consignee;
use App\Models\User;
use App\Models\Shipment;
use App\Models\Dataset;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ConsigneeController extends Controller
{
    function client_page()
    {
        $clients = Consignee::all();
        $users = User::all();
        return view('admin.clientPanel.clients', compact('clients'));
    }

    function archive_list()
    {
        $clients = Consignee::all();
        return view('admin.clientPanel.archive_list', compact('clients'));
    }

    public function add(Request $request)
    {
        // Validate the input data
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'tin' => 'required|string|max:255',
            'contact' => 'required|string|max:255',
            'email' => 'required|string|unique:users,email|max:255',
            'address' => 'required|string|max:255',
        ]);

        // Create new user
        $user = User::create([
            'name' => $validatedData['name'],
            'email' => $validatedData['email'],
            'password' => bcrypt($validatedData['tin']),
            'type' => 2, // Assuming you want to create a consignee user
        ]);

        // Create a new Consignee instance with the validated data
        $consignee = new Consignee([
            'user_id' => $user->id,
            'tin' => $validatedData['tin'],
            'contact' => $validatedData['contact'],
            'address' => $validatedData['address'],
            'status' => 0,
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

        return redirect()->back()->with('warning', 'Client data haven been archived successfully.');
    }

    function restore_client($id)
    {
        $client = Consignee::findOrFail($id);

        $client->status = false;
        $client->save();

        return redirect()->back()->with('success', 'Client data have been restored successfully.');
    }

    function open_shipment($id)
    {
        $consignee = Consignee::findOrFail($id);
        $shipments = Shipment::where('consignee_name', $consignee->user->name)->get();
        $shipping_lines = DB::table('datasets')->pluck('shipping_line')->unique();

        return view('admin.clientPanel.open_shipments', compact('consignee', 'shipments', 'shipping_lines'));
    }

    function close_shipment($id)
    {
        $consignee = Consignee::findOrFail($id);
        $shipments = Dataset::where('consignee_name', $consignee->user->name)->get();

        return view('admin.clientPanel.close_shipments', compact('consignee', 'shipments'));
    }

    function consignee_dashboard()
    {
        // this is for delivery status evaluation
        $data = Dataset::select('delivery_status', DB::raw('count(*) as count'))
            ->groupBy('delivery_status')->where('consignee_name', Auth::user()->name)
            ->get();

        $labels = [];
        $values = [];

        foreach ($data as $item) {
            $labels[] = $item->delivery_status;
            $values[] = $item->count;
        }

        $shipments = Shipment::orderBy('arrival', 'desc')->where('consignee_name', Auth::user()->name)
            ->take(5)
            ->get();

        return view('clients.dashboard', compact('shipments', 'labels', 'values'));
    }

    function consignee_open_shipment(){
        $shipments = Shipment::where('consignee_name', Auth::user()->name)->get();

        return view('clients.open_shipments', compact('shipments'));
    }

    function consignee_close_shipment(){
        $shipments = Dataset::where('consignee_name', Auth::user()->name)->get();

        return view('clients.close_shipments', compact('shipments'));
    }
}
