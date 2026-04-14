<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">
    
    <title>@yield('title', 'E-Pengaduan')</title>
    <style>
        /* CSS Tambahan untuk mempercantik scrollbar (ulir) di notifikasi */
        .notif-scroll::-webkit-scrollbar {
            width: 6px;
        }
        .notif-scroll::-webkit-scrollbar-track {
            background: #f1f1f1; 
        }
        .notif-scroll::-webkit-scrollbar-thumb {
            background: #cbd5e1; 
            border-radius: 10px;
        }
        .notif-scroll::-webkit-scrollbar-thumb:hover {
            background: #94a3b8; 
        }
    </style>
</head>
<body>

    <div class="bg-blobs">
        <div class="blob1"></div>
        <div class="blob2"></div>
    </div>

    <section id="sidebar">
        <a href="{{ url('/') }}" class="brand">
            <div class="brand-icon-box">
                <i class='bx bx-paper-plane'></i>
            </div>
            <span class="brand-text">E-Pengaduan</span>
        </a>
        <ul class="side-menu top">
            <li class="{{ request()->is('dashboard') ? 'active' : '' }}">
                <a href="{{ route('dashboard') }}"><i class='bx bxs-dashboard'></i><span class="text">Dashboard</span></a>
            </li>
            
            @if(Auth::user()->userRole && Auth::user()->userRole->role_name === 'admin')
            <li class="{{ request()->is('admin/laporan') ? 'active' : '' }}">
                <a href="{{ route('admin.index') }}"><i class='bx bxs-message-dots'></i><span class="text">Daftar Pengaduan</span></a>
            </li>
            @endif

            @if(Auth::user()->userRole && Auth::user()->userRole->role_name === 'mahasiswa')
            <li class="{{ request()->routeIs('mahasiswa.laporan.create') ? 'active' : '' }}">
                <a href="{{ route('mahasiswa.laporan.create') }}"><i class='bx bxs-edit'></i><span class="text">Buat Laporan</span></a>
            </li>
            <li>
                <a href="#"><i class='bx bxs-folder-open'></i><span class="text">Pengaduan Saya</span></a>
            </li>
            @endif
            
            <li class="{{ request()->routeIs('laporan.publik') ? 'active' : '' }}">
                <a href="{{ route('laporan.publik') }}"><i class='bx bxs-group'></i><span class="text">Laporan Publik</span></a>
            </li>
        </ul>
        
        <ul class="side-menu">
            <li><a href="{{ route('profile.edit') }}"><i class='bx bxs-cog'></i><span class="text">Settings</span></a></li>
            <li>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <a href="{{ route('logout') }}" onclick="event.preventDefault(); this.closest('form').submit();" class="logout">
                        <i class='bx bxs-log-out-circle'></i><span class="text">Logout</span>
                    </a>
                </form>
            </li>
        </ul>
    </section>
    
    <section id="content">
        <nav>
            <i class='bx bx-menu'></i>
            <a href="#" class="nav-link" style="display: none;">Categories</a>
            <form action="#" style="display: none;">
                <div class="form-input">
                    <input type="search" placeholder="Search...">
                    <button type="submit" class="search-btn"><i class='bx bx-search'></i></button>
                </div>
            </form>
            <div style="flex: 1;"></div>
            <input type="checkbox" id="switch-mode" hidden>
            <label for="switch-mode" class="switch-mode"></label>
            <div style="position: relative; display: flex; align-items: center; gap: 15px;">
                <a href="#" class="notification" id="btn-notif" style="cursor: pointer;">
                    <i class='bx bxs-bell'></i>
                    @if(Auth::user()->unreadNotifications->count() > 0)
                        <span class="num">{{ Auth::user()->unreadNotifications->count() }}</span>
                    @endif
                </a>

                <div id="box-notif" style="display: none; position: absolute; top: 45px; right: 50px; width: 320px; border-radius: 10px; overflow: hidden; z-index: 1000;">
                    <div style="padding: 12px 15px; border-bottom: 1px solid rgba(255,255,255,0.5); font-weight: 700; color: #333; font-size: 14px;">
                        Notifikasi Baru
                    </div>
                    <div style="max-height: 250px; overflow-y: auto;">
                        @forelse(Auth::user()->unreadNotifications as $notification)
                            
                            {{-- Pengecekan otomatis agar link Admin dan Mahasiswa tidak tertukar --}}
                            @php
                                $notifRoute = '';
                                if(Auth::user()->userRole && Auth::user()->userRole->role_name === 'admin') {
                                    $notifRoute = route('admin.notif.baca', $notification->id);
                                } else {
                                    $notifRoute = route('mahasiswa.laporan.notif.baca', $notification->id);
                                }
                            @endphp

                            <a href="{{ $notifRoute }}" style="display: block; text-decoration: none; padding: 12px 15px; border-bottom: 1px solid rgba(255,255,255,0.5); transition: 0.2s;" onmouseover="this.style.background='rgba(255,255,255,0.5)'" onmouseout="this.style.background='transparent'">
                                <p style="margin: 0; font-size: 13px; font-weight: 600; color: #1f2937;">{{ $notification->data['judul'] ?? 'Pembaruan Laporan' }}</p>
                                <p style="margin: 4px 0 0; font-size: 12px; color: #4b5563;">{{ $notification->data['pesan'] ?? '' }}</p>
                                <p style="margin: 6px 0 0; font-size: 10px; color: #9ca3af;">{{ $notification->created_at->diffForHumans() }}</p>
                            </a>
                        @empty
                            <div style="padding: 30px 15px; text-align: center; color: #9ca3af; font-size: 13px;">Belum ada notifikasi</div>
                        @endforelse
                    </div>
                </div>
                <a href="{{ route('profile.edit') }}" class="profile">
                    @if(Auth::user()->avatar)
                        <img src="{{ asset('storage/' . Auth::user()->avatar) }}" alt="Profile" style="object-fit: cover; width: 40px; height: 40px; border-radius: 50%;">
                    @else
                        <img src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->name) }}&background=EBF4FF&color=3B82F6&bold=true" alt="Profile" style="width: 40px; height: 40px; border-radius: 50%;">
                    @endif
                </a>
            </div>
        </nav>
        <main>
            @yield('konten_utama')
        </main>
    </section>
    
    <script src="{{ asset('js/script.js') }}"></script>
    <script>
        const btnNotif = document.getElementById('btn-notif');
        const boxNotif = document.getElementById('box-notif');
        if(btnNotif && boxNotif){
            btnNotif.addEventListener('click', function(e) {
                e.preventDefault();
                boxNotif.style.display = (boxNotif.style.display === 'none' || boxNotif.style.display === '') ? 'block' : 'none';
            });
            document.addEventListener('click', function(e) {
                if (!btnNotif.contains(e.target) && !boxNotif.contains(e.target)) {
                    boxNotif.style.display = 'none';
                }
            });
        }
    </script>
</body>
</html>