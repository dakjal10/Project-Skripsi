<!DOCTYPE html>
<html>
<head>
    <title>Laporan Selesai</title>
</head>
<body style="font-family: Arial, sans-serif; background-color: #f4f4f4; padding: 20px;">
    <div style="background-color: #ffffff; padding: 20px; border-radius: 8px; max-width: 600px; margin: 0 auto; border: 1px solid #e0e0e0;">
        <h2 style="color: #4f46e5;">Halo, {{ $pengaduan->user->name }}!</h2>
        
        <p>Kabar baik! Laporan pengaduan Anda telah selesai diproses oleh Admin.</p>
        
        <div style="background-color: #f9fafb; padding: 15px; border-left: 4px solid #4f46e5; margin: 20px 0;">
            <p><strong>Judul Laporan:</strong> {{ $pengaduan->judul }}</p>
            <p><strong>Tanggapan Admin:</strong> <br>
               {{ $pengaduan->balasan ?? 'Laporan Anda telah diselesaikan dengan baik.' }}
            </p>
        </div>

        <p>Terima kasih telah berpartisipasi dalam menciptakan lingkungan kampus yang lebih baik.</p>
        
        <p style="color: #888; font-size: 12px; margin-top: 30px;">Ini adalah email otomatis, mohon tidak membalas ke alamat email ini.</p>
    </div>
</body>
</html>