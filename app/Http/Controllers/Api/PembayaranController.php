<?php

namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use App\Models\Pembayaran;
use App\Models\MetodePembayaran;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rule;

class PembayaranController extends Controller
{
     public function index(Request $request)
    {
        try {
            $user = $request->user();

            $data = Pembayaran::with([
                'pesanan.layanan', 
                'pesanan.ukuranKendaraan', 
                'metodePembayaran'
            ])
            ->whereHas('pesanan', function ($query) use ($user) {
                $query->where('user_id', $user->id);
            })
            ->latest() 
            ->get();

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
            'status' => 'in:proses,berhasil,gagal'
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
                'status' => $request->status ?? 'proses',
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

   public function updateStatus(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'status' => ['required', Rule::in(['proses', 'berhasil', 'gagal'])],
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Validasi gagal.',
                'errors' => $validator->errors(),
            ], 422);
        }

        try {
            $pembayaran = Pembayaran::findOrFail($id);

            $pembayaran->status = $request->status;
            $pembayaran->save();

            return response()->json([
                'message' => 'Status pembayaran berhasil diperbarui.',
                'data' => $pembayaran,
            ], 200);

        } catch (\Exception $e) {
            Log::error('Gagal update status pembayaran: ' . $e->getMessage());

            return response()->json([
                'message' => 'Gagal memperbarui status pembayaran.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }
    public function destroy($id)
    {
        try {
            $pembayaran = Pembayaran::findOrFail($id);

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