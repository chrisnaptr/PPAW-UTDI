@extends('adminlte::page')

@section('title','Akreditasi')

@section('content')

<head>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
</head>

<body>
    <div>
        <div class="row">
            <div class="col-md-12">
                <div class="card border-0 shadow-sm rounded">
                    <div class="card-body">
                        <form method="GET" action="{{ route('akreditasi.index') }}" class="mb-3">
                            <div class="input-group">
                                {{-- Untuk search --}}
                                <input type="text" name="search" class="form-control" placeholder="Search..." value="{{ request('search') }}">
                                <div class="input-group-append">
                                    <button class="btn btn-primary" type="submit">Search</button>
                                </div>
                            </div>
                        </form>

                        <a href="{{ route('akreditasi.create') }}" class="btn btn-md btn-success mb-3">Tambah Data Akreditasi</a>

                        {{-- Table Data Akreditasi --}}
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th scope="col">NO</th>
                                    <th scope="col">
                                        PROGRAM STUDI
                                        <a href="{{ route('akreditasi.index', ['search' => request('search'), 'sort' => 'prodi', 'order' => 'asc']) }}">
                                            <i class="fas fa-arrow-up small" style="color: blue;"></i> {{-- atau gunakan blue untuk warna biru --}}
                                        </a>
                                        <a href="{{ route('akreditasi.index', ['search' => request('search'), 'sort' => 'prodi', 'order' => 'desc']) }}">
                                            <i class="fas fa-arrow-down small" style="color: blue;"></i> {{-- atau gunakan blue untuk warna biru --}}
                                        </a>
                                    </th>
                                    <th scope="col">
                                        NOMOR SK AKREDITASI
                                        <a href="{{ route('akreditasi.index', ['search' => request('search'), 'sort' => 'sk', 'order' => 'asc']) }}">
                                            <i class="fas fa-arrow-up small"></i>
                                        </a>
                                        <a href="{{ route('akreditasi.index', ['search' => request('search'), 'sort' => 'sk', 'order' => 'desc']) }}">
                                            <i class="fas fa-arrow-down small"></i>
                                        </a>
                                    </th>
                                    <th scope="col">
                                        TANGGAL AWAL BERLAKU
                                        <a href="{{ route('akreditasi.index', ['search' => request('search'), 'sort' => 'awal', 'order' => 'asc']) }}">
                                            <i class="fas fa-arrow-up small"></i>
                                        </a>
                                        <a href="{{ route('akreditasi.index', ['search' => request('search'), 'sort' => 'awal', 'order' => 'desc']) }}">
                                            <i class="fas fa-arrow-down small"></i>
                                        </a>
                                    </th>
                                    <th scope="col">
                                        TANGGAL AKHIR BERLAKU
                                        <a href="{{ route('akreditasi.index', ['search' => request('search'), 'sort' => 'akhir', 'order' => 'asc']) }}">
                                            <i class="fas fa-arrow-up small"></i>
                                        </a>
                                        <a href="{{ route('akreditasi.index', ['search' => request('search'), 'sort' => 'akhir', 'order' => 'desc']) }}">
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
                                        // Set a default color
                                        $warna = 'style=color:black;'; // Default color
                                        
                                        // Memasukkan Carbon ke dalam konteks
                                        $tanggalAwal = \Carbon\Carbon::parse($akreds->awal);
                                        $tanggalAkhir = \Carbon\Carbon::parse($akreds->akhir);
                                        $tanggalSekarang = \Carbon\Carbon::now();
                                        
                                        // Menghitung sisa bulan akreditasi
                                        $sisaBulan = $tanggalSekarang->diffInMonths($tanggalAkhir, false);

                                        // Atur warna dan pesan berdasarkan sisa bulan
                                        if ($sisaBulan > 12) {
                                            $warna = 'style=background-color:green; color:white;';
                                            $status = 'Masih Berlaku';
                                            $sisaText = intval($sisaBulan / 12) . ' tahun';
                                        }  elseif ($sisaBulan <= 12 && $sisaBulan > 0) {
                                            $warna = 'style=background-color:yellow; color:white;';
                                            $status = 'Segera Ajukan Re-Akreditasi';
                                            $sisaText = intval($sisaBulan) . ' bulan';
                                        } else {
                                            $warna = 'style=background-color:white; color:white;';
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
                                        <td {!! $warna !!}>
                                            {{-- Tampilkan sisa masa akreditasi dalam satuan bulan --}}
                                            @if ($sisaBulan > 0)
                                                <span>{{ $sisaText }} - {{ $status }}</span>
                                            @else
                                                <span>{{ $status }}</span>
                                            @endif
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
                        
                        {{-- Move pagination here --}}
                        <div class="d-flex justify-content-left">
                            @if ($akreditasi->hasPages())
                                <ul class="pagination">
                                    {{-- Previous Page Link --}}
                                    <li class="page-item {{ $akreditasi->onFirstPage() ? 'disabled' : '' }}">
                                        <a class="page-link" href="{{ $akreditasi->previousPageUrl() }}" rel="prev">«</a>
                                    </li>

                                    {{-- Pagination Elements --}}
                                    @foreach ($akreditasi->getUrlRange(1, $akreditasi->lastPage()) as $page => $url)
                                        <li class="page-item {{ $page == $akreditasi->currentPage() ? 'active' : '' }}">
                                            <a class="page-link" href="{{ $url }}">{{ $page }}</a>
                                        </li>
                                    @endforeach

                                    {{-- Next Page Link --}}
                                    <li class="page-item {{ $akreditasi->hasMorePages() ? '' : 'disabled' }}">
                                        <a class="page-link" href="{{ $akreditasi->nextPageUrl() }}" rel="next">»</a>
                                    </li>
                                </ul>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" integrity="sha384-k6RqeWeci5ZR/Lv4MR0sA0FfDOMN3S5T7ktN90+StlBY7C+K/zI8rJKmM+wBr79" crossorigin="anonymous"></script>
</body>
@endsection