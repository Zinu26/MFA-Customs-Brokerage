<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Employee;

class UserController extends Controller
{
    function admin_page(){
        $users = User::where('type', 0)->get();
        return view('admin.adminPanel.admin_page')->with('users', $users);
    }

    function employee_page(){
        $users = User::where('type', 1)->get();
        $employees = Employee::all();
        return view('admin.employeePanel.employee_page', compact('users', 'employees'));
    }

    function admin_archived_list(){
        $users = User::where('type', 0)->get();
        return view('admin.adminPanel.archive_list')->with('users', $users);
    }

    function employee_archived_list(){
        $users = User::where('type', 1)->get();
        $employees = Employee::all();
        return view('admin.employeePanel.archive_list', compact('users', 'employees'));
    }

    function add_admin(Request $request){
        // Validate form input
        $request->validate([
            'name' => 'required|string|max:255',
            'username' => 'required|string|unique:users,username|max:255',
            'email' => 'required|string|unique:users,email|max:255',
            'password' => 'required|string|min:8',
        ]);

        // Create new user
        $user = new User;
        $user->name = $request->input('name');
        $user->username = $request->input('username');
        $user->email = $request->input('email');
        $user->password = bcrypt($request->input('password'));
        $user->type = 0; // Assuming you want to create an admin user
        $user->save();

        // Redirect to success page
        return redirect()->route('admin_list')->with('success', 'Admin added successfully!');
    }

    function add_employee(Request $request){
        // Validate form input
        $request->validate([
            'name' => 'required|string|max:255',
            'position' => 'required|string|max:255',
            'birthdate' => 'required|date',
            'contact_number' => 'required|string|max:20',
            'email' => 'required|string|email|max:255',
            'username' => 'required|string|unique:users,username|max:255',
            'password' => 'required|string|min:8',
        ]);

        // Create new user
        $user = new User;
        $user->name = $request->input('name');
        $user->username = $request->input('username');
        $user->email = $request->input('email');
        $user->password = bcrypt($request->input('password'));
        $user->type = 1; // Assuming you want to create an employee user
        $user->save();

        $employee = new Employee;
        $employee->user_id = $user->id; // Store the user ID in the employee table
        $employee->position = $request->input('position');
        $employee->birthdate = $request->input('birthdate');
        $employee->contact_number = $request->input('contact_number');
        $employee->save();

        // Redirect to success page
        return redirect()->route('employee_list')->with('success', 'Employee added successfully!');
    }

    public function edit_admin(Request $request, $id)
    {
        $user = User::findOrFail($id);

        // update the user data with the submitted form data
        $user->name = $request->input('name');
        $user->username = $request->input('username');
        $user->password = bcrypt($request->input('password')); // make sure to hash the password

        $user->save();

        return redirect()->back()->with('success', 'Admin details have been updated successfully.');
    }

    public function edit_employee(Request $request, $id)
    {
        // Validate the incoming request data
        $validatedData = $request->validate([
            'name' => 'required',
            'position' => 'required',
            'birthdate' => 'required',
            'contact' => 'required',
            'email' => 'required|email',
            'username' => 'required',
            'password' => 'required|min:8'
        ]);

        // Update the user table data
        $user = User::find($id);
        $user->name = $validatedData['name'];
        $user->username = $validatedData['username'];
        $user->password = bcrypt($validatedData['password']);
        $user->save();

        // Update the employee table data
        $employee = Employee::where('user_id', $id)->first();
        $employee->position = $validatedData['position'];
        $employee->birthdate = $validatedData['birthdate'];
        $employee->contact_number = $validatedData['contact'];
        $employee->email = $validatedData['email'];
        $employee->save();

        return redirect()->back()->with('success', 'Employee details have been updated successfully.');
    }

    function archive_user($id)
    {
        $user = User::findOrFail($id);

        $user->isArchived = true;
        $user->save();

        return redirect()->back()->with('warning', 'User data archived successfully.');
    }

    function restore_user($id)
    {
        $user = User::findOrFail($id);

        $user->isArchived = false;
        $user->save();

        return redirect()->back()->with('success', 'User data restored successfully.');
    }

}
