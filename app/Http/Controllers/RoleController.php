<?php

namespace App\Http\Controllers;

use App\Models\Role;
use Illuminate\Http\Request;

class RoleController extends Controller
{
    public function index()
    {
        // Fetch all roles
        $roles = Role::paginate(10); // Adjust as per your pagination requirement
        return view('roles.index', compact('roles'));
    }

    public function create()
    {
        // Return view for creating a new role
        return view('roles.create');
    }

    public function store(Request $request)
    {
        // Validate request data
        $validatedData = $request->validate([
            'name' => 'required',
            'description' => 'required',
            // Add validation rules for permissions if needed
        ]);

        // Create new role
        $role = Role::create($validatedData);

        // Redirect back with success message
        return redirect('/roles')->with('success', 'Role created successfully.');
    }

    public function edit($id)
    {
        // Find role by ID and pass it to edit view
        $role = Role::findOrFail($id);
        return view('roles.edit', compact('role'));
    }

    public function update(Request $request, $id)
    {
        // Validate request data
        $validatedData = $request->validate([
            'name' => 'required',
            'description' => 'required',
            // Add validation rules for permissions if needed
        ]);

        // Find role by ID and update
        $role = Role::findOrFail($id);
        $role->update($validatedData);

        // Redirect back with success message
        return redirect('/roles')->with('success', 'Role updated successfully.');
    }

    public function delete($id)
    {
        // Find role by ID and delete
        $role = Role::findOrFail($id);
        $role->delete();

        // Redirect back with success message
        return redirect('/roles')->with('success', 'Role deleted successfully.');
    }
}
