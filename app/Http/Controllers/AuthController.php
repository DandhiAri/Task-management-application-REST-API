<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function register(Request $request)
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

        $token = $user->createToken($data['name'])->plainTextToken;

        return response()->json([
            'success' => true,
            'user' => $user,
            'token' => $token,
            'pfp_url' => $data['pfp'] ? Storage::url($data['pfp']) : null
        ], 201);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function login(Request $request)
    {
        $request->validate([
            "email" => "required|exists:users",
            "password" => "required"
        ]);
        $user = User::where('email', $request->email)->first();

        if(!$user || !Hash::check($request->password, $user->password )){
            return['message' => "The account didnt exist"];
        }
        $token = $user->createToken($user->name);

        return [
            'user' => $user,
            'token' =>$token->plainTextToken
        ];
    }

    /**
     * Store a newly created resource in storage.
     */
    public function logout(Request $request)
    {
        $request->user()->tokens()->delete();

        return["message" => "logout sucessfully"];
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
