<?php

namespace App\Http\Controllers;
use App\Models\SegitigaSiku;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Validator;

class SegitigaSikuController extends Controller
{
    public function input()
    {
        return view("segitiga-siku.input");
    }
    public function hasil(Request $request)
    {
        $segiTigaSiku = new SegitigaSiku;
        //aturan validasi
        $rules = [
            'alas' => 'required|numeric',
            'tinggi' => 'required|numeric'
        ];
        $validator = validator::make($request->all(), $rules);
        //cek validasi
        if ($validator->fails()) {
            // Jika salah, kembalikan ke form untuk diperbaiki dengan error dan input
            return redirect()->back()->withErrors($validator)->withInput();
        } else {
            // Lanjutkan ke menampilkan hasil
            $segiTigaSiku->alas = $request->alas;
            $segiTigaSiku->tinggi = $request->tinggi;

            return View::make('segitiga-siku.hasil', compact('segiTigaSiku'));
        }
    }

    public function inputLimasSegitiga()
    {
        return View::make('segitiga-siku.inputLimas'); 
  } 

    public function hasilLimas(Request $request)
    {
        $limasSegiTiga = new \App\Models\LimasSegitiga();
        //aturan validasi
        $rules = [
            'luas_alas' => 'required|numeric',
            'tinggi_limas' => 'required|numeric'
        ];
        $validator = Validator::make($request->all(), $rules);
        //cek validasi
        if ($validator->fails()) {
            //jika salah kembalikan ke form untuk diperbaiki
            return redirect()->back()->withErrors($validator)->withInput();
        } else {
            //lanjutkan ke menampilkan hasil/
            $limasSegiTiga->luas_alas = $request->luas_alas;
            $limasSegiTiga->tinggi_limas = $request->tinggi_limas;
            return View::make('segitiga-siku.hasilLimas', compact('limasSegiTiga'));
        }
    }
}
