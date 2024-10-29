<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Akreditasi Program Studi</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .search-container {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .search-container .col-md-20 {
            flex: 1;
        }
        .login-button {
            margin-left: auto;
        }
    </style>
</head>

<body>
    <div>
        <div class="row">
            <div class="col-md-12">
                <div class="card border-0 shadow-sm rounded">
                    <div class="card-body">
                                        <a href="{{ route('login') }}" >Login</a>
                                </div>
                            </div>
                            
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
                                        TANGGAL AWAL BERLAKU
                                    </th>
                                    <th scope="col">
                                        TANGGAL AKHIR BERLAKU
                                    </th>
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
                                        <td>{{ $akreds->awal }}</td>
                                        <td>{{ $akreds->akhir }}</td>
                                        <td>
                                            <!-- Tampilkan tombol status -->
                                            <button class="btn {{ $warnaTombol }} btn-sm" disabled>{{ $status }}</button>
                                        </td>
                                            <td class="center">
                                                <a href="{{ route('akreditasi.pdf', $akreds->id) }}" class="btn btn-sm btn-dark" target="_blank">DETAIL</a>
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

    {{-- Bootstrap JS dan jQuery --}}
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
</html>