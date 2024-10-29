<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Program Studi List</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="/css/styles.css">

    <style>
        .card {
            background-color: #f8f9fa;
        }
        .product-img {
            text-align: center;
        }
        .product-img img {
            max-width: 100px;
            height: auto;
        }
        .product-description {
            font-size: 14px;
            color: #6c757d;
            margin-bottom: 5px;
        }
        .card-footer {
            background-color: #f1f1f1;
        }
        .product-title {
            font-weight: bold;
            color: #007bff;
            font-size: 20px;
        }
        .product-info {
            margin-left: 15px;
        }
        .badge {
            font-size: 1.2em;
            padding: 10px;
            width: 100%;
            text-align: center;
        }
        .header-title {
            text-align: center;
            margin-bottom: 20px;
        }
        .info-details {
            display: flex;
            flex-direction: column;
            margin-top: 10px;
        }
    </style>
</head>
<body>

    <section class="content">
        <div class="header-title">
            <h3>Monitoring Akreditasi Program Studi</h3>
        </div>

        <div class="row justify-content-center">
            <!-- Loop through the 'akreditasi' data -->
            @foreach ($akreditasi as $index => $akreds)
                <div class="col-md-4 mb-4">
                    <div class="card">
                        <div class="card-body p-0">
                            <ul class="products-list product-list-in-card pl-2 pr-2">
                                <li class="item">
                                    <div class="product-info">
                                        <span class="product-title">{{ $akreds->prodi }}</span>
                                        <div class="info-details">
                                            <span class="product-description">SK Akreditasi: {{ $akreds->sk }}</span>
                                            <span class="product-description">Tanggal Awal: {{ $akreds->awal }}</span>
                                            <span class="product-description">Tanggal Akhir: {{ $akreds->akhir }}</span>
                                        </div>
                                    </div>
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
                                    <span class="badge {{ $warnaTombol }} mt-3 mx-auto">{{ $status }}</span>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </section>

    <!-- jQuery and Bootstrap scripts -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>
</body>
</html>
