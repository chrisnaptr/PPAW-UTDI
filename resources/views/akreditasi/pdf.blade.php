<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>File Akreditasi - {{ $akreditasi->prodi }}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-4">
        <h1 class="mb-4">File Akreditasi - {{ $akreditasi->prodi }}</h1>

        <div class="card">
            <div class="card-body">
                <h5>Program Studi: {{ $akreditasi->prodi }}</h5>
                <p>Nomor SK: {{ $akreditasi->sk }}</p>
                <p>Tanggal Awal Berlaku: {{ $akreditasi->awal }}</p>
                <p>Tanggal Akhir Berlaku: {{ $akreditasi->akhir }}</p>

                <h5 class="mt-4">Lihat File Akreditasi:</h5>

                {{-- Tampilkan file PDF menggunakan iframe --}}
                <embed src="{{ asset('assets/' . $akreditasi->pdf) }}" type="application/pdf" width="100%" height="800px">
            </div>
        </div>

        <a href="{{ route('akreditasi.user') }}" class="btn btn-primary mt-4">Kembali</a>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
