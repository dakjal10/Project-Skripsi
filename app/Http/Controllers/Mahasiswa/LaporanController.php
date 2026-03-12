<?php

namespace App\Http\Controllers\Mahasiswa;

use App\Http\Controllers\Controller; // Wajib ada untuk memanggil Controller utama
use Illuminate\Http\Request;
use App\Models\Pengaduan; // Tetap menggunakan model tabel yang sama
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Notification;
use App\Notifications\LaporanBaruNotification;
class LaporanController extends Controller

{
    // Menampilkan halaman form pengaduan khusus mahasiswa
    public function create()
    {
        return view('mahasiswa.laporan.create');
    }

    // Menyimpan data laporan ke database
    public function store(Request $request)
    {
        $request->validate([
            'judul' => 'required|string|max:255',
            'isi' => 'required|string',
        ]);
        // 1. Siapkan variabel path
        $buktiPath = null;

        // 2. Cek apakah user mengupload file 'bukti'
        if ($request->hasFile('bukti')) {
            // Simpan file ke folder 'storage/app/public/bukti_laporan'
            $buktiPath = $request->file('bukti')->store('bukti_laporan', 'public');
        }

        $laporanBaru = Pengaduan::create([
            'user_id' => Auth::id(),
            'judul' => $request->judul,
            'kategori' => $request->kategori,
            'isi' => $request->isi,
            'bukti' => $buktiPath,// <-- Buka komen ini jika Anda sudah mengatur upload file
            'status' => 'pending',
        ]);
        // ================= KODE NOTIFIKASI ADMIN =================
        // 2. Cari semua user yang memiliki role 'admin'
        $admins = \App\Models\User::where('role', 'admin')->get();
        
        // Kirim notifikasi ke semua admin yang ditemukan
        if ($admins->count() > 0) {
            \Illuminate\Support\Facades\Notification::send($admins, new \App\Notifications\LaporanBaruNotification($laporanBaru));
        }
        // =========================================================
        
        return redirect()->back()->with('success', 'Hore! Laporan Anda berhasil dikirim dan akan segera diproses.');
        //return redirect()->route('dashboard')->with('success', 'Laporan berhasil dikirim!');
    }
    public function show($id)
    {
        // Mengambil data laporan berdasarkan ID
        // Sesuaikan 'Pengaduan' dengan nama Model yang Anda gunakan (misal: Laporan atau Pengaduan)
        $laporan = \App\Models\Pengaduan::findOrFail($id); 

        return view('mahasiswa.show', compact('laporan'));
    }

   // Fungsi untuk memproses klik pada lonceng notifikasi
    public function bacaNotifikasi($id)
    {
        // Beritahu Code Editor bahwa ini adalah Model User milik kita
        /** @var \App\Models\User $user */
        $user = Auth::user();

        // 1. Cari notifikasi berdasarkan ID yang diklik
        $notifikasi = $user->notifications()->findOrFail($id);
        
        // 2. Tandai "sudah dibaca" (agar angka merah di lonceng berkurang/hilang)
        $notifikasi->markAsRead();
        
        // 3. Pindahkan halaman mahasiswa ke detail laporan tersebut
        return redirect()->route('mahasiswa.laporan.show', $notifikasi->data['laporan_id']);
    }

    // ======fungsi untuk Fitur Penilaian (Rating)========
    public function publik()
    {
        // Mengambil semua laporan beserta nama pembuatnya, diurutkan dari yang paling baru
        $laporans = \App\Models\Pengaduan::with('user')->latest()->get();
        
        return view('mahasiswa.laporan.publik', compact('laporans'));
    }
    public function toggleLike($id)
    {
        $pengaduan = \App\Models\Pengaduan::findOrFail($id);
        
        // Fitur toggle: Jika user sudah like, maka akan di-unlike. Jika belum, maka di-like.
        $pengaduan->likes()->toggle(Auth::id());

        return back(); // Kembali ke halaman sebelumnya
    }
    // ====== Fungsi untuk Menyimpan Rating ======
    // Tambahkan tanda \ sebelum Illuminate agar Laravel mencarinya di root, bukan di folder Controller Anda
    public function rating(\Illuminate\Http\Request $request, $id)
    {
        // 1. Validasi input dari form
        $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'ulasan' => 'nullable|string|max:1000',
        ]);

        // 2. Cari data laporan/pengaduan berdasarkan ID
        $pengaduan = \App\Models\Pengaduan::findOrFail($id);

        // 3. Simpan rating dan ulasan ke database
        $pengaduan->update([
            'rating' => $request->rating,
            'ulasan' => $request->ulasan,
        ]);

        // 4. Kembalikan ke halaman sebelumnya dengan pesan sukses
        return back()->with('success', 'Terima kasih! Penilaian Anda berhasil disimpan.');
    }


}