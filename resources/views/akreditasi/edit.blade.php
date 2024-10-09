@extends('adminlte::page')

@section('title','Edit Data Akreditasi')

@section('breadcrumbs')

<div class="breadcrumbs">
    <div class="col-sm-4">
        <div class="page-header float-left">
            <div class="page-title">
                <h1>Edit Data Akreditasi</h1>
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

<body style="background: lightgray">

    <div>
        <div class="row">
            <div class="col-md-12">
                <div class="card border-0 shadow-sm rounded">
                    <div class="card-body">
                        <form action="{{ route('akreditasi.update', $akreditasi->id) }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')

                            <div class="form-group">
                                <label class="font-weight-bold">GAMBAR SK AKREDITASI</label>
                                <input type="file" class="form-control @error('pdf') is-invalid @enderror" name="pdf">
                            
                                <!-- error message untuk gambar -->
                                @error('pdf')
                                    <div class="alert alert-danger mt-2">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label class="font-weight-bold">PROGRAM STUDI</label>
                                <select class="form-control @error('prodi') is-invalid @enderror" name="prodi">
                                    <option value="Program Studi Teknik Geologi-S2" {{ old('prodi', $akreditasi->prodi) == 'Program Studi Teknik Geologi-S2' ? 'selected' : '' }}>Program Studi Teknik Geologi-S2</option>
                                    <option value="Program Studi Teknik Sipil-S1" {{ old('prodi', $akreditasi->prodi) == 'Program Studi Teknik Sipil-S1' ? 'selected' : '' }}>Program Studi Teknik Sipil-S1</option>
                                    <option value="Program Studi Teknik Mesin-S1" {{ old('prodi', $akreditasi->prodi) == 'Program Studi Teknik Mesin-S1' ? 'selected' : '' }}>Program Studi Teknik Mesin-S1</option>
                                    <option value="Program Studi Teknik Elektro-S1" {{ old('prodi', $akreditasi->prodi) == 'Program Studi Teknik Elektro-S1' ? 'selected' : '' }}>Program Studi Teknik Elektro-S1</option>
                                    <option value="Program Studi Teknik Geologi-S1" {{ old('prodi', $akreditasi->prodi) == 'Program Studi Teknik Geologi-S1' ? 'selected' : '' }}>Program Studi Teknik Geologi-S1</option>
                                    <option value="Program Studi Perencanaan Wilayah dan Kota" {{ old('prodi', $akreditasi->prodi) == 'Program Studi Perencanaan Wilayah dan Kota' ? 'selected' : '' }}>Program Studi Perencanaan Wilayah dan Kota</option>
                                    <option value="Program Studi Teknik Pertambangan-S1" {{ old('prodi', $akreditasi->prodi) == 'Program Studi Teknik Pertambangan-S1' ? 'selected' : '' }}>Program Studi Teknik Pertambangan-S1</option>
                                    <option value="Program Studi Teknik Mesin-D3" {{ old('prodi', $akreditasi->prodi) == 'Program Studi Teknik Mesin-D3' ? 'selected' : '' }}>Program Studi Teknik Mesin-D3</option>
                                    <option value="Program Studi Teknik Elektronika-D3" {{ old('prodi', $akreditasi->prodi) == 'Program Studi Teknik Elektronika-D3' ? 'selected' : '' }}>Program Studi Teknik Elektronika-D3</option>
                                </select>
                            
                                <!-- error message untuk prodi -->
                                @error('prodi')
                                    <div class="alert alert-danger mt-2">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label class="font-weight-bold">NOMOR SK AKREDITASI</label>
                                <input type="text" class="form-control @error('sk') is-invalid @enderror" name="sk" value="{{ old('sk', $akreditasi->sk) }}" placeholder="Masukkan Nomor SK Akreditasi">
                            
                                <!-- error message untuk sk -->
                                @error('sk')
                                    <div class="alert alert-danger mt-2">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label class="font-weight-bold">Tanggal Awal SK Akreditasi</label>
                                <input type="date" class="col-3 form-control @error('awal') is-invalid @enderror" name="awal" value="{{ old('awal', $akreditasi->awal) }}" placeholder="Tanggal Awal Berlaku">
                            
                                <!-- error message untuk awal -->
                                @error('awal')
                                    <div class="alert alert-danger mt-2">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label class="font-weight-bold">Tanggal Akhir SK Akreditasi</label>
                                <input type="date" class="col-3 form-control @error('akhir') is-invalid @enderror" name="akhir" value="{{ old('akhir', $akreditasi->akhir) }}" placeholder="Tanggal Akhir Berlaku">
                            
                                <!-- error message untuk akhir -->
                                @error('akhir')
                                    <div class="alert alert-danger mt-2">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <button type="submit" class="btn btn-md btn-primary">UPDATE</button>
                            <button type="reset" class="btn btn-md btn-warning">RESET</button>

                        </form> 
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

@endsection
