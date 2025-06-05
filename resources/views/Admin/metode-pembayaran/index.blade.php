@extends('admin-lte.app')
@section('title', 'Metode Pembayaran')
@section('active-metode-pembayaran', 'active')
@section('content')

<!-- Modal Tambah Data -->
<div class="modal fade" id="createMetodeModal" tabindex="-1" aria-labelledby="createMetodeModalModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="createMetodeModalModalLabel">Tambah Metode Pembayaran</h5>
                <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="createMetodeModalForm" method="POST" action="{{route('save-metode-pembayaran-admin')}}" enctype="multipart/form-data">
                    @csrf
                    <div class="mb-3">
                        <label for="nama" class="form-label">Nama Metode</label>
                        <input type="text" class="form-control" id="nama" name="nama" required>
                    </div>
                    <div class="mb-3">
                        <label for="tipe" class="form-label">Tipe</label>
                        <input type="text" class="form-control" id="tipe" name="tipe" required>
                    </div>
                    <div class="mb-3">
                        <label for="nomor" class="form-label">Nomor</label>
                        <input type="text" class="form-control" id="nomor" name="nomor" required>
                    </div>
                    <div class="mb-3">
                        <label for="atas_nama" class="form-label">Atas Nama</label>
                        <input type="text" class="form-control" id="atas_nama" name="atas_nama" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- End Modal -->

<!-- Modal Edit Data -->
 @foreach ($metodePembayaran as $item)
<div class="modal fade" id="editMetodeModal-{{ $item->id }}" tabindex="-1" aria-labelledby="editMetodeModalLabel-{{ $item->id }}" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editMetodeModalLabel-{{ $item->id }}">Edit Metode Pembayaran</h5>
                <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form method="POST" action="{{ route('update-metode-pembayaran-admin', $item->id) }}">
                    @csrf
                    @method('PUT')
                    <div class="mb-3">
                        <label for="nama" class="form-label">Nama Metode</label>
                        <input type="text" class="form-control" id="nama" name="nama" value="{{ $item->nama }}" required>
                    </div>
                    <div class="mb-3">
                        <label for="tipe" class="form-label">Tipe</label>
                        <input type="text" class="form-control" id="tipe" name="tipe" value="{{ $item->tipe }}" required>
                    </div>
                    <div class="mb-3">
                        <label for="nomor" class="form-label">Nomor</label>
                        <input type="text" class="form-control" id="nomor" name="nomor" value="{{ $item->nomor }}" required>
                    </div>
                    <div class="mb-3">
                        <label for="atas_nama" class="form-label">Atas Nama</label>
                        <input type="text" class="form-control" id="atas_nama" name="atas_nama" value="{{ $item->atas_nama }}" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Update</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endforeach

<div class="card mt-3"> 
<div class="card-header d-flex justify-content-between align-items-center">
    <button class="btn btn-sm btn-primary" data-toggle="modal" data-target="#createMetodeModal">Tambah</button>
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
                    <th>Nama Metode</th>
                    <th>Tipe</th>
                    <th>Nomor</th>
                    <th>Atas Nama</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
            @forelse ($metodePembayaran as $index => $item)
                <tr class="text-center">
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $item['nama'] }}</td>
                    <td>{{ $item['tipe'] ?? '-' }}</td>
                    <td>{{ $item['nomor'] }}</td>
                    <td>{{ $item['atas_nama'] }}</td>
                    <td>
                        <button class="btn btn-warning btn-sm" data-toggle="modal" data-target="#editMetodeModal-{{ $item['id'] }}">
                            <i class="far fa-edit"></i> Edit
                        </button>
                        <form action="{{ route('destroy-metode-pembayaran-admin', $item['id']) }}" method="POST" class="d-inline">
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