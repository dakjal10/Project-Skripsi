<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PengaduanController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\AdminController;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Mahasiswa\LaporanController;
use App\Models\Pengaduan;
use Illuminate\Http\Request;
use App\Http\Controllers\ChatController;

Route::get('/', function () {
    return view('welcome');
});

// Halaman Dashboard - Harus dibungkus middleware 'auth' agar login dulu
Route::get('/dashboard', function (Illuminate\Http\Request $request) { // <-- Tambahkan Request di sini
    $role = Auth::user()->userRole->role_name ?? 'mahasiswa';

    if ($role === 'admin') {
        return redirect()->route('admin.index'); // Lempar ke halaman laporan admin
    }
    // 2. Hitung jumlah untuk kotak-kotak di atas
    $total_laporan = Pengaduan::where('user_id', Auth::id())->count();
    $laporan_diproses = Pengaduan::where('user_id', Auth::id())
                                 ->whereIn('status', ['pending', 'proses', 'diproses'])
                                 ->count();
    $laporan_selesai = Pengaduan::where('user_id', Auth::id())
                                ->where('status', 'selesai')
                                ->count();
    // Ambil data pengaduan khusus untuk mahasiswa yang sedang login (diurutkan dari yang terbaru)
    $laporanku = Pengaduan::where('user_id', Auth::id())
                          ->orderBy('created_at', 'desc')
                          ->get();

    // 2. LOGIKA PENCARIAN & FILTER (Pengganti Controller)
    $query = Pengaduan::where('user_id', Auth::id());

    // Jika ada input pencarian di kolom Search
    if ($request->filled('search')) {
        $query->where(function($q) use ($request) {
            $q->where('judul', 'like', '%' . $request->search . '%')
              ->orWhere('kategori', 'like', '%' . $request->search . '%');
        });
    }

    // Jika ada pilihan di Dropdown Status
    if ($request->filled('status')) {
        $query->where('status', $request->status);
    }

    // 3. Eksekusi pencarian dan kirim ke tabel
    $laporanku = $query->orderBy('created_at', 'desc')->get();
    // 3. Kirim semuanya ke view dashboard
    return view('dashboard', compact('laporanku', 'total_laporan', 'laporan_diproses', 'laporan_selesai'));
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    
});
Route::middleware(['auth'])->group(function () {

    Route::get('/pengaduan', [PengaduanController::class,'index'])->name('pengaduan.index');
    Route::get('/pengaduan/create', [PengaduanController::class,'create'])->name('pengaduan.create');
    Route::post('/pengaduan/store', [PengaduanController::class,'store'])->name('pengaduan.store');
    Route::get('/laporan-publik', [\App\Http\Controllers\Mahasiswa\LaporanController::class, 'publik'])->name('laporan.publik');
    Route::post('/laporan/publik/{id}/like', [App\Http\Controllers\Mahasiswa\LaporanController::class, 'toggleLike'])->name('laporan.like');
    // Route::post('/laporan/{id}/rating', [App\Http\Controllers\Mahasiswa\LaporanController::class, 'simpanRating'])->name('mahasiswa.laporan.rating');
    Route::post('/laporan/{id}/rating', [App\Http\Controllers\Mahasiswa\LaporanController::class, 'rating'])->name('mahasiswa.laporan.rating');
    // Tambahkan baris ini di dalam Route::middleware('auth')->group(function () { ... });
    Route::get('/chat', [ChatController::class, 'index'])->name('chat.index');
    Route::get('/chat/messages/{id}', [ChatController::class, 'fetchMessages']);
    Route::post('/chat/message', [ChatController::class, 'sendMessage']);
});
require __DIR__.'/auth.php';
// 2. GRUP MAHASISWA
    Route::middleware(['role:mahasiswa'])->group(function () {
        Route::get('/pengaduan/create', [PengaduanController::class, 'create'])->name('pengaduan.create');
        Route::post('/pengaduan/store', [PengaduanController::class, 'store'])->name('pengaduan.store');
        
    });

    // 3. GRUP ADMIN (Hanya bisa diakses jika user punya role 'admin')
    Route::middleware(['admin'])->group(function () {
        Route::get('/admin/pengaduan', [AdminController::class, 'index'])->name('admin.index');
        Route::get('/admin/laporan', [AdminController::class, 'index'])->name('admin.index');
        Route::put('/admin/pengaduan/{id}/status', [AdminController::class, 'updateStatus'])->name('admin.pengaduan.updateStatus');
        Route::get('/admin/pengaduan/{id}', [AdminController::class, 'show'])->name('admin.pengaduan.show');
        Route::put('/admin/pengaduan/{id}/reply', [AdminController::class, 'reply'])->name('admin.pengaduan.reply');
        Route::get('/admin/export-pdf', [AdminController::class, 'exportPdf'])->name('admin.pengaduan.export');
        Route::get('/admin/export-excel', [AdminController::class, 'exportExcel'])->name('admin.pengaduan.export_excel');
    });
    Route::prefix('mahasiswa/laporan')->name('mahasiswa.laporan.')->group(function () {
        Route::get('/buat', [LaporanController::class, 'create'])->name('create');
        Route::post('/simpan', [LaporanController::class, 'store'])->name('store');
    });
    // Tambahkan di dalam grup rute Admin Anda
    Route::get('/admin/notifikasi/{id}/baca', [App\Http\Controllers\AdminController::class, 'bacaNotifikasi'])->name('admin.notif.baca');
    Route::get('/notifikasi/{id}/baca', [LaporanController::class, 'bacaNotifikasi'])->name('mahasiswa.laporan.notif.baca');
    Route::get('/mahasiswa/laporan/{id}', [LaporanController::class, 'show'])->name('mahasiswa.laporan.show');//ini bagian popup

    //fungsi untuk menghapus data selesai di database
    // Route untuk membersihkan laporan lama (Archive Clean-up)
    Route::post('/admin/laporan/bersihkan', [App\Http\Controllers\AdminController::class, 'bersihkanDataLama'])->name('admin.laporan.bersihkan');