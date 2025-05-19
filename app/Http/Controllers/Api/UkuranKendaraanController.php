<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\UkuranKendaraan;
use Illuminate\Support\Facades\Validator;

class UkuranKendaraanController extends Controller
{
    public function index()
    {
        try {
            $data = UkuranKendaraan::all();
            return response()->json([
                'message' => 'Data ukuran kendaraan berhasil diambil',
                'data' => $data
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Gagal mengambil data ukuran kendaraan',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function store(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'ukuran' => 'required|string|max:255',
                'harga' => 'required|integer'
            ]);

            if ($validator->fails()) {
                return response()->json($validator->errors(), 422);
            }

            $data = UkuranKendaraan::create($request->only('ukuran', 'harga'));

            return response()->json([
                'message' => 'Ukuran kendaraan berhasil ditambahkan',
                'data' => $data
            ], 201);

        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Gagal menambahkan ukuran kendaraan',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function show($id)
    {
        try {
            $data = UkuranKendaraan::find($id);
            if (!$data) {
                return response()->json([
                    'message' => 'Ukuran kendaraan tidak ditemukan'
                ], 404);
            }

            return response()->json([
                'message' => 'Data ukuran kendaraan berhasil ditemukan',
                'data' => $data
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Gagal menampilkan data ukuran kendaraan',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $data = UkuranKendaraan::find($id);
            if (!$data) {
                return response()->json([
                    'message' => 'Ukuran kendaraan tidak ditemukan'
                ], 404);
            }

            $validator = Validator::make($request->all(), [
                'ukuran' => 'sometimes|required|string|max:255',
                'harga' => 'sometimes|required|integer'
            ]);

            if ($validator->fails()) {
                return response()->json($validator->errors(), 422);
            }

            $data->update($request->only('ukuran', 'harga'));

            return response()->json([
                'message' => 'Ukuran kendaraan berhasil diperbarui',
                'data' => $data
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Gagal memperbarui ukuran kendaraan',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function destroy($id)
    {
        try {
            $data = UkuranKendaraan::find($id);
            if (!$data) {
                return response()->json([
                    'message' => 'Ukuran kendaraan tidak ditemukan'
                ], 404);
            }

            $data->delete();

            return response()->json([
                'message' => 'Ukuran kendaraan berhasil dihapus'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Gagal menghapus ukuran kendaraan',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
