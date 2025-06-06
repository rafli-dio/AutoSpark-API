<?php

namespace App\Http\Controllers\Web;
use App\Http\Controllers\Controller;

use App\Models\UkuranKendaraan;
use Illuminate\Http\Request;

class UkuranKendaraanController extends Controller
{
    // Tampilkan semua data
    public function index()
    {
        $ukuranKendaraans = UkuranKendaraan::latest()->get();
        return view('admin.ukuran-kendaraan.index', compact('ukuranKendaraans'));
    }

    // Simpan data baru
    public function store(Request $request)
    {
        $request->validate([
            'ukuran' => 'required|string|max:255',
            'harga' => 'required|integer',
        ]);

        UkuranKendaraan::create([
            'ukuran' => $request->ukuran,
            'harga' => $request->harga,
        ]);

        return redirect()->back()->with('success', 'Ukuran kendaraan berhasil ditambahkan.');
    }

    // Update data
    public function update(Request $request, $id)
    {
        $request->validate([
            'ukuran' => 'required|string|max:255',
            'harga' => 'required|integer',
        ]);

        $ukuran = UkuranKendaraan::findOrFail($id);
        $ukuran->update([
            'ukuran' => $request->ukuran,
            'harga' => $request->harga,
        ]);

        return redirect()->back()->with('success', 'Ukuran kendaraan berhasil diperbarui.');
    }

    // Hapus data
    public function destroy($id)
    {
        $ukuran = UkuranKendaraan::findOrFail($id);
        $ukuran->delete();

        return redirect()->back()->with('success', 'Ukuran kendaraan berhasil dihapus.');
    }
}
