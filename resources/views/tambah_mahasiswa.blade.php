<!-- Offcanvas Tambah Mahasiswa -->
<div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasTambah" aria-labelledby="offcanvasTambahLabel">
    <div class="offcanvas-header">
        <h5 id="offcanvasTambahLabel">Tambah Mahasiswa</h5>
        <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>

    <div class="offcanvas-body">
        <form id="formTambahMahasiswa" action="{{ route('mahasiswa.store') }}" method="POST">
            @csrf
            <div class="mb-3">
                <label for="nim" class="form-label">NIM</label>
                <input type="text" class="form-control" id="nim" name="nim" required>
            </div>
            <div class="mb-3">
                <label for="nama" class="form-label">Nama</label>
                <input type="text" class="form-control" id="nama" name="nama" required>
            </div>
            <button type="submit" class="btn btn-success w-100">Simpan</button>
        </form>
    </div>
</div>

<!-- Tambahkan Script di bawah halaman -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    const formTambah = document.getElementById('formTambahMahasiswa');
    if (!formTambah) return;

    const submitBtn = formTambah.querySelector('button[type="submit"]');
    // safety: jika tidak ada tombol submit, jangan lanjut
    if (!submitBtn) return;

    submitBtn.addEventListener('click', async function(e) {
        e.preventDefault(); // hentikan reload bawaan

        // disable tombol untuk mencegah double submit
        submitBtn.disabled = true;
        const originalText = submitBtn.innerHTML;
        submitBtn.innerHTML = 'Menyimpan...';

        const formData = new FormData(formTambah);

        try {
            const response = await fetch(formTambah.action || '{{ route("mahasiswa.store") }}', {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: formData
            });

            if (response.ok) {
                // Tutup offcanvas dengan aman — jika bootstrap ada gunakan API resminya,
                // jika tidak, lakukan fallback sederhana untuk menghapus overlay.
                try {
                    const offcanvasEl = document.getElementById('offcanvasTambah');
                    if (window.bootstrap && window.bootstrap.Offcanvas) {
                        const instance = window.bootstrap.Offcanvas.getInstance(offcanvasEl) || new window.bootstrap.Offcanvas(offcanvasEl);
                        instance.hide();
                    } else if (offcanvasEl) {
                        // fallback: hapus class show dan backdrop jika ada
                        offcanvasEl.classList.remove('show');
                        offcanvasEl.setAttribute('aria-hidden', 'true');
                        const backdrop = document.querySelector('.offcanvas-backdrop');
                        if (backdrop) backdrop.remove();
                        document.body.classList.remove('offcanvas-open');
                    }
                } catch (err) {
                    // tidak fatal — log untuk debug
                    console.warn('Gagal menutup offcanvas dengan API Bootstrap:', err);
                }

                // Reset form dan reload untuk memuat data terbaru
                formTambah.reset();
                location.reload();
            } else {
                // coba ambil pesan dari respons jika ada
                let msg = 'Gagal menyimpan data mahasiswa.';
                try {
                    const json = await response.json();
                    if (json && json.message) msg += '\n' + json.message;
                } catch (_) {}
                alert(msg);
            }
        } catch (error) {
            console.error(error);
            alert('Terjadi kesalahan koneksi.');
        } finally {
            submitBtn.disabled = false;
            submitBtn.innerHTML = originalText;
        }
    });
});
</script>
