<!DOCTYPE html>
<html>
<head>
    <title>Laporan Pengaduan Mahasiswa</title>
    <style>
        body { font-family: 'Helvetica', 'Arial', sans-serif; font-size: 11px; color: #333; line-height: 1.5; }
        .header { text-align: center; padding-bottom: 10px; margin-bottom: 20px; }
        .logo { width: 300px;}
        .divider { border: none; border-top: 3px solid #8B1A1A; margin: 10px 0 12px 0; }
        .title { font-size: 15px; font-weight: bold; text-transform: uppercase; margin-bottom: 4px; color: #222; }
        .subtitle { font-size: 11px; color: #555; }
        
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
        <img src="{{ public_path('images/Horizon_University_Indonesia_Logo.png') }}" class="logo" alt="Logo Horizon University Indonesia">
        <hr class="divider">
        <div class="title">Rekapitulasi Pengaduan Mahasiswa</div>
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