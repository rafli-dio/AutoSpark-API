<?php

namespace App\Http\Controllers\Web;
use App\Http\Controllers\Controller;

use App\Models\UkuranKendaraan;
use Illuminate\Http\Request;

class UkuranKendaraanController extends Controller
{
    public function index()
    {
        $ukuranKendaraans = UkuranKendaraan::latest()->get();
        return view('admin.ukuran-kendaraan.index', compact('ukuranKendaraans'));
    }

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

    public function destroy($id)
    {
        $ukuran = UkuranKendaraan::findOrFail($id);
        $ukuran->delete();

        return redirect()->back()->with('success', 'Ukuran kendaraan berhasil dihapus.');
    }
}
