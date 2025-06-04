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
            alert(
                "Tidak Bisa Melakukan Booking, Jam Operasional 08:00 - 23:00"
            );
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

        // Hitung total harga
        const hargaPerJam = parseFloat(hargaPerJamInput.value) || 150000;
        let selisihJam = selisihWaktu / (1000 * 60 * 60);
        selisihJam = Math.ceil(selisihJam);

        const totalHarga = selisihJam * hargaPerJam;

        totalHargaInput.value = totalHarga.toLocaleString("id-ID", {
            style: "currency",
            currency: "IDR",
        });
    }

    // Event Listener
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

document.getElementById("mulai").addEventListener("change", checkAvailability);
document.getElementById("akhir").addEventListener("change", checkAvailability);

function checkAvailability() {
    let mulai = document.getElementById("mulai").value;
    let akhir = document.getElementById("akhir").value;

    if (mulai && akhir) {
        fetch(`/check-availability?mulai=${mulai}&akhir=${akhir}`)
            .then((response) => response.json())
            .then((data) => {
                if (data.isBooked) {
                    alert("Waktu yang Anda pilih sudah dipesan!");
                    document.getElementById("submitBtn").disabled = true;
                } else {
                    document.getElementById("submitBtn").disabled = false;
                }
            });
    }
}
