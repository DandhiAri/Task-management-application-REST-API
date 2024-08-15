<?php
namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;


class UserController extends Controller
{
    public function index()
    {
        return User::all();
    }

    public function show(User $User)
    {
        return $User;
    }

    public function store(Request $request)
    {
         // Validate the request
         $data = $request->validate([
            'name' => 'required|max:255',
            'email' => 'required|email|unique:users',
            'pfp' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'password' => 'required|',
        ]);

        if ($request->hasFile('pfp')) {
            $file = $request->file('pfp');
            $filePath = $file->store('pfp', 'public'); 
            $data['pfp'] = $filePath;
        }

        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'pfp' => $data['pfp'] ?? null, 
        ]);

        return response()->json($user, 201);
    }

    public function update(Request $request, User $User)
    {
        $request->validate([
            'name' => 'required|max:255',
            'email' => 'required|email|unique:users',
            'pfp' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'password' => 'required|',
        ]);

        $User->update($request->all());
        return response()->json($User, 200);
    }

    public function destroy(User $User)
    {
        $User->delete();
        return response()->json(['message' => 'Deleted Successfully'], 200);
    }
}
