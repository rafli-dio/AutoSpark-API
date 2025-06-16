<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\MetodePembayaran;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class MetodePembayaranController extends Controller
{
    public function index()
    {
        try {
            $data = MetodePembayaran::all();
            return response()->json(['success' => true, 'data' => $data]);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Gagal mengambil data', 'error' => $e->getMessage()], 500);
        }
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nama' => 'required|string|max:255',
            'tipe' => 'required|string|max:255',
            'nomor' => 'required|string|max:255',
            'atas_nama' => 'required|string|max:255',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,svg|max:2048' 
        ]);

        if ($validator->fails()) {
            return response()->json(['success' => false, 'errors' => $validator->errors()], 422);
        }

        try {
            $data = $request->only(['nama', 'tipe', 'nomor', 'atas_nama']);

            if ($request->hasFile('logo')) {
                $path = $request->file('logo')->store('logos', 'public');
                $data['logo'] = $path;
            }

            $metode = MetodePembayaran::create($data);

            return response()->json(['success' => true, 'data' => $metode, 'message' => 'Metode pembayaran berhasil ditambahkan'], 201);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Gagal menyimpan data', 'error' => $e->getMessage()], 500);
        }
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'nama' => 'sometimes|required|string|max:255',
            'tipe' => 'sometimes|required|string|max:255',
            'nomor' => 'sometimes|required|string|max:255',
            'atas_nama' => 'sometimes|required|string|max:255',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,svg|max:2048'
        ]);

        if ($validator->fails()) {
            return response()->json(['success' => false, 'errors' => $validator->errors()], 422);
        }

        try {
            $metode = MetodePembayaran::findOrFail($id);
            $data = $request->only(['nama', 'tipe', 'nomor', 'atas_nama']);

            if ($request->hasFile('logo')) {
                if ($metode->logo) {
                    Storage::disk('public')->delete($metode->logo);
                }

                $path = $request->file('logo')->store('logos', 'public');
                $data['logo'] = $path;
            }

            $metode->update($data);

            return response()->json(['success' => true, 'data' => $metode, 'message' => 'Metode pembayaran berhasil diperbarui']);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Gagal memperbarui data', 'error' => $e->getMessage()], 500);
        }
    }

    public function destroy($id)
    {
        try {
            $metode = MetodePembayaran::findOrFail($id);

            if ($metode->logo) {
                Storage::disk('public')->delete($metode->logo);
            }

            $metode->delete();

            return response()->json(['success' => true, 'message' => 'Metode pembayaran berhasil dihapus']);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Gagal menghapus data', 'error' => $e->getMessage()], 500);
        }
    }

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