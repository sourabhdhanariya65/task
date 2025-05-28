<?php
namespace App\Http\Controllers;

use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ProjectController extends Controller
{

    /**
     * Display a listing of projects with task completion stats.
     *
     * @return View
     */
    public function index()
    {
        $projects = Project::withCount('tasks')->get();

        foreach ($projects as $project) {
            $completed                = $project->tasks()->where('status', 'completed')->count();
            $total                    = $project->tasks_count ?: 1;
            $project->completion_rate = round(($completed / $total) * 100);
        }

        return view('projects.index', compact('projects'));
    }

    /**
     * Show the form for creating a new project.
     *
     * @return View
     */
    public function create()
    {
        return view('projects.create');
    }

    /**
     * Store a newly created project in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return RedirectResponse
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name'        => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            if ($request->ajax()) {
                return response()->json(['errors' => $validator->errors()], 422);
            }
            return redirect()->back()->withErrors($validator)->withInput();
        }

        Project::create($request->only('name', 'description'));

        if ($request->ajax()) {
            $projects = Project::withCount('tasks')->get();
            foreach ($projects as $project) {
                $completed                = $project->tasks()->where('status', 'completed')->count();
                $total                    = $project->tasks_count ?: 1;
                $project->completion_rate = round(($completed / $total) * 100);
            }

            $html = view('projects.index', compact('projects'))->render(); // 👈 full index view
            return response()->json(['redirect_html' => $html]);           // 👈 send full HTML
        }

        return redirect()->route('projects.index')->with('success', 'Project created!');
    }

    /**
     * Show the form for editing the specified project.
     *
     * @param  \App\Models\Project  $project
     * @return View
     */
    public function edit(Project $project)
    {
        return view('projects.edit', compact('project'));
    }

    /**
     * Update the specified project in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Project  $project
     * @return RedirectResponse
     */
    public function update(Request $request, Project $project)
    {
        $request->validate([
            'name'        => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        $project->update($request->only('name', 'description'));

        if ($request->ajax()) {
            $projects = Project::withCount('tasks')->get();
            foreach ($projects as $p) {
                $completed          = $p->tasks()->where('status', 'completed')->count();
                $total              = $p->tasks_count ?: 1;
                $p->completion_rate = round(($completed / $total) * 100);
            }

            $html = view('projects.index', compact('projects'))->render();
            return response()->json(['redirect_html' => $html]);
        }

        return redirect()->route('projects.index')->with('success', 'Project updated!');
    }

    /**
     * Remove the specified project from storage.
     *
     * @param  \App\Models\Project  $project
     * @param  \Illuminate\Http\Request  $request
     * @return RedirectResponse
     */
    public function destroy(Project $project, Request $request)
    {
        $project->delete();

        if ($request->ajax()) {
            return response()->json(['success' => true]);
        }

        return redirect()->route('projects.index')->with('success', 'Project deleted!');
    }
}
