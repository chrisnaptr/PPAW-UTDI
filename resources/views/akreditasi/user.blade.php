<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Akreditasi Program Studi</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">
    <style>
        /* ... Your CSS styles ... */
    </style>
</head>

<body>
    <div>
        <div class="row">
            <div class="col-md-12">
                <div class="card border-0 shadow-sm rounded">
                    <div class="card-body">
                        {{-- Form Pencarian --}}
                        <form method="GET" action="{{ route('akreditasi.user') }}" class="mb-3">
                            <div class="input-group">
                                <input type="text" name="search" class="form-control" placeholder="Search..." value="{{ request('search') }}">
                                <div class="input-group-append">
                                    <button class="btn btn-primary" type="submit">Search</button>
                                </div>
                            </div>
                        </form>

                        {{-- Table Data Akreditasi --}}
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th scope="col">NO</th>
                                    <th scope="col">
                                        PROGRAM STUDI
                                        <a href="{{ route('akreditasi.user', ['search' => request('search'), 'sort' => 'prodi', 'order' => 'asc']) }}">
                                            <i class="fas fa-arrow-up small" style="color: blue;"></i>
                                        </a>
                                        <a href="{{ route('akreditasi.user', ['search' => request('search'), 'sort' => 'prodi', 'order' => 'desc']) }}">
                                            <i class="fas fa-arrow-down small" style="color: blue;"></i>
                                        </a>
                                    </th>
                                    <th scope="col">
                                        NOMOR SK AKREDITASI
                                        <a href="{{ route('akreditasi.user', ['search' => request('search'), 'sort' => 'sk', 'order' => 'asc']) }}">
                                            <i class="fas fa-arrow-up small"></i>
                                        </a>
                                        <a href="{{ route('akreditasi.user', ['search' => request('search'), 'sort' => 'sk', 'order' => 'desc']) }}">
                                            <i class="fas fa-arrow-down small"></i>
                                        </a>
                                    </th>
                                    <th scope="col">
                                        TANGGAL AWAL BERLAKU
                                        <a href="{{ route('akreditasi.user', ['search' => request('search'), 'sort' => 'awal', 'order' => 'asc']) }}">
                                            <i class="fas fa-arrow-up small"></i>
                                        </a>
                                        <a href="{{ route('akreditasi.user', ['search' => request('search'), 'sort' => 'awal', 'order' => 'desc']) }}">
                                            <i class="fas fa-arrow-down small"></i>
                                        </a>
                                    </th>
                                    <th scope="col">
                                        TANGGAL AKHIR BERLAKU
                                        <a href="{{ route('akreditasi.user', ['search' => request('search'), 'sort' => 'akhir', 'order' => 'asc']) }}">
                                            <i class="fas fa-arrow-up small"></i>
                                        </a>
                                        <a href="{{ route('akreditasi.user', ['search' => request('search'), 'sort' => 'akhir', 'order' => 'desc']) }}">
                                            <i class="fas fa-arrow-down small"></i>
                                        </a>
                                    </th>
                                    <th scope="col">SISA MASA AKREDITASI</th>
                                    <th scope="col">AKSI</th>
                                </tr>
                            </thead>
                            
                            <tbody>
                                @foreach ($akreditasi as $akreds)
                                    @php
                                        // Mengatur warna dan status sisa masa akreditasi
                                        $tanggalAkhir = \Carbon\Carbon::parse($akreds->akhir);
                                        $tanggalSekarang = \Carbon\Carbon::now();
                                        $sisaBulan = $tanggalSekarang->diffInMonths($tanggalAkhir, false);

                                        $warna = 'style=color:black;';
                                        $status = '';
                                        $sisaText = '';

                                        if ($sisaBulan > 12) {
                                            $warna = 'style=background-color:green; color:white;';
                                            $status = 'Masih Berlaku';
                                            $sisaText = intval($sisaBulan / 12) . ' tahun';
                                        } elseif ($sisaBulan <= 12 && $sisaBulan > 0) {
                                            $warna = 'style=background-color:yellow; color:white;';
                                            $status = 'Segera Ajukan Re-Akreditasi';
                                            $sisaText = $sisaBulan . ' bulan';
                                        } else {
                                            $warna = 'style=background-color:white; color:white;';
                                            $status = 'Sudah Kadaluarsa';
                                        }
                                    @endphp
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $akreds->prodi }}</td>
                                        <td>{{ $akreds->sk }}</td>
                                        <td>{{ $akreds->awal }}</td>
                                        <td>{{ $akreds->akhir }}</td>
                                        <td {!! $warna !!}>
                                            @if ($sisaBulan > 0)
                                                <span>{{ $sisaText }} - {{ $status }}</span>
                                            @else
                                                <span>{{ $status }}</span>
                                            @endif
                                        </td>
                                        <td class="text-center">
                                            <a href="{{ route('akreditasi.pdf', $akreds->id) }}" class="btn btn-sm btn-dark" target="_blank">DETAIL</a>
                                        </td>                                       
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        
                        {{-- Pagination --}}
                        <div class="d-flex justify-content-left">
                            {{ $akreditasi->appends(request()->except('page'))->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Tambahkan Script untuk Pencarian Otomatis --}}
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            let searchInput = document.querySelector('input[name="search"]');
            let searchForm = searchInput.closest('form');
            let typingTimer;
            let typingInterval = 500;  // Waktu tunggu setelah mengetik (500 ms)

            // Deteksi perubahan input search
            searchInput.addEventListener('keyup', function() {
                clearTimeout(typingTimer);  // Reset timer jika pengguna terus mengetik
                typingTimer = setTimeout(function() {
                    searchForm.submit();   // Kirim form otomatis setelah selesai mengetik
                }, typingInterval);
            });

            searchInput.addEventListener('keydown', function() {
                clearTimeout(typingTimer);  // Hentikan timer jika ada pengetikan baru
            });
        });
    </script>

    {{-- Bootstrap JS dan jQuery --}}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
