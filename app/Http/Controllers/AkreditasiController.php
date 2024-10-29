<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use App\Models\akreds;
use Yajra\DataTables\Facades\DataTables;
use App\Mail\AkreditasiReminderMail;
use Illuminate\Pagination\LengthAwarePaginator;
use App\Models\User;
use Illuminate\View\View;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Response;
use Yajra\DataTables\Contracts\DataTable;

class AkreditasiController extends Controller
{
    /**
     * index
     *
     * @return View
     */
    public function index(Request $request): View
{
    $search = $request->input('search');
    $sort = $request->input('sort', 'prodi');
    $order = $request->input('order', 'asc');

    $akreditasi = akreds::when($search, function ($query) use ($search) {
            return $query->where('prodi', 'like', '%' . $search . '%')
                         ->orWhere('sk', 'like', '%' . $search . '%');
        })
        ->orderBy($sort, $order)
        ->get();
    $akreditasi = akreds::latest()->paginate(10);
    // // Periksa sisa akreditasi dan kirim email jika kurang dari 6 bulan
    // foreach ($akreditasi as $akreds) {
    //     $tanggalAkhir = \Carbon\Carbon::parse($akreds->akhir);
    //     $tanggalSekarang = \Carbon\Carbon::now();
    //     $sisaBulan = $tanggalSekarang->diffInMonths($tanggalAkhir, false);

    //     if ($sisaBulan <= 6 && $sisaBulan > 0) {
    //         // Kirim email pemberitahuan
    //         Mail::to('admin@example.com')->send(new AkreditasiReminderMail($akreds));
    //     }
    // }

   return view('akreditasi.index', compact('akreditasi', 'search', 'sort', 'order'));
}

    /**
     * create
     *
     * @return View
     */
    public function create(): View
    {
        return view('akreditasi.create');
    }

    /**
     * store
     *
     * @param  mixed $request
     * @return RedirectResponse
     */
    public function store(Request $request): RedirectResponse
    {
        // Validate form
        $this->validate($request, [
            'pdf'       => 'required|mimetypes:application/pdf|max:10000',
            'prodi'     => 'required|min:5',
            'sk'        => 'required|min:5',
            'predikat'  => 'required|min:5',
            'awal'      => 'required|min:10',
            'akhir'     => 'required|min:10'
        ]);

        // Upload pdf
        $pdf = $request->file('pdf');
        $filename = $pdf->getClientOriginalName(); // Ambil nama asli file
        $pdf->move(public_path('assets'), $filename); // Pindahkan file ke direktori yang diinginkan


        // Create akreditasi
        akreds::create([
            'pdf'       => $filename,  // Store the filename only
            'prodi'     => $request->prodi,
            'sk'        => $request->sk,
            'predikat'  => $request->predikat,
            'awal'      => $request->awal,
            'akhir'     => $request->akhir
        ]);

        // Redirect to index
        return redirect()->route('akreditasi.index')->with(['success' => 'Data Berhasil Disimpan!']);
    }

    /**
     * show
     *
     * @param  mixed $id
     * @return View
     */
    public function show(string $id): View
    {
        //get akreditasi by ID
        $akreditasi = akreds::findOrFail($id);

        //render view with akreditasi
        return view('akreditasi.show', compact('akreditasi'));
    }

    /**
     * edit
     *
     * @param  mixed $id
     * @return View
     */
    public function edit(string $id): View
    {
        //get akreditasi by ID
        $akreditasi = akreds::findOrFail($id);

        //render view with akreditasi
        return view('akreditasi.edit', compact('akreditasi'));
    }
    
