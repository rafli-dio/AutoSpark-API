<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\MetodePembayaran;
use Illuminate\Support\Facades\Validator;

class MetodePembayaranController extends Controller
{
    // GET: /api/metode-pembayaran
    public function index()
    {
        try {
            $data = MetodePembayaran::all();
            return response()->json(['success' => true, 'data' => $data]);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Gagal mengambil data', 'error' => $e->getMessage()], 500);
        }
    }

    // POST: /api/metode-pembayaran
    public function store(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'nama' => 'required|string',
                'tipe' => 'required|string',
                'nomor' => 'required|string',
                'atas_nama' => 'required|string',
            ]);

            if ($validator->fails()) {
                return response()->json(['success' => false, 'errors' => $validator->errors()], 422);
            }

            $metode = MetodePembayaran::create($request->all());
            return response()->json(['success' => true, 'data' => $metode, 'message' => 'Metode pembayaran berhasil ditambahkan']);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Gagal menyimpan data', 'error' => $e->getMessage()], 500);
        }
    }

    // PUT: /api/metode-pembayaran/{id}
    public function update(Request $request, $id)
    {
        try {
            $metode = MetodePembayaran::findOrFail($id);

            $validator = Validator::make($request->all(), [
                'nama' => 'required|string',
                'tipe' => 'required|string',
                'nomor' => 'required|string',
                'atas_nama' => 'required|string',
            ]);

            if ($validator->fails()) {
                return response()->json(['success' => false, 'errors' => $validator->errors()], 422);
            }

            $metode->update($request->all());
            return response()->json(['success' => true, 'data' => $metode, 'message' => 'Metode pembayaran berhasil diperbarui']);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Gagal memperbarui data', 'error' => $e->getMessage()], 500);
        }
    }

    // DELETE: /api/metode-pembayaran/{id}
    public function destroy($id)
    {
        try {
            $metode = MetodePembayaran::findOrFail($id);
            $metode->delete();

            return response()->json(['success' => true, 'message' => 'Metode pembayaran berhasil dihapus']);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Gagal menghapus data', 'error' => $e->getMessage()], 500);
        }
    }

    // GET: /api/metode-pembayaran/{id}
    public function show($id)
    {
        try {
            $metode = MetodePembayaran::findOrFail($id);
            return response()->json(['success' => true, 'data' => $metode]);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Data tidak ditemukan', 'error' => $e->getMessage()], 404);
        }
    }
}
