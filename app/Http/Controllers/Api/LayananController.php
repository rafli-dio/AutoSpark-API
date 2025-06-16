<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Layanan;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;

class LayananController extends Controller
{
    public function index()
    {
        try {
            $layanan = Layanan::all();
            return response()->json([
                'message' => 'Data layanan berhasil diambil',
                'data' => $layanan
            ], 200);
        } catch (\Exception $e) {
            Log::error("Index Error: " . $e->getMessage());
            return response()->json([
                'message' => 'Gagal mengambil data layanan',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function store(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'nama' => 'required|string|max:255',
                'deskripsi' => 'nullable|string',
                'harga' => 'required|integer',
                'gambar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            ]);

            if ($validator->fails()) {
                return response()->json($validator->errors(), 422);
            }

            $data = $request->only(['nama', 'deskripsi', 'harga']);

            if ($request->hasFile('gambar')) {
                $path = $request->file('gambar')->store('layanan_images', 'public');
                $data['gambar'] = $path;
            }

            $layanan = Layanan::create($data);

            return response()->json([
                'message' => 'Layanan berhasil ditambahkan',
                'data' => $layanan
            ], 201);
        } catch (\Exception $e) {
            Log::error("Store Error: " . $e->getMessage());
            return response()->json([
                'message' => 'Gagal menambahkan layanan',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function show($id)
    {
        try {
            $layanan = Layanan::find($id);
            if (!$layanan) {
                return response()->json(['message' => 'Layanan tidak ditemukan'], 404);
            }
            return response()->json([
                'message' => 'Layanan ditemukan',
                'data' => $layanan
            ]);
        } catch (\Exception $e) {
            Log::error("Show Error: " . $e->getMessage());
            return response()->json([
                'message' => 'Gagal menampilkan data layanan',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $layanan = Layanan::find($id);
            if (!$layanan) {
                return response()->json(['message' => 'Layanan tidak ditemukan'], 404);
            }

            $validator = Validator::make($request->all(), [
                'nama' => 'sometimes|required|string|max:255',
                'deskripsi' => 'nullable|string',
                'harga' => 'sometimes|required|integer',
                'gambar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            ]);

            if ($validator->fails()) {
                return response()->json($validator->errors(), 422);
            }

            $layanan->nama = $request->input('nama', $layanan->nama);
            $layanan->deskripsi = $request->input('deskripsi', $layanan->deskripsi);
            $layanan->harga = $request->input('harga', $layanan->harga);

            if ($request->hasFile('gambar')) {
                if ($layanan->gambar) {
                    Storage::disk('public')->delete($layanan->gambar);
                }
                $path = $request->file('gambar')->store('layanan_images', 'public');
                $layanan->gambar = $path;
            }

            $layanan->save();

            return response()->json([
                'message' => 'Layanan berhasil diperbarui',
                'data' => $layanan
            ]);
        } catch (\Exception $e) {
            Log::error("Update Error: " . $e->getMessage());
            return response()->json([
                'message' => 'Gagal memperbarui layanan',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function destroy($id)
    {
        try {
            $layanan = Layanan::find($id);
            if (!$layanan) {
                return response()->json(['message' => 'Layanan tidak ditemukan'], 404);
            }

            if ($layanan->gambar) {
                Storage::disk('public')->delete($layanan->gambar);
            }

            $layanan->delete();

            return response()->json(['message' => 'Layanan berhasil dihapus']);
        } catch (\Exception $e) {
            Log::error("Destroy Error: " . $e->getMessage());
            return response()->json([
                'message' => 'Gagal menghapus layanan',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
