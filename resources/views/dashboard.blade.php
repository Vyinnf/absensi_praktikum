<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Absensi Mahasiswa</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container mt-5">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h3>📘 Dashboard Absensi Mahasiswa</h3>
        <button class="btn btn-primary" data-bs-toggle="offcanvas" data-bs-target="#offcanvasTambah">
            + Tambah Mahasiswa
        </button>
    </div>

    <div class="table-responsive">
        <table class="table table-bordered align-middle text-center">
            <thead class="table-secondary">
                <tr>
                    <th rowspan="2">No</th>
                    <th rowspan="2">NIM</th>
                    <th rowspan="2">Nama</th>
                    @for($i = 1; $i <= 10; $i++)
                        <th colspan="3">Modul {{ $i }}</th>
                    @endfor
                    <th rowspan="2">Final Project</th>
                    <th rowspan="2">Nilai Akhir</th>
                    <th rowspan="2">Abjad</th>
                    <th rowspan="2">Aksi</th>
                </tr>
                <tr>
                    @for($i = 1; $i <= 10; $i++)
                        <th>Kehadiran</th>
                        <th>Laporan</th>
                        <th>Demo</th>
                    @endfor
                </tr>
            </thead>
            <tbody>
                @foreach($mahasiswa as $index => $m)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $m->nim }}</td>
                        <td>{{ $m->nama }}</td>

                        {{-- Isi modul kosong manual --}}
                        @for($i = 1; $i <= 10; $i++)
                            <td contenteditable="true"
                                class="editable"
                                data-mahasiswa="{{ $m->id }}"
                                data-modul="{{ $i }}"
                                data-kolom="kehadiran"></td>
                            <td contenteditable="true"
                                class="editable"
                                data-mahasiswa="{{ $m->id }}"
                                data-modul="{{ $i }}"
                                data-kolom="laporan"></td>
                            <td contenteditable="true"
                                class="editable"
                                data-mahasiswa="{{ $m->id }}"
                                data-modul="{{ $i }}"
                                data-kolom="demo"></td>
                        @endfor

                        <td contenteditable="true" class="editable-final" data-id="{{ $m->id }}"></td>
                        <td></td>
                        <td></td>
                        <td>
                            <button class="btn btn-sm btn-warning btn-edit"
                                data-id="{{ $m->id }}"
                                data-nim="{{ $m->nim }}"
                                data-nama="{{ $m->nama }}"
                                data-bs-toggle="modal"
                                data-bs-target="#modalEdit">
                                📝 Edit
                            </button>
                            <button class="btn btn-sm btn-danger btn-hapus" data-id="{{ $m->id }}">
                                🗑️ Hapus
                            </button>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

{{-- =====================================
     OFFCANVAS TAMBAH MAHASISWA
===================================== --}}
<div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasTambah">
  <div class="offcanvas-header">
    <h5 class="offcanvas-title">Tambah Mahasiswa</h5>
    <button type="button" class="btn-close" data-bs-dismiss="offcanvas"></button>
  </div>
  <div class="offcanvas-body">
    <form id="formTambahMahasiswa">
        @csrf
        <div class="mb-3">
            <label class="form-label">NIM</label>
            <input type="text" class="form-control" id="nim" name="nim" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Nama</label>
            <input type="text" class="form-control" id="nama" name="nama" required>
        </div>
        <button type="submit" class="btn btn-success w-100">Simpan</button>
    </form>
  </div>
</div>

{{-- =====================================
     MODAL EDIT MAHASISWA
===================================== --}}
<div class="modal fade" id="modalEdit" tabindex="-1">
  <div class="modal-dialog">
    <div class="modal-content">
      <form id="formEditMahasiswa">
        <div class="modal-header">
          <h5 class="modal-title">Edit Mahasiswa</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body">
          @csrf
          <input type="hidden" id="edit_id">
          <div class="mb-3">
            <label class="form-label">NIM</label>
            <input type="text" id="edit_nim" class="form-control" required>
          </div>
          <div class="mb-3">
            <label class="form-label">Nama</label>
            <input type="text" id="edit_nama" class="form-control" required>
          </div>
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
        </div>
      </form>
    </div>
  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
// === Tambah Mahasiswa ===
document.getElementById('formTambahMahasiswa').addEventListener('submit', function(e) {
    e.preventDefault();
    const formData = new FormData(this);

    fetch("{{ route('mahasiswa.store') }}", {
        method: "POST",
        headers: { "X-CSRF-TOKEN": "{{ csrf_token() }}" },
        body: formData
    })
    .then(res => res.json())
    .then(data => {
        if (data.success) location.reload();
        else alert('Gagal menambah mahasiswa');
    });
});

// === Buka Modal Edit ===
document.querySelectorAll('.btn-edit').forEach(btn => {
    btn.addEventListener('click', function() {
        document.getElementById('edit_id').value = this.dataset.id;
        document.getElementById('edit_nim').value = this.dataset.nim;
        document.getElementById('edit_nama').value = this.dataset.nama;
    });
});

// === Simpan Perubahan Edit ===
document.getElementById('formEditMahasiswa').addEventListener('submit', function(e) {
    e.preventDefault();
    const id = document.getElementById('edit_id').value;
    const nim = document.getElementById('edit_nim').value;
    const nama = document.getElementById('edit_nama').value;

    fetch(`/mahasiswa/update/${id}`, {
        method: "POST",
        headers: {
            "X-CSRF-TOKEN": "{{ csrf_token() }}",
            "Content-Type": "application/json",
        },
        body: JSON.stringify({ nim, nama })
    })
    .then(res => res.json())
    .then(data => {
        if (data.success) location.reload();
        else alert('Gagal mengedit mahasiswa');
    });
});

// === Hapus Mahasiswa ===
document.querySelectorAll('.btn-hapus').forEach(btn => {
    btn.addEventListener('click', function() {
        if (!confirm("Yakin ingin menghapus mahasiswa ini?")) return;

        const id = this.dataset.id;

        fetch(`/mahasiswa/delete/${id}`, {
            method: "DELETE",
            headers: { "X-CSRF-TOKEN": "{{ csrf_token() }}" }
        })
        .then(res => res.json())
        .then(data => {
            if (data.success) location.reload();
            else alert('Gagal menghapus mahasiswa');
        });
    });
});

// === Inline Edit Nilai Modul ===
document.querySelectorAll('.editable').forEach(cell => {
    cell.addEventListener('blur', function() {
        const mahasiswa_id = this.dataset.mahasiswa;
        const modul = this.dataset.modul;
        const kolom = this.dataset.kolom;
        const nilai = this.innerText.trim();

        fetch("{{ route('nilai.update') }}", {
            method: "POST",
            headers: {
                "X-CSRF-TOKEN": "{{ csrf_token() }}",
                "Content-Type": "application/json",
            },
            body: JSON.stringify({ mahasiswa_id, modul, kolom, nilai })
        })
        .then(res => res.json())
        .then(data => {
            if (data.success) {
                this.style.backgroundColor = "#d4edda";
                setTimeout(() => this.style.backgroundColor = "", 600);
            } else {
                this.style.backgroundColor = "#f8d7da";
            }
        });
    });
});
</script>

</body>
</html>
