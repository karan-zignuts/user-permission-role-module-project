<?php

namespace App\Http\Controllers;

use App\Models\Meeting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MeetingController extends Controller
{
    public function index(Request $request)
    {
        $editBtn = Auth::user()->hasUserAccess('2.3', 'edit');
        $deleteBtn = Auth::user()->hasUserAccess('2.3', 'delete');
        $createBtn = Auth::user()->hasUserAccess('2.3', 'create');

        $query = Meeting::query();

        if ($request->has('search')) {
            $search = $request->input('search');
            $query->where('name', 'like', "%$search%");
        }

        $status = $request->input('status');
        if ($status === 'active') {
            $query->where('is_active', true);
        } elseif ($status === 'inactive') {
            $query->where('is_active', false);
        }

        $meetings = $query->where('user_id', Auth::id())->orderBy('id', 'desc')->paginate(10);
        return view('/account/meetings/meeting_index', compact('meetings','editBtn','deleteBtn','createBtn'));
    }
    // public function index(Request $request)
    // {
    //     $editBtn = Auth::user()  ->hasUserAccess(2.2, 'edit');
    //     $deleteBtn = Auth::user()->hasUserAccess(2.2, 'delete');
    //     $createBtn = Auth::user()->hasUserAccess(2.2, 'create');

    //     $query = Activity::query();

    //     if ($request->has('search')) {
    //         $search = $request->input('search');
    //         $activities->where('name', 'like', "%$search%");
    //     }

    //     $status = $request->input('status');
    //     if ($status === 'active') {
    //         $activities->where('is_active', true);
    //     } elseif ($status === 'inactive') {
    //         $activities->where('is_active', false);
    //     }
    //     // $activities = $activities->orderBy('id', 'desc')->paginate(10);
    //     $activities = $query->where('user_id', Auth::id())->paginate(10);
    //     return view('/account/activity-log/activity_index', compact('activities', 'editBtn', 'deleteBtn', 'createBtn'));
    // }

    public function create()
    {
        return view('/account/meetings/meeting_create');
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required',
            'description' => 'required',
            'date' => 'required|date|after_or_equal:today',
            'time' => 'required',
        ]);

        Meeting::create([
            'name' => $request->name,
            'description' => $request->description,
            'date' => $request->date,
            'time' => $request->time,
            'user_id' => Auth::User()->id,
        ]);

        return redirect()->route('meetings.index');
    }

    public function edit(Meeting $meeting)
    {
        return view('/account/meetings/meeting_edit', compact('meeting'));
    }

    public function update(Request $request, Meeting $meeting)
    {
        $request->validate([
            'name' => 'required',
            'description' => 'required',
            'date' => 'required|date|after_or_equal:today',
            'time' => 'required|after_or_equal:now',
        ]);

        $meeting->update([
            'name' => $request->name,
            'description' => $request->description,
            'date' => $request->date,
            'time' => $request->time,
            'user_id' => Auth::User()->id,
        ]);
        return redirect()->route('meetings.index');
    }

    public function destroy(Meeting $meeting)
    {
        $meeting->delete();
        return redirect()->route('meetings.index');
    }

    public function updateStatus(Request $request)
    {
        $meeting = Meeting::find($request->meeting_id);
        if (!$meeting) {
            return response()->json(['error' => 'Meeting not found'], 404);
        }

        $meeting->is_active = $request->status;
        $meeting->save();

        return response()->json(['success' => 'Meeting status updated successfully']);
    }
}
