<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\RiwayatPesanan;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Validation\ValidationException;

class RiwayatPesananController extends Controller
{
    public function index()
    {
        try {
            $riwayats = RiwayatPesanan::with('pesanan')->get();
            return response()->json([
                'message' => 'Data riwayat cuci berhasil diambil.',
                'data' => $riwayats
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Gagal mengambil data riwayat pesanan.',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function show($id)
    {
        try {
            $riwayats = RiwayatPesanan::with('pesanan')->findOrFail($id);
            return response()->json([
                'message' => 'Data riwayat cuci berhasil diambil.',
                'data' => $riwayats
            ], 200);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'message' => 'Riwayat pesanan tidak ditemukan.'
            ], 404);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Gagal mengambil detail riwayat pesanan.',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $request->validate([
                'status' => 'required|in:pending,diproses,selesai'
            ]);

            $riwayats = RiwayatPesanan::findOrFail($id);
            $riwayats->update($request->all());

            return response()->json([
                'message' => 'Data riwayat cuci berhasil diupdate.',
                'data' => $riwayats
            ], 200);
        } catch (ValidationException $e) {
            return response()->json([
                'message' => 'Validasi gagal.',
                'errors' => $e->errors()
            ], 422);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'message' => 'Riwayat pesanan tidak ditemukan.'
            ], 404);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Gagal mengupdate riwayat pesanan.',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function destroy($id)
    {
        try {
            $riwayat = RiwayatPesanan::findOrFail($id);
            $riwayat->delete();

            return response()->json(['message' => 'Riwayat pesanan berhasil dihapus.']);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'message' => 'Riwayat pesanan tidak ditemukan.'
            ], 404);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Gagal menghapus riwayat pesanan.',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
