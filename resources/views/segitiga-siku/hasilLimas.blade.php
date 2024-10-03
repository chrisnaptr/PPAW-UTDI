@extends('adminlte::page')
@section('content') 
<h1>Hasil Perhitungan Limas</h1>
<table class="table table-striped table-bordered">
    <tr>
        <td>Luas alas</td>
        <td>{{$limasSegiTiga->luas_alas}}</td>
    </tr>
    <tr>
        <td>Tinggi limas</td>
        <td>{{$limasSegiTiga->tinggi_limas}}</td>
    </tr>
    <tr>
        <td>Volume</td>
        <td>{{$limasSegiTiga->volume()}}</td>
    </tr>
</table>
@endsection 