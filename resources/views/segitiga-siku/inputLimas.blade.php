@extends('adminlte::page')
@section('content') 
<h4>Form Masukan Nilai Limas Segitiga</h4> 
<form action="{{ route('segitiga-siku.hasilLimas') }}" method="get">
  {{csrf_field()}}
  @if ($errors->any())
      <div class="alert alert-danger">
          <strong>Ada kesalahan</strong> Harap diperbaiki.<br>
          <ul>
              @foreach ($errors->all() as $error)
                  <li>{{ $error }}</li>
              @endforeach
          </ul>
      </div>
  @endif
  <div class="form-group {{ $errors->has('luas_alas') ? 'has-error' : ''}}">
      <label for="panjang" class="control-label">Luas alas</label>
      <input type="text" class="form-control" name="luas_alas" required>
  </div>
  <div class="form-group {{ $errors->has('tinggi_limas') ? 'has-error' : ''}}">
      <label for="lebar" class="control-label">Tinggi limas</label>
      <input type="text" class="form-control" name="tinggi_limas" required>
  </div>
  <div class="form-group">
      <button type="submit" class="btn btn-info">Proses</button>
  </div>
</form>
@endsection 