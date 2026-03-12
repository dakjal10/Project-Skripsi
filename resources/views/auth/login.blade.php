<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Masuk - E-Pengaduan</title>
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
            border-color: rgba(59, 130, 246, 0.6);
            box-shadow: 0 0 15px rgba(59, 130, 246, 0.2);
        }
    </style>
</head>
<body class="font-sans antialiased text-white bg-gray-950 overflow-hidden h-screen w-screen flex items-center justify-center relative">
    
    <div class="absolute inset-0 z-0">
        <img src="https://images.unsplash.com/photo-1497366216548-37526070297c?q=80&w=2000" alt="Background" class="w-full h-full object-cover blur-sm opacity-20">
        <div class="absolute inset-0 bg-gradient-to-br from-blue-950 via-blue-900 to-indigo-950 opacity-90"></div>
        
        <div class="absolute top-1/4 left-1/4 w-96 h-96 bg-blue-500 rounded-full blur-[128px] opacity-20 animate-pulse"></div>
        <div class="absolute bottom-1/4 right-1/4 w-96 h-96 bg-indigo-500 rounded-full blur-[128px] opacity-20 animate-pulse delay-500"></div>
    </div>

    <div class="relative z-10 w-full max-w-md p-6 lg:p-8 mx-4 bg-white/5 backdrop-blur-2xl rounded-3xl border border-white/10 shadow-[0_8px_32px_0_rgba(31,38,135,0.37)] animate-fade-in delay-100">
        
        <div class="mb-6 text-center">
            <div class="inline-flex items-center gap-3 mb-2">
                <i class='bx bx-desktop text-4xl text-blue-400'></i>
                <h1 class="text-3xl font-extrabold tracking-tight">E-Pengaduan</h1>
            </div>
            <p class="text-gray-300 text-sm">Silakan masuk dengan akun Anda untuk melanjutkan.</p>
        </div>

        <x-auth-session-status class="mb-4 animate-fade-in delay-200" :status="session('status')" />

        <form method="POST" action="{{ route('login') }}" class="space-y-4">
            @csrf

            <div class="animate-fade-in delay-200">
                <label for="email" class="block text-sm font-semibold text-gray-200 mb-1">Email</label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                        <i class='bx bx-envelope text-gray-400 text-lg'></i>
                    </div>
                    <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus autocomplete="username" 
                        class="input-animated block w-full pl-11 pr-4 py-3 text-sm text-white bg-black/20 border border-white/10 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 focus:bg-black/30 placeholder:text-gray-500" placeholder="nama@email.com">
                </div>
                <x-input-error :messages="$errors->get('email')" class="mt-1 text-red-400 text-xs" />
            </div>

            <div class="animate-fade-in delay-300">
                <label for="password" class="block text-sm font-semibold text-gray-200 mb-1">Password</label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                        <i class='bx bx-lock-alt text-gray-400 text-lg'></i>
                    </div>
                    <input id="password" type="password" name="password" required autocomplete="current-password" 
                        class="input-animated block w-full pl-11 pr-12 py-3 text-sm text-white bg-black/20 border border-white/10 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 focus:bg-black/30 placeholder:text-gray-500" placeholder="••••••••">
                    
                    <div class="absolute inset-y-0 right-0 pr-3.5 flex items-center">
                        <button type="button" id="togglePassword" class="text-gray-500 hover:text-blue-400 focus:outline-none transition-colors">
                            <i class='bx bx-hide text-xl' id="eyeIcon"></i>
                        </button>
                    </div>
                </div>
                <x-input-error :messages="$errors->get('password')" class="mt-1 text-red-400 text-xs" />
            </div>

            <div class="flex items-center justify-between pt-1 animate-fade-in delay-400">
                <label for="remember_me" class="inline-flex items-center cursor-pointer group">
                    <input id="remember_me" type="checkbox" name="remember" class="w-4 h-4 text-blue-600 bg-black/30 border-white/10 rounded focus:ring-blue-500 cursor-pointer transition-all">
                    <span class="ms-2 text-sm text-gray-300 font-medium group-hover:text-blue-400 transition-colors">Ingat saya</span>
                </label>

                @if (Route::has('password.request'))
                    <a href="{{ route('password.request') }}" class="text-sm font-bold text-blue-400 hover:text-blue-300 transition-colors">
                        Lupa password?
                    </a>
                @endif
            </div>

            <div class="animate-fade-in delay-500 pt-2">
                <button type="submit" class="relative w-full flex justify-center py-3 px-4 border border-transparent rounded-xl shadow-[0_4px_15px_0_rgba(59,130,246,0.4)] text-sm font-bold text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-blue-950 focus:ring-blue-500 overflow-hidden group transition-all transform hover:-translate-y-0.5 hover:shadow-[0_8px_25px_0_rgba(59,130,246,0.5)]">
                    <span class="relative z-10 flex items-center gap-2">
                        Masuk Sekarang <i class='bx bx-right-arrow-alt text-lg group-hover:translate-x-1 transition-transform'></i>
                    </span>
                    <div class="absolute inset-0 h-full w-full bg-white/10 scale-x-0 group-hover:scale-x-100 transition-transform origin-left duration-300"></div>
                </button>
            </div>
        </form>

        <div class="mt-6 text-center animate-fade-in delay-500 border-t border-white/10 pt-5">
            <p class="text-sm text-gray-300">
                Belum punya akun? 
                <a href="/register" class="font-bold text-blue-400 hover:text-blue-300 transition-colors relative after:content-[''] after:absolute after:w-full after:scale-x-0 after:h-0.5 after:bottom-0 after:left-0 after:bg-blue-300 after:origin-bottom-right after:transition-transform after:duration-300 hover:after:scale-x-100 hover:after:origin-bottom-left">Daftar sekarang</a>
            </p>
        </div>

    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const togglePassword = document.querySelector('#togglePassword');
            const password = document.querySelector('#password');
            const eyeIcon = document.querySelector('#eyeIcon');

            togglePassword.addEventListener('click', function (e) {
                const type = password.getAttribute('type') === 'password' ? 'text' : 'password';
                password.setAttribute('type', type);
                
                if(type === 'text') {
                    eyeIcon.classList.remove('bx-hide');
                    eyeIcon.classList.add('bx-show', 'text-blue-400');
                } else {
                    eyeIcon.classList.remove('bx-show', 'text-blue-400');
                    eyeIcon.classList.add('bx-hide');
                }
            });
        });
    </script>
</body>
</html>