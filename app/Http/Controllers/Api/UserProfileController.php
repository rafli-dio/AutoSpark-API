<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class UserProfileController extends Controller
{
    // Menampilkan profil user yang sedang login
    public function getProfile(Request $request)
    {
        try {
            $user = $request->user();

            return response()->json([
                'status' => 'success',
                'data' => [
                    'nama' => $user->nama,
                    'email' => $user->email,
                    'nomor_telepon' => $user->nomor_telepon,
                    'foto' => $user->foto ? asset('storage/' . $user->foto) : null
                ]
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Gagal mengambil data profil.',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    // Memperbarui profil user yang sedang login
    public function updateProfile(Request $request)
    {
        $user = $request->user();

        $validator = Validator::make($request->all(), [
            'nama' => 'sometimes|required|string|max:255',
            'nomor_telepon' => 'nullable|string|max:20',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg|max:2048'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => 'Validasi gagal.',
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            if ($request->filled('nama')) {
                $user->nama = $request->nama;
            }

            if ($request->filled('nomor_telepon')) {
                $user->nomor_telepon = $request->nomor_telepon;
            }

            if ($request->hasFile('foto')) {
                // Hapus foto lama
                if ($user->foto && Storage::disk('public')->exists($user->foto)) {
                    Storage::disk('public')->delete($user->foto);
                }

                // Simpan foto baru
                $path = $request->file('foto')->store('foto_profil', 'public');
                $user->foto = $path;
            }

            $user->save();

            return response()->json([
                'status' => 'success',
                'message' => 'Profil berhasil diperbarui.',
                'data' => [
                    'nama' => $user->nama,
                    'email' => $user->email,
                    'nomor_telepon' => $user->nomor_telepon,
                    'foto' => $user->foto ? asset('storage/' . $user->foto) : null
                ]
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Terjadi kesalahan saat memperbarui profil.',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
