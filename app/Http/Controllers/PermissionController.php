<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Permission;
use App\Models\Module;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class PermissionController extends Controller
{
  public function index(Request $request)
  {
    $query = Permission::query();

    if ($request->has('search')) {
      $query->where('name', 'like', '%' . $request->input('search') . '%');
    }

    if ($request->has('status') && $request->input('status') != 'all') {
      $query->where('is_active', $request->input('status') == 'active' ? 1 : 0);
    }

    $permissions = $query->paginate(10);

    return view('permissions.index', compact('permissions'));
  }

  public function create()
  {
    // return view('permissions.create');

    $modules = Module::all();

    return view('permissions.create', ['modules' => $modules]);
  }

  public function store(Request $request)
  {
    // dd($request->all());
    $request->validate([
      'name' => 'required|string|max:255',
      'description' => 'nullable|string',
      'permissions' => 'required|array',
    ]);

    $permission = Permission::create([
      'name' => $request->name,
      'description' => $request->description,
    ]);

    foreach ($request->permissions as $moduleId => $modulePermissions) {
      $module = Module::where('code', $moduleId)->first();

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
        Log::warning("Module with code '$moduleId' does not exist.");
      }
    }
    return redirect()
      ->route('permissions.index')
      ->with('success', 'Permission created successfully.');
  }

  public function edit($id)
  {
    $permission = Permission::with('modules')->findOrFail($id);
    dd($permission);
    $modules = Module::all();
    return view('permissions.edit', compact('permission', 'modules'));
  }

  public function update(Request $request, $id)
  {
    $request->validate([
      'name' => 'required|string|max:255',
      'description' => 'nullable|string',
    ]);

    $permission = Permission::findOrFail($id);
    $permission->update($request->all());
    // dd($request->all());
    return redirect()->route('permissions.index');
  }

  public function destroy($id)
  {
    $permission = Permission::findOrFail($id);
    $permission->delete();

    return redirect()->route('permissions.index');
  }

  public function toggleStatus($permission_id, Request $request)
  {
    $permission = Permission::findOrFail($permission_id);
    // dd($permission);
    $permission->is_active = $request->status;
    $permission->save();

    return response()->json(['message' => 'Status updated successfully']);
  }

  public function editPermission($permissionId)
  {
    $permission = Permission::findOrFail($permissionId);
    $modules = Module::all(); // Fetch all modules

    return view('edit_permission', [
      'permission' => $permission,
      'modules' => $modules,
      // You may need to pass more data depending on your application logic
    ]);
  }
}
