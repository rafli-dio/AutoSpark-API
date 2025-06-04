@extends('admin-lte.app')
@section('title', 'Layanan Tambahan')
@section('active-layanan-tambahan', 'active')
@section('content')
<!-- Modal Tambah Data -->
<div class="modal fade" id="createLayananModal" tabindex="-1" aria-labelledby="createLayananModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="createLayananModalLabel">Tambah Layanan Tambahan</h5>
                <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="createSapiForm" method="POST" action="{{route('save-layanan-tambahan-admin')}}" enctype="multipart/form-data">
                    @csrf
                    <div class="mb-3">
                        <label for="nama" class="form-label">Nama Layanan</label>
                        <input type="text" class="form-control" id="nama" name="nama" required>
                    </div>
                    <div class="mb-3">
                        <label for="deskripsi" class="form-label">Deskripsi Layanan</label>
                        <input type="text" class="form-control" id="deskripsi" name="deskripsi" required>
                    </div>
                    <div class="mb-3">
                        <label for="harga" class="form-label">harga</label>
                        <input type="number" class="form-control" id="harga" name="harga" required>
                    </div>
                    <div class="mb-3">
                        <label for="gambar" class="form-label">gambar</label>
                        <input type="file" class="form-control" id="gambar" name="gambar" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- End Modal -->

<!-- Modal Update Data -->
@foreach($layananTambahan as $item)
<div class="modal fade" id="editModal-{{ $item['id'] }}" tabindex="-1" aria-labelledby="editModalLabel-{{ $item['id'] }}" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editModalLabel-{{ $item['id'] }}">Edit Layanan Tambahan</h5>
                <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form method="POST" action="{{ route('update-layanan-tambahan-admin', $item['id']) }}" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="mb-3">
                        <label for="nama" class="form-label">Nama Layanan</label>
                        <input type="text" class="form-control" name="nama" value="{{ $item['nama'] }}" required>
                    </div>
                    <div class="mb-3">
                        <label for="deskripsi" class="form-label">Deskripsi</label>
                        <input type="text" class="form-control" name="deskripsi" value="{{ $item['deskripsi'] }}" required>
                    </div>
                    <div class="mb-3">
                        <label for="harga" class="form-label">Harga</label>
                        <input type="number" class="form-control" name="harga" value="{{ $item['harga'] }}" required>
                    </div>
                    <div class="mb-3">
                        <label for="gambar" class="form-label">Gambar (opsional)</label><br>
                        @if ($item['gambar'])
                            <img src="{{ asset('storage/' . $item['gambar']) }}" width="80" class="mb-2">
                        @endif
                        <input type="file" class="form-control" name="gambar">
                    </div>
                    <button type="submit" class="btn btn-success">Update</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endforeach
<!-- end Modal Update -->

<div class="card mt-3"> 
<div class="card-header d-flex justify-content-between align-items-center">
    <button class="btn btn-sm btn-primary" data-toggle="modal" data-target="#createLayananModal">Tambah</button>
    <div class="input-group input-group-sm ml-auto" style="width: 200px;"> 
        <input wire:model="search" type="text" class="form-control" placeholder="Search">
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
                    <th width="10%">No</th>
                    <th>Nama Layanan</th>
                    <th>Deskripsi Layanan</th>
                    <th>Harga Layanan</th>
                    <th>Gambar</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
            @forelse ($layananTambahan as $index => $item)
                <tr class="text-center">
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $item['nama'] }}</td>
                    <td>{{ $item['deskripsi'] ?? '-' }}</td>
                    <td>Rp {{ number_format($item['harga'], 0, ',', '.') }}</td>
                    <td>
                        @if ($item['gambar'])
                            <img src="{{ asset('storage/' . $item['gambar']) }}" width="60">
                        @else
                            <span class="text-muted">Tidak ada gambar</span>
                        @endif
                    </td>
                    <td>
                        <button class="btn btn-warning btn-sm" data-toggle="modal" data-target="#editModal-{{ $item['id'] }}">
                            <i class="far fa-edit"></i> Edit
                        </button>
                        <form action="{{ route('destroy-layanan-tambahan-admin', $item['id']) }}" method="POST" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-danger btn-sm" onclick="return confirm('Apakah Anda yakin ingin menghapus data ini?')">
                                <i class="far fa-trash-alt"></i> Hapus
                            </button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" class="text-center">Belum ada data layanan.</td>
                </tr>
            @endforelse
        </tbody>

        </table>
    </div>
</div>
@endsection
