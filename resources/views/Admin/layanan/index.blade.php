@extends('admin-lte.app')
@section('title', 'Layanan')
@section('active-kategori', 'active')
@section('content')
<div class="card mt-3"> 
<div class="card-header d-flex justify-content-between align-items-center">
    <button class="btn btn-sm btn-primary" data-toggle="modal" data-target="#createKategoriModal">Tambah</button>
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
                <tr>
                    <td class="text-center">1</td>
                    <td class="text-center">2</td>
                    <td class="text-center">3</td>
                    <td class="text-center">
                        <button class="btn btn-warning btn-sm" data-toggle="modal" data-target="">
                            <i class="far fa-edit"></i> Edit
                        </button>
                        <form action="" method="POST" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-danger btn-sm" onclick="return confirm('Apakah Anda yakin ingin menghapus data ini?')">
                                <i class="far fa-trash-alt"></i> Hapus
                            </button>
                        </form>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
    <div class="card-body">
        <div class="alert alert-warning">Belum ada data Layanan.</div>
    </div>
</div>
@endsection
