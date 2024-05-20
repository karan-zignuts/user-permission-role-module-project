<?php

namespace App\Http\Controllers;

use App\Models\Role;
use Illuminate\Http\Request;
use App\Models\Permission;

class RoleController extends Controller
{
    // Display a list of roles
    public function index(Request $request)
    {
        // Initialize a query builder for roles
        $query = Role::query();

        // Search by name
        if ($request->has('search')) {
            $search = $request->input('search');
            $query->where('name', 'like', "%$search%");
        }

        // Filter by status
        $status = $request->input('status');
        if ($status === 'active') {
            $query->where('is_active', true);
        } elseif ($status === 'inactive') {
            $query->where('is_active', false);
        }

        $roles = $query->paginate(5);
        // dd($roles);
        return view('roles.index', compact('roles'));
    }

    // Display form to create a new role
    public function create()
    {
        // Retrieve all permissions to assign to roles
        $permissions = Permission::all();
        return view('roles.create', ['permissions' => $permissions]);
    }

    // Store a newly created role in storage
    public function store(Request $request)
    {
        // Validate the incoming request data
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string|max:255',
            'permissions' => 'nullable|array',
        ]);

        // Create a new role instance
        $role = new Role();
        $role->name = $request->input('name');
        $role->description = $request->input('description');
        $role->save();

        // Attach permissions if provided
        if ($request->has('permissions')) {
            $role->permissions()->attach($request->input('permissions'));
        }

        // Redirect back or to any desired route after saving
        return redirect()->route('roles.index');
    }

    // Show the form for editing the specified role
    public function edit($id)
    {
        // Find role by ID
        $role = Role::findOrFail($id);

        // Retrieve all permissions from the database
        $permissions = Permission::all();

        return view('roles.edit', compact('role', 'permissions'));
    }

    // Update the specified role in storage
    public function update(Request $request, $id)
    {
        // Find role by ID
        $role = Role::findOrFail($id);

        // Validate incoming request data
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string|max:255',
            'permissions' => 'nullable|array',
        ]);

        // Update role data with validated inputs
        $role->update([
            'name' => $request->input('name'),
            'description' => $request->input('description'),
        ]);

        // Sync the selected permissions for the role
        $role->permissions()->sync($request->input('permissions', []));

        // Redirect to roles index with success message
        return redirect()->route('roles.index')->with('success', 'Role updated successfully');
    }

    // Remove the specified role from storage
    public function delete($id)
    {
        // Find role by ID and delete
        $role = Role::findOrFail($id);
        $role->delete();

        // Redirect back with success message
        return redirect('/roles');
    }

    // Update the status of a role
    public function updateStatus(Request $request)
    {
        // Find role by ID
        $role = Role::find($request->role_id);
        if (!$role) {
            return response()->json(['error' => 'Role not found'], 404);
        }

        // Update role status and save changes
        $role->is_active = $request->status;
        $role->save();

        return response()->json(['success' => 'Role status updated successfully']);
    }
}
