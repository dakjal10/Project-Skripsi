@extends('layouts.main')

@section('title', 'Dashboard - E-Pengaduan')

@section('konten_utama')
    <div class="head-title">
        <div class="left">
            <h1>Dashboard</h1>
            <ul class="breadcrumb">
                <li><a href="#">Dashboard</a></li>
                <li><i class='bx bx-chevron-right' ></i></li>
                <li><a class="active" href="#">Home</a></li>
            </ul>
        </div>
        <a href="{{ route('mahasiswa.laporan.create') }}" class="btn-download">
            <i class='bx bx-plus' ></i>
            <span class="text">Buat Laporan Baru</span>
        </a>
    </div>

    <ul class="box-info">
        <li>
            <i class='bx bxs-folder-open'></i>
            <span class="text">
                <h3>{{ $total_laporan }}</h3>
                <p>Total Laporan Saya</p>
            </span>
        </li>

        <li>
            <i class='bx' style="display: flex; align-items: center; justify-content: center; background-color: #FFE0D3 !important;">
                <i class='bx bxs-cog bx-spin' style="color: #FD7238 !important; background: transparent !important; width: auto !important; height: auto !important; font-size: 36px !important; margin: 0 !important; padding: 0 !important;"></i>
            </i>
            <span class="text">
                <h3>{{ $laporan_diproses }}</h3>
                <p>Sedang Diproses</p>
            </span>
        </li>

        <li>
            <div style="width: 80px; height: 80px; border-radius: 50%; background-color: #D4EDDA !important; display: flex; align-items: center; justify-content: center;">
                <i class='bx bxs-check-circle' style="font-size: 36px !important; color: #155724 !important; background: transparent !important; width: auto !important; height: auto !important; padding: 0 !important; margin: 0 !important;"></i>
            </div>
            <span class="text">
                <h3>{{ $laporan_selesai }}</h3>
                <p>Laporan Selesai</p>
            </span>
        </li>
    </ul>

    <div class="table-data">
        <div class="order">
            <div class="head" style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 10px; margin-bottom: 20px;">
                <h3>Riwayat Pengaduan Saya</h3>
                
                <form action="{{ route('dashboard') }}" method="GET" style="display: flex; gap: 10px; align-items: center;">
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari judul/kategori..." style="padding: 8px 12px; border: 1px solid #ccc; border-radius: 6px; outline: none;">
                    
                    <select name="status" style="padding: 8px 32px 8px 12px; border: 1px solid #ccc; border-radius: 6px; outline: none; cursor: pointer; background-color: var(--light); color: var(--dark);">
                        <option value="">Semua Status</option>
                        <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                        <option value="diproses" {{ request('status') == 'diproses' ? 'selected' : '' }}>Diproses</option>
                        <option value="selesai" {{ request('status') == 'selesai' ? 'selected' : '' }}>Selesai</option>
                    </select>
                    
                    <button type="submit" style="background: #8B1A1A; color: white; border: none; padding: 8px 15px; border-radius: 6px; cursor: pointer; font-weight: bold;">Cari</button>

                    @if(request('search') || request('status'))
                        <a href="{{ route('dashboard') }}" style="background: #ef4444; color: white; text-decoration: none; padding: 8px 15px; border-radius: 6px; font-weight: bold; font-size: 13px;">Reset</a>
                    @endif
                </form>
            </div>
            <table>
                <thead>
                    <tr>
                        <th style="padding-right: 15px;">Judul Laporan</th>
                        <th style="padding-right: 15px;">Kategori</th>
                        <th style="padding-right: 15px;">Tanggal Lapor</th>
                        <th style="padding-right: 15px;">Status</th>
                        <th style="text-align: center;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($laporanku as $laporan)
                        <tr>
                            <td><p style="font-weight: 600; color: var(--dark);">{{ $laporan->judul }}</p></td>
                            <td>{{ $laporan->kategori }}</td>
                            <td>{{ \Carbon\Carbon::parse($laporan->created_at)->format('d M Y') }}</td>
                            <td>
                                @if($laporan->status == 'pending')
                                    <span style="background-color: #f5b547; color: white; padding: 6px 12px; border-radius: 20px; font-size: 12px; font-weight: 600; display: inline-block; min-width: 85px; text-align: center;">Pending</span>
                                
                                @elseif($laporan->status == 'proses' || $laporan->status == 'diproses')
                                    <span style="background-color: #FD7238; color: white; padding: 6px 12px; border-radius: 20px; font-size: 12px; font-weight: 600; display: inline-block; min-width: 85px; text-align: center;">Diproses</span>
                                
                                @elseif(strtolower($laporan->status) == 'selesai')
                                    <span style="background-color: #10B981; color: white; padding: 6px 12px; border-radius: 20px; font-size: 12px; font-weight: 600; display: inline-block; min-width: 85px; text-align: center;">Selesai</span>
                                
                                @else
                                    <span style="background-color: #6b7280; color: white; padding: 6px 12px; border-radius: 20px; font-size: 12px; font-weight: 600; display: inline-block; min-width: 85px; text-align: center;">{{ ucfirst($laporan->status) }}</span>
                                @endif
                            </td>
                            <td style="white-space: nowrap; text-align: center;">
                                <a href="{{ route('mahasiswa.laporan.show', $laporan->id) }}" style="background: #8B1A1A; color: white; padding: 6px 12px; border-radius: 6px; font-size: 12px; font-weight: 600; text-decoration: none; display: inline-block; white-space: nowrap;">Lihat Detail</a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" style="text-align: center; padding: 20px; color: var(--dark-grey);">Belum ada laporan yang Anda buat.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection