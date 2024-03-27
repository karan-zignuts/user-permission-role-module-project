<?php

namespace App\Http\Controllers;
use App\Models\Module;
use Illuminate\Http\Request;

class ModuleController extends Controller
{
  public function index(Request $request)
  {
    $query = Module::query()->with('children');

    if ($request->has('search')) {
      $searchTerm = $request->input('search');
      $query->where(function ($query) use ($searchTerm) {
        $query
          ->where('name', 'like', '%' . $searchTerm . '%')
          ->orWhereHas('children', function ($query) use ($searchTerm) {
            $query->where('name', 'like', '%' . $searchTerm . '%');
          });
      });
    }

    if ($request->has('status') && $request->input('status') != 'all') {
      $status = $request->input('status') == 'active' ? 1 : 0;
      $query->where('is_active', $status);
    }

    $modules = $query->whereNull('parent_code')->get();

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

    return redirect()
      ->route('modules.index')
      ->with('success', 'Module updated successfully.');
  }

  public function toggleStatus($submoduleId, Request $request)
  {
    // dd($request->all());
    $submodule = Module::findOrFail($submoduleId);
    $submodule->is_active = $request->status;
    $submodule->save();
    return response()->json(['message' => 'Status updated successfully']);
  }
}
