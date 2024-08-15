<?php
namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    public function index()
    {
        return Task::all();
    }

    public function show(Task $task)
    {
        return $task;
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'id_user' => 'required|integer',
            'id_project' => 'required|integer',
            'deadline' => 'required|date_format:Y-m-d H:i:s',
            'status' => 'required'
        ]);

        $task = Task::create($request->all());
        return response()->json($task, 201);
    }

    public function update(Request $request, Task $task)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'id_user' => 'required|integer',
            'id_project' => 'required|integer',
            'deadline' => 'required|date_format:Y-m-d H:i:s',
            'status' => 'required'
        ]);

        $task->update($request->all());
        return response()->json($task, 200);
    }

    public function destroy(Task $task)
    {
        $task->delete();
        return response()->json(['message' => 'Deleted Successfully'], 200);
    }

    public function searchUser($id)
    {
        if (!is_numeric($id)) {
            return response()->json(['error' => 'Invalid user ID'], 400);
        }
        $tasks = Task::where('id_user', $id)->get();
        if ($tasks->isEmpty()) {
            return response()->json(['message' => 'No tasks found for this user'], 404);
        }
        return response()->json($tasks, 200);
    }
    public function searchProject($id)
    {
        if (!is_numeric($id)) {
            return response()->json(['error' => 'Invalid user ID'], 400);
        }
        $tasks = Task::where('id_project', $id)->get();
        if ($tasks->isEmpty()) {
            return response()->json(['message' => 'No tasks found for this project'], 404);
        }
        return response()->json($tasks, 200);
    }
}
