<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Note;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Auth;

class NoteController extends Controller
{
    public function index(Request $request)
    {
      $editBtn = Auth::user()->hasUserAccess(2.1, 'edit');
      $deleteBtn = Auth::user()->hasUserAccess(2.1, 'delete');
      $createBtn = Auth::user()->hasUserAccess(2.1, 'create');

        $search = $request->input('search');
        $notes = Note::query()
            ->when($search, function ($query, $search) {
                return $query->where('name', 'like', "%$search%");
            })->where('user_id', Auth::id())
            ->orderBy('id', 'desc')
            ->paginate(6);

        return view('/account/notes/note_index', compact('notes', 'editBtn','deleteBtn','createBtn'));
    }

    public function create()
    {
        return view('/account/notes/note_create');
    }

    // public function store(Request $request)
    // {

    //     $note = new Note();
    //     $note->name = $request->input('name');
    //     $note->description = $request->input('description');
    //     $note->save();

    //     return redirect()->route('notes.index');
    // }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required',
            'description' => 'required',
        ]);


        Note::create([
          'name' => $request->name,
          'description' => $request->description,
          'user_id' => Auth::user()->id,
        ]);

        return redirect()->route('notes.index');
    }

    public function show(Note $note)
    {
        return view('notes.show', compact('note'));
    }

    public function edit(Note $note)
    {
        return view('/account/notes/note_edit', compact('note'));
    }

    public function update(Request $request, Note $note)
    {
       $validatedData = $request->validate([
          'name' => 'required',
          'description' => 'required',
       ]);

       $note->update([
        'name' => $request->name,
        'description' => $request->description,
        'user_id' => Auth::User()->id,
       ]);

        return redirect()->route('notes.index');
    }

    public function destroy(Note $note)
    {
        $note->delete();

        return redirect()->route('notes.index');
    }
}

// if user has permission to edit or delete

// class NoteController extends Controller
// {
//     public function index(Request $request)
//     {
//         $notes = Note::query();

//         // Filter notes by name if search query is provided
//         if ($request->has('search')) {
//             $notes->where('name', 'like', '%' . $request->search . '%');
//         }

//         $notes = $notes->paginate(10);

//         return view('/account/notes/note_index', compact('notes'));
//     }

//     public function create()
//     {
//         // Check if user has permission to create
//         if (Gate::allows('create', Note::class)) {
//             return view('notes.create');
//         } else {
//             abort(403, 'Unauthorized action.');
//         }
//     }

//     public function store(Request $request)
//     {
//         // Validation
//         $request->validate([
//             'name' => 'required',
//             'description' => 'required',
//         ]);

//         // Create new note
//         Note::create([
//             'name' => $request->input('name'),
//             'description' => $request->input('description'),
//         ]);

//         return redirect()->route('notes.index')->with('success', 'Note created successfully.');
//     }

//     public function edit(Note $note)
//     {
//         // Check if user has permission to edit
//         if (Gate::allows('update', $note)) {
//             return view('notes.edit', compact('note'));
//         } else {
//             abort(403, 'Unauthorized action.');
//         }
//     }

//     public function update(Request $request, Note $note)
//     {
//         // Check if user has permission to update
//         if (Gate::allows('update', $note)) {
//             // Validation
//             $request->validate([
//                 'name' => 'required',
//                 'description' => 'required',
//             ]);

//             // Update the note
//             $note->update([
//                 'name' => $request->input('name'),
//                 'description' => $request->input('description'),
//             ]);

//             return redirect()->route('notes.index')->with('success', 'Note updated successfully.');
//         } else {
//             abort(403, 'Unauthorized action.');
//         }
//     }

//     public function destroy(Note $note)
//     {
//         // Check if user has permission to delete
//         if (Gate::allows('delete', $note)) {
//             $note->delete();
//             return redirect()->route('notes.index')->with('success', 'Note deleted successfully.');
//         } else {
//             abort(403, 'Unauthorized action.');
//         }
//     }
// }
