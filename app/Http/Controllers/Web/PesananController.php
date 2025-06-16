<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\PesananCuci;
use Illuminate\Validation\Rule;

class PesananController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $pesanan = PesananCuci::with(['user', 'layanan', 'layananTambahan', 'ukuranKendaraan'])->latest()->get();
        return view('Admin.pesanan-cuci.index', compact('pesanan'));
    }


    /**
     * Update the specified resource in storage.
     * Khusus untuk memperbarui status pesanan dari panel admin.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $validStatus = ['proses', 'berangkat', 'sampai', 'dicuci', 'selesai', 'gagal'];

        $request->validate([
            'status' => ['required', Rule::in($validStatus)],
        ]);

        try {
            $pesanan = PesananCuci::findOrFail($id);

            $pesanan->update([
                'status' => $request->status,
            ]);

            return redirect()->route('get-pesanan-cuci-admin') 
                             ->with('success', 'Status pesanan berhasil diperbarui.');

        } catch (\Exception $e) {
            return back()->with('error', 'Gagal memperbarui status pesanan: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            $pesanan = PesananCuci::findOrFail($id);
            $pesanan->delete();
            return redirect()->route('get-pesanan-cuci-admin')->with('success', 'Pesanan berhasil dihapus.');
        } catch (\Exception $e) {
            return back()->with('error', 'Gagal menghapus pesanan.');
        }
    }
}
