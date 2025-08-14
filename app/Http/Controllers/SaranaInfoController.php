<?php

namespace App\Http\Controllers;

use App\Models\SaranaInfo;
use Illuminate\Http\Request;

class SaranaInfoController extends Controller
{
    public function index()
    {
        $data = SaranaInfo::latest()->paginate(10);
        return view('sarana_infos.index', compact('data'));
    }

    public function create()
    {
        return view('sarana_infos.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'sarana' => 'required',
            'status' => 'required|in:Tersedia,Sudah Dibooking,Dalam Perawatan,Tidak Tersedia',
            'mulai' => 'nullable|date',
            'sampai' => 'nullable|date|after_or_equal:mulai',
        ]);

        SaranaInfo::create($request->all());

        return redirect()->route('sarana-infos.index')
            ->with('success', 'Informasi sarana berhasil ditambahkan.');
    }

    public function edit(SaranaInfo $saranaInfo)
    {
        return view('sarana_infos.edit', compact('saranaInfo'));
    }

    public function update(Request $request, SaranaInfo $saranaInfo)
    {
        $request->validate([
            'sarana' => 'required',
            'status' => 'required|in:Tersedia,Sudah Dibooking,Dalam Perawatan,Tidak Tersedia',
            'mulai' => 'nullable|date',
            'sampai' => 'nullable|date|after_or_equal:mulai',
        ]);

        $saranaInfo->update($request->all());

        return redirect()->route('sarana-infos.index')
            ->with('success', 'Informasi sarana berhasil diperbarui.');
    }

    public function destroy(SaranaInfo $saranaInfo)
    {
        $saranaInfo->delete();

        return redirect()->route('sarana-infos.index')
            ->with('success', 'Informasi sarana berhasil dihapus.');
    }
}