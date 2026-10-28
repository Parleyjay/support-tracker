<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    public function index()
    {
        $tasks = Task::with('user')->latest()->get();
        return view('tasks.index', compact('tasks'));
    }

    public function store(Request $request)
    {
    $validated = $request->validate([
        'title' => 'required|string|max:255',
        'description' => 'nullable|string',
        'priority' => 'required|string|in:Low,Medium,High,Urgent',
    ]);

    Task::create([
        'title' => $validated['title'],
        'description' => $validated['description'],
        'priority' => $validated['priority'],
        'status' => 'Pending',
        'user_id' => auth()->id(), // Captures the logged-in personnel ID
    ]);

    return redirect()->route('tasks.index')->with('success', 'Task added successfully!');
    }

    public function update(Request $request, Task $task)
    {
    $validated = $request->validate([
        'status' => 'required|string|in:Pending,Done',
        'remarks' => 'nullable|string',
    ]);

    $task->update([
        'status' => $validated['status'],
        'remarks' => $validated['remarks'],
        'user_id' => auth()->id(), // Updates to the personnel who made the latest change
    ]);

    return redirect()->back()->with('success', 'Task status and remarks updated successfully!');
    }

    public function report(Request $request)
    {
    $startDate = $request->input('start_date');
    $endDate = $request->input('end_date');

    $query = Task::with('user');

    if ($startDate && $endDate) {
        $query->whereBetween('updated_at', [$startDate . ' 00:00:00', $endDate . ' 23:59:59']);
    }

    $tasks = $query->latest('updated_at')->get();

    return view('tasks.report', compact('tasks', 'startDate', 'endDate'));
    }
    public function handingOver(Request $request)
{
    $today = now()->format('Y-m-d');
    
    $tasks = Task::with('user')
        ->whereDate('updated_at', $today)
        ->latest('updated_at')
        ->get();

    return view('tasks.handing-over', compact('tasks', 'today'));
}


}
