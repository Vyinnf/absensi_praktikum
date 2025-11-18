<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Absensi Mahasiswa</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/style.css')}}">
</head>

<body>

    <!-- Header Section -->
    <div class="header-section">
        <div class="container">
            <div class="header-content">
                <div class="header-title">
                    <div class="header-icon">
                        <i class="fas fa-graduation-cap"></i>
                    </div>
                    <div>
                        <h1>Dashboard Absensi</h1>
                        <p>Sistem Manajemen Nilai Mahasiswa</p>
                    </div>
                </div>
                <button class="btn-primary-custom" data-bs-toggle="offcanvas" data-bs-target="#offcanvasTambah">
                    <i class="fas fa-plus"></i>
                    Tambah Mahasiswa
                </button>
            </div>
        </div>
    </div>

    <!-- Main Content -->
    <div class="container mb-5">
        <div class="table-container">
            <div class="table-responsive">
                <table class="table-custom">
                    <thead>
                        <tr>
                            <th rowspan="2">No</th>
                            <th rowspan="2">NIM</th>
                            <th rowspan="2">Nama</th>
                            @for ($i = 1; $i <= 10; $i++)
<th colspan="3" class="module-header" data-modul="{{ $i }}">
  <button type="button"
          class="btn btn-sm btn-outline-secondary toggle-module me-2"
          data-modul="{{ $i }}"
          aria-expanded="true"
          title="Tutup/Buka Modul {{ $i }}">
    <i class="fas fa-chevron-down"></i>
  </button>
  <span class="module-title">Modul {{ $i }}</span>
