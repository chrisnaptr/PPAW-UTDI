<?php

namespace App\Http\Controllers;

use App\Models\akreds;
use Illuminate\View\View;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Response;

class AkreditasiController extends Controller
{
    /**
     * index
     *
     * @return View
     */
    public function index(): View
    {
        // Get akreditasi
        $akreditasi = akreds::latest()->paginate(10);

        // Render view with akreditasi
        return view('akreditasi.index', compact('akreditasi'));
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
            'awal'      => 'required|min:10',
            'akhir'     => 'required|min:10'
        ]);

        // Upload pdf
        $pdf = $request->file('pdf');        
        $filename = time() . '.' . $pdf->getClientOriginalExtension();
        $pdf->move(public_path('assets'), $filename);

        // Create akreditasi
        akreds::create([
            'pdf'       => $filename,  // Store the filename only
            'prodi'     => $request->prodi,
            'sk'        => $request->sk,
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
                'awal'      => $request->awal,
                'akhir'     => $request->akhir
            ]);

        } else {

            // Update akreditasi without changing the pdf
            $akreditasi->update([
                'prodi'     => $request->prodi,
                'sk'        => $request->sk,
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

    /**
     * index
     *
     * @return View
     */
    public function frontend()
    {
       
        $akreditasi = akreds::latest()->paginate(4);
       
        //render view with akreds
        return view('akreditasi.frontend', compact('akreditasi'));
    }

    public function search(Request $request)
    {
        $search = $request->input('search');
        $prodi = $request->input('prodi');
        $status = $request->input('status');

        $akreditasi = akreds::where(function ($query) use ($search, $prodi, $status) {
            if ($search) {
                $query->where('prodi', 'like', '%' . $search . '%');
            }
            if ($prodi) {
                $query->where('prodi', $prodi);
            }
            if ($status) {
                $query->where('status', $status);
            }
        })->paginate(4);

        return view('akreditasi.search', compact('akreditasi'));
    }
}