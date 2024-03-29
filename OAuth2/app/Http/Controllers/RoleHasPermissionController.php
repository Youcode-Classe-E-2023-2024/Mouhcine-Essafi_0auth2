<?php

namespace App\Http\Controllers;

use App\Models\RoleHasPermission;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class RoleHasPermissionController extends Controller
{
    public function index()
    {
        $role_permissions = RoleHasPermission::latest()->get();

        if (is_null($role_permissions->first())) {
            return response()->json([
                'status' => 'failed',
                'message' => 'No Role has permission found!',
            ], 200);
        }

        $response = [
            'status' => 'success',
            'message' => 'Role has persmissions are retrieved successfully.',
            'data' => $role_permissions,
        ];

        return response()->json($response, 200);
    }

    public function store(Request $request)
    {
        $validate = Validator::make($request->all(), [
            'role' => 'required|exists:roles,id',
            'permission' => 'required|exists:permissions,id'
        ]);

        if ($validate->fails()) {
            return response()->json([
                'status' => 'failed',
                'message' => 'Validation Error!',
                'data' => $validate->errors(),
            ], 403);
        }

        $role_permissions = RoleHasPermission::create($request->all());

        $response = [
            'status' => 'success',
            'message' => 'Role has permissions is added successfully.',
            'data' => $role_permissions,
        ];

        return response()->json($response, 200);
    }

    public function show($id)
    {
        $role_permissions = RoleHasPermission::find($id);

        if (is_null($role_permissions)) {
            return response()->json([
                'status' => 'failed',
                'message' => 'Role has permissions is not found!',
            ], 200);
        }

        $response = [
            'status' => 'success',
            'message' => 'Role has permissions is retrieved successfully.',
            'data' => $role_permissions,
        ];

        return response()->json($response, 200);
    }

    public function update(Request $request, $id)
    {
        $validate = Validator::make($request->all(), [
            'role' => 'required',
            'permission' => 'required'
        ]);

        if($validate->fails()){
            return response()->json([
                'status' => 'failed',
                'message' => 'Validation Error!',
                'data' => $validate->errors(),
            ], 403);
        }

        $role_permissions = RoleHasPermission::find($id);

        if (is_null($role_permissions)) {
            return response()->json([
                'status' => 'failed',
                'message' => 'Role has permissions is not found!',
            ], 200);
        }

        $role_permissions->update($request->all());

        $response = [
            'status' => 'success',
            'message' => 'Role has permissions is updated successfully.',
            'data' => $role_permissions,
        ];

        return response()->json($response, 200);
    }

    public function destroy($id)
    {
        $role_permissions = RoleHasPermission::find($id);

        if (is_null($role_permissions)) {
            return response()->json([
                'status' => 'failed',
                'message' => 'Role has permissions is not found!',
            ], 200);
        }

        RoleHasPermission::destroy($id);
        return response()->json([
            'status' => 'success',
            'message' => 'Role has permissions is deleted successfully.'
        ], 200);
    }
}
