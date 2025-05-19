<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\LayananTambahan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;

class LayananTambahanController extends Controller
{
    public function index()
    {
        try {
            $data = LayananTambahan::all();

            return response()->json([
                'message' => 'Data layanan tambahan berhasil diambil',
                'data' => $data
            ]);
        } catch (\Throwable $e) {
            Log::error('Index Error: ' . $e->getMessage());
            return response()->json([
                'message' => 'Terjadi kesalahan saat mengambil data'
            ], 500);
        }
    }

    public function store(Request $request)
    {
        try {
            $request->validate([
                'nama' => 'required|string|max:255',
                'deskripsi' => 'nullable|string',
                'harga' => 'required|integer',
                'gambar' => 'nullable|image|max:2048',
            ]);

            $gambarPath = null;
            if ($request->hasFile('gambar')) {
                $gambarPath = $request->file('gambar')->store('layanan_tambahan_images', 'public');
            }

            $layananTambahan = LayananTambahan::create([
                'nama' => $request->nama,
                'deskripsi' => $request->deskripsi,
                'harga' => $request->harga,
                'gambar' => $gambarPath,
            ]);

            return response()->json([
                'message' => 'Layanan tambahan berhasil ditambahkan',
                'data' => $layananTambahan
            ]);
        } catch (\Throwable $e) {
            Log::error('Store Error: ' . $e->getMessage());
            return response()->json([
                'message' => 'Terjadi kesalahan saat menambahkan layanan tambahan'
            ], 500);
        }
    }

    public function show($id)
    {
        try {
            $layananTambahan = LayananTambahan::find($id);

            if (!$layananTambahan) {
                return response()->json([
                    'message' => 'Layanan tambahan tidak ditemukan'
                ], 404);
            }

            return response()->json([
                'message' => 'Data layanan tambahan ditemukan',
                'data' => $layananTambahan
            ]);
        } catch (\Throwable $e) {
            Log::error('Show Error: ' . $e->getMessage());
            return response()->json([
                'message' => 'Terjadi kesalahan saat mengambil data layanan tambahan'
            ], 500);
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $layananTambahan = LayananTambahan::find($id);

            if (!$layananTambahan) {
                return response()->json([
                    'message' => 'Layanan tambahan tidak ditemukan'
                ], 404);
            }

            $request->validate([
                'nama' => 'sometimes|string|max:255',
                'deskripsi' => 'nullable|string',
                'harga' => 'sometimes|integer',
                'gambar' => 'nullable|image|max:2048',
            ]);

            if ($request->hasFile('gambar')) {
                // Hapus gambar lama
                if ($layananTambahan->gambar) {
                    Storage::disk('public')->delete($layananTambahan->gambar);
                }

                $layananTambahan->gambar = $request->file('gambar')->store('layanan_tambahan_images', 'public');
            }

            $layananTambahan->update($request->only(['nama', 'deskripsi', 'harga']));

            return response()->json([
                'message' => 'Layanan tambahan berhasil diperbarui',
                'data' => $layananTambahan
            ]);
        } catch (\Throwable $e) {
            Log::error('Update Error: ' . $e->getMessage());
            return response()->json([
                'message' => 'Terjadi kesalahan saat memperbarui layanan tambahan'
            ], 500);
        }
    }

    public function destroy($id)
    {
        try {
            $layananTambahan = LayananTambahan::find($id);

            if (!$layananTambahan) {
                return response()->json([
                    'message' => 'Layanan tambahan tidak ditemukan'
                ], 404);
            }

            if ($layananTambahan->gambar) {
                Storage::disk('public')->delete($layananTambahan->gambar);
            }

            $layananTambahan->delete();

            return response()->json([
                'message' => 'Layanan tambahan berhasil dihapus'
            ]);
        } catch (\Throwable $e) {
            Log::error('Destroy Error: ' . $e->getMessage());
            return response()->json([
                'message' => 'Terjadi kesalahan saat menghapus layanan tambahan'
            ], 500);
        }
    }
}
