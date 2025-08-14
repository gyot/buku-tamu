<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan Biodata Tamu</title>
    <style>
        body {
            font-family: "Times-Roman", Times, serif;
            font-size: 11px;
        }
        .kop {
            text-align: center;
            margin-bottom: 10px;
        }
        .kop img {
            float: left;
            width: 70px;
            height: auto;
        }
        .kop h4, .kop p {
            margin: 0;
        }
        .garis {
            border-bottom: 2px solid #000;
            margin-top: 10px;
            margin-bottom: 20px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
        }
        th, td {
            border: 1px solid #000;
            padding: 4px;
            font-size: 10px;
            vertical-align: top;
        }
        th {
            background-color: #f0f0f0;
        }
        .ttd {
            width: 100%;
            margin-top: 40px;
            text-align: right;
        }
        .ttd p {
            margin: 2px 0;
        }
    </style>
</head>
<body>

    {{-- KOP --}}
    <div class="kop">
        <img src="{{ public_path('assets/image/logo_kemdikbud_2.jpg') }}" alt="logo">
        <div>
            <h4>KEMENTERIAN PENDIDIKAN, DASAR DAN MENENGAH</h4>
            <h4>BALAI PENJAMINAN MUTU PENDIDIKAN PROVINSI NUSA TENGGARA BARAT</h4>
            <p>Jalan Panji Tilarnegara No. 8, Mataram 83114</p>
            <p>Telepon (0370) 631088 &nbsp; Faksimile (0370) 629835</p>
            <p>Laman: https://bpmpntb.kemendikdasmen.go.id/</p>
        </div>
    </div>
    <div class="garis"></div>

    {{-- JUDUL --}}
    <h4 style="text-align:center; margin-bottom: 0;">LAPORAN LAYANAN TAMU</h4>
    @if($tanggalAwal && $tanggalAkhir)
        <p style="text-align:center; margin: 0;">
            Periode: {{ \Carbon\Carbon::parse($tanggalAwal)->translatedFormat('d M Y') }}
            - {{ \Carbon\Carbon::parse($tanggalAkhir)->translatedFormat('d M Y') }}
        </p>
    @endif

    {{-- TABEL --}}
    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Nama</th>
                <th>Instansi/Alamat</th>
                <th>Nomor HP</th>
                <th>Keperluan</th>
                <th>Tanggal</th>
                <th>Permasalahan</th>
                <th>Tanggapan</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($data as $i => $row)
                <tr>
                    <td align="center">{{ $i + 1 }}</td>
                    <td>{{ optional($row->bukuTamu)->nama }}</td>
                    <td>{{ optional($row->bukuTamu)->instansi }}</td>
                    <td>{{ optional($row->bukuTamu)->no_hp }}</td>
                    <td>{{ optional($row->bukuTamu)->keperluan }}</td>
                    <td>
                        {{ optional($row->bukuTamu)->tanggal
                            ? \Carbon\Carbon::parse($row->bukuTamu->tanggal)->format('d-m-Y')
                            : '-' }}
                    </td>
                    <td>{{ $row->permasalahan ?? '-' }}</td>
                    <td>{{ $row->tanggapan ?? '-' }}</td>
                    <td>{{ $row->status ?? '-' }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    {{-- TANDA TANGAN --}}
    <div class="ttd">
        <p>Mataram, {{ now()->translatedFormat('d F Y') }}</p>
        <p>Dicetak oleh:</p>
        <br><br>
        <p><strong>{{ $admin->name }}</strong></p>
        @if($admin->nip)
            <p>NIP. {{ $admin->nip }}</p>
        @endif
    </div>

</body>
</html>
