<!DOCTYPE html>
<html>
<head>
    <title>Laporan Pengaduan Mahasiswa</title>
    <style>
        body { font-family: sans-serif; font-size: 12px; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #333; padding: 8px; text-align: left; }
        th { background-color: #f2f2f2; }
        .text-center { text-align: center; }
        .badge { padding: 3px 8px; border-radius: 4px; color: white; font-size: 10px; }
        .bg-pending { background-color: #f59e0b; }
        .bg-diproses { background-color: #3b82f6; }
        .bg-selesai { background-color: #10b981; }
    </style>
</head>
<body>

    <div class="text-center">
        <h2>Rekapitulasi Pengaduan Mahasiswa</h2>
        <p>Dicetak pada: {{ \Carbon\Carbon::now()->format('d M Y, H:i') }}</p>
    </div>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Pengirim</th>
                <th>Judul Laporan</th>
                <th>Kategori</th>
                <th>Tanggal Lapor</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($pengaduans as $index => $p)
            <tr>
                <td class="text-center">{{ $index + 1 }}</td>
                <td>{{ $p->user->name }}</td>
                <td>{{ $p->judul }}</td>
                <td>{{ $p->kategori }}</td>
                <td>{{ \Carbon\Carbon::parse($p->created_at)->format('d/m/Y') }}</td>
                <td>
                    @if($p->status == 'pending') <span class="badge bg-pending">Pending</span>
                    @elseif($p->status == 'diproses') <span class="badge bg-diproses">Diproses</span>
                    @else <span class="badge bg-selesai">Selesai</span>
                    @endif
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

</body>
</html>