</th>


                            @endfor
                            <th rowspan="2">Final Project</th>
                            <th rowspan="2">Nilai Akhir</th>
                            <th rowspan="2">Grade</th>
                            <th rowspan="2">Aksi</th>
                        </tr>
                        <tr>
                            @for ($i = 1; $i <= 10; $i++)
                                <th class="mod-col mod-{{ $i }}">Kehadiran</th>
                                <th class="mod-col mod-{{ $i }}">Laporan</th>
                                <th class="mod-col mod-{{ $i }}">Demo</th>
                            @endfor
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($mahasiswa as $m)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td><strong>{{ $m->nim }}</strong></td>
                                <td style="text-align: left;">{{ $m->nama }}</td>

                                {{-- Loop modul --}}
                                @for ($i = 1; $i <= 10; $i++)
                                    @php
                                        $nilai = $m->nilai_moduls->where('modul', $i)->first();
                                    @endphp
                                    <td class="mod-col mod-{{ $i }}" contenteditable="true" data-mahasiswa="{{ $m->id }}"
                                        data-modul="{{ $i }}" data-kolom="kehadiran">
                                        {{ $nilai->kehadiran ?? '' }}
                                    </td>
                                    <td class="mod-col mod-{{ $i }}" contenteditable="true" data-mahasiswa="{{ $m->id }}"
                                        data-modul="{{ $i }}" data-kolom="laporan">
                                        {{ $nilai->laporan ?? '' }}
                                    </td>
                                    <td class="mod-col mod-{{ $i }}" contenteditable="true" data-mahasiswa="{{ $m->id }}"
                                        data-modul="{{ $i }}" data-kolom="demo">
                                        {{ $nilai->demo ?? '' }}
                                    </td>
                                @endfor

                                {{-- Final Project --}}
                                @php
                                    $finalProject = $m->nilai_moduls->first()?->final_project ?? '';
                                @endphp
                                <td contenteditable="true" data-mahasiswa="{{ $m->id }}" data-kolom="final_project">
                                    {{ $finalProject }}
                                </td>

                                {{-- Nilai Akhir --}}
                                <td>
                                    <strong style="font-size: 1.125rem; color: var(--primary-color);">
                                        {{ $m->getNilaiAkhir() }}
                                    </strong>
                                </td>

                                {{-- Grade --}}
                                <td>
                                    @php
                                        $grade = $m->getGrade();
                                        $gradeClass = 'grade-' . strtolower($grade);
                                    @endphp
                                    <span class="grade-badge {{ $gradeClass }}">{{ $grade }}</span>
                                </td>

                                {{-- Aksi --}}
                                <td>
                                    <button class="btn-action btn-edit" data-id="{{ $m->id }}"
                                        data-nim="{{ $m->nim }}" data-nama="{{ $m->nama }}"
                                        data-bs-toggle="modal" data-bs-target="#modalEdit">
                                        <i class="fas fa-edit"></i> Edit
                                    </button>
                                    <button class="btn-action btn-delete btn-hapus" data-id="{{ $m->id }}">
                                        <i class="fas fa-trash"></i> Hapus
                                    </button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    {{-- OFFCANVAS TAMBAH MAHASISWA --}}
    <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasTambah">
        <div class="offcanvas-header">
            <h5 class="offcanvas-title"><i class="fas fa-user-plus me-2"></i>Tambah Mahasiswa Baru</h5>
            <button type="button" class="btn-close" data-bs-dismiss="offcanvas"></button>
        </div>
        <div class="offcanvas-body">
            <form id="formTambahMahasiswa">
                @csrf
                <div class="mb-3">
                    <label class="form-label">NIM</label>
                    <input type="text" class="form-control" id="nim" name="nim" placeholder="Masukkan NIM" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Nama Lengkap</label>
                    <input type="text" class="form-control" id="nama" name="nama" placeholder="Masukkan nama lengkap" required>
                </div>
                <button type="submit" class="btn-submit">
                    <i class="fas fa-save me-2"></i>Simpan Data
                </button>
            </form>
        </div>
    </div>

    {{-- MODAL EDIT MAHASISWA --}}
    <div class="modal fade" id="modalEdit" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <form id="formEditMahasiswa">
                    <div class="modal-header">
                        <h5 class="modal-title"><i class="fas fa-user-edit me-2"></i>Edit Data Mahasiswa</h5>
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
                            <label class="form-label">Nama Lengkap</label>
                            <input type="text" id="edit_nama" class="form-control" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn-submit">
                            <i class="fas fa-check me-2"></i>Simpan Perubahan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // === Tambah Mahasiswa ===
        document.addEventListener('DOMContentLoaded', function() {
            const formTambah = document.getElementById('formTambahMahasiswa');
            const submitBtn = formTambah.querySelector('button[type="submit"]');

            formTambah.addEventListener('submit', async function(e) {
                e.preventDefault();

                submitBtn.disabled = true;
                const originalHTML = submitBtn.innerHTML;
                submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Menyimpan...';

                const formData = new FormData(formTambah);

                try {
                    const response = await fetch("{{ route('mahasiswa.store') }}", {
                        method: "POST",
                        headers: {
                            "X-CSRF-TOKEN": "{{ csrf_token() }}"
                        },
                        body: formData
                    });

                    if (response.redirected) {
                        const offcanvasEl = document.getElementById('offcanvasTambah');
                        if (offcanvasEl && bootstrap?.Offcanvas) {
                            bootstrap.Offcanvas.getInstance(offcanvasEl)?.hide();
                        }
                        formTambah.reset();
                        window.location.href = response.url;
                        return;
                    }

                    const data = await response.json();
                    if (data.success) {
                        const offcanvasEl = document.getElementById('offcanvasTambah');
                        bootstrap.Offcanvas.getInstance(offcanvasEl)?.hide();
                        formTambah.reset();
                        location.reload();
                    } else {
                        alert('Gagal menyimpan data mahasiswa');
                    }
                } catch (error) {
                    console.error(error);
                    alert('Terjadi kesalahan koneksi: ' + error.message);
                } finally {
                    submitBtn.disabled = false;
                    submitBtn.innerHTML = originalHTML;
                }
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
            const submitBtn = this.querySelector('button[type="submit"]');
            const originalHTML = submitBtn.innerHTML;
            submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Menyimpan...';
            submitBtn.disabled = true;

            const id = document.getElementById('edit_id').value;
            const nim = document.getElementById('edit_nim').value;
            const nama = document.getElementById('edit_nama').value;

            fetch(`/mahasiswa/update/${id}`, {
                    method: "PUT",
                    headers: {
                        "X-CSRF-TOKEN": "{{ csrf_token() }}",
                        "Content-Type": "application/json",
                    },
                    body: JSON.stringify({
                        nim,
                        nama
                    })
                })
                .then(res => res.json())
                .then(data => {
                    if (data.success) {
                        bootstrap.Modal.getInstance(document.getElementById('modalEdit')).hide();
                        location.reload();
                    } else {
                        alert('Gagal mengedit mahasiswa: ' + (data.message || ''));
                    }
                })
                .catch(err => {
                    console.error(err);
                    alert('Terjadi kesalahan koneksi');
                })
                .finally(() => {
                    submitBtn.disabled = false;
                    submitBtn.innerHTML = originalHTML;
                });
        });

        // === Hapus Mahasiswa ===
        document.querySelectorAll('.btn-hapus').forEach(btn => {
            btn.addEventListener('click', function() {
                if (!confirm("Yakin ingin menghapus mahasiswa ini?")) return;

                const id = this.dataset.id;
                const btnText = this.innerHTML;
                this.innerHTML = '<i class="fas fa-spinner fa-spin"></i>';
                this.disabled = true;

                fetch(`/mahasiswa/delete/${id}`, {
                        method: "DELETE",
                        headers: {
                            "X-CSRF-TOKEN": "{{ csrf_token() }}"
                        }
                    })
                    .then(res => res.json())
                    .then(data => {
                        if (data.success) {
                            location.reload();
                        } else {
                            alert('Gagal menghapus mahasiswa: ' + (data.message || ''));
                            this.innerHTML = btnText;
                            this.disabled = false;
                        }
                    })
                    .catch(err => {
                        console.error(err);
                        alert('Terjadi kesalahan koneksi');
                        this.innerHTML = btnText;
                        this.disabled = false;
                    });
            });
        });

        // === Inline Edit Nilai Modul & Final Project ===
        document.querySelectorAll('[contenteditable="true"]').forEach(cell => {
            cell.addEventListener('blur', function() {
                const mahasiswa_id = this.dataset.mahasiswa;
                const modul = this.dataset.modul || null;
                const kolom = this.dataset.kolom;
                const nilai = this.innerText.trim();

                if (nilai && isNaN(nilai)) {
                    alert('Nilai harus berupa angka');
                    this.classList.add('cell-error');
                    setTimeout(() => this.classList.remove('cell-error'), 500);
                    return;
                }

                this.classList.add('loading-cell');

                fetch("{{ route('nilai.update') }}", {
                        method: "POST",
                        headers: {
                            "X-CSRF-TOKEN": "{{ csrf_token() }}",
                            "Content-Type": "application/json",
                        },
                        body: JSON.stringify({
                            mahasiswa_id,
                            modul,
                            kolom,
                            nilai: nilai ? parseInt(nilai) : null
                        })
                    })
                    .then(res => res.json())
                    .then(data => {
                        this.classList.remove('loading-cell');
                        if (data.success) {
                            this.classList.add('cell-success');
                            setTimeout(() => {
                                this.classList.remove('cell-success');
                                location.reload();
                            }, 600);
                        } else {
                            this.classList.add('cell-error');
                            setTimeout(() => this.classList.remove('cell-error'), 500);
                            alert('Gagal menyimpan nilai: ' + (data.message || ''));
                        }
                    })
                    .catch(err => {
                        console.error(err);
                        this.classList.remove('loading-cell');
                        this.classList.add('cell-error');
                        setTimeout(() => this.classList.remove('cell-error'), 500);
                        alert('Terjadi kesalahan koneksi');
                    });
            });
        });

// helper: angka -> romawi (1..10)
// toggle modul: menambah/menghapus kelas .mod-col-hidden pada semua sub-col (header baris kedua + semua td)
(function () {
  function toRoman(n) {
    const r = ["","I","II","III","IV","V","VI","VII","VIII","IX","X"];
    return r[n] || n;
  }

  function toggleModule(modul, forceState = null) {
    const btn = document.querySelector('.toggle-module[data-modul="'+modul+'"]');
    const moduleHeader = document.querySelector('.module-header[data-modul="'+modul+'"]');
    const moduleTitle = moduleHeader?.querySelector('.module-title');

    if (!btn || !moduleHeader) {
      console.warn('toggleModule: tidak menemukan tombol/header untuk modul', modul);
      return;
    }

    const isExpanded = btn.getAttribute('aria-expanded') === 'true';
    const willExpand = forceState === null ? !isExpanded : Boolean(forceState);

    // sub-header di baris ke-2
    const headerSubcells = document.querySelectorAll('thead tr:nth-child(2) th.mod-col.mod-' + modul);
    // semua td body untuk modul ini
    const bodyCells = document.querySelectorAll('tbody tr td.mod-col.mod-' + modul);

    if (!willExpand) {
      // collapse: tambahkan kelas hide
      headerSubcells.forEach(el => el.classList.add('mod-col-hidden'));
      bodyCells.forEach(el => el.classList.add('mod-col-hidden'));
      // ubah colspan
      try { moduleHeader.colSpan = 1; } catch(e) { moduleHeader.setAttribute('colspan','1'); }
      if (moduleTitle) moduleTitle.textContent = toRoman(parseInt(modul,10));
      btn.setAttribute('aria-expanded','false');
      btn.classList.add('collapsed');
      btn.title = 'Buka Modul ' + modul;
    } else {
      // expand: hapus kelas hide
      headerSubcells.forEach(el => el.classList.remove('mod-col-hidden'));
      bodyCells.forEach(el => el.classList.remove('mod-col-hidden'));
      try { moduleHeader.colSpan = 3; } catch(e) { moduleHeader.setAttribute('colspan','3'); }
      if (moduleTitle) moduleTitle.textContent = 'Modul ' + modul;
      btn.setAttribute('aria-expanded','true');
      btn.classList.remove('collapsed');
      btn.title = 'Tutup/Buka Modul ' + modul;
    }

    // Force reflow / layout update agar browser merender ulang tabel dengan benar
    // (memaksa repaint)
    document.querySelector('.table-custom')?.offsetWidth;
    // tambahan event resize agar library/sticky header menyusun ulang
    window.dispatchEvent(new Event('resize'));
  }

  // pasang event ke tombol-tombol
  document.querySelectorAll('.toggle-module').forEach(btn => {
    btn.addEventListener('click', function () {
      const modul = this.dataset.modul;
      if (!modul) return;
      toggleModule(modul, null);
    });
  });

  // expose global util (opsional)
  window.toggleAllModules = function(state) {
    document.querySelectorAll('.toggle-module').forEach(b => {
      const modul = b.dataset.modul;
      if (modul) toggleModule(modul, state);
    });
  };

  // DEBUG: tampilkan jumlah tombol yang terdeteksi
  console.log('toggle-module count:', document.querySelectorAll('.toggle-module').length);
})();

   </script>

</body>

</html>
