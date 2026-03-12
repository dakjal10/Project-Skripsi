@extends('layouts.main')

@section('title', 'Laporan Publik - E-Pengaduan')

@section('konten_utama')
    <div class="head-title">
        <div class="left">
            <h1>Laporan Publik</h1>
            <ul class="breadcrumb">
                <li><a href="{{ route('dashboard') }}">Dashboard</a></li>
                <li><i class='bx bx-chevron-right' ></i></li>
                <li><a class="active" href="#">Laporan Publik</a></li>
            </ul>
        </div>
    </div>

    <div class="table-data">
        <div class="order">
            <div class="head">
                <h3>Forum Laporan Mahasiswa</h3>
            </div>

            <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(300px, 1fr)); gap: 20px; margin-top: 20px;">
                
                @forelse($laporans as $laporan)
                    <div style="border: 1px solid #eee; border-radius: 10px; padding: 20px; box-shadow: 0 4px 6px rgba(0,0,0,0.05); background: #fff; transition: 0.3s;" onmouseover="this.style.transform='translateY(-5px)'" onmouseout="this.style.transform='translateY(0)'">
                        
                        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 15px;">
                            <span style="font-weight: 600; font-size: 14px; color: #333; display: flex; align-items: center; gap: 5px;">
                                <i class='bx bxs-user-circle' style="font-size: 20px; color: var(--blue);"></i> 
                                
                                {{-- FASE 1: LOGIKA SENSOR NAMA (ANONIM) --}}
                                @php
                                    $namaAwal = $laporan->user->name ?? 'Anonim';
                                    $panjang = strlen($namaAwal);
                                    
                                    if($namaAwal == 'Anonim' || $panjang <= 3) {
                                        $namaSensor = $namaAwal;
                                    } else {
                                        // Ambil 2 huruf pertama, beri bintang, lalu ambil 1 huruf terakhir
                                        $namaSensor = substr($namaAwal, 0, 2) . str_repeat('*', $panjang - 3) . substr($namaAwal, -1);
                                    }
                                @endphp
                                {{ $namaSensor }}
                            </span>
                            
                            {{-- Status Laporan --}}
                            @if($laporan->status == 'pending')
                                <span style="background: var(--orange); color: var(--light); padding: 4px 10px; border-radius: 20px; font-size: 11px; font-weight: bold;">Pending</span>
                            @elseif($laporan->status == 'proses' || $laporan->status == 'diproses')
                                <span style="background: var(--blue); color: var(--light); padding: 4px 10px; border-radius: 20px; font-size: 11px; font-weight: bold;">Diproses</span>
                            @else
                                <span style="background: #10B981; color: white; padding: 4px 10px; border-radius: 20px; font-size: 11px; font-weight: bold;">Selesai</span>
                            @endif
                        </div>
                        
                        <h4 style="margin: 0 0 10px 0; color: #1f2937; font-size: 16px;">{{ $laporan->judul }}</h4>
                        
                        <p style="font-size: 13px; color: #6b7280; line-height: 1.5; margin-bottom: 15px;">
                            {{ Str::limit($laporan->deskripsi ?? $laporan->isi, 100) }}
                        </p>
                        
                        <div style="border-top: 1px solid #eee; padding-top: 15px; display: flex; justify-content: space-between; align-items: center;">
                            {{-- Tombol Dukung / Upvote --}}
                            <form action="{{ route('laporan.like', $laporan->id) }}" method="POST">
                                @csrf
                                @php
                                    // Cek apakah user yang login sudah memberikan like pada laporan ini
                                    $isLiked = $laporan->likes->contains(Auth::user()->id);
                                @endphp
                                <button type="submit" style="background: none; border: none; cursor: pointer; display: flex; align-items: center; gap: 5px; color: {{ $isLiked ? 'var(--blue)' : '#6b7280' }}; font-weight: 600; font-size: 13px; transition: 0.2s;" onmouseover="this.style.opacity='0.8'" onmouseout="this.style.opacity='1'">
                                    <i class='bx {{ $isLiked ? 'bxs-upvote' : 'bx-upvote' }}' style="font-size: 18px;"></i>
                                    Dukung ({{ $laporan->likes->count() }})
                                </button>
                            </form>

                            {{-- Waktu --}}
                            <div style="font-size: 11px; color: #9ca3af; text-align: right;">
                                <i class='bx bx-time-five'></i> {{ $laporan->created_at->diffForHumans() }}
                            </div>
                        </div>
                    </div>
                @empty
                    <div style="grid-column: 1 / -1; text-align: center; padding: 40px; color: #9ca3af;">
                        <i class='bx bx-message-square-dots' style="font-size: 48px; margin-bottom: 10px; color: #ccc;"></i>
                        <p>Belum ada laporan dari mahasiswa lain.</p>
                    </div>
                @endforelse

            </div>
        </div>
    </div>
@endsection