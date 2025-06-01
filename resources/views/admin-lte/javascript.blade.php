<!-- jQuery -->
<script src="/adminlte/plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="/adminlte/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- AdminLTE App -->
<script src="/adminlte/dist/js/adminlte.js"></script>
<!-- full calender -->
<script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.5/index.global.min.js"></script>
    
<script>
    console.log('checkAvailability function loaded');

    document.addEventListener("DOMContentLoaded", function () {
    const mulaiInput = document.getElementById("mulai");

    const now = new Date();
    const formattedNow = now.toISOString().slice(0, 16); 
    mulaiInput.setAttribute("min", formattedNow);
});
</script>

<script>
document.addEventListener("DOMContentLoaded", function () {
    const mulaiInput = document.getElementById("mulai");
    const akhirInput = document.getElementById("akhir");
    const hargaPerJamInput = document.getElementById("harga_per_jam");
    const totalHargaInput = document.getElementById("total_harga");

    function hitungTotalHarga() {
        const mulaiValue = mulaiInput.value;
        const akhirValue = akhirInput.value;

        if (!mulaiValue || !akhirValue) {
            totalHargaInput.value = "";
            return;
        }

        const mulai = new Date(mulaiValue);
        const akhir = new Date(akhirValue);

        if (isNaN(mulai.getTime()) || isNaN(akhir.getTime())) {
            totalHargaInput.value = "Tidak Valid";
            return;
        }

        const jamMulai = mulai.getHours();

        if (jamMulai < 8 || jamMulai >= 23) {
            alert("Tidak Bisa Melakukan Booking, Jam Operasional 08:00 - 23:00");
            mulaiInput.value = "";
            akhirInput.value = "";
            totalHargaInput.value = "";
            return;
        }

        const selisihWaktu = akhir.getTime() - mulai.getTime();
        if (selisihWaktu < 3600000) {
            alert("Minimal 1 jam");
            akhirInput.value = "";
            return;
        }

        const hargaPerJam = parseFloat(hargaPerJamInput.value) || 150000;
        let selisihJam = selisihWaktu / (1000 * 60 * 60);
        selisihJam = Math.ceil(selisihJam);

        const totalHarga = selisihJam * hargaPerJam;

        totalHargaInput.value = totalHarga.toLocaleString("id-ID", {
            style: "currency",
            currency: "IDR",
        });
    }

    mulaiInput.addEventListener("change", hitungTotalHarga);
    akhirInput.addEventListener("change", hitungTotalHarga);
});
document.addEventListener("DOMContentLoaded", function () {
    const statusPembayaran = document.getElementById("status_pembayaran");
    const jumlahDp = document.getElementById("jumlah_dp");

    function toggleJumlahDp() {
        if (statusPembayaran.value === "dp") {
            jumlahDp.removeAttribute("disabled");
            jumlahDp.setAttribute("required", "required");
        } else {
            jumlahDp.setAttribute("disabled", "disabled");
            jumlahDp.removeAttribute("required");
            jumlahDp.value = ""; 
        }
    }

    statusPembayaran.addEventListener("change", toggleJumlahDp);
    toggleJumlahDp(); 
});
</script>

<!-- form input availibility -->
<script>
    document.getElementById('mulai').addEventListener('change', checkAvailability);
    document.getElementById('akhir').addEventListener('change', checkAvailability);

    function checkAvailability() {
        let mulai = document.getElementById('mulai').value;
        let akhir = document.getElementById('akhir').value;

        if (mulai && akhir) {
            fetch(`/check-availability?mulai=${mulai}&akhir=${akhir}`)
                .then(response => response.json())
                .then(data => {
                    if (data.isBooked) {
                        alert('Waktu yang Anda pilih sudah dipesan!');
                        document.getElementById('submitBtn').disabled = true;
                    } else {
                        document.getElementById('submitBtn').disabled = false;
                    }
                });
        }
    }
</script>

<!-- dom mengatasi bentrok jam di update -->
<script>
    document.querySelectorAll(".modal").forEach(modal => {
        modal.addEventListener("shown.bs.modal", function () {
            const id = modal.id.replace("editModal", "");
            const mulaiInput = document.getElementById("mulai-" + id);
            const akhirInput = document.getElementById("akhir-" + id);
            const totalHargaInput = document.getElementById("total_harga-" + id);
            const submitButton = document.getElementById("submit-btn-" + id);
            const hargaPerJam = 150000;

            async function checkAvailability() {
                const mulai = mulaiInput.value;
                const akhir = akhirInput.value;

                if (mulai && akhir) {
                    const response = await fetch(`/check-availability?mulai=${mulai}&akhir=${akhir}&id=${id}`);
                    const data = await response.json();

                    if (data.conflict) {
                        alert("Waktu yang dipilih sudah dibooking oleh pengguna lain.");
                        submitButton.disabled = true;
                    } else {
                        submitButton.disabled = false;
                        calculateTotalHarga();
                    }
                }
            }

            function calculateTotalHarga() {
                const mulai = new Date(mulaiInput.value);
                const akhir = new Date(akhirInput.value);
                if (!isNaN(mulai) && !isNaN(akhir) && akhir > mulai) {
                    const diffMs = akhir - mulai;
                    const diffHours = diffMs / (1000 * 60 * 60);
                    totalHargaInput.value = diffHours * hargaPerJam;
                } else {
                    totalHargaInput.value = "";
                }
            }

            mulaiInput.addEventListener("change", checkAvailability);
            akhirInput.addEventListener("change", checkAvailability);
        });
    });
</script>

<!-- menampilkan kalender -->
