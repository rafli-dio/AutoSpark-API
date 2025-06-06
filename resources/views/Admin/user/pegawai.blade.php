@extends('admin-lte.app')
@section('title', 'Daftar User Pegawai')
@section('active-pegawai', 'active')
@section('content')
<div class="card mt-3"> 
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="mb-0">Daftar Pegawai</h5>
        <div class="input-group input-group-sm ml-auto" style="width: 250px;"> 
            <form method="GET" action="" class="d-flex">
                <input name="search" type="text" class="form-control" placeholder="Cari nama/email..." value="{{ request('search') }}">
                <div class="input-group-append">
                    <button type="submit" class="btn btn-default">
                        <i class="fas fa-search"></i>
                    </button>
                </div>
            </form>
        </div>
    </div>
    <div class="card-body table-responsive p-0">
        <table class="table table-hover text-nowrap">
            <thead class="text-center">
                <tr>
                    <th>No</th>
                    <th>Nama</th>
                    <th>Email</th>
                    <th>No. Telepon</th>
                    <th>Foto</th>
                    <th>Tanggal Registrasi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($pegawais as $index => $pegawai)
                    <tr class="text-center">
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $pegawai->nama }}</td>
                        <td>{{ $pegawai->email }}</td>
                        <td>{{ $pegawai->nomor_telepon ?? '-' }}</td>
                        <td>
                            @if ($pegawai->foto)
                                <img src="{{ asset('storage/' . $pegawai->foto) }}" alt="Foto" width="40" height="40" class="rounded-circle">
                            @else
                                <span class="text-muted">Tidak Ada</span>
                            @endif
                        </td>
                        <td>{{ $pegawai->created_at->format('d M Y') }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="text-center">Tidak ada pegawai ditemukan.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

@endsection