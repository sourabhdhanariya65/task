<?php
namespace App\Http\Controllers;

use App\Models\ActivityLog;
use App\Models\Project;
use App\Models\Task;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    /**
     * Display a listing of tasks with optional filtering.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return View
     */
    public function index(Request $request)
    {
        $query = Task::with('project');

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('search')) {
            $query->where('title', 'like', '%' . $request->search . '%');
        }

        $tasks = $query->latest()->get();

        if ($request->ajax()) {
            return view('tasks.index', compact('tasks'))->render();
        }

        return view('tasks.index', compact('tasks'));
    }

    /**
     * Show the form for creating a new task.
     *
     * @return View
     */
    public function create()
    {
        $projects = Project::all();
        return view('tasks.create', compact('projects'));
    }

    /**
     * Store a newly created task in storage and log the activity.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return RedirectResponse
     */
    public function store(Request $request)
    {
        $request->validate([
            'project_id'  => 'required|exists:projects,id',
            'title'       => 'required|string|max:255',
            'description' => 'nullable|string',
            'due_date'    => 'nullable|date',
        ]);

        $task = Task::create($request->only('project_id', 'title', 'description', 'due_date'));

        ActivityLog::create([
            'user_id'    => auth()->id(),
            'action'     => 'Created Task',
            'model_type' => 'Task',
            'model_id'   => $task->id,
        ]);

        if ($request->ajax()) {
            $tasks = Task::with('project')->latest()->get();          
            $html  = view('tasks.index', compact('tasks'))->render(); 

            return response()->json([
                'redirect_html' => $html,
            ]);
        }

        return redirect()->route('tasks.index')->with('success', 'Task created!');
    }

    /**
     * Show the form for editing the specified task.
     *
     * @param  \App\Models\Task  $task
     * @return View
     */
    public function edit(Task $task)
    {
        $projects = Project::all();
        return view('tasks.edit', compact('task', 'projects'));
    }

    /**
     * Update the specified task in storage and log the activity.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Task  $task
     * @return RedirectResponse
     */
    public function update(Request $request, Task $task)
    {
        $request->validate([
            'project_id'  => 'required|exists:projects,id',
            'title'       => 'required|string|max:255',
            'description' => 'nullable|string',
            'due_date'    => 'nullable|date',
        ]);

        $task->update($request->only('project_id', 'title', 'description', 'due_date'));

        ActivityLog::create([
            'user_id'    => auth()->id(),
            'action'     => 'Updated Task',
            'model_type' => 'Task',
            'model_id'   => $task->id,
        ]);

        if ($request->ajax()) {
            return response()->json(['success' => true]);
        }

        return redirect()->route('tasks.index')->with('success', 'Task updated!');
    }

    /**
     * Remove the specified task from storage and log the activity.
     *
     * @param  \App\Models\Task  $task
     * @param  Request  $request
     * @return RedirectResponse
     */
    public function destroy(Task $task, Request $request)
    {
        $task->delete();

        ActivityLog::create([
            'user_id'    => auth()->id(),
            'action'     => 'Deleted Task',
            'model_type' => 'Task',
            'model_id'   => $task->id,
        ]);

        if ($request->ajax()) {
            return response()->json(['success' => true]);
        }
        return redirect()->route('tasks.index')->with('success', 'Task deleted!');
    }

    /**
     * Toggle the task's status between 'pending' and 'completed' and log the activity.
     *
     * @param  int  $id
     * @return JsonResponse
     */
    public function toggleStatus($id)
    {
        $task         = Task::findOrFail($id);
        $task->status = $task->status === 'pending' ? 'completed' : 'pending';
        $task->save();

        ActivityLog::create([
            'user_id'    => auth()->id(),
            'action'     => 'Toggled Task Status',
            'model_type' => 'Task',
            'model_id'   => $task->id,
        ]);

        return response()->json([
            'success'    => true,
            'new_status' => $task->status,
        ]);
    }
}
