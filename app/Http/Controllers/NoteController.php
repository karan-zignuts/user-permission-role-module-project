<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Note;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Auth;

class NoteController extends Controller
{
    // Display a listing of the notes
    public function index(Request $request)
    {
        // Check user permissions for edit, delete, and create actions
        $editBtn = Auth::user()->hasUserAccess(2.1, 'edit');
        $deleteBtn = Auth::user()->hasUserAccess(2.1, 'delete');
        $createBtn = Auth::user()->hasUserAccess(2.1, 'create');

        // Get the search term from the request
        $search = $request->input('search');

        // Query notes, applying search filter if provided, and paginate the results
        $notes = Note::query()
            ->when($search, function ($query, $search) {
                return $query->where('name', 'like', "%$search%");
            })
            ->where('user_id', Auth::id())
            ->orderBy('id', 'desc')
            ->paginate(6);

        // Return the notes index view with the notes and user permissions
        return view('/account/notes/note_index', compact('notes', 'editBtn', 'deleteBtn', 'createBtn'));
    }

    // Show the form for creating a new note
    public function create()
    {
        // Return the note create view
        return view('/account/notes/note_create');
    }

    // Store a newly created note in the database
    public function store(Request $request)
    {
        // Validate the incoming request data
        $validatedData = $request->validate([
            'name' => 'required',
            'description' => 'required',
        ]);

        // Create a new note with the validated data and associate it with the authenticated user
        Note::create([
            'name' => $request->name,
            'description' => $request->description,
            'user_id' => Auth::user()->id,
        ]);

        // Redirect to the notes index page
        return redirect()->route('notes.index');
    }

    // Display the specified note
    public function show(Note $note)
    {
        return view('notes.show', compact('note'));
    }

    // Show the form for editing the specified note
    public function edit(Note $note)
    {
        return view('/account/notes/note_edit', compact('note'));
    }

    // Update the specified note in the database
    public function update(Request $request, Note $note)
    {
        // Validate the incoming request data
        $validatedData = $request->validate([
            'name' => 'required',
            'description' => 'required',
        ]);

        // Update the note with the validated data
        $note->update([
            'name' => $request->name,
            'description' => $request->description,
            'user_id' => Auth::User()->id,
        ]);

        return redirect()->route('notes.index');
    }

    // Remove the specified note from the database
    public function destroy(Note $note)
    {
        // Delete the note
        $note->delete();
        return redirect()->route('notes.index');
    }
}
