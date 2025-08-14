<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\BukuTamu;
use Carbon\Carbon;

class BukuTamuController extends Controller
{
    /**
     * Menampilkan daftar tamu.
     */
    // Menampilkan daftar tamu (untuk admin)
    public function index(Request $request)
    {
        $query = BukuTamu::query();

        // Filter pencarian (nama, instansi, keperluan)
        if ($request->filled('cari')) {
            $query->where(function($q) use ($request) {
                $q->where('nama', 'like', '%' . $request->cari . '%')
                ->orWhere('instansi', 'like', '%' . $request->cari . '%')
                ->orWhere('keperluan', 'like', '%' . $request->cari . '%');
            });
        }

        // Filter berdasarkan bulan dan tahun (input type="month")
        if ($request->filled('bulan')) {
            $bulan = $request->bulan;
            try {
                $tanggal = Carbon::createFromFormat('Y-m', $bulan);
                $query->whereMonth('tanggal', $tanggal->month)
                    ->whereYear('tanggal', $tanggal->year);
            } catch (\Exception $e) {
                // Format salah, abaikan filter bulan
            }
        }

        // Pagination dan sorting
        $bukuTamus = $query->orderBy('tanggal', 'desc')->paginate(10)->withQueryString();

        return view('bukutamu.index', compact('bukuTamus'));
    }
    /**
     * Menampilkan form untuk menambah tamu baru.
     */
    public function create()
    {
        $today = Carbon::today();
        $yesterday = Carbon::yesterday();
        $bulan_ini = Carbon::now();

        $statistik = [
            'hari_ini' => [
                'label' => $today->translatedFormat('d/m/Y'),
                'jumlah' => BukuTamu::whereDate('tanggal', $today)->count(),
            ],
            'kemarin' => [
                'label' => $yesterday->translatedFormat('d/m/Y'),
                'jumlah' => BukuTamu::whereDate('tanggal', $yesterday)->count(),
            ],
            'bulan_ini' => [
                'label' => $bulan_ini->translatedFormat('F Y'),
                'jumlah' => BukuTamu::whereMonth('tanggal', $bulan_ini->month)
                                    ->whereYear('tanggal', $bulan_ini->year)
                                    ->count(),
            ]
        ];

        return view('bukutamu.create', compact('statistik'));
    }


    /**
     * Menyimpan data tamu ke database.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'instansi' => 'nullable|string|max:255',
            'keperluan' => 'required|in:Layanan Data dan Informasi Mutu Pendidikan,Layanan Pemetaan dan Supervisi Mutu Pendidikan,Layanan Kemitraan Penjaminan Mutu Pendidikan,Layanan Sarana dan Prasarana,Kunjungan Kerja,Silaturahmi,Lainnya',
            'no_hp' => 'nullable|numeric|digits_between:10,15',
            'tanggal' => 'required|date'
        ], [
            'no_hp.numeric' => 'Nomor HP harus berupa angka.',
            'no_hp.digits_between' => 'Nomor HP harus terdiri dari 10 sampai 15 digit.'
        ]);

        BukuTamu::create($request->all());

        // return redirect()->route('buku-tamus.create')->with('success', 'Data tamu berhasil ditambahkan.');
        return redirect()->route('buku-tamus.terimakasih');
    }

    /**
     * Menampilkan detail tamu.
     */
    public function show(BukuTamu $bukuTamu)
    {
        return view('bukutamu.show', compact('bukuTamu'));
    }

    /**
     * Menampilkan form untuk mengedit tamu.
     */
    public function edit(BukuTamu $bukuTamu)
    {
        $page = request('page');
        return view('bukutamu.edit', compact('bukuTamu', 'page'));
    }

    /**
     * Mengupdate data tamu.
     */
    public function update(Request $request, BukuTamu $bukuTamu)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'instansi' => 'nullable|string|max:255',
            'keperluan' => 'required|in:Layanan Data dan Informasi Mutu Pendidikan,Layanan Pemetaan dan Supervisi Mutu Pendidikan,Layanan Kemitraan Penjaminan Mutu Pendidikan,Layanan Sarana dan Prasarana,Kunjungan Kerja,Silaturahmi,Lainnya',
            'no_hp' => 'nullable|numeric|digits_between:10,15'
        ], [
            'no_hp.numeric' => 'Nomor HP harus berupa angka.',
            'no_hp.digits_between' => 'Nomor HP harus terdiri dari 10 sampai 15 digit.'
        ]);

        $bukuTamu->update($request->all());

        return redirect()->route('buku-tamus.index', ['page' => $request->input('page')])
            ->with('success', 'Data tamu berhasil diperbarui.');
    }

    /**
     * Menghapus tamu dari database.
     */
    public function destroy(BukuTamu $bukuTamu)
    {
        $bukuTamu->delete();
        return redirect()->route('buku-tamus.index')->with('success', 'Data tamu berhasil dihapus.');
    }
}
