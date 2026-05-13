<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>E-Pengaduan Mahasiswa</title>
    <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        /* --- WARNA CUSTOM (ANTI-GAGAL) --- */
        /* Kode warna ini memotong sistem Tailwind agar PASTI muncul */
        .bg-kampus-maroon { background-color: #8B1A1A !important; }
        .text-kampus-maroon { color: #8B1A1A !important; }
        .border-kampus-maroon { border-color: #8B1A1A !important; }
        .hover-bg-kampus-dark:hover { background-color: #661010 !important; }
        .hover-text-kampus-dark:hover { color: #661010 !important; }
        .shadow-kampus { box-shadow: 0 10px 15px -3px rgba(139, 26, 26, 0.3) !important; }
        .bg-kampus-soft { background-color: #FDF2F2 !important; }
        .text-kampus-soft { color: #F87171 !important; }

        /* --- Animasi Kustom Tetap Dipertahankan --- */
        @keyframes blob {
            0% { transform: translate(0px, 0px) scale(1); }
            33% { transform: translate(30px, -50px) scale(1.1); }
            66% { transform: translate(-20px, 20px) scale(0.9); }
            100% { transform: translate(0px, 0px) scale(1); }
        }
        .animate-blob { animation: blob 7s infinite; }
        .animation-delay-2000 { animation-delay: 2s; }
        .animation-delay-4000 { animation-delay: 4s; }

        @keyframes fadeInUp {
            0% { opacity: 0; transform: translateY(30px); }
            100% { opacity: 1; transform: translateY(0); }
        }
        .reveal { animation: fadeInUp 0.8s ease-out forwards; }

        /* Smooth Scroll */
        html { scroll-behavior: smooth; }

        .glass-nav {
            background: rgba(255, 255, 255, 0.8);
            backdrop-filter: blur(10px);
            border-bottom: 1px solid rgba(255, 255, 255, 0.2);
        }
    </style>
</head>
<body class="antialiased bg-gray-50 text-gray-900 overflow-x-hidden">

    <div class="fixed inset-0 z-0 pointer-events-none">
        <div class="absolute top-0 -left-4 w-96 h-96 rounded-full mix-blend-multiply filter blur-[100px] opacity-20 animate-blob" style="background-color: #fca5a5;"></div>
        <div class="absolute top-0 -right-4 w-96 h-96 rounded-full mix-blend-multiply filter blur-[100px] opacity-20 animate-blob animation-delay-2000" style="background-color: #fdba74;"></div>
        <div class="absolute -bottom-8 left-20 w-96 h-96 rounded-full mix-blend-multiply filter blur-[100px] opacity-20 animate-blob animation-delay-4000" style="background-color: #fecdd3;"></div>
    </div>

    <nav class="sticky top-0 z-50 glass-nav py-4 px-6 lg:px-12 flex justify-between items-center transition-all duration-300">
        <div class="flex items-center gap-2 group cursor-pointer">
            <div class="w-10 h-10 bg-kampus-maroon rounded-xl flex items-center justify-center text-white shadow-lg shadow-kampus group-hover:rotate-12 transition-transform">
                <i class='bx bx-paper-plane text-2xl'></i>
            </div>
            <span class="font-bold text-2xl tracking-tight text-kampus-maroon">
                E-Pengaduan
            </span>
        </div>

        <div class="flex items-center gap-3 lg:gap-6">
            @if (Route::has('login'))
                @auth
                    <a href="{{ url('/dashboard') }}" class="px-6 py-2.5 bg-kampus-maroon text-white font-bold rounded-xl hover-bg-kampus-dark transition shadow-lg shadow-kampus">Dashboard</a>
                @else
                    <a href="{{ route('login') }}" class="px-5 py-2 text-gray-600 font-semibold hover-text-kampus-dark transition">Log in</a>
                    @if (Route::has('register'))
                        <a href="{{ route('register') }}" class="hidden md:block px-6 py-2.5 bg-kampus-maroon text-white font-bold rounded-xl hover-bg-kampus-dark transition shadow-lg shadow-kampus">
                            Daftar Sekarang
                        </a>
                    @endif
                @endauth
            @endif
        </div>
    </nav>

    <header class="relative z-10 max-w-7xl mx-auto px-6 lg:px-12 pt-6 pb-16 lg:pt-10 lg:pb-24 grid lg:grid-cols-2 gap-16 items-center">
        <div class="reveal" style="animation-delay: 0.2s">
            <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-kampus-soft border-kampus-maroon border text-kampus-maroon text-xs font-bold mb-6">
                <span class="relative flex h-2 w-2">
                    <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-kampus-maroon opacity-75"></span>
                    <span class="relative inline-flex rounded-full h-2 w-2 bg-kampus-maroon"></span>
                </span>
                Sistem Pengaduan Resmi
            </div>
            <h1 class="text-5xl lg:text-7xl font-extrabold text-gray-900 leading-[1.1] mb-8">
                Suara Anda <br> 
                <span class="text-kampus-maroon">Membangun</span> <br>
                Kampus Kita.
            </h1>
            <p class="text-lg text-gray-600 mb-10 leading-relaxed max-w-lg">
                Sampaikan aspirasi, keluhan, atau laporan fasilitas kampus secara transparan dan cepat. Kami siap mendengar demi perubahan yang lebih baik.
            </p>
            <div class="flex flex-col sm:flex-row gap-4">
                <a href="{{ route('register') }}" class="group flex items-center justify-center gap-2 px-8 py-4 bg-kampus-maroon text-white font-bold rounded-2xl hover-bg-kampus-dark transition-all transform hover:-translate-y-1 shadow-xl shadow-kampus">
                    Mulai Melapor <i class='bx bx-right-arrow-alt text-xl group-hover:translate-x-1 transition-transform'></i>
                </a>
                <a href="#fitur" class="px-8 py-4 bg-white border border-gray-200 text-gray-700 font-bold rounded-2xl hover:bg-gray-50 transition-all flex items-center justify-center">
                    Pelajari Selengkapnya
                </a>
            </div>
            
            <div class="mt-12 grid grid-cols-3 gap-4 border-t border-gray-100 pt-8">
                <div>
                    <h3 class="text-2xl font-bold text-gray-900">24/7</h3>
                    <p class="text-xs text-gray-500 uppercase tracking-wider">Akses Pelayanan</p>
                </div>
                <div>
                    <h3 class="text-2xl font-bold text-gray-900">100%</h3>
                    <p class="text-xs text-gray-500 uppercase tracking-wider">Transparansi</p>
                </div>
                <div>
                    <h3 class="text-2xl font-bold text-gray-900">Cepat</h3>
                    <p class="text-xs text-gray-500 uppercase tracking-wider">Respon Admin</p>
                </div>
            </div>
        </div>
        
        <div class="relative reveal" style="animation-delay: 0.4s">
            <div class="absolute -z-10 inset-0 rounded-3xl blur-3xl transform rotate-3 opacity-20" style="background: linear-gradient(to top right, #8B1A1A, #fb923c);"></div>
            
            <div class="relative group">
                <img src="{{ asset('images/rame.jpg') }}" alt="Ilustrasi Pengaduan" 
                    class="relative rounded-[2rem] shadow-2xl border-4 border-white transition-transform duration-500 group-hover:scale-[1.02]">
                
                <div class="absolute -bottom-6 -left-6 bg-white p-4 rounded-2xl shadow-xl animate-bounce" style="animation-duration: 3s">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 bg-green-100 text-green-600 rounded-full flex items-center justify-center">
                            <i class='bx bx-check-shield text-2xl'></i>
                        </div>
                        <div>
                            <p class="text-xs text-gray-400 font-medium italic">Laporan Terkirim!</p>
                            <p class="text-sm font-bold text-gray-800">Privasi Terjamin</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </header>

    <section id="fitur" class="max-w-7xl mx-auto px-6 lg:px-12 py-10 reveal" style="animation-delay: 0.6s">
        <div class="bg-kampus-maroon rounded-[3rem] p-8 lg:p-12 text-white flex flex-col lg:flex-row items-center justify-between gap-8 shadow-2xl shadow-kampus">
            <div>
                <h2 class="text-3xl font-bold mb-2">Ingin tahu status laporan Anda?</h2>
                <p class="text-white" style="opacity: 0.8;">Pantau proses penanganan pengaduan secara real-time melalui dashboard.</p>
            </div>
            <a href="{{ route('login') }}" class="px-8 py-4 bg-white text-kampus-maroon font-bold rounded-xl hover:bg-gray-50 transition-colors shadow-lg">
                Cek Status Laporan
            </a>
        </div>
    </section>

    <footer class="text-center py-12 text-gray-400 text-sm">
        <div class="flex justify-center gap-6 mb-4 text-xl">
            <a href="#" class="hover-text-kampus-dark"><i class='bx bxl-instagram'></i></a>
            <a href="#" class="hover-text-kampus-dark"><i class='bx bxl-facebook-circle'></i></a>
            <a href="#" class="hover-text-kampus-dark"><i class='bx bxl-twitter'></i></a>
        </div>
        &copy; 2026 E-Pengaduan Mahasiswa. Built with <i class='bx bxs-heart text-kampus-maroon'></i> for better campus.
    </footer>

</body>
</html>