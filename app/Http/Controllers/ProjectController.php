<?php
namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\Task;
use Illuminate\Http\Request;

class ProjectController extends Controller
{
    public function index()
    {
        return Project::all();
    }

    public function show(Project $Project)
    {
        return $Project;
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'status' => 'required|string',
            'deadline' => 'required|date_format:Y-m-d H:i:s',
        ]);

        $Project = Project::create($request->all());
        return response()->json($Project, 201);
    }

    public function update(Request $request, Project $Project)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'status' => 'required|string',
            'deadline' => 'required|date_format:Y-m-d H:i:s',
        ]);
        
        $Project->update($request->all());
        return response()->json($Project, 200);
    }

    public function destroy(Project $Project)
    {
        $k = Task::where('id_project', $Project->id)->delete();
        $Project->delete();
        return response()->json(['message' => 'Deleted Successfully'], 200);
    }
   
}
