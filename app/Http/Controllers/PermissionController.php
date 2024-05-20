<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Permission;
use App\Models\Module;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;

class PermissionController extends Controller
{
    // Display a listing of permissions
    public function index(Request $request)
    {
        // Initialize query for fetching permissions
        $query = Permission::query();

        // Filter permissions by name if search term is provided
        if ($request->has('search')) {
            $query->where('name', 'like', '%' . $request->input('search') . '%');
        }

        // Filter permissions by status if status parameter is provided
        if ($request->has('status') && $request->input('status') != 'all') {
            $query->where('is_active', $request->input('status') == 'active' ? 1 : 0);
        }

        // Get paginated permissions ordered by ID in descending order
        $permissions = $query->orderBy('id', 'desc')->paginate(10);

        // Return permissions index view with permissions data
        return view('permissions.index', compact('permissions'));
    }

    // Show the form for creating a new permission
    public function create()
    {
        // Fetch all modules
        $modules = Module::all();
        return view('permissions.create', ['modules' => $modules]);
    }

    // Store a newly created permission in the database
    public function store(Request $request)
    {
        // dd($request);
        // Validate the incoming request data
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'permissions' => 'required|array',
        ]);

        // Create a new permission
        $permission = Permission::create([
            'name' => $request->name,
            'description' => $request->description,
        ]);

        // Assign module-wise permissions
        foreach ($request->permissions as $moduleId => $modulePermissions) {
            $module = Module::where('code', $moduleId)->first();

            // If module exists, insert permission module record
            if ($module) {
                DB::table('permission_modules')->insert([
                    'permission_id' => $permission->id,
                    'module_code' => $moduleId,
                    'create' => isset($modulePermissions['create']) ? 1 : 0,
                    'edit' => isset($modulePermissions['edit']) ? 1 : 0,
                    'view' => isset($modulePermissions['view']) ? 1 : 0,
                    'delete' => isset($modulePermissions['delete']) ? 1 : 0,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            } else {
                // Log a warning if module does not exist
                Log::warning("Module with code '$moduleId' does not exist.");
            }
        }
        return redirect()->route('permissions.index')->with('success', 'Permission created successfully.');
    }

    // Show the form for editing
    public function edit($id)
    {
        // Find the permission by ID
        $permission = Permission::with('modules')->findOrFail($id);
        // dd($permission);

        // Fetch all modules
        $modules = Module::all();
        return view('permissions.edit', compact('permission', 'modules'));
    }

    // Update the specified permission in the database
    public function update(Request $request, $id)
    {
        // Validate the incoming request data
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'permissions' => 'nullable|array',
        ]);

        // Find the permission by ID
        $permission = Permission::findOrFail($id);
        $permission->update([
            'name' => $request->input('name'),
            'description' => $request->input('description'),
            'user_id' => Auth::User()->id,
        ]);

        // Process module-wise permissions
        $permissions = $request->input('permissions', []);

        foreach ($permissions as $moduleCode => $permissionData) {
            // Check if any action is selected for this module
            if (in_array(true, $permissionData)) {
                // Find or create the permission module record
                $permissionModule = $permission->permissionModules()->updateOrCreate(
                    ['module_code' => $moduleCode],
                    [
                        'create' => isset($permissionData['create']),
                        'edit' => isset($permissionData['edit']),
                        'view' => isset($permissionData['view']),
                        'delete' => isset($permissionData['delete']),
                    ],
                );
            } else {
                // If no action is selected, delete existing permission for this module
                $permission->permissionModules()->where('module_code', $moduleCode)->delete();
            }
        }

        return redirect()->route('permissions.index')->with('success', 'Permission updated successfully.');
    }

    // Toggle the status
    public function toggleStatus($permission_id, Request $request)
    {
        // Find the permission by ID
        $permission = Permission::findOrFail($permission_id);
        // dd($permission);
        // Update the status of the permission
        $permission->is_active = $request->status;
        $permission->save();

        return response()->json(['message' => 'Status updated successfully']);
    }

    // Show the form for editing
    public function editPermission($permissionId)
    {
        // Find the permission by ID
        $permission = Permission::findOrFail($permissionId);
        // Fetch all modules
        $modules = Module::all();

        return view('edit_permission', [
            'permission' => $permission,
            'modules' => $modules,
        ]);
    }

    // Remove the specified permission
    public function destroy($id)
    {
        // Find the permission by ID
        $permission = Permission::findOrFail($id);

        // Delete the permission
        $permission->delete();

        return redirect()->route('permissions.index')->with('success', 'Permission deleted successfully.');
    }
}
