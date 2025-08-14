<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use App\Models\BukuTamu;
use App\Models\BiodataTamu;
use Barryvdh\DomPDF\Facade\Pdf;
use PhpOffice\PhpSpreadsheet\Worksheet\Drawing;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Font;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Fill;


class RekapanTamuController extends Controller
{
    public function index(Request $request)
    {
        $tipe = $request->input('tipe_data', 'buku');
        $tanggalAwal = $request->input('tanggal_awal');
        $tanggalAkhir = $request->input('tanggal_akhir');

        $data = [];

        if ($tipe === 'buku') {
            $query = BukuTamu::query();
            if ($tanggalAwal && $tanggalAkhir) {
                $query->whereBetween('tanggal', [$tanggalAwal, $tanggalAkhir]);
            }
            $data = $query->orderBy('tanggal', 'desc')->get();
        } elseif ($tipe === 'biodata') {
            $query = BiodataTamu::with(['bukuTamu' => function ($q) use ($tanggalAwal, $tanggalAkhir) {
                if ($tanggalAwal && $tanggalAkhir) {
                    $q->whereBetween('tanggal', [$tanggalAwal, $tanggalAkhir]);
                }
            }]);

            $data = $query->get()
                ->filter(fn($item) => $item->bukuTamu !== null)
                ->sortByDesc(fn($item) => optional($item->bukuTamu)->tanggal);
        }

        return view('rekapan.index', compact('data', 'tipe', 'tanggalAwal', 'tanggalAkhir'));
    }

    public function export(Request $request)
    {
        $tipe = $request->input('tipe_data');
        $tanggalAwal = $request->input('tanggal_awal');
        $tanggalAkhir = $request->input('tanggal_akhir');
        $filenameInput = $request->input('filename');

        if ($tipe === 'buku') {
            $query = BukuTamu::query();
            if ($tanggalAwal && $tanggalAkhir) {
                $query->whereBetween('tanggal', [$tanggalAwal, $tanggalAkhir]);
            }
            $data = $query->orderBy('tanggal', 'desc')->get();
        } elseif ($tipe === 'biodata') {
            $query = BiodataTamu::with('bukuTamu');
            if ($tanggalAwal && $tanggalAkhir) {
                $query->whereHas('bukuTamu', function ($q) use ($tanggalAwal, $tanggalAkhir) {
                    $q->whereBetween('tanggal', [$tanggalAwal, $tanggalAkhir]);
                });
            }
            $data = $query->get()
                ->filter(fn($item) => $item->bukuTamu !== null)
                ->sortByDesc(fn($item) => optional($item->bukuTamu)->tanggal);
        } else {
            return back()->with('error', 'Tipe data tidak valid.');
        }

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        // Tentukan kolom terakhir berdasarkan jenis data
        $lastCol = $tipe === 'biodata' ? 'H' : 'E';

        // Tambahkan logo
        $logo = new Drawing();
        $logo->setName('Logo');
        $logo->setDescription('Logo Kemdikbud');
        $logo->setPath(public_path('assets/image/logo_kemdikbud_2.jpg'));
        $logo->setHeight(60);
        $logo->setCoordinates('A1');
        $logo->setWorksheet($sheet);

        // KOP
        $kop = [
            'KEMENTERIAN PENDIDIKAN, DASAR DAN MENENGAH',
            'BALAI PENJAMINAN MUTU PENDIDIKAN PROVINSI NUSA TENGGARA BARAT',
            'Jalan Panji Tilarnegara No. 8, Mataram 83114',
            'Telepon (0370) 631088, Faks (0370) 629835',
            'Laman: https://bpmpntb.kemendikdasmen.go.id/'
        ];

        foreach ($kop as $i => $text) {
            $row = $i + 1;
            $sheet->mergeCells("B$row:{$lastCol}$row");
            $sheet->setCellValue("B$row", $text);
            $sheet->getStyle("B$row")->getFont()->setBold(true);
            $sheet->getStyle("B$row")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        }

        // Tambahkan garis tebal di bawah kop
        $borderRow = count($kop) + 1; // Baris ke-6
        $sheet->getStyle("A$borderRow:{$lastCol}$borderRow")->getBorders()->getBottom()
            ->setBorderStyle(Border::BORDER_THICK);

        // Judul laporan
        $sheet->mergeCells("A7:{$lastCol}7");
        $sheet->setCellValue("A7", 'LAPORAN DATA ' . strtoupper($tipe === 'biodata' ? 'BIODATA TAMU' : 'BUKU TAMU'));
        $sheet->getStyle("A7")->getFont()->setBold(true)->setSize(12);
        $sheet->getStyle("A7")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

        // Periode
        if ($tanggalAwal && $tanggalAkhir) {
            $sheet->mergeCells("A8:{$lastCol}8");
            $sheet->setCellValue("A8", 'Periode: ' . \Carbon\Carbon::parse($tanggalAwal)->format('d-m-Y') . ' s.d. ' . \Carbon\Carbon::parse($tanggalAkhir)->format('d-m-Y'));
            $sheet->getStyle("A8")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        }

        // Baris awal data
        $startRow = 10;

        if ($tipe === 'buku') {
            $headers = ['Nama', 'Instansi/Alamat', 'Nomor HP', 'Keperluan', 'Tanggal'];
            $sheet->fromArray($headers, null, "A$startRow");

            foreach ($data as $index => $row) {
                $sheet->fromArray([
                    $row->nama,
                    $row->instansi,
                    $row->no_hp,
                    $row->keperluan,
                    $row->tanggal->format('d-m-Y'),
                ], null, 'A' . ($startRow + 1 + $index));
            }
        } else {
            $headers = ['Nama', 'Instansi/Alamat', 'Nomor HP', 'Keperluan', 'Tanggal', 'Permasalahan', 'Tanggapan', 'Status'];
            $sheet->fromArray($headers, null, "A$startRow");

            foreach ($data as $index => $row) {
                $sheet->fromArray([
                    optional($row->bukuTamu)->nama,
                    optional($row->bukuTamu)->instansi,
                    optional($row->bukuTamu)->no_hp,
                    optional($row->bukuTamu)->keperluan,
                    optional($row->bukuTamu)->tanggal ? $row->bukuTamu->tanggal->format('d-m-Y') : '',
                    $row->permasalahan,
                    $row->tanggapan,
                    $row->status,
                ], null, 'A' . ($startRow + 1 + $index));
            }
        }

        $lastRow = $startRow + $data->count();

        // Styling header tabel
        $sheet->getStyle("A$startRow:{$lastCol}$startRow")->getFont()->setBold(true);
        $sheet->getStyle("A$startRow:{$lastCol}$startRow")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle("A$startRow:{$lastCol}$startRow")->getFill()
            ->setFillType(Fill::FILL_SOLID)
            ->getStartColor()->setRGB('DDEBF7');

        // Border seluruh tabel
        $sheet->getStyle("A$startRow:{$lastCol}$lastRow")->getBorders()->getAllBorders()
            ->setBorderStyle(Border::BORDER_THIN);

        // Auto size kolom
        foreach (range('A', $lastCol) as $col) {
            $sheet->getColumnDimension($col)->setAutoSize(true);
        }

        // Footer
        $sheet->setCellValue("A" . ($lastRow + 2), 'Dicetak oleh: ' . auth()->user()->name);
        $sheet->setCellValue("A" . ($lastRow + 3), 'Tanggal: ' . now()->format('d-m-Y'));


        $filename = $filenameInput ?: 'rekapan_' . $tipe . '_tamu.xlsx';
        $tempPath = tempnam(sys_get_temp_dir(), $filename);
        $writer = new Xlsx($spreadsheet);
        $writer->save($tempPath);

        return response()->download($tempPath, $filename)->deleteFileAfterSend(true);
    }

