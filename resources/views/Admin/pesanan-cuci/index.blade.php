@extends('admin-lte.app')
@section('title', 'Pesanan Cuci')
@section('active-pesanan', 'active')
@section('content')

<div class="card mt-3">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="mb-0">Daftar Pesanan</h5>
        <div class="input-group input-group-sm ml-auto" style="width: 250px;">
            <input wire:model="search" type="text" class="form-control" placeholder="Cari pesanan...">
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
                    <th>Tanggal & Waktu</th>
                    <th>Plat Nomor</th>
                    <th>Ukuran</th>
                    <th>Status</th>
                    <th>Total</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($pesanan as $index => $item)
                    <tr class="text-center">
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $item->user->nama ?? 'N/A' }}</td>
                        <td style="white-space: normal;">{{ $item->alamat }}</td>
                        <td>{{ $item->layanan->nama ?? 'N/A' }}</td>
                        <td>
                            {{-- PERBAIKAN: Gunakan @forelse untuk menampilkan daftar layanan tambahan --}}
                            @forelse($item->layananTambahan as $tambahan)
                                <span class="badge badge-secondary">{{ $tambahan->nama }}</span>
                            @empty
                                -
                            @endforelse
                        </td>
                        <td>{{ \Carbon\Carbon::parse($item->tanggal . ' ' . $item->waktu)->format('d M Y, H:i') }}</td>
                        <td>{{ $item->plat_nomor }}</td>
                        {{-- Memanggil 'ukuran' dari objek relasi 'ukuranKendaraan' --}}
                        <td>{{ $item->ukuranKendaraan->ukuran ?? 'N/A' }}</td>
                        <td>
                            @switch($item->status)
                                @case('proses')
                                    <span class="badge badge-warning">Proses</span>
                                    @break
                                @case('berangkat')
                                    <span class="badge badge-info">Berangkat</span>
                                    @break
                                @case('sampai')
                                    <span class="badge" style="background-color: #6f42c1; color: white;">Sampai</span>
                                    @break
                                @case('dicuci')
                                    <span class="badge badge-primary">Dicuci</span>
                                    @break
                                @case('selesai')
                                    <span class="badge badge-success">Selesai</span>
                                    @break
                                @case('gagal')
                                    <span class="badge badge-danger">Gagal</span>
                                    @break
                                @default
                                    <span class="badge badge-secondary">{{ ucfirst($item->status) }}</span>
                            @endswitch
                        </td>
                        <td>Rp{{ number_format($item->total, 0, ',', '.') }}</td>
                        <td>
                            <button class="btn btn-sm btn-info" data-toggle="modal" data-target="#editStatusModal-{{ $item->id }}">
                                <i class="fas fa-edit"></i> Ubah Status
                            </button>
                        </td>
                    </tr>

                    <!-- Modal Edit Status untuk setiap item -->
                    <div class="modal fade" id="editStatusModal-{{ $item->id }}" tabindex="-1" aria-labelledby="editStatusModalLabel-{{ $item->id }}" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="editStatusModalLabel-{{ $item->id }}">Ubah Status Pesanan #{{ $item->id }}</h5>
                                    <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    {{-- Pastikan nama route ini sudah benar --}}
                                    <form method="POST" action="{{ route('update-pesanan-cuci-admin', $item->id) }}">
                                        @csrf
                                        @method('PUT')
                                        <div class="form-group">
                                            <label for="status-{{ $item->id }}">Status Pesanan</label>
                                            <select class="form-control" id="status-{{ $item->id }}" name="status">
                                                <option value="proses" {{ $item->status == 'proses' ? 'selected' : '' }}>Proses</option>
                                                <option value="berangkat" {{ $item->status == 'berangkat' ? 'selected' : '' }}>Berangkat</option>
                                                <option value="sampai" {{ $item->status == 'sampai' ? 'selected' : '' }}>Sampai</option>
                                                <option value="dicuci" {{ $item->status == 'dicuci' ? 'selected' : '' }}>Dicuci</option>
                                                <option value="selesai" {{ $item->status == 'selesai' ? 'selected' : '' }}>Selesai</option>
                                                <option value="gagal" {{ $item->status == 'gagal' ? 'selected' : '' }}>Gagal</option>
                                            </select>
                                        </div>
                                        <button type="submit" class="btn btn-primary float-right">Simpan Perubahan</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                    <tr>
                        <td colspan="12" class="text-center">Belum ada data pesanan.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

@endsection
