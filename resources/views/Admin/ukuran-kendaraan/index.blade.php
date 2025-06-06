@extends('admin-lte.app')
@section('title', 'Ukuran Kendaraan')
@section('active-ukuran-kendaraan', 'active')
@section('content')
<!-- Modal Tambah Data -->
<div class="modal fade" id="createUkuranModal" tabindex="-1" aria-labelledby="createUkuranModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="createUkuranModalLabel">Tambah Ukuran Kendaraan</h5>
                <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form method="POST" action="{{ route('save-ukuran-kendaraan-admin') }}">
                    @csrf
                    <div class="mb-3">
                        <label for="ukuran" class="form-label">Ukuran Kendaraan</label>
                        <input type="text" class="form-control" id="ukuran" name="ukuran" required>
                    </div>
                    <div class="mb-3">
                        <label for="harga" class="form-label">Harga</label>
                        <input type="number" class="form-control" id="harga" name="harga" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- End Modal -->

<!-- Modal Update Data -->
@foreach($ukuranKendaraans as $item)
<div class="modal fade" id="editUkuranModal-{{ $item->id }}" tabindex="-1" aria-labelledby="editUkuranModalLabel-{{ $item->id }}" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editUkuranModalLabel-{{ $item->id }}">Edit Ukuran Kendaraan</h5>
                <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form method="POST" action="{{ route('update-ukuran-kendaraan-admin', $item->id) }}">
                    @csrf
                    @method('PUT')
                    <div class="mb-3">
                        <label for="ukuran" class="form-label">Ukuran Kendaraan</label>
                        <input type="text" class="form-control" name="ukuran" value="{{ $item->ukuran }}" required>
                    </div>
                    <div class="mb-3">
                        <label for="harga" class="form-label">Harga</label>
                        <input type="number" class="form-control" name="harga" value="{{ $item->harga }}" required>
                    </div>
                    <button type="submit" class="btn btn-success">Update</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endforeach
<!-- End Modal Update -->

<div class="card mt-3">
    <div class="card-header d-flex justify-content-between align-items-center">
        <button class="btn btn-sm btn-primary" data-toggle="modal" data-target="#createUkuranModal">Tambah</button>
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
                    <th>Ukuran Kendaraan</th>
                    <th>Harga</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
            @forelse ($ukuranKendaraans as $index => $item)
                <tr class="text-center">
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $item->ukuran }}</td>
                    <td>Rp {{ number_format($item->harga, 0, ',', '.') }}</td>
                    <td>
                        <button class="btn btn-warning btn-sm" data-toggle="modal" data-target="#editUkuranModal-{{ $item->id }}">
                            <i class="far fa-edit"></i> Edit
                        </button>
                        <form action="{{ route('destroy-ukuran-kendaraan-admin', $item->id) }}" method="POST" class="d-inline">
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
                    <td colspan="4" class="text-center">Belum ada data ukuran kendaraan.</td>
                </tr>
            @endforelse
            </tbody>
        </table>
    </div>
</div>

@endsection