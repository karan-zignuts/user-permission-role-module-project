<?php

namespace App\Http\Controllers;
use App\Models\Module;
use Illuminate\Http\Request;

class ModuleController extends Controller
{
    // Display a listing of the modules
    public function index(Request $request)
    {
        // Initialize the query to fetch modules with their children
        $query = Module::query()->with('children');

        // If there is a search term in the request, filter the modules based on the search term
        if ($request->has('search')) {
            $searchTerm = $request->input('search');
            $query->where(function ($query) use ($searchTerm) {
                $query->where('name', 'like', '%' . $searchTerm . '%')->orWhereHas('children', function ($query) use ($searchTerm) {
                    $query->where('name', 'like', '%' . $searchTerm . '%');
                });
            });
        }

        // If there is a status filter in the request, apply the status filter to the query
        if ($request->has('status') && $request->input('status') != 'all') {
            $status = $request->input('status') == 'active' ? 1 : 0;
            $query->where('is_active', $status);
        }

        // Get the modules that have no parent (top-level modules)
        $modules = $query->whereNull('parent_code')->get();

        // Return the modules index view with the modules data
        return view('modules.index', compact('modules'));
    }

    // Show the form for editing the specified module
    public function edit(Module $module)
    {
        // Return the module edit view with the module data
        return view('modules.edit', compact('module'));
    }

    // Update the specified module in the database
    public function update(Request $request, Module $module)
    {
        // Validate the incoming request data
        $request->validate([
            'name' => 'required',
            'description' => 'nullable',
        ]);

        // Update the module with validate data
        $module->update([
            'name' => $request->input('name'),
            'description' => $request->input('description'),
        ]);

        // Redirect to the modules index page
        return redirect()->route('modules.index')->with('success', 'Module updated successfully.');
    }

    // Toggle the status of the specified submodule
    public function toggleStatus($submoduleId, Request $request)
    {
        // dd($request->all());
        // Find the submodule by its ID or fail if not found
        $submodule = Module::findOrFail($submoduleId);

        // Update the submodule's status
        $submodule->is_active = $request->status;
        $submodule->save();

        return response()->json(['message' => 'Status updated successfully']);
    }
}
