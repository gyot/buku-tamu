<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\BiodataTamu;
use App\Models\BukuTamu;
use Illuminate\Support\Facades\DB;

class BiodataTamuController extends Controller
{
    /**
     * Menampilkan daftar biodata tamu.
     */
    public function index(Request $request)
    {
        $query = DB::table('buku_tamus')
            ->leftJoin('biodata_tamus', 'buku_tamus.id', '=', 'biodata_tamus.buku_tamu_id')
            ->select(
                'buku_tamus.*',
                'biodata_tamus.id as biodata_id',
                'biodata_tamus.permasalahan',
                'biodata_tamus.tanggapan',
                'biodata_tamus.status'
            );

        if ($request->filled('cari')) {
            $query->where(function ($q) use ($request) {
                $q->where('buku_tamus.nama', 'like', "%{$request->cari}%")
                ->orWhere('buku_tamus.instansi', 'like', "%{$request->cari}%")
                ->orWhere('buku_tamus.keperluan', 'like', "%{$request->cari}%");
            });
        }

        if ($request->filled('status')) {
            $query->where('biodata_tamus.status', $request->status);
        }

        $biodataTamus = $query->orderBy('buku_tamus.tanggal', 'desc')->paginate(10)->withQueryString();

        return view('biodata_tamus.index', compact('biodataTamus'));
    }
    /**
     * Menampilkan form untuk menambah biodata tamu.
     */
    public function create(Request $request)
    {
        $bukuTamu = BukuTamu::findOrFail($request->buku_tamu_id);
        return view('biodata_tamus.create', compact('bukuTamu'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'buku_tamu_id' => 'required|exists:buku_tamus,id',
            'permasalahan' => 'required',
            'tanggapan' => 'required',
            'status' => 'required',
        ]);

        BiodataTamu::create($request->all());

        return redirect()
            ->route('biodata-tamus.index', ['page' => $request->input('page')])
            ->with('success', 'Biodata berhasil disimpan.');
    }

    public function edit($id)
    {
        $biodata = BiodataTamu::with('bukuTamu')->findOrFail($id);
        $page = request('page');
        return view('biodata_tamus.edit', compact('biodata', 'page'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'permasalahan' => 'required',
            'tanggapan' => 'required',
            'status' => 'required',
        ]);

        $biodata = BiodataTamu::findOrFail($id);
        $biodata->update($request->all());

        return redirect()->route('biodata-tamus.index', ['page' => $request->input('page')])
            ->with('success', 'Biodata berhasil diperbarui.');
    }

    /**
     * Menghapus biodata tamu dari database.
     */
    public function destroy(BiodataTamu $biodataTamu)
    {
        $biodataTamu->delete();
        return redirect()->route('biodata-tamus.index')->with('success', 'Biodata tamu berhasil dihapus.');
    }
}
