<!DOCTYPE html>
<html>
<head>
    <title>Laporan Diproses</title>
</head>
<body style="font-family: Arial, sans-serif; background-color: #f4f4f4; padding: 20px;">
    <div style="background-color: #ffffff; padding: 20px; border-radius: 8px; max-width: 600px; margin: 0 auto; border: 1px solid #e0e0e0; border-top: 5px solid #3b82f6;">
        <h2 style="color: #3b82f6;">Halo, {{ $pengaduan->user->name }}!</h2>
        
        <p>Terima kasih telah menunggu. Laporan pengaduan Anda saat ini <strong>sedang diproses / ditindaklanjuti</strong> oleh tim terkait.</p>
        
        <div style="background-color: #eff6ff; padding: 15px; border-left: 4px solid #3b82f6; margin: 20px 0;">
            <p><strong>Judul Laporan:</strong> {{ $pengaduan->judul }}</p>
            <p><strong>Kategori:</strong> {{ $pengaduan->kategori ?? '-' }}</p>
            <p><strong>Tanggal Lapor:</strong> {{ \Carbon\Carbon::parse($pengaduan->created_at)->format('d M Y') }}</p>
        </div>

        <p>Kami akan mengirimkan email pemberitahuan lagi setelah laporan Anda berstatus "Selesai" dan Admin memberikan tanggapan / solusi.</p>
        
        <p style="color: #888; font-size: 12px; margin-top: 30px;">Ini adalah email otomatis, mohon tidak membalas ke alamat email ini.</p>
    </div>
</body>
</html>