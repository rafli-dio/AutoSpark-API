@extends('admin-lte.app')
@section('title', 'Daftar Pembayaran')
@section('active-pembayaran', 'active')
@section('content')
<div class="card mt-3"> 
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="mb-0">Daftar Pembayaran</h5>
        <div class="input-group input-group-sm ml-auto" style="width: 250px;"> 
            <input wire:model="search" type="text" class="form-control" placeholder="Cari berdasarkan nama / pesanan">
            <div class="input-group-append">
                <button type="submit" class="btn btn-default">
                    <i class="fas fa-search"></i>
                </button>
            </div>
        </div>
    </div>

    <div class="card-body table-responsive p-0">
        <table class="table table-hover text-nowrap">
            <thead class="text-center">
                <tr>
                    <th>No</th>
                    <th>Nama Pengguna</th>
                    <th>No. Pesanan</th>
                    <th>Metode</th>
                    <th>Status</th>
                    <th>Bukti</th>
                    <th>Tanggal</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($pembayaran as $index => $item)
                    <tr class="text-center">
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $item->pesanan->user->nama }}</td>
                        <td>#{{ $item->pesanan->id }}</td>
                        <td>{{ $item->metodePembayaran->nama ?? '-' }}</td>
                        <td>
                            @if ($item->status == 'proses')
                                <span class="badge badge-warning">proses</span>
                            @elseif ($item->status == 'gagal')
                                <span class="badge badge-danger">Gagal</span>
                            @else
                                <span class="badge badge-success">Berhasil</span>
                            @endif
                        </td>
                        <td>
                            @if ($item->bukti_pembayaran)
                                <a href="{{ asset('storage/' . $item->bukti_pembayaran) }}" target="_blank" class="btn btn-sm btn-primary">Lihat</a>
                            @else
                                <span class="text-muted">Belum Ada</span>
                            @endif
                        </td>
                        <td>{{ $item->created_at->format('d M Y') }}</td>
                        <td>
                            <form action="{{ route('update-status-pembayaran-admin', $item->id) }}" method="POST" class="d-inline">
                                @csrf
                                @method('PUT')
                                <select name="status" class="form-control form-control-sm d-inline-block" style="width: 140px;" onchange="this.form.submit()">
                                    <option value="proses" style="color: #856404; background-color: #fff3cd;" {{ $item->status == 'proses' ? 'selected' : '' }}>proses</option>
                                    <option value="berhasil" style="color: #155724; background-color: #d4edda;" {{ $item->status == 'berhasil' ? 'selected' : '' }}>Berhasil</option>
                                    <option value="gagal" style="color: #721c24; background-color: #f8d7da;" {{ $item->status == 'gagal' ? 'selected' : '' }}>Gagal</option>
                                </select>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="8" class="text-center">Belum ada data pembayaran.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection