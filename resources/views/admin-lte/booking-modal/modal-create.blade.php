<!-- Booking Modal -->
<div class="modal fade" id="bookingModal" tabindex="-1" aria-labelledby="bookingModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="bookingModalLabel">Buat Booking</h5>
                <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
            <form id="bookingForm" method="POST" action="{{ route('store-booking-admin') }}" enctype="multipart/form-data">
            @csrf
                    <div class="mb-3">
                        <label for="nama" class="form-label">Nama</label>
                        <input type="text" class="form-control" id="nama" name="nama" required>
                    </div>
                    <div class="mb-3">
                        <label for="no_hp" class="form-label">Nomor HP</label>
                        <input type="text" class="form-control" id="no_hp" name="no_hp" required>
                    </div>
                    <div class="mb-3">
                        <label for="acara" class="form-label">Team</label>
                        <input type="text" class="form-control" id="acara" name="acara" required>
                    </div>
                    
                    <div class="mb-3">
                        <label for="mulai" class="form-label">Mulai</label>
                        <input type="datetime-local" class="form-control" id="mulai" name="mulai" required>
                    </div>
                    <div class="mb-3">
                        <label for="akhir" class="form-label">Akhir</label>
                        <input type="datetime-local" class="form-control" id="akhir" name="akhir" required>
                    </div>
                    <div class="mb-3">
                        <label for="harga_per_jam" class="form-label">Harga Per Jam</label>
                        <input type="number" class="form-control" id="harga_per_jam" name="harga_per_jam" value="150000" readonly required>
                    </div>
                    <div class="mb-3">
                        <label for="total_harga" class="form-label">Total Harga</label>
                        <input type="text" class="form-control" id="total_harga" name="total_harga" readonly required>
                    </div>
                    <div class="mb-3">
                        <label for="jenis_pembayaran" class="form-label">Jenis Pembayaran</label>
                        <select class="form-control" id="jenis_pembayaran" name="jenis_pembayaran" required>
                            <option value="transfer">Transfer</option>
                            <option value="tunai">Tunai</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="status_pembayaran" class="form-label">Status Pembayaran</label>
                        <select class="form-control" id="status_pembayaran" name="status_pembayaran" required>
                            <option value="dp">DP</option>
                            <option value="lunas">Lunas</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="jumlah_dp" class="form-label">Jumlah DP</label>
                        <input type="number" class="form-control" id="jumlah_dp" name="jumlah_dp" disabled required>
                    </div>
                    <div class="mb-3">
                        <label for="bukti_pembayaran" class="form-label">Bukti Pembayaran</label>
                        <input type="file" class="form-control" id="bukti_pembayaran" name="bukti_pembayaran" accept="image/*">
                    </div>
                    <button type="submit" class="btn btn-primary" id="submitBtn">Submit</button>
                </form>
            </div>
        </div>
    </div>
</div>
