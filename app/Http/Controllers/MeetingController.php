<?php

namespace App\Http\Controllers;

use App\Models\Meeting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MeetingController extends Controller
{
    // Display a listing of the meetings
    public function index(Request $request)
    {
        // Check user permissions for edit, delete, and create actions
        $editBtn = Auth::user()->hasUserAccess('2.3', 'edit');
        $deleteBtn = Auth::user()->hasUserAccess('2.3', 'delete');
        $createBtn = Auth::user()->hasUserAccess('2.3', 'create');

        // Initialize the query builder for the Meeting model
        $query = Meeting::query();

        // Apply search filter if 'search' parameter is present in the request
        if ($request->has('search')) {
            $search = $request->input('search');
            $query->where('name', 'like', "%$search%");
        }

        // Apply status filter if 'status' parameter is present in the request
        $status = $request->input('status');
        if ($status === 'active') {
            $query->where('is_active', true);
        } elseif ($status === 'inactive') {
            $query->where('is_active', false);
        }

        // Get the meetings for the authenticated user, ordered by ID in descending order and paginate the results
        $meetings = $query->where('user_id', Auth::id())->orderBy('id', 'desc')->paginate(10);

        // Return the meetings index view with the necessary data
        return view('/account/meetings/meeting_index', compact('meetings', 'editBtn', 'deleteBtn', 'createBtn'));
    }

    // Show the form for creating a new meeting
    public function create()
    {
        return view('/account/meetings/meeting_create');
    }

    // Store a newly created meeting in the database
    public function store(Request $request)
    {
        // Validate the incoming request data
        $validatedData = $request->validate([
            'name' => 'required',
            'description' => 'required',
            'date' => 'required|date|after_or_equal:today',
            'time' => 'required',
        ]);

        // Create a new meeting with the validated data and associate it with the authenticated user
        Meeting::create([
            'name' => $request->name,
            'description' => $request->description,
            'date' => $request->date,
            'time' => $request->time,
            'user_id' => Auth::User()->id,
        ]);

        // Redirect to the meetings index page
        return redirect()->route('meetings.index');
    }

    // Show the form for editing the specified meeting
    public function edit(Meeting $meeting)
    {
        return view('/account/meetings/meeting_edit', compact('meeting'));
    }

    // Update the specified meeting in the database
    public function update(Request $request, Meeting $meeting)
    {
        // Validate the incoming request data
        $request->validate([
            'name' => 'required',
            'description' => 'required',
            'date' => 'required|date|after_or_equal:today',
            'time' => 'required|after_or_equal:now',
        ]);

        // Update the meeting with the validated data
        $meeting->update([
            'name' => $request->name,
            'description' => $request->description,
            'date' => $request->date,
            'time' => $request->time,
            'user_id' => Auth::User()->id,
        ]);

        // Redirect to the meetings index page
        return redirect()->route('meetings.index');
    }

    // Remove the specified meeting from the database
    public function destroy(Meeting $meeting)
    {
        $meeting->delete();
        return redirect()->route('meetings.index');
    }

    // Update the status of the specified meeting (active/inactive)
    public function updateStatus(Request $request)
    {
        // Find the meeting by ID
        $meeting = Meeting::find($request->meeting_id);

        // Return an error response if the meeting is not found
        if (!$meeting) {
            return response()->json(['error' => 'Meeting not found'], 404);
        }

        // Update the 'is_active' status of the meeting and save it
        $meeting->is_active = $request->status;
        $meeting->save();

        // Return a success response
        return response()->json(['success' => 'Meeting status updated successfully']);
    }
}
