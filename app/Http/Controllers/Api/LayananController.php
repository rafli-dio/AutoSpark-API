<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Layanan;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class LayananController extends Controller
{
    // Tampilkan semua layanan
    public function index()
    {
        try {
            $layanan = Layanan::all();
            return response()->json([
                'message' => 'Data layanan berhasil diambil',
                'data' => $layanan
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Gagal mengambil data layanan',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    // Simpan layanan baru
    public function store(Request $request)
    {
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

        // Upload gambar jika ada
        if ($request->hasFile('gambar')) {
            $path = $request->file('gambar')->store('layanan_images', 'public');
            $data['gambar'] = $path;
        }

        $layanan = Layanan::create($data);

        return response()->json($layanan, 201);
    }

    // Tampilkan layanan berdasarkan id
    public function show($id)
    {
        $layanan = Layanan::find($id);
        if (!$layanan) {
            return response()->json(['message' => 'Layanan tidak ditemukan'], 404);
        }
        return response()->json($layanan);
    }

    // Update layanan berdasarkan id
    public function update(Request $request, $id)
    {
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
            // Hapus gambar lama jika ada
            if ($layanan->gambar) {
                Storage::disk('public')->delete($layanan->gambar);
            }
            $path = $request->file('gambar')->store('layanan_images', 'public');
            $layanan->gambar = $path;
        }

        $layanan->save();

        return response()->json($layanan);
    }

    // Hapus layanan
    public function destroy($id)
    {
        $layanan = Layanan::find($id);
        if (!$layanan) {
            return response()->json(['message' => 'Layanan tidak ditemukan'], 404);
        }

        // Hapus gambar jika ada
        if ($layanan->gambar) {
            Storage::disk('public')->delete($layanan->gambar);
        }

        $layanan->delete();

        return response()->json(['message' => 'Layanan berhasil dihapus']);
    }
}
