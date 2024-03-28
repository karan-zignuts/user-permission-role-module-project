<?php

namespace App\Http\Controllers;

use App\Models\Role;
use Illuminate\Http\Request;
use App\Models\Permission;

class RoleController extends Controller
{
  public function index(Request $request)
  {
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

    $roles = $query->paginate(10);

    return view('roles.index', compact('roles'));
  }

  public function create()
  {
    $permissions = Permission::all();
    return view('roles.create', ['permissions' => $permissions]);
  }

  public function store(Request $request)
  {
    // Validate the incoming request data
    $request->validate([
      'name' => 'required|string|max:255',
      'description' => 'nullable|string|max:255',
      'permissions' => 'nullable|array', // Assuming permissions are optional
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
    return redirect()->route('roles.index')->with('success', 'Role created successfully.');
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
  public function updateStatus(Request $request)
  {
    $role = Role::find($request->role_id);
    if (!$role) {
      return response()->json(['error' => 'Role not found'], 404);
    }

    $role->is_active = $request->status;
    $role->save();

    return response()->json(['success' => 'Role status updated successfully']);
  }
}
