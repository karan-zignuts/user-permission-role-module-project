<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Permission;

class PermissionController extends Controller
{
  public function index()
  {
    // dd('123');
      $permissions = Permission::paginate(10);
      return view('permissions.index', compact('permissions'));
  }

  public function create()
  {
    return view('permissions.create');
  }

  public function store(Request $request)
    {
      $request->validate([
        'name' => 'required|string|max:255',
        'description' => 'nullable|string',
      ]);

      Permission::create([
        'name' => $request->name,
        'description' => $request->description,
      ]);
      // dd($request->all());

        return redirect()->route('permissions.index')->with('success', 'Permission created successfully.');
    }

  public function edit($id)
  {
    $permission = Permission::findOrFail($id);
    return view('permissions.edit', compact('permission'));
  }

  public function update(Request $request, $id)
  {
    $request->validate([
      'name' => 'required|string|max:255',
      'description' => 'nullable|string',
      'is_active' => 'required|boolean',
    ]);

    $permission = Permission::findOrFail($id);
    $permission->update($request->all());

    return redirect()->route('permissions.index');
  }

  public function destroy($id)
  {
    $permission = Permission::findOrFail($id);
    $permission->delete();

    return redirect()->route('permissions.index');
  }
}
