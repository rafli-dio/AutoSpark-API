<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Role;
use Illuminate\Support\Facades\Validator;

class RoleController extends Controller
{
    public function index()
    {
        try {
            $roles = Role::all();
            return response()->json(['message' => 'Daftar role berhasil diambil', 'data' => $roles], 200);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Gagal mengambil data role', 'error' => $e->getMessage()], 500);
        }
    }

    public function store(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'nama' => 'required|string|unique:roles,nama',
                'deskripsi' => 'nullable|string',
            ]);

            if ($validator->fails()) {
                return response()->json($validator->errors(), 422);
            }

            $role = Role::create($request->only('nama', 'deskripsi'));

            return response()->json(['message' => 'Role berhasil dibuat', 'data' => $role], 201);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Gagal membuat role', 'error' => $e->getMessage()], 500);
        }
    }

    public function show($id)
    {
        try {
            $role = Role::find($id);
            if (!$role) {
                return response()->json(['message' => 'Role tidak ditemukan'], 404);
            }
            return response()->json(['message' => 'Detail role', 'data' => $role], 200);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Gagal mengambil data role', 'error' => $e->getMessage()], 500);
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $role = Role::find($id);
            if (!$role) {
                return response()->json(['message' => 'Role tidak ditemukan'], 404);
            }

            $validator = Validator::make($request->all(), [
                'nama' => 'sometimes|required|string|unique:roles,nama,' . $id,
                'deskripsi' => 'nullable|string',
            ]);

            if ($validator->fails()) {
                return response()->json($validator->errors(), 422);
            }

            $role->update($request->only('nama', 'deskripsi'));

            return response()->json(['message' => 'Role berhasil diperbarui', 'data' => $role], 200);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Gagal memperbarui role', 'error' => $e->getMessage()], 500);
        }
    }

    public function destroy($id)
    {
        try {
            $role = Role::find($id);
            if (!$role) {
                return response()->json(['message' => 'Role tidak ditemukan'], 404);
            }

            $role->delete();

            return response()->json(['message' => 'Role berhasil dihapus'], 200);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Gagal menghapus role', 'error' => $e->getMessage()], 500);
        }
    }
}
