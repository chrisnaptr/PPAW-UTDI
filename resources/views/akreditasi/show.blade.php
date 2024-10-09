@extends('adminlte::page')

@section('title','Detail Data Akreditasi')

@section('breadcrumbs')
<div class="breadcrumbs">
    <div class="col-sm-4">
        <div class="page-header float-left">
            <div class="page-title">
                <h1>Detail Data Akreditasi</h1>
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
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card border-0 shadow-sm rounded">
                <div class="card-body">
                    <h4>{{ $akreditasi->prodi }}</h4>
                    <p><strong>SK:</strong> {!! $akreditasi->sk !!}</p>

                    <!-- Full-width PDF display -->
                    <embed src="{{ asset('assets/' . $akreditasi->pdf) }}" type="application/pdf" width="100%" height="800px">

                    <!-- Alternatively, you can use iframe -->
                    <!-- <iframe height="800px" width="100%" src="{{ asset('assets/' . $akreditasi->pdf) }}"></iframe> -->

                    <!-- Button to go back to the list -->
                    <a href="{{ route('akreditasi.index') }}" class="btn btn-primary mt-3">Kembali ke Daftar Akreditasi</a>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
@endsection
