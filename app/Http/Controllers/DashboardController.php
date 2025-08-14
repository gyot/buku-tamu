<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\BiodataTamu;
use App\Models\BukuTamu;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $filterKeperluan = $request->input('keperluan');
        $filterTahun = $request->input('tahun');

        // Validasi tahun
        if (!is_numeric($filterTahun) || strlen($filterTahun) != 4) {
            $filterTahun = date('Y');
        }

        // Grafik jumlah tamu per bulan berdasarkan tahun
        $queryBuku = BukuTamu::query()->whereYear('tanggal', $filterTahun);
        if ($filterKeperluan) {
            $queryBuku->where('keperluan', $filterKeperluan);
        }

        $tamuPerBulan = $queryBuku->selectRaw('MONTH(tanggal) as bulan, COUNT(*) as jumlah')
            ->groupBy('bulan')
            ->orderBy('bulan')
            ->pluck('jumlah', 'bulan')
            ->toArray();

        $bulan = [];
        $jumlahTamu = [];
        foreach (range(1, 12) as $i) {
            $bulan[] = Carbon::create()->month($i)->locale('id')->translatedFormat('F');
            $jumlahTamu[] = $tamuPerBulan[$i] ?? 0;
        }

        // Statistik Biodata
        $queryBiodata = BiodataTamu::with('bukuTamu')->whereYear('created_at', $filterTahun);
        if ($filterKeperluan) {
            $queryBiodata->whereHas('bukuTamu', function ($q) use ($filterKeperluan) {
                $q->where('keperluan', $filterKeperluan);
            });
        }

        $totalBiodata = $queryBiodata->count();
        $belumSelesai = (clone $queryBiodata)->where('status', 'Belum Selesai')->count();
        $proses = (clone $queryBiodata)->where('status', 'Proses')->count();
        $selesai = (clone $queryBiodata)->where('status', 'Selesai')->count();

        $statusChart = [
            'Belum Selesai' => $belumSelesai,
            'Proses' => $proses,
            'Selesai' => $selesai,
        ];

        // Jumlah tamu yang belum isi biodata
        $biodataTamuIDs = BiodataTamu::pluck('buku_tamu_id')->toArray();
        $belumIsiBiodata = BukuTamu::whereYear('tanggal', $filterTahun)
            ->when($filterKeperluan, fn($q) => $q->where('keperluan', $filterKeperluan))
            ->whereNotIn('id', $biodataTamuIDs)
            ->count();

        // Keperluan chart
        $keperluanChart = BukuTamu::selectRaw('keperluan, COUNT(*) as jumlah')
            ->when($filterKeperluan, fn($q) => $q->where('keperluan', $filterKeperluan))
            ->whereYear('tanggal', $filterTahun)
            ->groupBy('keperluan')
            ->pluck('jumlah', 'keperluan')
            ->toArray();

        return view('admin.dashboard', compact(
            'totalBiodata', 'belumSelesai', 'proses', 'selesai', 'belumIsiBiodata',
            'bulan', 'jumlahTamu', 'filterTahun', 'filterKeperluan',
            'statusChart', 'keperluanChart'
        ));
    }
}
