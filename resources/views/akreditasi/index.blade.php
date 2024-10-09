@extends('adminlte::page')

@section('title','Akreditasi')

@section('breadcrumbs')

<div class="breadcrumbs">
    <div class="col-sm-4">
        <div class="page-header float-left">
            <div class="page-title">
                <h1>Data Akreditasi</h1>
            </div>
        </div>
    </div>
    <div class="col-sm-8">
        <div class="page-header float-right">
            <div class="page-title">
                <ol class="breadcrumb text-right">
                    <li class="active"><i class="fa fa-dashboard"></i></li>
                </ol>
            </div>
        </div>
    </div>
</div>

@endsection

@section('content')
<body>

    <div>
        <div class="row">
            <div class="col-md-12">
                <div class="card border-0 shadow-sm rounded">
                    <div class="card-body">
                        <a href="{{ route('akreditasi.create') }}" class="btn btn-md btn-success mb-3">Tambah Data Akreditasi</a>
                        <table class="table table-bordered">
                            <thead>
                              <tr>
                                <th scope="col">NO</th>
                                <th scope="col">PROGRAM STUDI</th>
                                <th scope="col">NOMOR SK AKREDITASI</th>
                                <th scope="col">TANGGAL AWAL BERLAKU</th>
                                <th scope="col">TANGGAL AKHIR BERLAKU</th>      
                                <th scope="col">SISA MASA AKREDITASI</th> {{-- Kolom baru untuk sisa masa akreditasi --}}
                                <th scope="col">AKSI</th>
                              </tr>
                            </thead>
                            <tbody>
                              @forelse ($akreditasi as $akreds)
                                @php
                                    // Memasukkan Carbon ke dalam konteks
                                    $tanggalAwal = \Carbon\Carbon::parse($akreds->awal); // Pastikan ini benar
                                    $tanggalAkhir = \Carbon\Carbon::parse($akreds->akhir); // Pastikan ini benar
                                    $tanggalSekarang = \Carbon\Carbon::now();

                                    // Debugging
                                    // dd($tanggalAwal, $tanggalAkhir, $tanggalSekarang); // Uncomment this line to debug

                                    $sisaHari = $tanggalAkhir->diffInDays($tanggalSekarang, false); // Hitung selisih dalam hari
                                    $warna = $sisaHari < 365 ? 'style=background-color:red;' : ''; // Jika kurang dari 365 hari, beri warna merah
                                @endphp
                                <tr>
                                    <td>{{ $loop->iteration }}</td> {{-- Nomor urut --}}
                                    <td>{{ $akreds->prodi }}</td>
                                    <td>{{ $akreds->sk }}</td>
                                    <td>{!! $akreds->awal !!}</td>
                                    <td>{!! $akreds->akhir !!}</td>
                                    <td {!! $warna !!}>
                                        {{-- Tampilkan sisa masa akreditasi --}}
                                        @if($sisaHari > 0)
                                            {{ $sisaHari }} hari
                                        @else
                                            Sudah kadaluarsa
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
                              @empty
                                  <div class="alert alert-danger">
                                      Data Akreditasi belum Tersedia.
                                  </div>
                              @endforelse
                            </tbody>
                          </table>  
                          {{ $akreditasi->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

    {{-- <script>
        //message with toastr
        @if(session()->has('success'))
        
            toastr.success('{{ session('success') }}', 'BERHASIL!'); 

        @elseif(session()->has('error'))

            toastr.error('{{ session('error') }}', 'GAGAL!'); 
            
        @endif
    </script> --}}

</body>
@endsection
