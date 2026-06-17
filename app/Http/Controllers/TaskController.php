<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    public function index(Request $request)
    {
        $query = auth()->user()->tasks()->with('category');

        if ($request->filter === 'completed') {
            $query->completed();
        } elseif ($request->filter === 'pending') {
            $query->pending();
        }

        if ($request->priority && in_array($request->priority, ['low', 'medium', 'high'])) {
            $query->where('priority', $request->priority);
        }

        if ($request->category_id) {
            $query->where('category_id', $request->category_id);
        }

        if ($request->search) {
            $query->where('title', 'like', '%' . $request->search . '%');
        }

        $priorityOrder = ['high' => 0, 'medium' => 1, 'low' => 2];

        $tasks = $query->orderByRaw("CASE priority WHEN 'high' THEN 0 WHEN 'medium' THEN 1 ELSE 2 END")
                       ->orderBy('due_date')
                       ->paginate(10)
                       ->withQueryString();

        $categories = auth()->user()->categories;

        $user    = auth()->user();
        $stats   = [
            'total'     => $user->tasks()->count(),
            'pending'   => $user->tasks()->pending()->count(),
            'completed' => $user->tasks()->completed()->count(),
            'high'      => $user->tasks()->where('priority', 'high')->pending()->count(),
        ];

        return view('dashboard', compact('tasks', 'categories', 'stats'));
    }

    public function create()
    {
        $categories = auth()->user()->categories;
        return view('tasks.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title'       => 'required|string|max:255',
            'description' => 'nullable|string',
            'priority'    => 'required|in:low,medium,high',
            'category_id' => 'nullable|exists:categories,id',
            'due_date'    => 'nullable|date',
            'due_time'    => 'nullable|date_format:H:i',
        ]);

        auth()->user()->tasks()->create($validated);

        return redirect()->route('dashboard')->with('success', 'Task created successfully!');
    }

    public function edit(Task $task)
    {
        abort_if($task->user_id !== auth()->id(), 403);
        $categories = auth()->user()->categories;
        return view('tasks.edit', compact('task', 'categories'));
    }

    public function update(Request $request, Task $task)
    {
        abort_if($task->user_id !== auth()->id(), 403);

        $validated = $request->validate([
            'title'       => 'required|string|max:255',
            'description' => 'nullable|string',
            'priority'    => 'required|in:low,medium,high',
            'status'      => 'required|in:pending,completed',
            'category_id' => 'nullable|exists:categories,id',
            'due_date'    => 'nullable|date',
            'due_time'    => 'nullable|date_format:H:i',
        ]);

        $task->update($validated);

        return redirect()->route('dashboard')->with('success', 'Task updated successfully!');
    }

    public function destroy(Task $task)
    {
        abort_if($task->user_id !== auth()->id(), 403);
        $task->delete();
        return redirect()->route('dashboard')->with('success', 'Task deleted.');
    }

    public function toggle(Task $task)
    {
        abort_if($task->user_id !== auth()->id(), 403);
        $task->update(['status' => $task->isCompleted() ? 'pending' : 'completed']);
        return back()->with('success', 'Task status updated.');
    }
}
