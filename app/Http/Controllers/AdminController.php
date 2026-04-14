<?php

namespace App\Http\Controllers;
use App\Models\Pengaduan;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Mail;
use App\Mail\LaporanSelesaiMail;
use App\Mail\LaporanDiprosesMail;
use App\Notifications\StatusLaporanNotification;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;

class AdminController extends Controller
    {
        public function index(Request $request)
    {
        // 1. Hitung data untuk Kartu Statistik
        $total_laporan = Pengaduan::count();
        $laporan_pending = Pengaduan::where('status', 'pending')->count();
        $laporan_diproses = Pengaduan::whereIn('status', ['proses', 'diproses'])->count();
        $laporan_selesai = Pengaduan::where('status', 'selesai')->count();
        
        //===============================================================================
        // 1. Mulai query, tambahkan withCount('likes') untuk menghitung jumlah dukungan
        $query = Pengaduan::with('user')->withCount('likes');

        // 2. Fitur Pencarian (Berdasarkan Judul, Kategori, atau Nama Pengirim)
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('judul', 'like', '%' . $search . '%')
                ->orWhere('kategori', 'like', '%' . $search . '%')
                ->orWhereHas('user', function($userQuery) use ($search) {
                    $userQuery->where('name', 'like', '%' . $search . '%'); 
                });
            });
        }

        // 3. Fitur Filter Status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // 4. Fitur Pengurutan (Terbaru vs Dukungan Terbanyak)
        if ($request->filled('sort') && $request->sort == 'terbanyak') {
            // Jika admin memilih urutkan berdasarkan dukungan terbanyak
            $query->orderBy('likes_count', 'desc');
        } else {
            // Default: Urutkan dari yang terbaru (tanggal dibuat)
            $query->orderBy('created_at', 'desc');
        }

        // 5. Eksekusi query
        $pengaduans = $query->get();

        return view('admin.index', compact(
            'pengaduans', 
            'total_laporan', 
            'laporan_pending', 
            'laporan_diproses', 
            'laporan_selesai'
        )); 
    
        dd($pengaduan->user); // ini code chek yg baru saya tambahkan
        $pengaduan->user->notify(new StatusLaporanNotification($pengaduan));
    }
