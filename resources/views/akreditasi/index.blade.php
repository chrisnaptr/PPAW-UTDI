@extends('adminlte::page')

@section('title','Akreditasi')

@section('content')

<head>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.datatables.net/2.1.8/css/dataTables.bootstrap5.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/3.0.3/css/responsive.bootstrap5.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
</head>

<body>
    <div>
        <div class="row">
            <div class="col-md-12">
                <div class="card border-0 shadow-sm rounded">
                    <div class="card-body">
                        <form method="GET" action="{{ route('akreditasi.index') }}" class="mb-3">

                        </form>

                        <a href="{{ route('akreditasi.create') }}" class="btn btn-md btn-success mb-3">Tambah Data Akreditasi</a>

                        {{-- Table Data Akreditasi --}}
                        <table id="example" class="table table-striped nowrap" style="width:100%">
                            <thead>
                                <tr>
                                    <th scope="col">NO</th>
                                    <th scope="col">
                                        PROGRAM STUDI
                                    </th>
                                    <th scope="col">
                                        NOMOR SK AKREDITASI
                                    </th>
                                    <th scope="col">
                                        PREDIKAT AKREDITASI
                                    </th>
                                    <th scope="col">
                                        TANGGAL AWAL BERLAKU
                                    </th>
                                    <th scope="col">
                                        TANGGAL AKHIR BERLAKU
                                    </th>
                                    <th scope="col">AKSI</th>
                                    <th scope="col">STATUS AKREDITASI</th>
                                </tr>
                            </thead>
                            
                            <tbody>
                                @foreach ($akreditasi as $akreds)
                                @php
                                        $tanggalAkhir = \Carbon\Carbon::parse($akreds->akhir);
                                        $tanggalSekarang = \Carbon\Carbon::now();
                                        $sisaBulan = $tanggalSekarang->diffInMonths($tanggalAkhir, false);

                                        $warnaTombol = '';
                                        $status = '';

                                        if ($sisaBulan > 12) {
                                            $warnaTombol = 'btn-success';  // Hijau
                                            $status = 'Masih Berlaku';
                                        } elseif ($sisaBulan <= 12 && $sisaBulan > 0) {
                                            $warnaTombol = 'btn-primary';  // Biru
                                            $status = 'Segera Ajukan Re-Akreditasi';
                                        } else {
                                            $warnaTombol = 'btn-warning';  // Kuning
                                            $status = 'Sudah Berakhir';
                                        }
                                    @endphp

                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $akreds->prodi }}</td>
                                        <td>{{ $akreds->sk }}</td>
                                        <td>{{ $akreds->predikat }}</td>
                                        <td>{{ $akreds->awal }}</td>
                                        <td>{{ $akreds->akhir }}</td>
                                        <td class="text-center">
                                            <form onsubmit="return confirm('Apakah Anda Yakin ?');" action="{{ route('akreditasi.destroy', $akreds->id) }}" method="POST">
                                                <a href="{{ route('akreditasi.show', $akreds->id) }}" class="btn btn-sm btn-dark">DETAIL</a>
                                                <a href="{{ route('akreditasi.edit', $akreds->id) }}" class="btn btn-sm btn-primary">EDIT</a>
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-danger">HAPUS</button>
                                            </form>
                                        </td>
                                        <td>
                                            <!-- Tampilkan tombol status -->
                                            <button class="btn {{ $warnaTombol }} btn-sm" disabled>{{ $status }}</button>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <div>
                        {{-- Move pagination here --}}
                        {{ $akreditasi->links('pagination::bootstrap-4') }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdn.datatables.net/2.1.8/js/dataTables.js"></script>
    <script src="https://cdn.datatables.net/2.1.8/js/dataTables.bootstrap5.js"></script>
    <script src="https://cdn.datatables.net/responsive/3.0.3/js/dataTables.responsive.js"></script>
    <script src="https://cdn.datatables.net/responsive/3.0.3/js/responsive.bootstrap5.js"></script>
    <script>
    new DataTable('#example', {
    responsive: true
    });
    </script>
</body>
@endsection