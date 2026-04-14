@extends('layouts.main')

@section('title', 'Daftar Pengaduan - Admin')

@section('konten_utama')
    <div class="head-title">
        <div class="left">
            <h1>Daftar Pengaduan Mahasiswa</h1>
            <ul class="breadcrumb">
                <li><a href="#">Dashboard</a></li>
                <li><i class='bx bx-chevron-right'></i></li>
                <li><a class="active" href="#">Pengaduan</a></li>
            </ul>
        </div>
    </div>

    @if (session('success'))
        <div style="background-color: #D4EDDA; color: #155724; padding: 15px; border-radius: 8px; border-left: 5px solid #28A745; margin-bottom: 20px; display: flex; align-items: center; gap: 10px;">
            <i class='bx bxs-check-circle' style="font-size: 20px;"></i>
            <p style="margin: 0;"><strong>Berhasil!</strong> {{ session('success') }}</p>
        </div>
    @endif

    <ul class="box-info">
        <li>
            <i class='bx bxs-folder-open'></i>
            <span class="text">
                <h3>{{ $total_laporan }}</h3>
                <p>Total Laporan</p>
            </span>
        </li>

        <li>
            <i class='bx bxs-time-five'></i>
            <span class="text">
                <h3>{{ $laporan_pending }}</h3>
                <p>Menunggu (Pending)</p>
            </span>
        </li>

        <li>
            <i class='bx' style="display: flex; align-items: center; justify-content: center;">
                <i class='bx bxs-cog bx-spin' style="background: transparent !important; width: auto !important; height: auto !important; font-size: 36px;"></i>
            </i>
            <span class="text">
                <h3>{{ $laporan_diproses }}</h3>
                <p>Sedang Diproses</p>
            </span>
        </li>

        <li>
            <div style="width: 80px; height: 80px; border-radius: 50%; background-color: #D4EDDA; color: #155724; display: flex; align-items: center; justify-content: center;">
                <i class='bx bxs-check-circle' style="font-size: 36px; background: transparent !important; width: auto !important; height: auto !important; padding: 0 !important;"></i>
            </div>
            <span class="text">
                <h3>{{ $laporan_selesai }}</h3>
                <p>Selesai</p>
            </span>
        </li>
    </ul>

    <div class="table-data">
        <div class="order">
            <div class="head" style="display: flex; flex-wrap: wrap; justify-content: space-between; align-items: center; gap: 15px;">
                
                {{-- KIRI: Judul --}}
                <h3>Laporan Masuk</h3>
                
                {{-- KANAN: Semua Aksi berjejer ke kanan --}}
                <div style="display: flex; flex-wrap: wrap; gap: 10px; align-items: center;">

                    {{-- 1. Form Search, Filter, Export --}}
                    <form action="{{ route('admin.index') }}" method="GET" style="display: flex; flex-wrap: wrap; gap: 10px; align-items: center; margin: 0; padding: 0; background: transparent;">
                        
                        <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama/judul..." style="padding: 8px 12px; border: 1px solid #ccc; border-radius: 6px; outline: none;">
                        
                        <select name="status" style="padding: 8px 12px; border: 1px solid #ccc; border-radius: 6px; outline: none; cursor: pointer;">
                            <option value="">Semua Status</option>
                            <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                            <option value="diproses" {{ request('status') == 'diproses' ? 'selected' : '' }}>Diproses</option>
                            <option value="selesai" {{ request('status') == 'selesai' ? 'selected' : '' }}>Selesai</option>
                        </select>

                        <select name="sort" onchange="this.form.submit()" style="padding: 8px 12px; border: 1px solid #ccc; border-radius: 6px; outline: none; cursor: pointer;">
                            <option value="terbaru" {{ request('sort') == 'terbaru' ? 'selected' : '' }}>Urutkan: Terbaru</option>
                            <option value="terbanyak" {{ request('sort') == 'terbanyak' ? 'selected' : '' }}>Urutkan: Dukungan 🔥</option>
                        </select>
                        
                        <button type="submit" style="background: var(--blue); color: var(--light); border: none; padding: 8px 15px; border-radius: 6px; cursor: pointer; font-weight: bold;">Cari</button>

                        @if(request('search') || request('status'))
                            <a href="{{ route('admin.index') }}" style="background: var(--red); color: var(--light); text-decoration: none; padding: 8px 15px; border-radius: 6px; font-weight: bold; font-size: 13px;">Reset</a>
                        @endif

                        <a href="{{ route('admin.pengaduan.export', request()->query()) }}" target="_blank" style="background: #10B981; color: white; text-decoration: none; padding: 8px 15px; border-radius: 6px; font-weight: bold; font-size: 13px; display: flex; align-items: center; gap: 5px;">
                            <i class='bx bxs-file-pdf'></i> Export PDF
                        </a>
                    </form>

                    {{-- 2. Tombol Bersihkan Arsip (Hanya Icon, Seukuran tombol Cari, Di ujung kanan) --}}
                    <form action="{{ route('admin.laporan.bersihkan') }}" method="POST" onsubmit="return confirm('Peringatan: Yakin ingin membersihkan semua data laporan Selesai yang usianya lebih dari 6 bulan? File bukti gambar juga akan terhapus secara permanen dari server.')" style="margin: 0; padding: 0;">
                        @csrf
                        {{-- Menggunakan padding yang sama dengan tombol Cari & Export, text dihapus, icon diperbesar --}}
                        <button type="submit" title="Bersihkan Arsip Laporan (> 6 Bulan)" style="background: #dc3545; color: white; padding: 8px 15px; border-radius: 6px; border: none; cursor: pointer; display: flex; align-items: center; justify-content: center; transition: 0.3s;">
                            <i class='bx bx-trash' style="font-size: 18px;"></i>
                        </button>
                    </form>

                </div>
            </div>
            
            <table>
                <thead>
                    <tr>
                        <th>Pengirim</th>
                        <th>Judul & Waktu</th>
                        <th>Dukungan</th>
                        <th>Status Laporan</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($pengaduans as $p)
                    <tr>
                        <td>
                            <div style="display: flex; align-items: center; gap: 10px;">
                                @if(isset($p->user->avatar) && $p->user->avatar != '')
                                    <img src="{{ asset('storage/' . $p->user->avatar) }}" alt="Foto" style="width: 36px; height: 36px; border-radius: 50%; object-fit: cover; border: 1px solid #e5e7eb;">
                                @else
                                    <img src="https://ui-avatars.com/api/?name={{ urlencode($p->user->name) }}&background=EBF4FF&color=3B82F6&bold=true" alt="Avatar" style="width: 36px; height: 36px; border-radius: 50%;">
                                @endif
                                
                                <p style="margin: 0; font-weight: 600;">{{ $p->user->name }}</p>
                            </div>
                        </td>
                        
                        <td>
                            <p style="margin: 0; font-weight: 500;">{{ $p->judul }}</p>
                            <small style="color: var(--dark-grey); font-size: 12px;">
                                <i class='bx bx-time-five'></i> {{ \Carbon\Carbon::parse($p->created_at)->format('d M Y • H:i') }}
                            </small>
                        </td>

                        <td>
                            <div style="display: inline-flex; align-items: center; gap: 5px; background: #EBF4FF; color: #3B82F6; padding: 4px 10px; border-radius: 20px; font-size: 12px; font-weight: bold; margin-bottom: 5px;">
                                <i class='bx bxs-upvote'></i> {{ $p->likes_count ?? 0 }} Suara
                            </div>
                            <br>
                            @if(($p->likes_count ?? 0) >= 10)
                                <span style="font-size: 10px; font-weight: bold; color: #DC3545; background: #F8D7DA; padding: 2px 6px; border-radius: 4px;">🔴 PRIORITAS TINGGI</span>
                            @elseif(($p->likes_count ?? 0) >= 5)
                                <span style="font-size: 10px; font-weight: bold; color: #FD7E14; background: #FFE8D6; padding: 2px 6px; border-radius: 4px;">🟠 PERLU PERHATIAN</span>
                            @endif
                        </td>

                        <td>
                            <form action="{{ route('admin.pengaduan.updateStatus', $p->id) }}" method="POST" style="margin: 0;">
                                @csrf
                                @method('PUT')
                                <select name="status" onchange="this.form.submit()" style="padding: 6px 10px; border-radius: 20px; font-size: 12px; font-weight: 600; cursor: pointer; border: 1px solid transparent; outline: none;
                                    @if($p->status == 'pending') background: #FFF3CD; color: #fcc520; border-color: #e3e3e3;
                                    @elseif($p->status == 'diproses') background: #FFEDD5; color: #C2410C; border-color: #FDBA74;
                                    @elseif($p->status == 'selesai') background: #D4EDDA; color: #155724; border-color: #C3E6CB;
                                    @endif">
                                    <option value="pending" {{ $p->status == 'pending' ? 'selected' : '' }}>Pending</option>
                                    <option value="diproses" {{ $p->status == 'diproses' ? 'selected' : '' }}>Diproses</option>
                                    <option value="selesai" {{ $p->status == 'selesai' ? 'selected' : '' }}>Selesai</option>
                                </select>
                            </form>
                        </td>

                        <td>
                            <a href="{{ route('admin.pengaduan.show', $p->id) }}" style="display: inline-flex; align-items: center; gap: 5px; background: #EBF4FF; color: #3B82F6; padding: 6px 12px; border-radius: 6px; text-decoration: none; font-size: 13px; font-weight: bold; transition: 0.3s;">
                                <i class='bx bx-show'></i> Detail
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" style="text-align: center; padding: 40px 20px;">
                            <i class='bx bx-file-blank' style="font-size: 48px; color: var(--dark-grey); margin-bottom: 10px;"></i>
                            <p style="color: var(--dark-grey); font-weight: 500;">
                                @if(request('search') || request('status'))
                                    Pencarian tidak ditemukan. Coba filter lain.
                                @else
                                    Belum ada laporan yang masuk.
                                @endif
                            </p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection