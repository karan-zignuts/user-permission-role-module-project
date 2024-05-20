<?php
namespace App\Http\Controllers;

use App\Models\People;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Auth;

class PeoplesController extends Controller
{
    // Display a listing of the people
    public function index(Request $request)
    {
        // Check user permissions for edit, delete, and create actions
        $editBtn = Auth::user()->hasUserAccess(1.2, 'edit');
        $deleteBtn = Auth::user()->hasUserAccess(1.2, 'delete');
        $createBtn = Auth::user()->hasUserAccess(1.2, 'create');

        // Initialize the query for people
        $query = People::query();

        // Search by name if the search term is provided
        if ($request->has('search')) {
            $search = $request->input('search');
            $query->where('name', 'like', "%$search%");
        }

        // Search by name if the search term is provided
        $status = $request->input('status');
        if ($status === 'active') {
            $query->where('is_active', true);
        } elseif ($status === 'inactive') {
            $query->where('is_active', false);
        }

        // Fetch the people records for the authenticated user and paginate the results
        $people = $query->where('user_id', Auth::id())->paginate(10);

        // Return the people index view with the people data and user permissions
        return view('/contact/people/people_index', compact('people', 'editBtn', 'deleteBtn', 'createBtn'));
    }

    // Show the form for creating a new person
    public function create()
    {
        return view('/contact/people/people_create');
    }

    // Store a newly created person in the database
    public function store(Request $request)
    {
        // Validate the incoming request data
        $validatedData = $request->validate([
            'name' => 'required',
            'designation' => 'required',
            'address' => 'required',
            'phone_number' => 'required',
            'email' => 'required|email',
        ]);

        // Create a new people with the validated data and associate it with the authenticated user
        People::create([
            'name' => $request->name,
            'designation' => $request->designation,
            'address' => $request->address,
            'phone_number' => $request->phone_number,
            'email' => $request->email,
            'user_id' => Auth::User()->id,
        ]);

        // Redirect to the people index page
        return redirect()->route('people.index');
    }

    // Show the form for editing the specified person
    public function edit($id)
    {
        // dd($editBtn);
        // Find the person by ID or fail if not found
        $person = People::findOrFail($id);
        return view('/contact/people/people_edit', compact('person'));
    }

    // Update the specified person in the database
    public function update(Request $request, $id)
    {
        // Validate the incoming request data
        $validatedData = $request->validate([
            'name' => 'required',
            'designation' => 'required',
            'address' => 'required',
            'phone_number' => 'required',
            'email' => 'required|email',
        ]);

        // dd($validatedData);
        // Find the person by ID or fail if not found
        $person = People::findOrFail($id);

        // Update the person with the validated data
        $person->update([
            'name' => $request->name,
            'designation' => $request->designation,
            'address' => $request->address,
            'phone_number' => $request->phone_number,
            'email' => $request->email,
            'user_id' => Auth::User()->id,
        ]);

        // Redirect to the people index page
        return redirect()->route('people.index');
    }

    // Remove the specified person from the database
    public function destroy($id)
    {
        // Find the person by ID or fail if not found
        $person = People::findOrFail($id);

        // Delete the person
        $person->delete();
        return redirect()->route('people.index');
    }

    // Update the status of the specified person
    public function updateStatus(Request $request)
    {
        // Find the person by ID or return error if not found
        $people = People::find($request->person_id);
        if (!$people) {
            return response()->json(['error' => 'People not found'], 404);
        }

        // Update the status of the person
        $people->is_active = $request->status;
        $people->save();

        return response()->json(['success' => 'Role status updated successfully']);
    }
}
