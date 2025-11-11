<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Absensi Mahasiswa</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="p-4">
    <div class="container-fluid">
        <h1 class="mb-3">Dashboard Absensi Mahasiswa</h1>

        <!-- Tombol buka offcanvas -->
        <button class="btn btn-primary mb-3" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasTambah" aria-controls="offcanvasTambah">
            + Tambah Mahasiswa
        </button>

        <!-- Include file offcanvas -->
        @include('tambah_mahasiswa')

        <div class="table-responsive">
            <table class="table table-bordered">
                <thead class="table-light text-center align-middle">
                    <tr>
                        <th>No</th>
                        <th>NIM</th>
                        <th>Nama</th>
                        <th colspan="3">Kehadiran</th>
                        <th>Modul 1</th>
                        <th>Modul 2</th>
                        <th>Modul 3</th>
                        <th>Modul 4</th>
                        <th>Modul 5</th>
                        <th>Modul 6</th>
                        <th>Modul 7</th>
                        <th>Modul 8</th>
                        <th>Modul 9</th>
                        <th>Modul 10</th>
                        <th>Final Project</th>
                        <th>Nilai Akhir</th>
                        <th>Abjad</th>
                    </tr>
                    <tr>
                        <th></th><th></th><th></th>
                        <th>Hadir</th>
                        <th>Tidak Hadir</th>
                        <th>Izin</th>
                        <th colspan="13"></th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>1</td>
                        <td>20231001</td>
                        <td>Ahmad Adi</td>
                        <td><input type="checkbox"></td>
                        <td><input type="checkbox"></td>
                        <td><input type="checkbox"></td>
                        <td>80</td>
                        <td>85</td>
                        <td>75</td>
                        <td>90</td>
                        <td>88</td>
                        <td>70</td>
                        <td>95</td>
                        <td>92</td>
                        <td>85</td>
                        <td>89</td>
                        <td>94</td>
                        <td>87</td>
                        <td>B+</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
