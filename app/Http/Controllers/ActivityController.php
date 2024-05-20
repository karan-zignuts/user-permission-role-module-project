<?php

namespace App\Http\Controllers;

use App\Models\Activity;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class ActivityController extends Controller
{
    // Display a listing of the activities
    public function index(Request $request)
    {
        // Check user permissions for edit, delete, and create actions
        $editBtn = Auth::user()->hasUserAccess(2.2, 'edit');
        $deleteBtn = Auth::user()->hasUserAccess(2.2, 'delete');
        $createBtn = Auth::user()->hasUserAccess(2.2, 'create');

        // Initialize the query builder for the Activity model
        $query = Activity::query();

        // Apply search filter if 'search' parameter is present in the request
        if ($request->has('search')) {
            $search = $request->input('search');
            $activities->where('name', 'like', "%$search%");
        }

        // Apply status filter if 'status' parameter is present in the request
        $status = $request->input('status');
        if ($status === 'active') {
            $activities->where('is_active', true);
        } elseif ($status === 'inactive') {
            $activities->where('is_active', false);
        }

        // Get the activities for the authenticated user and paginate the results
        $activities = $query->where('user_id', Auth::id())->paginate(10);

        // Return the activity index view with the necessary data
        return view('/account/activity-log/activity_index', compact('activities', 'editBtn', 'deleteBtn', 'createBtn'));
    }

    // Show the form for creating a new activity
    public function create()
    {
        return view('/account/activity-log/activity_create');
    }

    // Store a newly created activity in the database
    public function store(Request $request)
    {
        // Validate the incoming request data
        $validatedData = $request->validate([
            'name' => 'required',
            'description' => 'required',
            'assign_person' => 'required',
        ]);

        // Create a new activity with the validated data and associate it with the authenticated user
        Activity::create([
            'name' => $request->name,
            'description' => $request->description,
            'assign_person' => $request->assign_person,
            'user_id' => Auth::User()->id,
        ]);

        // Redirect to the activities index page
        return redirect()->route('activities.index');
    }

    // Show the form for editing the specified activity
    public function edit($id)
    {
        // Find the activity by ID or fail if not found
        $activity = Activity::findOrFail($id);
        return view('/account/activity-log/activity_edit', compact('activity'));
    }

    // Update the specified activity in the database
    public function update(Request $request, $id)
    {
        // Validate the incoming request data
        $validatedData = $request->validate([
            'name' => 'required',
            'description' => 'required',
            'assign_person' => 'required',
        ]);

        // Find the activity by ID or fail if not found
        $activity = Activity::findOrFail($id);

        // Update the activity with the validated data
        $activity->update([
            'name' => $request->name,
            'description' => $request->description,
            'assign_person' => $request->assign_person,
            'user_id' => Auth::User()->id,
        ]);

        // Redirect to the activities index page
        return redirect()->route('activities.index')->with('success', 'Activity updated successfully.');
    }

    // Remove the specified activity from the database
    public function destroy($id)
    {
        // Find the activity by ID or fail if not found
        $activity = Activity::findOrFail($id);
        $activity->delete();

        // Redirect to the activities index page
        return redirect('/activities')->with('success', 'Activity deleted successfully.');
    }

    // Update the status of the specified activity (active/inactive)
    public function updateStatus(Request $request)
    {
        // Find the activity by ID
        $activity = Activity::find($request->activity_id);

        // Return an error response if the activity is not found
        if (!$activity) {
            return response()->json(['error' => 'Activity not found'], 404);
        }

        // Update the 'is_active' status of the activity and save it
        $activity->is_active = $request->status;
        $activity->save();

        return response()->json(['success' => 'Activity status updated successfully']);
    }
}
