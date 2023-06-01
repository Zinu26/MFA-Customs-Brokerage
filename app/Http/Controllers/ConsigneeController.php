<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Consignee;
use App\Models\User;
use App\Models\Shipment;
use App\Models\Dataset;
use App\Models\File;
use App\Models\CloseShipment;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use App\Models\ActivityLog;
use App\Models\Notification;
use Illuminate\Support\Facades\Config;

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
            'tin' => 'required|string|unique:consignees|max:255',
            'contact' => 'required|string|max:255',
            'email' => 'required|string|unique:users,email|max:255',
            'address' => 'required|string|max:255',
        ], [
            'tin.unique' => 'The TIN number has already been taken.',
            'email.unique' => 'Email has already been taken.',
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

        // Create activity log
        $changes = [
            'user' => $user->toJson(),
            'employee' => $consignee->toJson(),
        ];

        if (Auth::user()->type == 'admin') {
            // Create activity log
            ActivityLog::create([
                'user_id' => Auth::id(),
                'loggable_id' => $user->id,
                'loggable_type' => 'Admin',
                'activity' => 'Consignee Added',
                'changes' => json_encode($changes),
            ]);
        } else if (Auth::user()->type == 'employee') {
            // Create activity log
            ActivityLog::create([
                'user_id' => Auth::id(),
                'loggable_id' => $user->id,
                'loggable_type' => 'Employee',
                'activity' => 'Consignee Added',
                'changes' => json_encode($changes),
            ]);
        }

        // Save the new Consignee instance to the database
        $consignee->save();

        // Generate a unique database name for the tenant based on the user's ID
        $databaseName = 'client_' . $user->id;

        // Create a new database for the tenant
        DB::statement('CREATE DATABASE ' . $databaseName);

        // Create a new database connection dynamically
        Config::set('database.connections.client', [
            'driver' => 'mysql',
            'host' => env('DB_HOST', 'localhost'),
            'port' => env('DB_PORT', '3306'),
            'database' => $databaseName,
            'username' => env('DB_USERNAME', 'root'),
            'password' => env('DB_PASSWORD', ''),
            'charset' => 'utf8mb4',
            'collation' => 'utf8mb4_unicode_ci',
            'prefix' => '',
            'strict' => false,
            'engine' => null,
        ]);

        // Switch to the new tenant database connection
        DB::connection('client')->reconnect();

        Schema::connection('client')->create('shipments', function (Blueprint $table) {
            $table->id();
            $table->string('consignee_name')->nullable();
            $table->string('bl_number')->nullable();
            $table->string('entry_number')->nullable();
            $table->date('arrival_date')->nullable();
            $table->date('process_started')->nullable();
            $table->date('process_finished')->nullable();
            $table->date('predicted_delivery_date')->nullable();
            $table->date('delivered_date')->nullable();
            $table->string('port_of_origin')->nullable();
            $table->string('destination_address')->nullable();
            $table->string('size')->nullable();
            $table->string('shipment_details')->nullable();
            $table->string('weight')->nullable();
            $table->string('shipping_line')->nullable();
            $table->string('do_status')->nullable();
            $table->string('shipment_status')->nullable();
            $table->string('billing_status')->nullable();
            $table->string('delivery_status')->nullable();
            $table->boolean('status')->default(false);
            $table->timestamps();
        });

        Schema::connection('client')->create('notifications', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('type');
            $table->morphs('notifiable');
            $table->text('data');
            $table->timestamp('read_at')->nullable();
            $table->timestamps();
        });

        Schema::connection('client')->create('files', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('shipment_id');
            $table->string('name');
            $table->string('size');
            $table->string('location');
            $table->timestamps();

            $table->foreign('shipment_id')->references('id')->on('shipments')->onDelete('cascade');
        });

        // Redirect to the index page with a success message
        return redirect()->route('client_list')->with('success', 'Consignee added successfully.');
    }

    public function update(Request $request, $id)
    {
        $client = Consignee::findOrFail($id);
        $user = User::where('id', $client->user_id)->first();

        // Validate the input data
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'tin' => 'required|string|max:255',
            'contact' => 'required|string|max:255',
            'email' => 'required|string|max:255',
            'address' => 'required|string|max:255',
        ]);

        if ($client->tin != $validatedData['tin'] && Consignee::where('tin', $validatedData['tin'])->exists()) {
            return redirect()->back()->with('error', 'Tin has already been taken.');
        }
        $client->tin = $validatedData['tin'];
        $client->contact = $validatedData['contact'];
        $client->address = $validatedData['address'];
        $client->save();

        $user->name = $validatedData['name'];
        if ($user->email != $validatedData['email'] && User::where('email', $validatedData['email'])->exists()) {
            return redirect()->back()->with('error', 'Email has already been taken.');
        }
        $user->email = $validatedData['email'];
        $user->password = bcrypt($validatedData['tin']);
        $user->save();

        $changes_user = $user->getChanges();
        $changes_client = $client->getChanges();
        $changes = [
            json_encode($changes_user),
            json_encode($changes_client),
        ];
        if (empty($changes_user) && empty($changes_client)) {
            return redirect()->back()->with('warning', 'No changes were made to the Consignee details.');
        }
        // Log activity
        else {
            if (Auth::user()->type == '0') {
                $activity = 'Consignee ' . $user->id . ' details were updated';
                $logData = [
                    'user_id' => Auth::id(),
                    'activity' => $activity,
                    'changes' => json_encode($changes),
                ];
                $logData['loggable_type'] = 'Admin';
                $logData['loggable_id'] = Auth::id();

                ActivityLog::create($logData);
            } else if (Auth::user()->type == '1') {
                $activity = 'Consignee ' . $user->id . ' details were updated';
                $logData = [
                    'user_id' => Auth::id(),
                    'activity' => $activity,
                    'changes' => json_encode($changes),
                ];
                $logData['loggable_type'] = 'Employee';
                $logData['loggable_id'] = Auth::id();

                ActivityLog::create($logData);
            }
        }


        return redirect()->back()->with('success', 'Client details updated successfully');
    }

    function archive_client($id)
    {
        $client = Consignee::findOrFail($id);

        $client->status = true;
        $client->save();

        if (Auth::user()->type == 'admin') {
            // Log activity
            $changes = $client->getChanges();
            $activity = 'Consignee ' . $client->id . ' were archived';
            $logData = [
                'user_id' => Auth::id(),
                'activity' => $activity,
                'changes' => json_encode($changes),
            ];
            $logData['loggable_type'] = 'Admin';
            $logData['loggable_id'] = Auth::id();

            ActivityLog::create($logData);

            return redirect()->back()->with('success', 'Consignee data archived successfully.');
        } else if (Auth::user()->type == 'employee') {

            // Log activity
            $changes = $client->getChanges();
            $activity = 'Consignee ' . $client->id . ' were archived';
            $logData = [
                'user_id' => Auth::id(),
                'activity' => $activity,
                'changes' => json_encode($changes),
            ];
            $logData['loggable_type'] = 'Employee';
            $logData['loggable_id'] = Auth::id();

            ActivityLog::create($logData);

            return redirect()->back()->with('success', 'Consignee data archived successfully.');
        }
    }

    function restore_client($id)
    {
        $client = Consignee::findOrFail($id);

        $client->status = false;
        $client->save();

        if (Auth::user()->type == 'admin') {
            // Log activity
            $changes = $client->getChanges();
            $activity = 'Consignee ' . $client->id . ' were restored';
            $logData = [
                'user_id' => Auth::id(),
                'activity' => $activity,
                'changes' => json_encode($changes),
            ];
            $logData['loggable_type'] = 'Admin';
            $logData['loggable_id'] = Auth::id();

            ActivityLog::create($logData);

            return redirect()->back()->with('success', 'Consignee data restored successfully.');
        } else if (Auth::user()->type == 'employee') {

            // Log activity
            $changes = $client->getChanges();
            $activity = 'Consignee ' . $client->id . ' were restored';
            $logData = [
                'user_id' => Auth::id(),
                'activity' => $activity,
                'changes' => json_encode($changes),
            ];
            $logData['loggable_type'] = 'Employee';
            $logData['loggable_id'] = Auth::id();

            ActivityLog::create($logData);

            return redirect()->back()->with('success', 'Consignee data restored successfully.');
        }
    }

    function open_shipment($id)
    {
        $consignee = Consignee::findOrFail($id);
        $shipments = Shipment::where('consignee_name', $consignee->user->name)->get();
        $shipping_lines = DB::table('datasets')->pluck('shipping_line')->unique();
        $files = File::all();

        return view('admin.clientPanel.open_shipments', compact('consignee', 'shipments', 'shipping_lines', 'files'));
    }

    function close_shipment($id)
    {
        $consignee = Consignee::findOrFail($id);
        $shipments = Dataset::where('consignee_name', $consignee->user->name)->get();
        $files = File::all();

        return view('admin.clientPanel.close_shipments', compact('consignee', 'shipments', 'files'));
    }

    function consignee_dashboard()
    {
        $user = User::where('name', Auth::user()->name)->first();
        $databaseName = 'client_' . $user->id;

        DB::purge('client');
        Config::set('database.connections.client', [
            'driver' => 'mysql',
            'host' => env('DB_HOST', 'localhost'),
            'port' => env('DB_PORT', '3306'),
            'database' => $databaseName,
            'username' => env('DB_USERNAME', 'root'),
            'password' => env('DB_PASSWORD', ''),
            'charset' => 'utf8mb4',
            'collation' => 'utf8mb4_unicode_ci',
            'prefix' => '',
            'strict' => false,
            'engine' => null,
        ]);

        // Reconnect to the client's database
        DB::reconnect('client');

        $shipments = DB::connection('client')->table('shipments')->orderBy('arrival_date', 'desc')->where('consignee_name', Auth::user()->name)
            ->take(5)
            ->get();

        $OnProcess = DB::connection('client')->table('shipments')->where('status', false)->whereNull('predicted_delivery_date')->count();
        $ToDeliver = DB::connection('client')->table('shipments')->where('status', false)->whereNotNull('predicted_delivery_date')->count();
        $Closed = DB::connection('client')->table('shipments')->where('status', true)->count();

        $notifications = auth()->user()->notifications->sortByDesc('created_at');
        $latestNotification = $notifications->first();

        return view('clients.dashboard', compact('shipments', 'notifications', 'latestNotification', 'OnProcess', 'ToDeliver', 'Closed'));
    }

    function consignee_open_shipment()
    {
        $user = User::where('name', Auth::user()->name)->first();
        $databaseName = 'client_' . $user->id;

        DB::purge('client');
        Config::set('database.connections.client', [
            'driver' => 'mysql',
            'host' => env('DB_HOST', 'localhost'),
            'port' => env('DB_PORT', '3306'),
            'database' => $databaseName,
            'username' => env('DB_USERNAME', 'root'),
            'password' => env('DB_PASSWORD', ''),
            'charset' => 'utf8mb4',
            'collation' => 'utf8mb4_unicode_ci',
            'prefix' => '',
            'strict' => false,
            'engine' => null,
        ]);

        // Reconnect to the client's database
        DB::reconnect('client');

        // Select shipments with status = true from the shipment table
        $shipments = DB::connection('client')->table('shipments')->where('status', false)->get();

        $files = File::all();
        return view('clients.open_shipments', compact('shipments', 'files'));
    }

    function consignee_close_shipment()
    {
        $user = User::where('name', Auth::user()->name)->first();
        $databaseName = 'client_' . $user->id;

        DB::purge('client');
        Config::set('database.connections.client', [
            'driver' => 'mysql',
            'host' => env('DB_HOST', 'localhost'),
            'port' => env('DB_PORT', '3306'),
            'database' => $databaseName,
            'username' => env('DB_USERNAME', 'root'),
            'password' => env('DB_PASSWORD', ''),
            'charset' => 'utf8mb4',
            'collation' => 'utf8mb4_unicode_ci',
            'prefix' => '',
            'strict' => false,
            'engine' => null,
        ]);

        // Reconnect to the client's database
        DB::reconnect('client');

        // Select shipments with status = true from the shipment table
        $shipments = DB::connection('client')->table('shipments')->where('status', true)->get();

        $files = File::all();

        return view('clients.close_shipments', compact('shipments', 'files'));
    }


    public function downloadCsv()
    {
        $data = Shipment::where('consignee_name', '=', Auth::user()->name)->get()->merge(Dataset::where('consignee_name', Auth::user()->name)->get());

        $headers = [
            'Content-type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename=shipment_record.csv',
        ];

        $callback = function () use ($data) {
            $file = fopen('php://output', 'w');
            fputcsv($file, ['Entry Number', 'BL Number', 'Consignee Name', 'Shipping Line', 'Arrival Date', 'Process Start', 'Process End', 'Predicted Delivery Date', 'Actual Delivery Date', 'Port of Discharge', 'Size of Shipment', 'Weight of Shipment', 'Description of Shipment']);

            foreach ($data as $shipment) {
                $shipment->arrival_date = date('Y-m-d', strtotime($shipment->arrival_date));
                $shipment->process_started = date('Y-m-d', strtotime($shipment->process_started));
                $shipment->process_finished = date('Y-m-d', strtotime($shipment->process_finished));
                $shipment->predicted_delivery_date = date('Y-m-d', strtotime($shipment->predicted_delivery_date));
                $shipment->delivered_date = date('Y-m-d', strtotime($shipment->delivered_date));
                fputcsv($file, [$shipment->entry_number, $shipment->bl_number, $shipment->consignee_name, $shipment->shipping_line, $shipment->arrival_date, $shipment->process_started, $shipment->process_finished, $shipment->predicted_delivery_date, $shipment->delivered_date, $shipment->port_of_origin, $shipment->size, $shipment->weight, $shipment->shipment_details]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    public function downloadCsv_by_date(Request $request)
    {
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');

        $shipments = Shipment::where('consignee_name', '=', Auth::user()->name)
            ->orWhere('consignee_name', '=', Auth::user()->name)
            ->whereBetween('arrival_date', [$startDate, $endDate])
            ->get();

        $headers = [
            'Content-type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename=shipment_record.csv',
        ];

        $callback = function () use ($shipments) {
            $file = fopen('php://output', 'w');
            fputcsv($file, ['Entry Number', 'BL Number', 'Consignee Name', 'Shipping Line', 'Arrival Date', 'Process Start', 'Process End', 'Predicted Delivery Date', 'Actual Delivery Date', 'Port of Discharge', 'Size of Shipment', 'Weight of Shipment', 'Description of Shipment']);

            foreach ($shipments as $shipment) {
                $shipment->arrival_date = date('Y-m-d', strtotime($shipment->arrival_date));
                $shipment->process_started = date('Y-m-d', strtotime($shipment->process_started));
                $shipment->process_finished = date('Y-m-d', strtotime($shipment->process_finished));
                $shipment->predicted_delivery_date = date('Y-m-d', strtotime($shipment->predicted_delivery_date));
                $shipment->delivered_date = date('Y-m-d', strtotime($shipment->delivered_date));

                fputcsv($file, [$shipment->entry_number, $shipment->bl_number, $shipment->consignee_name, $shipment->shipping_line, $shipment->arrival_date, $shipment->process_started, $shipment->process_finished, $shipment->predicted_delivery_date, $shipment->delivered_date, $shipment->port_of_origin, $shipment->size, $shipment->weight, $shipment->item_description]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    public function markAsRead($id)
    {
        $notification = Notification::findOrFail($id);

        $notification->read_at = now();
        $notification->save();

        return redirect()->back();
    }
}
