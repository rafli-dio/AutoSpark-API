<?php

namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use App\Models\PesananCuci;
use App\Models\Pembayaran;
use App\Models\MetodePembayaran;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;

class PembayaranController extends Controller
{
    // GET /api/pembayaran
    public function index()
    {
        try {
            $data = Pembayaran::with(['pesanan', 'metodePembayaran'])->get();

            return response()->json([
                'message' => 'Data pembayaran berhasil diambil.',
                'data' => $data
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Gagal mengambil data.',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function getMetodePembayaran()
    {
        try {
            $metodes = MetodePembayaran::all();

            return response()->json([
                'message' => 'Daftar metode pembayaran berhasil diambil.',
                'data' => $metodes
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Gagal mengambil data metode pembayaran.',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    // POST /api/pembayaran
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'pesanan_id' => 'required|exists:pesanan_cucis,id',
            'metode_pembayaran_id' => 'required|exists:metode_pembayarans,id',
            'bukti_pembayaran' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'status' => 'in:menunggu verifikasi,berhasil,gagal'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Validasi gagal.',
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            $buktiPath = null;
            if ($request->hasFile('bukti_pembayaran')) {
                $buktiPath = $request->file('bukti_pembayaran')->store('bukti_pembayaran', 'public');
            }

            $pembayaran = Pembayaran::create([
                'pesanan_id' => $request->pesanan_id,
                'metode_pembayaran_id' => $request->metode_pembayaran_id,
                'bukti_pembayaran' => $buktiPath,
                'status' => $request->status ?? 'menunggu verifikasi',
            ]);

            return response()->json([
                'message' => 'Pembayaran berhasil disimpan.',
                'data' => $pembayaran
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Gagal menyimpan pembayaran.',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    // PUT /api/pembayaran/{id}
   public function updateStatus(Request $request, $id)
{
    $request->validate([
        'status' => 'required|in:menunggu verifikasi,berhasil,gagal',
    ]);

    try {
        DB::beginTransaction();

        $pembayaran = Pembayaran::with('pesanan')->findOrFail($id);
        $pembayaran->status = $request->status;
        $pembayaran->save();

        $pesanan = $pembayaran->pesanan;
        $pesanan->status = $request->status; 
        $pesanan->save();

        DB::commit();

        return response()->json([
            'message' => 'Status pembayaran dan pesanan berhasil diperbarui.',
            'data' => [
                'pembayaran' => $pembayaran,
                'pesanan' => $pesanan,
            ],
        ], 200);

    } catch (\Exception $e) {
        DB::rollBack();
        Log::error('Gagal update status pembayaran: ' . $e->getMessage());

        return response()->json([
            'message' => 'Gagal memperbarui status.',
            'error' => $e->getMessage(),
        ], 500);
    }
}
    // DELETE /api/pembayaran/{id}
    public function destroy($id)
    {
        try {
            $pembayaran = Pembayaran::findOrFail($id);

            // Hapus file bukti jika ada
            if ($pembayaran->bukti_pembayaran && Storage::disk('public')->exists($pembayaran->bukti_pembayaran)) {
                Storage::disk('public')->delete($pembayaran->bukti_pembayaran);
            }

            $pembayaran->delete();

            return response()->json([
                'message' => 'Pembayaran berhasil dihapus.'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Gagal menghapus pembayaran.',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}