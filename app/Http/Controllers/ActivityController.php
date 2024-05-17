<?php

namespace App\Http\Controllers;

use App\Models\Activity;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class ActivityController extends Controller
{
    public function index(Request $request)
    {
        $editBtn = Auth::user()  ->hasUserAccess(2.2, 'edit');
        $deleteBtn = Auth::user()->hasUserAccess(2.2, 'delete');
        $createBtn = Auth::user()->hasUserAccess(2.2, 'create');

        $query = Activity::query();

        if ($request->has('search')) {
            $search = $request->input('search');
            $activities->where('name', 'like', "%$search%");
        }

        $status = $request->input('status');
        if ($status === 'active') {
            $activities->where('is_active', true);
        } elseif ($status === 'inactive') {
            $activities->where('is_active', false);
        }
        // $activities = $activities->orderBy('id', 'desc')->paginate(10);
        $activities = $query->where('user_id', Auth::id())->paginate(10);
        return view('/account/activity-log/activity_index', compact('activities', 'editBtn', 'deleteBtn', 'createBtn'));
    }

    public function create()
    {
        return view('/account/activity-log/activity_create');
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required',
            'description' => 'required',
            'assign_person' => 'required',
        ]);

        Activity::create([
            'name' => $request->name,
            'description' => $request->description,
            'assign_person' => $request->assign_person,
            'user_id' => Auth::User()->id,
        ]);
        return redirect()->route('activities.index');
    }

    public function edit($id)
    {
        $activity = Activity::findOrFail($id);
        return view('/account/activity-log/activity_edit', compact('activity'));
    }

    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'name' => 'required',
            'description' => 'required',
            'assign_person' => 'required',
        ]);

        $activity = Activity::findOrFail($id);

        $activity->update([
            'name' => $request->name,
            'description' => $request->description,
            'assign_person' => $request->assign_person,
            'user_id' => Auth::User()->id,
        ]);

        return redirect()->route('activities.index')->with('success', 'Activity updated successfully.');
    }

    public function destroy($id)
    {
        $activity = Activity::findOrFail($id);
        $activity->delete();

        return redirect('/activities')->with('success', 'Activity deleted successfully.');
    }

    public function updateStatus(Request $request)
    {
        $activity = Activity::find($request->activity_id);
        if (!$activity) {
            return response()->json(['error' => 'Activity not found'], 404);
        }

        $activity->is_active = $request->status;
        $activity->save();

        return response()->json(['success' => 'Activity status updated successfully']);
    }
}
