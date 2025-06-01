<div class="modal fade" id="editModal{{ $bookings->id }}" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form method="POST" action="{{ route('updateBooking', $bookings->id) }}" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="modal-header">
                    <h5 class="modal-title">Edit Booking</h5>
                    <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <!-- Pesan Error -->
                    @if(session('error'))
                    <div class="alert alert-danger">
                        {{ session('error') }}
                    </div>
                    @endif

                    <!-- Nama -->
                    <div class="mb-3">
                        <label for="nama" class="form-label">Nama</label>
                        <input type="text" class="form-control" name="nama" value="{{ $bookings->nama }}" required>
                    </div>
                    <div class="mb-3">
                        <label for="no_hp" class="form-label">Nomor HP</label>
                        <input type="text" class="form-control" name="no_hp" value="{{ $bookings->no_hp }}" required>
                    </div>
                    <!-- Acara -->
                    <div class="mb-3">
                        <label for="acara" class="form-label">Team</label>
                        <input type="text" class="form-control" name="acara" value="{{ $bookings->acara }}" required>
                    </div>

                    <!-- Mulai -->
                    <div class="mb-3">
                        <label for="mulai" class="form-label">Mulai</label>
                        <input type="datetime-local" class="form-control booking-time" id="mulai-{{ $bookings->id }}" name="mulai" value="{{ $bookings->mulai }}" required>
                    </div>

                    <!-- Akhir -->
                    <div class="mb-3">
                        <label for="akhir" class="form-label">Akhir</label>
                        <input type="datetime-local" class="form-control booking-time" id="akhir-{{ $bookings->id }}" name="akhir" value="{{ $bookings->akhir }}" required>
                    </div>

                    <!-- Harga Per Jam -->
                    <div class="mb-3">
                        <label for="harga_per_jam" class="form-label">Harga Per Jam</label>
                        <input type="number" class="form-control" name="harga_per_jam" value="150000" disabled>
                    </div>

                    <!-- Total Harga -->
                    <div class="mb-3">
                        <label for="total_harga" class="form-label">Total Harga</label>
                        <input type="text" class="form-control" id="total_harga-{{ $bookings->id }}" name="total_harga" value="{{ $bookings->total_harga }}" readonly>
                    </div>

                    <!-- Jenis Pembayaran -->
                    <div class="mb-3">
                        <label for="jenis_pembayaran" class="form-label">Jenis Pembayaran</label>
                        <select class="form-control" name="jenis_pembayaran" required>
                            <option value="transfer" {{ $bookings->jenis_pembayaran == 'transfer' ? 'selected' : '' }}>Transfer</option>
                            <option value="tunai" {{ $bookings->jenis_pembayaran == 'tunai' ? 'selected' : '' }}>Tunai</option>
                        </select>
                    </div>

                    <!-- Bukti Pembayaran -->
                    <div class="mb-3">
                        <label for="bukti_pembayaran" class="form-label">Bukti Pembayaran (Opsional)</label>
                        <input type="file" class="form-control" id="bukti_pembayaran-{{ $bookings->id }}" name="bukti_pembayaran" accept="image/*">
                        @if ($bookings->bukti_pembayaran)
                            <p class="mt-2">Bukti sebelumnya: <a href="{{ asset('storage/' . $bookings->bukti_pembayaran) }}" target="_blank">Lihat</a></p>
                        @endif
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary" id="submit-btn-{{ $bookings->id }}">Simpan Perubahan</button>
                </div>
            </form>
        </div>
    </div>
</div>