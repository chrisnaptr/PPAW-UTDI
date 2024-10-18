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
                                @foreach ($akreditasi as $akreds)
                                    @php
                                        $tanggalAkhir = \Carbon\Carbon::parse($akreds->akhir);
                                        $tanggalSekarang = \Carbon\Carbon::now();
                                        $sisaBulan = $tanggalSekarang->diffInMonths($tanggalAkhir, false);
                                        if ($sisaBulan > 12) {
                                            $warna = 'background-color:green; color:white;';
                                            $status = 'Masih Berlaku';
                                            $sisaText = intval($sisaBulan / 12) . ' tahun';
                                        } elseif ($sisaBulan <= 12 && $sisaBulan > 0) {
                                            $warna = 'background-color:yellow; color:black;';
                                            $status = 'Segera Ajukan Re-Akreditasi';
                                            $sisaText = intval($sisaBulan) . ' bulan';
                                        } else {
                                            $warna = 'background-color:red; color:white;';
                                            $status = 'Sudah Kadaluarsa';
                                            $sisaText = '';
                                        }
                                    @endphp
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $akreds->prodi }}</td>
                                        <td>{{ $akreds->sk }}</td>
                                        <td>{{ $akreds->awal }}</td>
                                        <td>{{ $akreds->akhir }}</td>
                                        <td style="{{ $warna }}">
                                            {{ $sisaText ? $sisaText . ' - ' : '' }}{{ $status }}
                                        </td>
                                        <td class="text-center">
                                            <form onsubmit="return confirm('Apakah Anda Yakin ?');" action="{{ route('akreditasi.destroy', $akreds->id) }}" method="POST">
                                                <a href="{{ route('akreditasi.show', $akreds->id) }}" class="btn btn-sm btn-dark">DETAIL</a>
                                                <a href="{{ route('akreditasi.edit', $akreds->id) }}" class="btn btn-sm btn-primary">EDIT</a>
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-danger">HAPUS</button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        
                        <!-- Pagination (opsional) -->
                        <div class="d-flex justify-content-left">
                            {{ $akreditasi->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Tambahkan jQuery dan DataTables JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap4.min.js"></script>

    <!-- Inisialisasi DataTables -->
    <script>
        $(document).ready(function() {
            $('#akreditasi-table').DataTable({
                "processing": true,
                "serverSide": true, // Jika menggunakan server-side processing
                "ajax": "{{ route('akreditasi.index') }}", // URL untuk mengambil data
                "columns": [
                    { "data": "no" }, // Urutkan berdasarkan kolom ini
                    { "data": "prodi" },
                    { "data": "sk" },
                    { "data": "awal" },
                    { "data": "akhir" },
                    { "data": "sisa_masa" },
                    { "data": "aksi" }
                ],
                "order": [[1, 'asc']] // Default sorting berdasarkan kolom kedua (prodi)
            });
        });
    </script>
</body>

@endsection
