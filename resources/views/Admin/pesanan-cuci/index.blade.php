@extends('admin-lte.app')
@section('title', 'Pesanan Cuci')
@section('active-pesanan', 'active')
@section('content')
<div class="card mt-3"> 
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="mb-0">Daftar Pesanan</h5>
        <div class="input-group input-group-sm ml-auto" style="width: 250px;"> 
            <input wire:model="search" type="text" class="form-control" placeholder="Cari berdasarkan plat / nama user">
            <div class="input-group-append">
                <button type="submit" class="btn btn-default">
                    <i class="fas fa-search"></i>
                </button>
            </div>
        </div>
    </div>

    <div class="card-body table-responsive p-0">
        <table class="table table-hover text-nowrap">
            <thead>
                <tr class="text-center">
                    <th>No</th>
                    <th>Nama User</th>
                    <th>Alamat</th>
                    <th>Layanan</th>
                    <th>Tambahan</th>
                    <th>Tanggal</th>
                    <th>Waktu</th>
                    <th>Plat Nomor</th>
                    <th>Ukuran</th>
                    <th>Status</th>
                    <th>Total</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($pesanan as $index => $item)
                    <tr class="text-center">
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $item->user->nama }}</td>
                        <td>{{ $item->alamat }}</td>
                        <td>{{ $item->layanan->nama }}</td>
                        <td>{{ $item->layananTambahan->nama ?? '-' }}</td>
                        <td>{{ $item->tanggal }}</td>
                        <td>{{ $item->waktu }}</td>
                        <td>{{ $item->plat_nomor }}</td>
                        <td>{{ $item->ukuranKendaraan->ukuran }}</td>
                        <td>
                            @if ($item->status == 'menunggu verifikasi')
                                <span class="badge badge-warning">Menunggu Verifikasir</span>
                            @elseif ($item->status == 'gagal')
                                <span class="badge badge-info">Gagal</span>
                            @else
                                <span class="badge badge-success">Berhasil</span>
                            @endif
                        </td>
                        <td>Rp{{ number_format($item->total, 0, ',', '.') }}</td>
                    </tr>

                    {{-- Modal Edit bisa ditambahkan di sini jika diperlukan --}}
                @empty
                    <tr>
                        <td colspan="11" class="text-center">Belum ada data pesanan.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

@endsection