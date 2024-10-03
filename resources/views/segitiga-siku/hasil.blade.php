@extends('adminlte::page')
@section('content') 
<h1>Hasil Perhitungan Segitiga Siku</h1>
<table class="table table-striped table-bordered">
    <tr>
        <td>Alas </td>
        <td>{{$segiTigaSiku->alas}}</td>
    </tr>
    <tr>
        <td>Tinggi </td>
        <td>{{$segiTigaSiku->tinggi}}</td>
    </tr>
    <tr>
        <td>Luas </td>
        <td>{{$segiTigaSiku->luas()}}</td>
    </tr>
    <tr>
        <td>Keliling </td>
        <td>{{$segiTigaSiku->keliling()}}</td>
    </tr>
</table>
@endsection 