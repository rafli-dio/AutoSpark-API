<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\MetodePembayaran;
use Illuminate\Support\Facades\Storage; // <-- Tambahkan import ini

class MetodePembayaranController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $metodePembayaran = MetodePembayaran::all();
        return view('Admin.metode-pembayaran.index', compact('metodePembayaran'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'tipe' => 'required|string|max:255',
            'nomor' => 'required|string|max:255',
            'atas_nama' => 'required|string|max:255',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,svg|max:2048', 
        ]);

        $data = $request->all();

        if ($request->hasFile('logo')) {
            $path = $request->file('logo')->store('logos', 'public');
            $data['logo'] = $path;
        }

        MetodePembayaran::create($data);

        return redirect()->route('get-metode-pembayaran-admin')->with('success', 'Metode pembayaran berhasil ditambahkan');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        // Biasanya tidak digunakan di CRUD admin web standar, bisa dikosongkan
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'tipe' => 'required|string|max:255',
            'nomor' => 'required|string|max:255',
            'atas_nama' => 'required|string|max:255',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,svg|max:2048',
        ]);

        $metode = MetodePembayaran::findOrFail($id);
        $data = $request->all();

        if ($request->hasFile('logo')) {
            if ($metode->logo) {
                Storage::disk('public')->delete($metode->logo);
            }
            $path = $request->file('logo')->store('logos', 'public');
            $data['logo'] = $path;
        }

        $metode->update($data);

        return redirect()->route('get-metode-pembayaran-admin')->with('success', 'Metode pembayaran berhasil diupdate');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $metode = MetodePembayaran::findOrFail($id);

        if ($metode->logo) {
            Storage::disk('public')->delete($metode->logo);
        }

        $metode->delete();

        return redirect()->route('get-metode-pembayaran-admin')->with('success', 'Metode pembayaran berhasil dihapus');
    }
}
