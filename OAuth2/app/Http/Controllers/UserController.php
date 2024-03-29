<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    public function index()
    {
        $users = User::latest()->get();

        if (is_null($users->first())) {
            return response()->json([
                'status' => 'failed',
                'message' => 'No user found!',
            ], 200);
        }

        $response = [
            'status' => 'success',
            'message' => 'Users are retrieved successfully.',
            'data' => $users,
        ];

        return response()->json($response, 200);
    }

    public function store(Request $request)
    {
        $validate = Validator::make($request->all(), [
            'name' => 'required|string|max:250',
            'email' => 'required|string|max:250|unique:users,email',
            'password' => 'required|string|min:8',
            'role' => 'required|exists:roles,id'
        ]);

        if ($validate->fails()) {
            return response()->json([
                'status' => 'failed',
                'message' => 'Validation Error!',
                'data' => $validate->errors(),
            ], 403);
        }

        // Créez un nouvel utilisateur en incluant le champ "role" dans les données de création
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role,
        ]);

        $response = [
            'status' => 'success',
            'message' => 'User is added successfully.',
            'data' => $user,
        ];

        return response()->json($response, 200);
    }

    public function show($id)
    {
        $user = User::find($id);

        if (is_null($user)) {
            return response()->json([
                'status' => 'failed',
                'message' => 'User is not found!',
            ], 200);
        }

        $response = [
            'status' => 'success',
            'message' => 'User is retrieved successfully.',
            'data' => $user,
        ];

        return response()->json($response, 200);
    }

    public function update(Request $request, $id)
    {
        // Vérifier si l'utilisateur existe dans la base de données
        $user = User::find($id);

        if (is_null($user)) {
            return response()->json([
                'status' => 'failed',
                'message' => 'User not found.',
            ], 404);
        }

        // Valider les données de la requête
        $validate = Validator::make($request->all(), [
            'name' => 'required|string|max:250',
            'email' => 'required|string|max:250|unique:users,email,' . $id,
            'password' => 'sometimes|required|string|min:8',
            'role' => 'required|exists:roles,id',
        ]);

        if ($validate->fails()) {
            return response()->json([
                'status' => 'failed',
                'message' => 'Validation Error!',
                'data' => $validate->errors(),
            ], 422);
        }

        $user->name = $request->name;
        $user->email = $request->email;
        if ($request->has('password')) {
            $user->password = Hash::make($request->password);
        }
        $user->role = $request->role;
        $user->save();

        return response()->json([
            'status' => 'success',
            'message' => 'User updated successfully.',
            'data' => $user,
        ], 200);
    }

    public function destroy($id)
    {
        $user = User::find($id);

        if (is_null($user)) {
            return response()->json([
                'status' => 'failed',
                'message' => 'User is not found!',
            ], 200);
        }

        User::destroy($id);
        return response()->json([
            'status' => 'success',
            'message' => 'User is deleted successfully.'
        ], 200);
    }
}
