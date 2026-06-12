<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Laporan - e-Pengaduan</title>
    <script src="https://cdn.tailwindcss.com"></script>
    
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    
    <script>
        if (localStorage.getItem('theme') === 'dark') {
            document.documentElement.classList.add('dark');
        }

        window.addEventListener('storage', function(e) {
            if (e.key === 'theme') {
                if (e.newValue === 'dark') {
                    document.documentElement.classList.add('dark');
                } else {
                    document.documentElement.classList.remove('dark');
                }
            }
        });
    </script>

    <style>
        :root {
            --maroon: #8B1A1A;
            --bg-light: #F9F9F9;
            --text-main: #342E37;
            --card-bg: #ffffff;
        }

        .dark {
            --bg-light: #060714;
            --text-main: #FBFBFB;
            --card-bg: #0C0C1E;
        }

        body {
            font-family: 'Poppins', sans-serif;
            background-color: var(--bg-light);
            color: var(--text-main);
        }

        
        .custom-card {
            background: #ffffff;
            border: 1px solid #e2e8f0;
            border-radius: 1rem;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05);
            transition: all 0.3s ease;
        }

        .dark .custom-card {
            background: var(--card-bg);
            border: 1px solid rgba(255, 255, 255, 0.05);
            backdrop-filter: none;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);
        }

        
        .text-label {
            color: #64748b;
            font-size: 0.75rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.05em;
        }
        .dark .text-label { color: #AAAAAA; }

        .text-value {
            color: #1e293b;
            font-weight: 700;
        }
        .dark .text-value { color: #FBFBFB; }

        
        .dark .text-gray-900, .dark .text-gray-800, .dark .text-gray-700 { color: #FBFBFB !important; }
        .dark .text-gray-600, .dark .text-gray-500, .dark .text-gray-400 { color: #AAAAAA !important; }

        .section-header {
            font-size: 0.875rem;
            font-weight: 700;
            color: #334155;
            text-transform: uppercase;
            border-bottom: 1px solid #f1f5f9;
            padding-bottom: 0.5rem;
            margin-bottom: 1rem;
        }
        .dark .section-header {
            color: #cbd5e1;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        }

        
        .box-desc {
            background: #fef2f2;
            border: 1px solid #fee2e2;
            color: #1e293b;
            padding: 1.25rem;
            border-radius: 0.75rem;
        }
        .dark .box-desc {
            background: rgba(139, 26, 26, 0.1);
            border: 1px solid rgba(139, 26, 26, 0.2);
            color: #f1f5f9;
        }

        .box-resp {
            background: #f0fdf4;
            border: 1px solid #dcfce7;
            color: #166534;
            padding: 1.25rem;
            border-radius: 0.75rem;
            font-weight: 600;
        }
        .dark .box-resp {
            background: rgba(22, 101, 52, 0.1);
            border: 1px solid rgba(22, 101, 52, 0.2);
            color: #4ade80;
        }

        
        .dark .text-gray-900, .dark .text-gray-800, .dark .text-gray-700 { color: #f8fafc !important; }
        .dark .text-gray-600, .dark .text-gray-500, .dark .text-gray-400 { color: #cbd5e1 !important; }
        
        
        .pickerContainer {
            --background-color: #ffffff;
            --text-color: #1e293b;
            --border-color: #e2e8f0;
        }
        .dark .pickerContainer {
            --background-color: #0f172a;
            --text-color: #f1f5f9;
            --border-color: rgba(255, 255, 255, 0.1);
        }

        .picmo__picker {
            --picker-width: 320px !important;
            --picker-height: 350px !important;
            --emojis-per-row: 8 !important;   
            width: 100% !important;
        }

        #picker-container-ulasan {
            width: auto !important;
            height: auto !important;
            transform: scale(0.6); 
            transform-origin: bottom right; 
        }

        .picmo__picker header, .picmo__picker nav { display: flex !important; }

        .picmo__emojiButton {
            background-color: transparent !important;
            box-shadow: none !important;
            border: none !important;
            outline: none !important;
            border-radius: 8px !important;
            margin: 0 !important;
            padding: 0 !important;
            display: flex !important;
            align-items: center !important;
            justify-content: center !important;
            width: 100% !important; 
            aspect-ratio: 1 / 1 !important; 
        }

        .picmo__emojiButton:hover { background-color: #f3f4f6 !important; }
        
        
        .star-svg {
            transition: color 0.2s ease-in-out;
        }

        .btn-maroon {
            background: linear-gradient(135deg, #8B1A1A, #B22222) !important;
            color: #ffffff !important;
            box-shadow: 0 4px 15px rgba(139, 26, 26, 0.3) !important;
        }
        .btn-maroon:hover {
            background: linear-gradient(135deg, #B22222, #8B1A1A) !important;
            box-shadow: 0 8px 25px rgba(139, 26, 26, 0.4) !important;
        }
    </style>
</head>
<body class="antialiased py-6 sm:px-6 lg:px-8">

    <div class="max-w-7xl mx-auto">
        
        <div class="mb-6 px-4 md:px-0 flex justify-between items-center">
            <a href="{{ route('dashboard') }}" class="custom-card hover:bg-red-50/20 hover:text-red-500 border border-gray-200 dark:border-white/10 font-semibold py-2.5 px-5 rounded-xl inline-flex items-center transition duration-200 shadow-sm text-sm text-value">
                <i class='bx bx-arrow-back mr-2 text-xl'></i>
                Kembali ke Dashboard
            </a>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 px-4 md:px-0">
            
            <div class="lg:col-span-2 space-y-6">
                
                <div class="custom-card overflow-hidden mb-6">
                    <div class="p-6 md:p-8">
                        <div class="relative mb-6">
                            <h3 class="text-3xl font-bold text-gray-900 pr-14">{{ $laporan->judul }}</h3>
                            @if(strtolower($laporan->status) == 'pending' && $laporan->user_id == auth()->id())
                                <a href="{{ route('mahasiswa.laporan.edit', $laporan->id) }}" class="absolute top-0 right-0 btn-maroon text-white p-2.5 rounded-xl inline-flex items-center justify-center transition duration-200 shadow-md" title="Edit Laporan">
                                    <i class='bx bx-edit text-xl'></i>
                                </a>
                            @endif
                        </div>
                        
                        <h4 class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-2">Deskripsi Laporan</h4>
                        <hr class="border-gray-100 mb-4">
                        
                        <div class="bg-red-50/50 border border-red-100 rounded-xl p-5 text-gray-800 leading-relaxed">
                            {{ $laporan->isi }}
                        </div>
                    </div>
                </div>

                <div class="custom-card overflow-hidden mb-6">
                    <div class="p-6 md:p-8">
                        <h4 class="text-lg font-bold mb-4 flex items-center gap-2 border-b border-gray-100 pb-4 text-gray-900">
                            <i class='bx bxs-check-shield text-green-500 text-2xl'></i> Tanggapan Admin
                        </h4>
                        
                        @if($laporan->balasan)
                            <div class="bg-green-50/50 border border-green-200 rounded-xl p-5 text-gray-800 font-medium leading-relaxed">
                                {{ $laporan->balasan }}
                            </div>
                        @elseif(strtolower($laporan->status) == 'selesai' && !$laporan->balasan)
                            <div class="bg-gray-50 border border-gray-200 rounded-xl p-5 text-gray-600 italic">
                                Laporan telah diselesaikan, namun tidak ada pesan balasan tertulis dari Admin.
                            </div>
                        @else
                            <div class="bg-yellow-50/50 border border-yellow-200 rounded-xl p-5 text-yellow-800 flex items-center gap-3 font-bold">
                                <i class='bx bx-time-five text-2xl animate-pulse text-yellow-600'></i> 
                                <span>Belum ada tanggapan. Laporan Anda sedang dalam proses pemeriksaan.</span>
                            </div>
                        @endif
                    </div>
                </div>

                @if(strtolower($laporan->status) == 'selesai')
                <div class="custom-card overflow-hidden">
                    <div class="p-6 md:p-8">
                        <h4 class="text-lg font-bold mb-4 flex items-center gap-2 border-b border-gray-100 pb-4 text-gray-900">
                            <i class='bx bxs-star text-yellow-400 text-2xl'></i> Penilaian dari Mahasiswa
                        </h4>

                        @if(is_null($laporan->rating))
                            
                            <p class="text-sm font-bold mb-5 text-gray-700">Bagaimana tingkat kepuasan Anda terhadap penanganan laporan ini?</p>
                            
                            <form action="{{ route('mahasiswa.laporan.rating', $laporan->id) }}" method="POST">
                                @csrf
                                
                                
                                <div class="flex items-center space-x-2 mb-6" id="star-container">
                                    @for($i = 1; $i <= 5; $i++)
                                        <label for="star{{ $i }}" class="cursor-pointer transition duration-150 hover:scale-110 drop-shadow-sm" id="label-star{{ $i }}">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 text-gray-200 star-svg" viewBox="0 0 20 20" fill="currentColor" stroke="currentColor" stroke-width="0.5">
                                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                            </svg>
                                        </label>
                                        <input type="radio" name="rating" id="star{{ $i }}" value="{{ $i }}" class="opacity-0 absolute w-0 h-0" required onclick="updateStars({{ $i }})">
                                    @endfor
                                </div>

                                
                                <div class="mb-6 relative w-full">
                                    <label for="ulasan" class="text-sm font-bold text-gray-700 mb-2 block">Berikan Ulasan Singkat (Opsional)</label>
                                    <div class="relative">
                                        <textarea name="ulasan" id="ulasan" rows="3" class="w-full custom-card border border-yellow-200 rounded-xl py-3 pl-4 pr-12 text-sm focus:ring-2 focus:ring-yellow-400 outline-none transition-all resize-y text-value" placeholder="Ceritakan pengalaman Anda di sini..."></textarea>
                                        
                                        <button type="button" id="emoji-trigger-ulasan" class="absolute right-4 bottom-4 text-gray-500 hover:text-yellow-600 transition-colors custom-card rounded-full p-1 shadow-md border border-gray-200 z-10 flex items-center justify-center h-8 w-8">
                                            <i class='bx bx-smile text-xl'></i>
                                        </button>

                                        <div id="picker-container-ulasan" class="absolute right-0 bottom-[110%] z-[9999] shadow-2xl rounded-xl border border-gray-200 custom-card" style="display: none;"></div>
                                    </div>
                                </div>

                                <button type="submit" class="bg-yellow-500 hover:bg-yellow-600 text-white font-bold py-2.5 px-8 rounded-xl shadow-lg shadow-yellow-500/20 transition-all text-sm flex items-center gap-2 w-full justify-center md:w-auto md:justify-start">
                                    <i class='bx bx-send'></i> Kirim Penilaian
                                </button>
                            </form>

                        @else
                            
                            <div class="bg-yellow-50/30 border border-yellow-300 p-5 rounded-xl">
                                <div class="mb-3 flex items-center gap-2">
                                    <span class="text-sm font-bold text-gray-700">Bintang:</span>
                                    <div class="flex items-center gap-1">
                                        @for($i = 1; $i <= 5; $i++)
                                            <i class='bx {{ $i <= $laporan->rating ? 'bxs-star text-yellow-400' : 'bx-star text-gray-300' }} text-xl drop-shadow-sm'></i>
                                        @endfor
                                        <span class="ml-2 font-bold text-gray-500">({{ $laporan->rating }}/5)</span>
                                    </div>
                                </div>
                                <div>
                                    <span class="text-sm font-bold block mb-2 text-gray-700">Ulasan Singkat:</span>
                                    @if($laporan->ulasan)
                                        <div class="italic custom-card p-4 rounded-lg border border-yellow-200 shadow-sm text-value font-medium">
                                            "{{ $laporan->ulasan }}"
                                        </div>
                                    @else
                                        <p class="text-gray-400 italic text-sm">Tidak ada ulasan teks yang diberikan.</p>
                                    @endif
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
                @endif
            </div>

            <div class="lg:col-span-1 space-y-6">
                
                <div class="custom-card overflow-hidden mb-6">
                    <div class="p-6">
                        <h4 class="section-header">Informasi Detail</h4>
                        
                        <div class="space-y-5">
                            <div>
                                <p class="text-label mb-1">Status Laporan</p>
                                <span class="px-3 py-1.5 rounded-lg text-xs font-bold uppercase tracking-wider inline-flex items-center gap-1
                                    {{ strtolower($laporan->status) == 'pending' ? 'bg-rose-100 text-rose-700 dark:bg-rose-900/30 dark:text-rose-400' : '' }}
                                    {{ strtolower($laporan->status) == 'selesai' ? 'bg-emerald-600 text-white dark:bg-emerald-900/30 dark:text-emerald-400' : '' }}"
                                    @if(strtolower($laporan->status) == 'diproses' || strtolower($laporan->status) == 'proses')
                                        style="background-color: #f97316; color: #ffffff;"
                                    @endif
                                >
                                    @if(strtolower($laporan->status) == 'pending') <i class='bx bxs-time-five text-sm'></i>
                                    @elseif(strtolower($laporan->status) == 'diproses' || strtolower($laporan->status) == 'proses') <i class='bx bxs-cog bx-spin text-sm'></i>
                                    @elseif(strtolower($laporan->status) == 'selesai') <i class='bx bxs-check-circle text-sm'></i>
                                    @endif
                                    {{ ucfirst($laporan->status) }}
                                </span>
                            </div>

                            <div>
                                <p class="text-label mb-1">Kategori Masalah</p>
                                <p class="text-value flex items-center gap-2">
                                    <i class='bx bx-purchase-tag text-slate-400'></i> {{ $laporan->kategori ?? 'Umum' }}
                                </p>
                            </div>

                            <div>
                                <p class="text-label mb-1">Dikirim Oleh</p>
                                <div class="flex items-center gap-3 mt-1">
                                    @php
                                        $pengirim = $laporan->user ?? Auth::user();
                                    @endphp
                                    
                                    @if($pengirim && $pengirim->avatar)
                                        <img src="{{ asset('storage/' . $pengirim->avatar) }}" alt="User Profile" class="w-10 h-10 rounded-full object-cover border border-slate-200">
                                    @else
                                        <img src="https://ui-avatars.com/api/?name={{ urlencode($pengirim ? $pengirim->name : 'Mahasiswa') }}&background=FDF2F2&color=8B1A1A&bold=true" alt="Profile" class="w-10 h-10 rounded-full object-cover border border-slate-200">
                                    @endif
                                    <span class="text-value text-sm">{{ $pengirim ? $pengirim->name : 'Mahasiswa' }}</span>
                                </div>
                            </div>

                            <div>
                                <p class="text-label mb-1">Waktu Dibuat</p>
                                <p class="text-value text-sm flex items-center">
                                    <i class='bx bx-calendar-alt mr-2 text-slate-400 text-lg'></i> 
                                    {{ \Carbon\Carbon::parse($laporan->created_at)->translatedFormat('d F Y - H:i') }}
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="custom-card overflow-hidden">
                    <div class="p-6">
                        <h4 class="section-header">Bukti Lampiran</h4>
                        @if($laporan->bukti)
                            <a href="{{ asset('storage/' . $laporan->bukti) }}" target="_blank" class="block group relative overflow-hidden rounded-xl border border-gray-200 dark:border-white/10 shadow-sm">
                                <img src="{{ asset('storage/' . $laporan->bukti) }}" alt="Bukti Laporan" class="w-full h-auto object-cover transform group-hover:scale-105 transition duration-300">
                                <div class="absolute inset-0 bg-black bg-opacity-0 group-hover:bg-opacity-30 transition duration-300 flex items-center justify-center">
                                    <i class='bx bx-zoom-in text-white text-4xl opacity-0 group-hover:opacity-100 transition duration-300'></i>
                                </div>
                            </a>
                            <p class="text-xs opacity-50 mt-3 text-center flex justify-center items-center gap-1">
                                <i class='bx bx-pointer'></i> Klik gambar untuk memperbesar
                            </p>
                        @else
                            <div class="bg-gray-50 dark:bg-white/5 p-6 rounded-xl border border-gray-200 dark:border-white/10 text-center border-dashed">
                                <i class='bx bx-image-alt text-5xl opacity-20 mb-2'></i>
                                <p class="text-sm opacity-50 font-medium">Tidak ada lampiran gambar</p>
                            </div>
                        @endif
                    </div>
                </div>

            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/@picmo/renderer-fontawesome@5.1.1/dist/umd/index.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/picmo@5.8.5/dist/umd/index.min.js"></script>

    <script>
        function updateStars(rating) {
            for (let i = 1; i <= 5; i++) {
                const starSvg = document.querySelector(`#label-star${i} svg`);
                if (i <= rating) {
                    starSvg.classList.remove('text-gray-200');
                    starSvg.classList.add('text-yellow-400');
                } else {
                    starSvg.classList.add('text-gray-200');
                    starSvg.classList.remove('text-yellow-400');
                }
            }
        }

        document.addEventListener('DOMContentLoaded', () => {
            if (typeof picmo === 'undefined') {
                console.warn('Picmo tidak termuat, emoji tidak tersedia.');
                return;
            }

            const trigger = document.querySelector('#emoji-trigger-ulasan');
            const container = document.querySelector('#picker-container-ulasan');
            const textarea = document.querySelector('#ulasan');

            if (trigger && container && textarea) {
                const picker = picmo.createPicker({
                    rootElement: container,
                    showSearch: true,
                    showPreview: false,
                    emojisPerRow: 8,
                });

                trigger.addEventListener('click', (e) => {
                    e.stopPropagation();
                    e.preventDefault();
                    if (container.style.display === 'none' || container.style.display === '') {
                        container.style.display = 'block';
                        trigger.classList.add('text-red-600', 'bg-red-50');
                    } else {
                        container.style.display = 'none';
                        trigger.classList.remove('text-red-600', 'bg-red-50');
                    }
                });

                picker.addEventListener('emoji:select', event => {
                    const start = textarea.selectionStart;
                    const end = textarea.selectionEnd;
                    textarea.value = textarea.value.substring(0, start) + event.emoji + textarea.value.substring(end);
                    textarea.focus();
                    textarea.selectionStart = textarea.selectionEnd = start + event.emoji.length;
                    container.style.display = 'none';
                    trigger.classList.remove('text-red-600', 'bg-red-50');
                });

                document.addEventListener('click', (e) => {
                    if (!container.contains(e.target) && e.target !== trigger && !trigger.contains(e.target)) {
                        container.style.display = 'none';
                        trigger.classList.remove('text-red-600', 'bg-red-50');
                    }
                });
            }
        });
    </script>
</body>
</html>