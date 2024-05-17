<?php
namespace App\Http\Controllers;

use App\Models\People;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Auth;

class PeoplesController extends Controller
{
    // public function index(Request $request)
    // {
    //     // dd($request);
    //     $people = People::all();

    //     return view('/contact/people/people_index', compact('people'));
    // }

    // public function create()
    // {
    //     return view('/contact/people/people_create');
    // }

    // public function store(Request $request)
    // {
    //     if (!$request->user()->hasUserAccess('1.2', 'add')) {
    //         return abort(403, 'Unauthorized');
    //     }
    //     $validatedData = $request->validate([
    //         'name' => 'required',
    //         'designation' => 'required',
    //         'address' => 'required',
    //         'contact_no' => 'required',
    //         'email' => 'required|email',
    //     ]);

    //     People::create($validatedData);

    //     return redirect()->route('/contact/people/people_index');
    // }

    // public function edit($id)
    // {
    //     // Implement permissions check here
    //     $person = People::findOrFail($id);

    //     return view('people.edit', compact('person'));
    // }

    // public function update(Request $request, $id)
    // {
    //     $validatedData = $request->validate([
    //         'name' => 'required',
    //         'designation' => 'required',
    //         'address' => 'required',
    //         'contact_no' => 'required',
    //         'email' => 'required|email',
    //     ]);

    //     $person = People::findOrFail($id);
    //     $people->update($validatedData);

    //     return redirect()->route('people.index');
    // }

    // public function destroy($id)
    // {
    //     $person = People::findOrFail($id);
    //     $person->delete();

    //     return redirect()->route('people.index');
    // }

    public function index(Request $request)
    {
        $editBtn = Auth::user()->hasUserAccess(1.2, 'edit');
        $deleteBtn = Auth::user()->hasUserAccess(1.2, 'delete');
        $createBtn = Auth::user()->hasUserAccess(1.2, 'create');

        $query = People::query();

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

        $people = $query->where('user_id', Auth::id())->paginate(10);
        return view('/contact/people/people_index', compact('people', 'editBtn', 'deleteBtn', 'createBtn'));
    }

    public function create()
    {
        return view('/contact/people/people_create');
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required',
            'designation' => 'required',
            'address' => 'required',
            'phone_number' => 'required',
            'email' => 'required|email',
        ]);

        People::create([
            'name' => $request->name,
            'designation' => $request->designation,
            'address' => $request->address,
            'phone_number' => $request->phone_number,
            'email' => $request->email,
            'user_id' => Auth::User()->id,
        ]);

        return redirect()->route('people.index');
    }

    public function edit($id)
    {
        // dd('hii');

        // dd($editBtn);
        $person = People::findOrFail($id);
        return view('/contact/people/people_edit', compact('person'));
    }

    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'name' => 'required',
            'designation' => 'required',
            'address' => 'required',
            'phone_number' => 'required',
            'email' => 'required|email',
        ]);

        // dd($validatedData);
        $person = People::findOrFail($id);
        $person->update([
            'name' => $request->name,
            'designation' => $request->designation,
            'address' => $request->address,
            'phone_number' => $request->phone_number,
            'email' => $request->email,
            'user_id' => Auth::User()->id,
        ]);

        return redirect()->route('people.index');
    }

    public function destroy($id)
    {
        $person = People::findOrFail($id);
        $person->delete();
        return redirect()->route('people.index');
    }
    public function updateStatus(Request $request)
    {
        $people = People::find($request->person_id);
        if (!$people) {
            return response()->json(['error' => 'People not found'], 404);
        }

        $people->is_active = $request->status;
        $people->save();

        return response()->json(['success' => 'Role status updated successfully']);
    }
}