    /**
     * update
     *
     * @param  mixed $request
     * @param  mixed $id
     * @return RedirectResponse
     */
    public function update(Request $request, $id): RedirectResponse
    {
        // Validate form
        $this->validate($request, [
            'pdf'       => 'mimetypes:application/pdf|max:10000',  // Not required for update
            'prodi'     => 'required|min:5',
            'sk'        => 'required|min:5',
            'predikat'  => 'required|min:5',
            'awal'      => 'required|min:10',
            'akhir'     => 'required|min:10'
        ]);

        // Get akreditasi by ID
        $akreditasi = akreds::findOrFail($id);

        // Check if a new pdf is uploaded
        if ($request->hasFile('pdf')) {

            // Upload new pdf
            $pdf = $request->file('pdf');        
            $filename = time() . '.' . $pdf->getClientOriginalExtension();
            $pdf->move(public_path('assets'), $filename);

            // Delete old pdf (manually from 'assets' folder)
            if ($akreditasi->pdf) {
                $oldFile = public_path('assets/' . $akreditasi->pdf);
                if (file_exists($oldFile)) {
                    unlink($oldFile);
                }
            }

            // Update akreditasi with new pdf
            $akreditasi->update([
                'pdf'       => $filename,
                'prodi'     => $request->prodi,
                'sk'        => $request->sk,
                'predikat'  => $request->predikat,
                'awal'      => $request->awal,
                'akhir'     => $request->akhir
            ]);

        } else {

            // Update akreditasi without changing the pdf
            $akreditasi->update([
                'prodi'     => $request->prodi,
                'sk'        => $request->sk,
                'predikat'  => $request->predikat,
                'awal'      => $request->awal,
                'akhir'     => $request->akhir
            ]);
        }

        // Redirect to index
        return redirect()->route('akreditasi.index')->with(['success' => 'Data Berhasil Diubah!']);
    }

     /**
     * destroy
     *
     * @param  mixed $akreditasi
     * @return void
     */
    public function destroy($id): RedirectResponse
    {
        // Get akreditasi by ID
        $akreditasi = akreds::findOrFail($id);

        // Delete pdf from 'assets' folder
        $filePath = public_path('assets/' . $akreditasi->pdf);
        if (file_exists($filePath)) {
            unlink($filePath);
        }

        // Delete akreditasi
        $akreditasi->delete();

        // Redirect to index
        return redirect()->route('akreditasi.index')->with(['success' => 'Data Berhasil Dihapus!']);
    }

    public function userIndex(Request $request): View
    {
        $search = $request->input('search');
    $sort = $request->input('sort', 'prodi');
    $order = $request->input('order', 'asc');

    $akreditasi = akreds::when($search, function ($query) use ($search) {
            return $query->where('prodi', 'like', '%' . $search . '%')
                         ->orWhere('sk', 'like', '%' . $search . '%');
        })
        ->orderBy($sort, $order)
        ->get();
    $akreditasi = akreds::latest()->paginate(10);
        // Return view for the user frontend
        return view('akreditasi.user', compact('akreditasi'));
    }

    public function showPdf($id)
    {
    // Temukan data akreditasi berdasarkan ID
    $akreditasi = akreds::findOrFail($id);

    // Asumsi bahwa field 'file_pdf' menyimpan path file PDF akreditasi
    // Misalkan file PDF disimpan di folder storage/app/public/akreditasi/
    $filePath = storage_path('app/public/akreditasi/' . $akreditasi->file_pdf);

    // Redirect ke view baru untuk menampilkan PDF
    return view('akreditasi.pdf', compact('akreditasi', 'filePath'));
    }

    //Datatables
    public function sisaAkreditasi(): JsonResponse
{
    // Get akreditasi with search and sorting functionality
    $akreditasi = akreds::get();

    return DataTables::of($akreditasi)
        ->addIndexColumn()
        ->addColumn('action', function($row){
            return '<div>
                        <button class="btn btn-sm btn-success edit" data-id="' . $row->id . '">Edit</button>
                    </div>';
        })
        ->make(true);
        return view('akreditasi.user', compact('akreditasi'));
    }


    public function showTabulasi(Request $request)
{
    $search = $request->input('search');
    $sort = $request->input('sort', 'prodi');
    $order = $request->input('order', 'asc');

    // Query data akreditasi dengan filter pencarian dan sorting
    $akreditasi = akreds::when($search, function ($query) use ($search) {
            return $query->where('prodi', 'like', '%' . $search . '%')
                         ->orWhere('sk', 'like', '%' . $search . '%');
        })
        ->orderBy($sort, $order)
        ->paginate(9); // Menggunakan paginate agar bisa menggunakan pagination secara otomatis

    // Menambahkan countdown untuk setiap akreditasi
    foreach ($akreditasi as $akreds) {
        $tanggalAkhir = Carbon::parse($akreds->akhir);
        $tanggalSekarang = Carbon::now();
        $sisaHari = $tanggalSekarang->diffInDays($tanggalAkhir, false);

        // Simpan hasil hitungan sisa hari sebagai bagian dari objek akreditasi
        if ($sisaHari > 0) {
            $akreds->countdown = $sisaHari . ' hari tersisa';
        } else {
            $akreds->countdown = 'Sudah kadaluarsa';
        }
    }

    return view('akreditasi.tabulasi', ['akreditasi' => $akreditasi]);

    }



}