// TAMBAHKAN FUNGSI INI
    public function updateStatus(Request $request, $id)
    {
        $pengaduan = \App\Models\Pengaduan::findOrFail($id);
        
        // Simpan status lama untuk dicek nanti
        $statusLama = $pengaduan->status; 
        
        // Update ke status baru
        $pengaduan->update([
            'status' => $request->status
        ]);

        // LOGIKA PENGIRIMAN EMAIL OTOMATIS
        if ($pengaduan->user->email) {
            
            // 1. Jika status diubah jadi "Diproses"
            if ($pengaduan->user && $statusLama != $request->status) {
            $pengaduan->user->notify(new \App\Notifications\StatusLaporanNotification($pengaduan));
            }
            
            // 2. Sekalian kita tambahkan: Jika Admin ubah jadi "Selesai" lewat dropdown tabel (bukan lewat tombol balas)
            elseif ($request->status == 'selesai' && $statusLama != 'selesai') {
                Mail::to($pengaduan->user->email)->send(new LaporanSelesaiMail($pengaduan));
            }
        }

        return redirect()->back()->with('success', 'Status berhasil diperbarui dan notifikasi email telah dikirim!');
    }
    public function show($id)
    {
        // Cari pengaduan berdasarkan ID beserta data usernya
        $pengaduan = Pengaduan::with('user')->findOrFail($id);
        
        // Tampilkan ke halaman detail
        return view('admin.detail', compact('pengaduan'));
    }
    public function reply(Request $request, $id)
    {
        // Validasi input
        $request->validate([
            'balasan' => 'required|string',
        ]);

        // Cari data pengaduan
        $pengaduan = \App\Models\Pengaduan::findOrFail($id);

        // Update balasan dan ubah status otomatis jadi selesai
        $pengaduan->update([
            'balasan' => $request->balasan,
            'status' => 'selesai'
        ]);

        // Kirim Notifikasi Lonceng & Email saat Admin Membalas
        if ($pengaduan->user) {
            $pengaduan->user->notify(new StatusLaporanNotification($pengaduan));
            
            if ($pengaduan->user->email) {
                Mail::to($pengaduan->user->email)->send(new LaporanSelesaiMail($pengaduan));
            }
        }

        return redirect()->back()->with('success', 'Tanggapan berhasil dikirim dan status laporan telah Selesai!');
    }

    public function exportPdf(Request $request)
    {
        // 1. Ambil data pengaduan (sama seperti fungsi index, agar bisa difilter)
        $query = Pengaduan::with('user');

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('judul', 'like', '%' . $search . '%')
                  ->orWhere('kategori', 'like', '%' . $search . '%')
                  ->orWhereHas('user', function($userQuery) use ($search) {
                      $userQuery->where('name', 'like', '%' . $search . '%'); 
                  });
            });
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $pengaduans = $query->orderBy('created_at', 'desc')->get();

        // 2. Load tampilan (view) khusus untuk PDF
        $pdf = Pdf::loadView('admin.pdf', compact('pengaduans'));
        
        // 3. Download file PDF-nya
        return $pdf->download('Rekap_Pengaduan_Mahasiswa.pdf');
    }
    // Fungsi untuk memproses klik notifikasi oleh Admin
    public function bacaNotifikasi($id)
    {
        /** @var \App\Models\User $user */
        $user = \Illuminate\Support\Facades\Auth::user();

        // 1. Cari notifikasi berdasarkan ID
        $notifikasi = $user->notifications()->findOrFail($id);
        
        // 2. Tandai sudah dibaca
        $notifikasi->markAsRead();
        
        // 3. Arahkan Admin ke halaman detail laporan tersebut
        // PENTING: Sesuaikan 'admin.show' dengan nama rute detail laporan Admin milik Anda
        // Jika nama rutenya berbeda (misal: admin.pengaduan.detail), silakan diganti.
        return redirect()->route('admin.pengaduan.show', $notifikasi->data['laporan_id']);
    }

    public function bersihkanDataLama()
    {
        // 1. Tentukan batas waktu: 6 bulan yang lalu dari hari ini
        $batasWaktu = Carbon::now()->subMonths(6);

        // 2. Ambil data laporan yang statusnya 'selesai' dan tanggal update-nya lebih lama dari 6 bulan lalu
        $laporanLama = Pengaduan::where('status', 'selesai')
                              ->where('updated_at', '<', $batasWaktu)
                              ->get();

        $jumlahDihapus = 0;

        // 3. Looping data yang ditemukan
        foreach ($laporanLama as $laporan) {
            // Cek apakah laporan tersebut memiliki file bukti lampiran
            if ($laporan->bukti) {
                // HAPUS FILE FISIK DARI STORAGE
                // Catatan: Sesuaikan 'public/laporan/' dengan nama folder tempat Anda menyimpan foto saat mahasiswa upload.
                // Jika pakai Storage::putFile, gunakan Storage::delete
                Storage::delete('public/laporan/' . $laporan->bukti); 
                
                /* * JIKA Anda menyimpan gambar menggunakan move(public_path('...')), 
                 * maka gunakan kode di bawah ini (hapus tanda // untuk mengaktifkan, dan matikan Storage::delete di atas):
                 * * $pathFile = public_path('folder_foto/' . $laporan->bukti);
                 * if(file_exists($pathFile)){
                 * unlink($pathFile);
                 * }
                 */
            }

            // 4. Hapus data baris laporan dari database PostgreSQL
            $laporan->delete(); 
            $jumlahDihapus++;
        }

        // 5. Kembalikan Admin ke halaman sebelumnya dengan membawa pesan notifikasi
        return redirect()->back()->with('success', "Berhasil membersihkan $jumlahDihapus data laporan lama beserta file buktinya dari server.");
    }
}   