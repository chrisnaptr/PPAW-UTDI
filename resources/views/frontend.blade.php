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
<div class="container mt-1">
    <h1 class="mb-4">Daftar Akreditasi Program Studi ITNY</h1>

    <div class="row mb-2">
        <div class="col-md-4">
            <select class="form-select" id="prodiFilter">
                <option value="">Pilih Program Studi</option> 
                @foreach($akreditasi as $front)
                    <option value="{{ $front }}">{{ $front }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-md-3">
            <select class="form-select" id="statusFilter">
                <option value="">Status Kedaluwarsa</option>
                <option value="Masih berlaku">Masih berlaku</option>
                <option value="Kedaluwarsa">Kedaluwarsa</option>
            </select>
        </div>
        <div class="col-md-3">
            <input type="search" id="search" placeholder="Cari Akreditasi" class="form-control">
        </div>
    </div>

    <table class="table table-bordered">
        <thead>
          <tr>
            <th scope="col">SERTIFIKAT AKREDITASI</th>
            <th scope="col">PROGRAM STUDI</th>
            <th scope="col">NOMOR SK AKREDITASI</th>
            <th scope="col">TANGGAL AWAL BERLAKU</th>
            <th scope="col">TANGGAL AKHIR BERLAKU</th>
          </tr>
        </thead>
        <tbody>
            @forelse ($akreditasi as $front)
              <tr>
                  <td class="text-center">
                    <a href="{{ route('showfrontend', $front->id) }}">View Details</a>
                  </td>
                  <td>{{ $front->prodi }}</td>
                  <td>{{ $front->sk }}</td>
                  <td>{!! $front->awal !!}</td>
                  <td>{!! $front->akhir !!}</td>
                  <td class="text-center"></td>
              </tr>
            @empty
                <div class="alert alert-danger">
                    Data Akreditasi belum Tersedia.
                </div>
            @endforelse
          </tbody>
          
      </table>  
    {{ $akreditasi->links() }} <div id="Content"></div> 
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script> 

{{-- <script>
$(document).ready(function() {
    $('#search, #prodiFilter, #statusFilter').on('keyup change', function() {
        var search = $('#search').val();
        var prodi = $('#prodiFilter').val();
        var status = $('#statusFilter').val();

        $.ajax({
            url: "{{ route('akreditasi.search') }}",
            type: 'GET',
            data: { search: search, prodi: prodi, status: status },
            success: function(data) {
                $('tbody').html(data); 
            }
        });
    });
});
</script> --}}

</body>
</html>