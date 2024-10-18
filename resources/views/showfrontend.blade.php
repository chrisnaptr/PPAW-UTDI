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

<body style="background: lightgray">
    <table class="table table-bordered table-hover table-striped">
        {{-- <thead>
            <tr>
                <th>İsim</th>
                <th>Email</th>
                <th>Tarih</th>
                <th>İstek</th>
            </tr>
        </thead> --}}
    
        <tbody>
            @foreach($akreditasi as $front)
            <tr>
                        <embed src="{{ asset('assets/' . $front->pdf) }}" type="application/pdf" width="100%" height="800px">
    
                        <!-- Alternatively, you can use iframe -->
                        <!-- <iframe height="800px" width="100%" src="{{ asset('assets/' . $front->pdf) }}"></iframe> -->
    
            </tr>
            @endforeach
        </tbody>
    </table>
    {{$akreditasi->links()}}

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>