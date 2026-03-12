<?php

namespace App\Http\Controllers;
use App\Models\Pengaduan;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Mail;
use App\Mail\LaporanSelesaiMail;
use App\Mail\LaporanDiprosesMail;
use App\Notifications\StatusLaporanNotification;

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
}   