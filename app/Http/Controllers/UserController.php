<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Employee;
use App\Models\ActivityLog;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;


class UserController extends Controller
{
    function admin_page()
    {
        $users = User::where('type', 0)->get();
        return view('admin.adminPanel.admin_page')->with('users', $users);
    }

    function employee_page()
    {
        $users = User::where('type', 1)->get();
        $employees = Employee::all();
        return view('admin.employeePanel.employee_page', compact('users', 'employees'));
    }

    function admin_archived_list()
    {
        $users = User::where('type', 0)->get();
        return view('admin.adminPanel.archive_list')->with('users', $users);
    }

    function employee_archived_list()
    {
        $users = User::where('type', 1)->get();
        $employees = Employee::all();
        return view('admin.employeePanel.archive_list', compact('users', 'employees'));
    }

    function add_admin(Request $request)
    {
        // Validate form input
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'username' => 'required|string|unique:users,username|max:255',
            'email' => 'required|string|unique:users,email|max:255',
            'password' => 'required|string|min:8',
        ], [
            'username.unique' => 'Username has already been taken.',
            'email.unique' => 'Email has already been taken.',
            'password.min' => 'The password must be at least 8 characters long.',
        ]);

        // Create new user
        $user = new User;
        $user->name = $validatedData['name'];
        $user->username = $validatedData['username'];
        $user->email = $validatedData['email'];
        $user->password = bcrypt($validatedData['password']);
        $user->type = 0; // Assuming you want to create an admin user
        $user->save();

        // Create activity log
        ActivityLog::create([
            'user_id' => Auth::id(),
            'loggable_id' => $user->id,
            'loggable_type' => 'User',
            'activity' => 'Admin Added',
            'changes' => json_encode($user),
        ]);

        // Redirect to success page
        return redirect()->route('admin_list')->with('success', 'Admin added successfully!');
    }

    function add_employee(Request $request)
    {
        // Validate form input
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'position' => 'required|string|max:255',
            'birthdate' => 'required|date',
            'contact_number' => 'required|string|max:20',
            'username' => 'required|string|unique:users,username|max:255',
            'email' => 'required|string|unique:users,email|max:255',
            'password' => 'required|string|min:8',
        ], [
            'username.unique' => 'Username has already been taken.',
            'email.unique' => 'Email has already been taken.',
            'password.min' => 'The password must be at least 8 characters long.',
        ]);

        // Create new user
        $user = new User;
        $user->name = $validatedData['name'];
        $user->username = $validatedData['username'];
        $user->email = $validatedData['email'];
        $user->password = bcrypt($validatedData['password']);
        $user->type = 1; // Assuming you want to create an employee user
        $user->save();

        $employee = new Employee;
        $employee->user_id = $user->id; // Store the user ID in the employee table
        $employee->position = $validatedData['position'];
        $employee->birthdate = $validatedData['birthdate'];
        $employee->contact_number = $validatedData['contact_number'];
        $employee->save();

        // Create activity log
        $changes = [
            'user' => $user->toJson(),
            'employee' => $employee->toJson(),
        ];

        // Create activity log
        ActivityLog::create([
            'user_id' => Auth::id(),
            'loggable_id' => $user->id,
            'loggable_type' => 'User',
            'activity' => 'Employee Added',
            'changes' => json_encode($changes),
        ]);

        // Redirect to success page
        return redirect()->route('employee_list')->with('success', 'Employee added successfully!');
    }

    public function edit_admin(Request $request, $id)
    {
        // Validate form input
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255',
            'username' => 'required|string|max:255',
        ]);

        $user = User::findOrFail($id);
        // Update the user data with the submitted form data
        $user->name = $validatedData['name'];

        // Check if the submitted username is already taken
        if ($user->username != $validatedData['username'] && User::where('username', $validatedData['username'])->exists()) {
            return redirect()->back()->with('error', 'Username has already been taken.');
        }
        $user->username = $validatedData['username'];

        if ($user->email != $validatedData['email'] && User::where('email', $validatedData['email'])->exists()) {
            return redirect()->back()->with('error', 'Email has already been taken.');
        }
        $user->email = $validatedData['email'];

        // Save the updated user data
        $user->save();

        // Check if any changes were made
        $changes = $user->getChanges();
        if (empty($changes)) {
            return redirect()->back()->with('warning', 'No changes were made to the admin details.');
        }

        // Log activity
        $activity = 'Admin ' . $user->id . ' details were updated';
        $logData = [
            'user_id' => Auth::id(),
            'activity' => $activity,
            'changes' => json_encode($changes),
        ];
        $logData['loggable_type'] = 'Admin';
        $logData['loggable_id'] = Auth::id();

        ActivityLog::create($logData);

        return redirect()->back()->with('success', 'Admin details have been updated successfully.');
    }


    public function edit_employee(Request $request, $id)
    {
        // Update the user table data
        $user = User::find($id);

        // Validate the incoming request data
        $validatedData = $request->validate([
            'name' => 'required',
            'position' => 'required',
            'birthdate' => 'required',
            'contact' => 'required',
            'email' => 'required|email',
            'username' => 'required',
        ]);

        // Check if the submitted username is already taken
        if ($user->username != $validatedData['username'] && User::where('username', $validatedData['username'])->exists()) {
            return redirect()->back()->with('error', 'Username has already been taken.');
        }
        $user->username = $validatedData['username'];

        if ($user->email != $validatedData['email'] && User::where('email', $validatedData['email'])->exists()) {
            return redirect()->back()->with('error', 'Email has already been taken.');
        }
        $user->email = $validatedData['email'];
        $user->name = $validatedData['name'];
        $user->save();

        // Update the employee table data
        $employee = Employee::where('user_id', $id)->first();
        $employee->position = $validatedData['position'];
        $employee->birthdate = $validatedData['birthdate'];
        $employee->contact_number = $validatedData['contact'];
        $employee->save();

        $changes_user = $user->getChanges();
        $changes_employee = $employee->getChanges();
        $changes = [
            json_encode($changes_user),
            json_encode($changes_employee),
        ];
        if (empty($changes_user) && empty($changes_employee)) {
            return redirect()->back()->with('warning', 'No changes were made to the employee details.');
        }
        // Log activity
        else {
            $activity = 'Employee ' . $user->id . ' details were updated';
            $logData = [
                'user_id' => Auth::id(),
                'activity' => $activity,
                'changes' => json_encode($changes),
            ];
            $logData['loggable_type'] = 'Admin';
            $logData['loggable_id'] = Auth::id();

            ActivityLog::create($logData);
        }

        return redirect()->back()->with('success', 'Employee details have been updated successfully.');
    }

    function archive_user($id)
    {
        $user = User::findOrFail($id);

        $user->isArchived = true;
        $user->save();

        if ($user->type == "admin") {
            // Log activity
            $changes = $user->getChanges();
            $activity = 'Admin ' . $user->id . ' were archived';
            $logData = [
                'user_id' => Auth::id(),
                'activity' => $activity,
                'changes' => json_encode($changes),
            ];
            $logData['loggable_type'] = 'Admin';
            $logData['loggable_id'] = Auth::id();

            ActivityLog::create($logData);

            return redirect()->back()->with('success', 'Admin data archived successfully.');
        } else if ($user->type == "employee") {

            // Log activity
            $changes = $user->getChanges();
            $activity = 'Employee ' . $user->id . ' were archived';
            $logData = [
                'user_id' => Auth::id(),
                'activity' => $activity,
                'changes' => json_encode($changes),
            ];
            $logData['loggable_type'] = 'Admin';
            $logData['loggable_id'] = Auth::id();

            ActivityLog::create($logData);

            return redirect()->back()->with('success', 'Employee data archived successfully.');
        }
    }

    function restore_user($id)
    {
        $user = User::findOrFail($id);

        $user->isArchived = false;
        $user->save();

        if ($user->type == "admin") {
            // Log activity
            $changes = $user->getChanges();
            $activity = 'Admin ' . $user->id . ' were restored';
            $logData = [
                'user_id' => Auth::id(),
                'activity' => $activity,
                'changes' => json_encode($changes),
            ];
            $logData['loggable_type'] = 'Admin';
            $logData['loggable_id'] = Auth::id();

            ActivityLog::create($logData);

            return redirect()->back()->with('success', 'Admin data restored successfully.');
        } else if ($user->type == "employee") {

            // Log activity
            $changes = $user->getChanges();
            $activity = 'Employee ' . $user->id . ' were restored';
            $logData = [
                'user_id' => Auth::id(),
                'activity' => $activity,
                'changes' => json_encode($changes),
            ];
            $logData['loggable_type'] = 'Admin';
            $logData['loggable_id'] = Auth::id();

            ActivityLog::create($logData);

            return redirect()->back()->with('success', 'Employee data restored successfully.');
        }
    }
}
