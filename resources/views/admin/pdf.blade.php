<!DOCTYPE html>
<html>
<head>
    <title>Laporan Pengaduan Mahasiswa</title>
    <style>
        body { font-family: 'Helvetica', 'Arial', sans-serif; font-size: 11px; color: #333; line-height: 1.5; }
        .header { text-align: center; border-bottom: 2px solid #333; padding-bottom: 15px; margin-bottom: 20px; }
        .logo { width: 350px; height: auto; }
        .title { font-size: 18px; font-weight: bold; text-transform: uppercase; margin-bottom: 5px; }
        .subtitle { font-size: 12px; margin-bottom: 20px; }
        
        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        th, td { border: 1px solid #999; padding: 10px 8px; text-align: left; }
        th { background-color: #f2f2f2; font-weight: bold; text-transform: uppercase; font-size: 10px; }
        
        .text-center { text-align: center; }
        .badge { padding: 4px 8px; border-radius: 4px; color: white; font-size: 9px; font-weight: bold; display: inline-block; }
        .bg-pending { background-color: #f59e0b; }
        .bg-diproses { background-color: #8B1A1A; }
        .bg-selesai { background-color: #10b981; }

        .footer-section { margin-top: 50px; width: 100%; }
        .signature-box { float: right; width: 250px; text-align: center; }
        .clear { clear: both; }
    </style>
</head>
<body>

    <div class="header">
        <div style="color: #8B1A1A; font-size: 24px; font-weight: bold; letter-spacing: 1px; margin-bottom: 5px;">HORIZON UNIVERSITY INDONESIA</div>
        <div style="color: #333; font-size: 14px; font-weight: bold; letter-spacing: 3px; margin-bottom: 10px;">K A R A W A N G</div>
        <div class="title" style="margin-top: 20px; border-top: 1px solid #333; padding-top: 15px;">Rekapitulasi Pengaduan Mahasiswa</div>
        <div class="subtitle">Dicetak pada: {{ \Carbon\Carbon::now()->translatedFormat('d F Y, H:i') }} WIB</div>
    </div>

    <table>
        <thead>
            <tr>
                <th style="width: 30px;">No</th>
                <th>Nama Pengirim</th>
                <th>Judul Laporan</th>
                <th>Kategori</th>
                <th style="width: 100px;">Tanggal Lapor</th>
                <th style="width: 80px;">Status</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($pengaduans as $index => $p)
            <tr>
                <td class="text-center">{{ $index + 1 }}</td>
                <td style="font-weight: bold;">{{ $p->user->name }}</td>
                <td>{{ $p->judul }}</td>
                <td>{{ $p->kategori }}</td>
                <td class="text-center">{{ \Carbon\Carbon::parse($p->created_at)->format('d/m/Y') }}</td>
                <td class="text-center">
                    @if($p->status == 'pending') <span class="badge bg-pending">PENDING</span>
                    @elseif($p->status == 'diproses') <span class="badge bg-diproses">DIPROSES</span>
                    @else <span class="badge bg-selesai">SELESAI</span>
                    @endif
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div class="footer-section">
        <div class="signature-box">
            <p>Karawang, {{ \Carbon\Carbon::now()->translatedFormat('d F Y') }}</p>
            <p style="margin-top: 5px; font-weight: bold;">CSDL Horizon University Indonesia</p>
            <div style="height: 80px;"></div>
            <p style="text-decoration: underline; font-weight: bold;">( __________________________ )</p>
            <p>Petugas Penanggung Jawab</p>
        </div>
        <div class="clear"></div>
    </div>

</body>
</html>