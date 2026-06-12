<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Daftar - E-Pengaduan</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link href='https://unpkg.com/boxicons@2.0.9/css/boxicons.min.css' rel='stylesheet'>
    
    <style>
        @keyframes fadeInUp {
            0% { opacity: 0; transform: translateY(30px); }
            100% { opacity: 1; transform: translateY(0); }
        }
        
        .animate-fade-in { animation: fadeInUp 0.8s cubic-bezier(0.16, 1, 0.3, 1) forwards; opacity: 0; }
        
        .delay-100 { animation-delay: 0.1s; }
        .delay-200 { animation-delay: 0.2s; }
        .delay-300 { animation-delay: 0.3s; }
        .delay-400 { animation-delay: 0.4s; }
        .delay-500 { animation-delay: 0.5s; }

        .input-animated {
            transition: all 0.3s ease;
        }
        .input-animated:focus {
            background-color: rgba(0, 0, 0, 0.4);
            border-color: rgba(139, 26, 26, 0.6);
            box-shadow: 0 0 15px rgba(139, 26, 26, 0.2);
        }
        
        ::-webkit-scrollbar { width: 5px; }
        ::-webkit-scrollbar-track { background: transparent; }
        ::-webkit-scrollbar-thumb { background: rgba(139, 26, 26, 0.3); border-radius: 10px; }
    </style>
