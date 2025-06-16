<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Layanan;
use App\Models\LayananTambahan;
use App\Models\PesananCuci;
use App\Models\UkuranKendaraan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class PesananCuciController extends Controller
{

    public function index()
    {
        try {
            $pesanan = PesananCuci::with(['user', 'layanan', 'layananTambahan', 'ukuranKendaraan'])->get();

            return response()->json([
                'message' => 'Data pesanan cuci berhasil diambil.',
                'data' => $pesanan,
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Terjadi kesalahan saat mengambil data.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }


    public function getOrders(Request $request)
    {
        try {
            $userId = auth()->user()->id;
            
            $orders = PesananCuci::with(['user', 'layanan', 'layananTambahan', 'ukuranKendaraan'])
                                 ->where('user_id', $userId)
                                 ->latest() 
                                 ->get();
    
            return response()->json([
                'success' => true,
                'data' => $orders,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal mengambil riwayat pesanan.',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function getOptions()
    {
        try {
            return response()->json([
                'layanans' => Layanan::all(),
                'layanan_tambahans' => LayananTambahan::all(),
                'ukuran_kendaraans' => UkuranKendaraan::all(),
            ]);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Gagal mengambil data opsi.'], 500);
        }
    }

    public function store(Request $request)
    {
        $validStatus = ['proses', 'berangkat', 'sampai', 'dicuci', 'selesai', 'gagal'];

        $validator = Validator::make($request->all(), [
            'layanan_id' => 'required|exists:layanans,id',
            'layanan_tambahan_id' => 'nullable|array', 
            'layanan_tambahan_id.*' => 'exists:layanan_tambahans,id', 
            'alamat' => 'required|string',
            'tanggal' => 'required|date',
            'waktu' => 'required',
            'plat_nomor' => 'required|string',
            'ukuran_kendaraan_id' => 'required|exists:ukuran_kendaraans,id',
            'status' => ['nullable', Rule::in($validStatus)],
        ]);

        if ($validator->fails()) {
            return response()->json(['message' => 'Validasi gagal.', 'errors' => $validator->errors()], 422);
        }

        try {
            $layanan = Layanan::findOrFail($request->layanan_id);
            $ukuran = UkuranKendaraan::findOrFail($request->ukuran_kendaraan_id);
            
            $layananTambahanIds = $request->layanan_tambahan_id ?? [];
            $totalHargaTambahan = 0;
            if (!empty($layananTambahanIds)) {
                $totalHargaTambahan = LayananTambahan::whereIn('id', $layananTambahanIds)->sum('harga');
            }
            
            $subtotal = $layanan->harga + $totalHargaTambahan;
            $total = $subtotal + $ukuran->harga;

            $pesanan = PesananCuci::create([
                'user_id' => $request->user()->id,
                'layanan_id' => $request->layanan_id,
                'alamat' => $request->alamat,
                'tanggal' => $request->tanggal,
                'waktu' => $request->waktu,
                'plat_nomor' => $request->plat_nomor,
                'ukuran_kendaraan_id' => $request->ukuran_kendaraan_id,
                'subtotal' => $subtotal,
                'total' => $total,
                'status' => $request->status ?? 'proses',
            ]);

            if (!empty($layananTambahanIds)) {
                $pesanan->layananTambahan()->attach($layananTambahanIds);
            }

            $pesanan->load('layananTambahan');

            return response()->json(['message' => 'Pesanan berhasil dibuat.', 'data' => $pesanan], 201);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Gagal membuat pesanan.', 'error' => $e->getMessage()], 500);
        }
    }


    public function show($id)
    {
        try {
            $pesanan = PesananCuci::with(['user', 'layanan', 'layananTambahan', 'ukuranKendaraan'])->findOrFail($id);
            return response()->json(['message' => 'Detail pesanan ditemukan.', 'data' => $pesanan]);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Pesanan tidak ditemukan.', 'error' => $e->getMessage()], 404);
        }
    }


    public function update(Request $request, $id)
    {
        $validStatus = ['proses', 'berangkat', 'sampai', 'dicuci', 'selesai', 'gagal'];
        
        $validator = Validator::make($request->all(), [
            'status' => ['sometimes', Rule::in($validStatus)],
        ]);

        if ($validator->fails()) {
            return response()->json(['message' => 'Validasi gagal.', 'errors' => $validator->errors()], 422);
        }

        try {
            $pesanan = PesananCuci::findOrFail($id);
            $pesanan->update($request->all());

            return response()->json(['message' => 'Pesanan berhasil diperbarui.', 'data' => $pesanan]);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Gagal memperbarui pesanan.', 'error' => $e->getMessage()], 500);
        }
    }

    public function destroy($id)
    {
        try {
            $pesanan = PesananCuci::findOrFail($id);
            $pesanan->delete();

            return response()->json(['message' => 'Pesanan berhasil dihapus.']);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Gagal menghapus pesanan.', 'error' => $e->getMessage()], 500);
        }
    }
}
