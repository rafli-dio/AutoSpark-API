<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\PesananCuci;
use App\Models\Layanan;
use App\Models\LayananTambahan;
use App\Models\UkuranKendaraan;
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

    public function getOptions()
    {
        return response()->json([
            'layanans' => Layanan::all(),
            'layanan_tambahans' => LayananTambahan::all(),
            'ukuran_kendaraans' => UkuranKendaraan::all(),
        ]);
    }

    public function store(Request $request)
{
    $validator = Validator::make($request->all(), [
        'layanan_id' => 'required|exists:layanans,id',
        'layanan_tambahan_id' => 'nullable|exists:layanan_tambahans,id',
        'alamat' => 'required|string',
        'tanggal' => 'required|date',
        'waktu' => 'required',
        'plat_nomor' => 'required|string',
        'ukuran_kendaraan_id' => 'required|exists:ukuran_kendaraans,id',
        'status' => 'in:pending,diproses,selesai'
    ]);

    if ($validator->fails()) {
        return response()->json([
            'message' => 'Validasi gagal.',
            'errors' => $validator->errors()
        ], 422);
    }

    try {
        // Ambil harga masing-masing komponen
        $layanan = Layanan::findOrFail($request->layanan_id);
        $ukuran = UkuranKendaraan::findOrFail($request->ukuran_kendaraan_id);
        $layananTambahan = $request->layanan_tambahan_id
            ? LayananTambahan::findOrFail($request->layanan_tambahan_id)
            : null;

        // Hitung subtotal dan total
        $subtotal = $layanan->harga + $ukuran->harga + ($layananTambahan->harga ?? 0);
        $total = $subtotal; // Tambahkan biaya lain jika ada

        // Buat pesanan
        $pesanan = PesananCuci::create([
            'user_id' => $request->user()->id,
            'layanan_id' => $request->layanan_id,
            'layanan_tambahan_id' => $request->layanan_tambahan_id,
            'alamat' => $request->alamat,
            'tanggal' => $request->tanggal,
            'waktu' => $request->waktu,
            'plat_nomor' => $request->plat_nomor,
            'ukuran_kendaraan_id' => $request->ukuran_kendaraan_id,
            'subtotal' => $subtotal,
            'total' => $total,
            'status' => $request->status ?? 'pending',
        ]);

      

        return response()->json([
            'message' => 'Pesanan berhasil dibuat.',
            'data' => $pesanan,
            'detail_subtotal' => [
                'layanan' => $layanan->harga,
                'ukuran_kendaraan' => $ukuran->harga,
                'layanan_tambahan' => $layananTambahan ? $layananTambahan->harga : 0,
                'subtotal' => $subtotal,
                'total' => $total
            ]
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
        $validator = Validator::make($request->all(), [
            'layanan_id' => 'sometimes|exists:layanans,id',
            'layanan_tambahan_id' => 'nullable|exists:layanan_tambahans,id',
            'alamat' => 'sometimes|string',
            'tanggal' => 'sometimes|date',
            'waktu' => 'sometimes',
            'plat_nomor' => 'sometimes|string',
            'ukuran_kendaraan_id' => 'sometimes|exists:ukuran_kendaraans,id',
            'subtotal' => 'sometimes|integer',
            'total' => 'sometimes|integer',
            'status' => 'sometimes|in:pending,diproses,selesai'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Validasi gagal.',
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            $pesanan = PesananCuci::findOrFail($id);
            $pesanan->update($request->only([
                'layanan_id', 'layanan_tambahan_id', 'alamat', 'tanggal',
                'waktu', 'plat_nomor', 'ukuran_kendaraan_id','subtotal',
                'total', 'status'
            ]));

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