</head>
<body class="font-sans antialiased text-white bg-gray-950 overflow-hidden h-screen w-screen flex flex-col lg:flex-row items-center justify-center lg:justify-center lg:px-24 relative">
    
    <div class="absolute inset-0 z-0">
        <img src="https://images.unsplash.com/photo-1497366216548-37526070297c?q=80&w=2000" alt="Background" class="w-full h-full object-cover blur-sm opacity-20">
        <div class="absolute inset-0 bg-gradient-to-br from-red-950 via-red-900 to-rose-950 opacity-90"></div>
        
        <div class="absolute top-1/4 left-1/4 w-96 h-96 bg-red-600 rounded-full blur-[128px] opacity-20 animate-pulse"></div>
        <div class="absolute bottom-1/4 right-1/4 w-96 h-96 bg-rose-600 rounded-full blur-[128px] opacity-20 animate-pulse delay-500"></div>
    </div>

    
    <div class="hidden lg:flex flex-1 items-center justify-center z-10 animate-fade-in delay-200">
        <div class="text-center">
            <img src="{{ asset('images/images-removebg-preview.png') }}" alt="Logo" class="max-w-md opacity-25 grayscale brightness-150 hover:opacity-40 transition-opacity duration-700" style="filter: drop-shadow(0 0 30px rgba(139,26,26,0.2));">
            <div class="mt-8">
                <h2 class="text-2xl font-light tracking-[0.5em] text-white/40 uppercase">Horizon University</h2>
            </div>
        </div>
    </div>

    
    <div class="relative z-10 w-full max-w-md p-6 lg:p-8 mx-4 bg-white/5 backdrop-blur-2xl rounded-3xl border border-white/10 shadow-[0_8px_32px_0_rgba(31,38,135,0.37)] animate-fade-in delay-100 lg:ml-20 overflow-y-auto max-h-[95vh]">
        
        <div class="mb-6 text-center">
            <div class="inline-flex items-center gap-3 mb-2">
                <i class='bx bx-user-plus text-4xl text-red-500'></i>
                <h1 class="text-3xl font-extrabold tracking-tight">Daftar Akun</h1>
            </div>
            <p class="text-gray-300 text-sm">Buat akun untuk mulai menyampaikan pengaduan Anda.</p>
        </div>

        <form method="POST" action="{{ route('register') }}" class="space-y-4">
            @csrf

            
            <div class="animate-fade-in delay-200">
                <label for="name" class="block text-sm font-semibold text-gray-200 mb-1">Nama Lengkap</label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                        <i class='bx bx-user text-gray-400 text-lg'></i>
                    </div>
                    <input id="name" type="text" name="name" value="{{ old('name') }}" required autofocus autocomplete="name" 
                        class="input-animated block w-full pl-11 pr-4 py-3 text-sm text-white bg-black/20 border border-white/10 rounded-xl focus:ring-2 focus:ring-red-500 focus:border-red-500 focus:bg-black/30 placeholder:text-gray-500" placeholder="Nama lengkap Anda">
                </div>
                <x-input-error :messages="$errors->get('name')" class="mt-1 text-red-400 text-xs" />
            </div>

            
            <div class="animate-fade-in delay-300">
                <label for="email" class="block text-sm font-semibold text-gray-200 mb-1">Email</label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                        <i class='bx bx-envelope text-gray-400 text-lg'></i>
                    </div>
                    <input id="email" type="email" name="email" value="{{ old('email') }}" required autocomplete="username" 
                        class="input-animated block w-full pl-11 pr-4 py-3 text-sm text-white bg-black/20 border border-white/10 rounded-xl focus:ring-2 focus:ring-red-500 focus:border-red-500 focus:bg-black/30 placeholder:text-gray-500" placeholder="nama@email.com">
                </div>
                <x-input-error :messages="$errors->get('email')" class="mt-1 text-red-400 text-xs" />
            </div>

            
            <div class="animate-fade-in delay-400">
                <label for="password" class="block text-sm font-semibold text-gray-200 mb-1">Password</label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                        <i class='bx bx-lock-alt text-gray-400 text-lg'></i>
                    </div>
                    <input id="password" type="password" name="password" required autocomplete="new-password" 
                        class="input-animated block w-full pl-11 pr-12 py-3 text-sm text-white bg-black/20 border border-white/10 rounded-xl focus:ring-2 focus:ring-red-500 focus:border-red-500 focus:bg-black/30 placeholder:text-gray-500" placeholder="••••••••">
                </div>
                <x-input-error :messages="$errors->get('password')" class="mt-1 text-red-400 text-xs" />
            </div>

            
            <div class="animate-fade-in delay-500">
                <label for="password_confirmation" class="block text-sm font-semibold text-gray-200 mb-1">Konfirmasi Password</label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                        <i class='bx bx-lock text-gray-400 text-lg'></i>
                    </div>
                    <input id="password_confirmation" type="password" name="password_confirmation" required autocomplete="new-password" 
                        class="input-animated block w-full pl-11 pr-4 py-3 text-sm text-white bg-black/20 border border-white/10 rounded-xl focus:ring-2 focus:ring-red-500 focus:border-red-500 focus:bg-black/30 placeholder:text-gray-500" placeholder="Ulangi password">
                </div>
                <x-input-error :messages="$errors->get('password_confirmation')" class="mt-1 text-red-400 text-xs" />
            </div>

            <div class="animate-fade-in delay-500 pt-4">
                <button type="submit" class="relative w-full flex justify-center py-3 px-4 border border-transparent rounded-xl shadow-[0_4px_15px_0_rgba(139,26,26,0.4)] text-sm font-bold text-white bg-red-700 hover:bg-red-800 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-red-950 focus:ring-red-500 overflow-hidden group transition-all transform hover:-translate-y-0.5 hover:shadow-[0_8px_25px_0_rgba(139,26,26,0.5)]">
                    <span class="relative z-10 flex items-center gap-2">
                        Daftar Sekarang <i class='bx bx-user-plus text-lg group-hover:translate-x-1 transition-transform'></i>
                    </span>
                    <div class="absolute inset-0 h-full w-full bg-white/10 scale-x-0 group-hover:scale-x-100 transition-transform origin-left duration-300"></div>
                </button>
            </div>
        </form>

        <div class="mt-6 text-center animate-fade-in delay-500 border-t border-white/10 pt-5">
            <p class="text-sm text-gray-300">
                Sudah punya akun? 
                <a href="{{ route('login') }}" class="font-bold text-red-400 hover:text-red-300 transition-colors relative after:content-[''] after:absolute after:w-full after:scale-x-0 after:h-0.5 after:bottom-0 after:left-0 after:bg-red-300 after:origin-bottom-right after:transition-transform after:duration-300 hover:after:scale-x-100 hover:after:origin-bottom-left">Masuk di sini</a>
            </p>
        </div>

    </div>

</body>
</html>