    public function exportPdf(Request $request)
    {
        $tipe = $request->input('tipe_data');
        $tanggalAwal = $request->input('tanggal_awal');
        $tanggalAkhir = $request->input('tanggal_akhir');

        if ($tipe === 'buku') {
            $query = BukuTamu::query();
            if ($tanggalAwal && $tanggalAkhir) {
                $query->whereBetween('tanggal', [$tanggalAwal, $tanggalAkhir]);
            }
            $data = $query->orderBy('tanggal', 'desc')->get();

            $pdf = Pdf::loadView('rekapan.pdf_buku', [
                'data' => $data,
                'tanggalAwal' => $tanggalAwal,
                'tanggalAkhir' => $tanggalAkhir,
                'admin' => auth()->user(),
            ])->setPaper('a4', 'portrait');

        } elseif ($tipe === 'biodata') {
            $query = BiodataTamu::with('bukuTamu');
            if ($tanggalAwal && $tanggalAkhir) {
                $query->whereHas('bukuTamu', function ($q) use ($tanggalAwal, $tanggalAkhir) {
                    $q->whereBetween('tanggal', [$tanggalAwal, $tanggalAkhir]);
                });
            }
            $data = $query->get()
                ->filter(fn($item) => $item->bukuTamu !== null)
                ->sortByDesc(fn($item) => optional($item->bukuTamu)->tanggal);

            $pdf = Pdf::loadView('rekapan.pdf_biodata', [
                'data' => $data,
                'tanggalAwal' => $tanggalAwal,
                'tanggalAkhir' => $tanggalAkhir,
                'admin' => auth()->user(),
            ])->setPaper('a4', 'landscape');
        } else {
            return back()->with('error', 'Tipe data tidak valid.');
        }

        return $pdf->stream('rekapan_' . $tipe . '.pdf');
    }
}
