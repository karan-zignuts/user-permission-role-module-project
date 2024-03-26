<?php

namespace App\Http\Controllers;
use App\Models\Module;
use Illuminate\Http\Request;

class ModuleController extends Controller
{
  public function index(Request $request)
  {
    $query = Module::query();

    if ($request->has('search')) {
      $query->where('name', 'like', '%' . $request->input('search') . '%');
  }

  if ($request->has('status') && $request->input('status') != 'all') {
      $query->where('is_active', $request->input('status') == 'active' ? 1 : 0);
  }
    $modules = $query->paginate(10);

    return view('modules.index', compact('modules'));
  }

  public function edit(Module $module)
  {
    return view('modules.edit', compact('module'));
  }

  public function update(Request $request, Module $module)
  {
    $request->validate([
      'name' => 'required',
      'description' => 'nullable',
    ]);

    $module->update([
      'name' => $request->input('name'),
      'description' => $request->input('description'),
    ]);

    return redirect()->route('modules.index')->with('success', 'Module updated successfully.');
  }
  // public function changeStatus(Request $request)
  // {
  //     $module = Module::find($request->module_code);
  //     $module->is_active = $request->is_active;
  //     $module->save();

  //     return response()->json(['success'=>'Status change successfully.']);
  // }
}
