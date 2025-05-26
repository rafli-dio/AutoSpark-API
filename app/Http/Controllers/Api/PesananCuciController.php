<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\PesananCuci;
use App\Models\RiwayatPesanan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PesananCuciController extends Controller
{
    public function index()
    {
        try {
            $pesanan = PesananCuci::with(['user', 'layanan', 'layananTambahan', 'ukuranKendaraan'])->get();

            return response()->json([
                'message' => 'Data pesanan cuci berhasil diambil.',
                'data' => $pesanan
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Terjadi kesalahan saat mengambil data.',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'layanan_id' => 'required|exists:layanans,id',
            'layanan_tambahan_id' => 'nullable|exists:layanan_tambahans,id',
            'alamat' => 'required|string',
            'latitude' => 'nullable|numeric',
            'longitude' => 'nullable|numeric',
            'tanggal' => 'required|date',
            'waktu' => 'required',
            'plat_nomor' => 'required|string',
            'ukuran_kendaraan_id' => 'required|exists:ukuran_kendaraans,id',
            'subtotal' => 'required|integer',
            'total' => 'required|integer',
            'status' => 'in:pending,diproses,selesai'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Validasi gagal.',
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            $pesanan = PesananCuci::create([
                'user_id' => $request->user()->id,
                'layanan_id' => $request->layanan_id,
                'layanan_tambahan_id' => $request->layanan_tambahan_id,
                'alamat' => $request->alamat,
                'latitude' => $request->latitude,
                'longitude' => $request->longitude,
                'tanggal' => $request->tanggal,
                'waktu' => $request->waktu,
                'plat_nomor' => $request->plat_nomor,
                'ukuran_kendaraan_id' => $request->ukuran_kendaraan_id,
                'subtotal' => $request->subtotal,
                'total' => $request->total,
                'status' => $request->status ?? 'pending'
            ]);

            RiwayatPesanan::create([
                'pesanan_id' => $pesanan->id,
                'status' => $pesanan->status
            ]);

            return response()->json([
                'message' => 'Pesanan berhasil dibuat.',
                'data' => $pesanan
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Gagal membuat pesanan.',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function show($id)
    {
        try {
            $pesanan = PesananCuci::with(['user', 'layanan', 'layananTambahan', 'ukuranKendaraan'])->findOrFail($id);

            return response()->json([
                'message' => 'Detail pesanan ditemukan.',
                'data' => $pesanan
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Pesanan tidak ditemukan.',
                'error' => $e->getMessage()
            ], 404);
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $pesanan = PesananCuci::findOrFail($id);
            $pesanan->update($request->all());

            return response()->json([
                'message' => 'Pesanan berhasil diperbarui.',
                'data' => $pesanan
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Gagal memperbarui pesanan.',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function destroy($id)
    {
        try {
            $pesanan = PesananCuci::findOrFail($id);
            $pesanan->delete();

            return response()->json([
                'message' => 'Pesanan berhasil dihapus.'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Gagal menghapus pesanan.',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
