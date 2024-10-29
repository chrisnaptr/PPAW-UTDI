<!DOCTYPE html>
<html>
<head>
    <title>Pengingat Akreditasi</title>
</head>
<body>
    <h1>Peringatan Akreditasi</h1>
    <p>Program studi {{ $akreditasi->prodi }} akan segera berakhir masa akreditasinya dalam {{ $sisaBulan }} bulan.</p>
    <p>Nomor SK: {{ $akreditasi->sk }}</p>
    <p>Silakan ajukan perpanjangan akreditasi sebelum masa berlaku berakhir.</p>
</body>
</html>
