<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Akreditasi</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.datatables.net/2.1.8/css/dataTables.bootstrap5.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/3.0.3/css/responsive.bootstrap5.css">
  </head>
  <body>
    <div class="container mt-4">
      <h1>Akreditasi Program Studi</h1>
      <table id="example" class="table table-striped nowrap" style="width:100%">
          <thead>
          <tr>
            <td>{{ $loop->iteration }}</td>
            <td>{{ $akreds->prodi }}</td>
            <td>{{ $akreds->sk }}</td>
            <td>{{ $akreds->awal }}</td>
            <td>{{ $akreds->akhir }}</td>
          </tr>
          </thead>
      </table>
    </div>
    
    <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdn.datatables.net/2.1.8/js/dataTables.js"></script>
    <script src="https://cdn.datatables.net/2.1.8/js/dataTables.bootstrap5.js"></script>
    <script src="https://cdn.datatables.net/responsive/3.0.3/js/dataTables.responsive.js"></script>
    <script src="https://cdn.datatables.net/responsive/3.0.3/js/responsive.bootstrap5.js"></script>

    <script>
      $(document).ready(function() {
        $('#example').DataTable({
            processing: true,
            serverSide: true,
            responsive: true,
            ajax: {
                url: '/akreditasi/sisaAkreditasi', // Sesuaikan dengan URL endpoint yang mengembalikan JSON
                type: 'GET'
            },
            columns: [
                { data: 'DT_RowIndex', name: 'DT_RowIndex' }, // Index kolom otomatis dari DataTables
                { data: 'pdf', name: 'pdf' },                 // File PDF
                { data: 'prodi', name: 'prodi' },             // Program Studi
                { data: 'sk', name: 'sk' },                   // SK
                { data: 'awal', name: 'awal' },               // Tanggal awal
                { data: 'akhir', name: 'akhir' },             // Tanggal akhir
                { data: 'action', name: 'action', orderable: false, searchable: false }, // Kolom aksi
            ]
        });
      });
    </script>
  </body>
</html>
