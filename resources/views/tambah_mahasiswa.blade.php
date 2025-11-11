<div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasTambah" aria-labelledby="offcanvasTambahLabel">
    <div class="offcanvas-header">
        <h5 id="offcanvasTambahLabel">Tambah Mahasiswa</h5>
        <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <div class="offcanvas-body">
        <form action="{{ route('mahasiswa.store') }}" method="POST">
            @csrf
            <div class="mb-3">
                <label for="nim" class="form-label">NIM</label>
                <input type="text" class="form-control" id="nim" name="nim" required>
            </div>
            <div class="mb-3">
                <label for="nama" class="form-label">Nama</label>
                <input type="text" class="form-control" id="nama" name="nama" required>
            </div>
            <button type="submit" class="btn btn-success">Simpan</button>
        </form>
    </div>
</div>
