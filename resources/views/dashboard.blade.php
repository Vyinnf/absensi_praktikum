<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Absensi Mahasiswa</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="p-4 bg-light">
    <div class="container-fluid">

        <h1 class="mb-4">Dashboard Absensi Mahasiswa</h1>

        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <!-- Tombol Tambah Mahasiswa -->
        <button class="btn btn-primary mb-3" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasTambah">
            + Tambah Mahasiswa
        </button>

        @include('tambah_mahasiswa')

        <div class="table-responsive">
            <table class="table table-bordered table-hover align-middle text-center">
                <thead class="table-secondary">
                    <tr>
                        <th rowspan="3">No</th>
                        <th rowspan="3">NIM</th>
                        <th rowspan="3">Nama</th>
                        <th colspan="3" rowspan="2">Kehadiran</th>
                        <th colspan="30">Modul</th>
                        <th rowspan="3">Final Project</th>
                        <th rowspan="3">Nilai Akhir</th>
                        <th rowspan="3">Abjad</th>
                        <th rowspan="3">Aksi</th>
                    </tr>
                    <tr>
                        @for($i = 1; $i <= 10; $i++)
                            <th colspan="3">Modul {{ $i }}</th>
                        @endfor
                    </tr>
                    <tr>
                        <th>Hadir</th>
                        <th>Tidak Hadir</th>
                        <th>Izin</th>

                        @for($i = 1; $i <= 10; $i++)
                            <th>Kehadiran</th>
                            <th>Laporan Praktikum</th>
                            <th>Demo Implementasi</th>
                        @endfor
                    </tr>
                </thead>

                <tbody>
                    @forelse($mahasiswa as $index => $m)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $m->nim }}</td>
                        <td>{{ $m->nama }}</td>

                        <!-- Kehadiran -->
                        <td><input type="checkbox" name="hadir_{{ $index }}" class="kehadiran" data-row="{{ $index }}"></td>
                        <td><input type="checkbox" name="tidak_hadir_{{ $index }}" class="kehadiran" data-row="{{ $index }}"></td>
                        <td><input type="checkbox" name="izin_{{ $index }}" class="kehadiran" data-row="{{ $index }}"></td>

                        @for($i = 1; $i <= 10; $i++)
                            <td></td><td></td><td></td>
                        @endfor

                        <td></td>
                        <td></td>
                        <td></td>

                        <!-- Tombol Edit -->
                        <td>
                            <button class="btn btn-sm btn-warning"
                                data-bs-toggle="modal"
                                data-bs-target="#editModal{{ $m->id }}">
                                Edit
                            </button>
                        </td>
                    </tr>

                    <!-- Modal Edit Mahasiswa -->
                    <div class="modal fade" id="editModal{{ $m->id }}" tabindex="-1" aria-labelledby="editModalLabel{{ $m->id }}" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <form action="{{ route('mahasiswa.update', $m->id) }}" method="POST">
                                    @csrf
                                    @method('PUT')
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="editModalLabel{{ $m->id }}">Edit Mahasiswa</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="mb-3">
                                            <label for="nim{{ $m->id }}" class="form-label">NIM</label>
                                            <input type="text" class="form-control" id="nim{{ $m->id }}" name="nim" value="{{ $m->nim }}" required>
                                        </div>
                                        <div class="mb-3">
                                            <label for="nama{{ $m->id }}" class="form-label">Nama</label>
                                            <input type="text" class="form-control" id="nama{{ $m->id }}" name="nama" value="{{ $m->nama }}" required>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                        <button type="submit" class="btn btn-primary">Simpan</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    @empty
                    <tr>
                        <td colspan="40" class="text-muted">Belum ada data mahasiswa.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Script Bootstrap & Checkbox Handler -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.querySelectorAll('.kehadiran').forEach(cb => {
            cb.addEventListener('change', e => {
                const row = e.target.dataset.row;
                const group = document.querySelectorAll(`.kehadiran[data-row="${row}"]`);
                if (e.target.checked) {
                    group.forEach(other => {
                        if (other !== e.target) other.checked = false;
                    });
                }
            });
        });
    </script>
</body>
</html>
