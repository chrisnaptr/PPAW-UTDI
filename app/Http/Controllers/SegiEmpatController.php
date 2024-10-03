<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\SegiEmpat;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Validator;

class SegiEmpatController extends Controller
{
public function inputSegiEmpat()
{
return View::make('segi-empat.inputSegiEmpat');
}
    public function hasil(Request $request)
    {
        $segiEmpat = new SegiEmpat;
        
        // Aturan validasi
        $rules = [
            'panjang' => 'required|numeric',
            'lebar' => 'required|numeric'
        ];
        
        $validator = Validator::make($request->all(), $rules);
        
        // Cek validasi
        if ($validator->fails()) {
            // Jika salah, kembalikan ke form untuk diperbaiki dengan error
            return redirect()->back()->withErrors($validator)->withInput();
        } else {
            // Lanjutkan ke menampilkan hasil
            $segiEmpat->panjang = $request->panjang;
            $segiEmpat->lebar = $request->lebar;
            
            return View::make('segi-empat.hasil', compact('segiEmpat'));
        }
    }

    public function inputBalok() 
  { 
    return View::make('segi-empat.inputBalok'); 
  } 
  
//method menghitung hasil 
        public function hasilBalok(Request $request) 
        { 
            $balok = new \App\Models\Balok; 
        
            //aturan validasi 
            $rules = [ 
                'panjang' => 'required|numeric', 
                'lebar' => 'required|numeric', 
                'tebal' => 'required|numeric'
            ]; 

            $validator = Validator::make($request->all(), $rules); 

            //cek validasi 
            if ($validator->fails()) { 
                //jika validasi gagal, kembalikan ke form untuk diperbaiki 
                return redirect()->back()
                                ->withErrors($validator)
                                ->withInput(); // Use withInput to preserve form data
            } else {  
                //lanjutkan ke menampilkan hasil
                $balok->panjang = $request->panjang; 
                $balok->lebar = $request->lebar; 
                $balok->tebal = $request->tebal; 

                return view('segi-empat.hasilBalok', compact('balok')); 
            } 
        }

}