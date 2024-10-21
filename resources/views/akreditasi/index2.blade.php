@extends('adminlte::page')

@section('title', 'Akreditasi')

@section('content')

<head>
    <!-- CSS DataTables -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/2.1.8/css/dataTables.bootstrap5.css">
</head>

<body>
    <div>
        <div class="row">
            <div class="col-md-12">
                <div class="card border-0 shadow-sm rounded">
                    <div class="card-body">
                        <!-- Tombol tambah data akreditasi -->
                        <a href="{{ route('akreditasi.create') }}" class="btn btn-md btn-success mb-3">Tambah Data Akreditasi</a>

                        <!-- Tabel Data Akreditasi -->
                        <table id="akreditasi-table" class="table table-striped" style="width:100%">
                            <thead>
                                <tr>
                                    <th scope="col">NO</th>
                                    <th scope="col">PROGRAM STUDI</th>
                                    <th scope="col">NOMOR SK AKREDITASI</th>
                                    <th scope="col">TANGGAL AWAL BERLAKU</th>
                                    <th scope="col">TANGGAL AKHIR BERLAKU</th>
                                    <th scope="col">SISA MASA AKREDITASI</th>
                                    <th scope="col">AKSI</th>
                                </tr>
                            </thead>
                            <tbody>
                                <!-- Data akan diisi oleh DataTables via AJAX -->
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Tambahkan jQuery dan DataTables JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap5.min.js"></script>

    <!-- Inisialisasi DataTables -->
    <script>
        $(document).ready(function() {
            $('#akreditasi-table').DataTable({
                "processing": true,
                "serverSide": true, // Aktifkan server-side processing
                "ajax": "{{ route('akreditasi.index') }}", // URL untuk mengambil data via AJAX
                "columns": [
                    { "data": "id" }, // Kolom ID
                    { "data": "prodi" }, // Kolom Program Studi
                    { "data": "sk" }, // Kolom SK Akreditasi
                    { "data": "awal" }, // Kolom Tanggal Awal
                    { "data": "akhir" }, // Kolom Tanggal Akhir
                    { 
                        "data": null, // Kolom Sisa Masa Akreditasi
                        "render": function(data, type, row) {
                            let tanggalAkhir = new Date(row.akhir);
                            let tanggalSekarang = new Date();
                            let sisaBulan = (tanggalAkhir.getFullYear() - tanggalSekarang.getFullYear()) * 12 + (tanggalAkhir.getMonth() - tanggalSekarang.getMonth());
                            
                            if (sisaBulan > 12) {
                                return Math.floor(sisaBulan / 12) + ' tahun';
                            } else if (sisaBulan > 0) {
                                return sisaBulan + ' bulan';
                            } else {
                                return 'Kadaluarsa';
                            }
                        }
                    },
                    {
                        "data": null, // Kolom Aksi
                        "render": function(data, type, row) {
                            return `
                                <a href="/akreditasi/${row.id}" class="btn btn-sm btn-dark">DETAIL</a>
                                <a href="/akreditasi/${row.id}/edit" class="btn btn-sm btn-primary">EDIT</a>
                                <form onsubmit="return confirm('Apakah Anda Yakin ?');" action="/akreditasi/${row.id}" method="POST" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger">HAPUS</button>
                                </form>
                            `;
                        }
                    }
                ],
                "order": [[1, 'asc']], // Urutkan berdasarkan kolom kedua (prodi)
                "pageLength": 10,
                "lengthMenu": [5, 10, 25, 50], // Opsi jumlah data yang ditampilkan
                "pagingType": "full_numbers"
            });
        });
    </script>

</body>

@endsection
