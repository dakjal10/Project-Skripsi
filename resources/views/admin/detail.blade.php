<x-app-layout>
    <script>
        // Cek status tema saat pertama kali halaman dimuat
        if (localStorage.getItem('theme') === 'dark') {
            document.documentElement.classList.add('dark');
        }
        
        // Dengarkan perubahan pada localStorage jika user mengubah tema di tab lain (Live Sync)
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
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>

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

        /* CARD STYLE - SOLID IN LIGHT, SOLID IN DARK (MATCHING DASHBOARD) */
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

        /* TEXT CONTRAST */
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

        /* OVERRIDES */
        .dark .bg-gray-100 { background-color: var(--bg-light) !important; }
        .dark .text-gray-900, .dark .text-gray-800, .dark .text-gray-700 { color: #FBFBFB !important; }
        .dark .text-gray-600, .dark .text-gray-500, .dark .text-gray-400 { color: #AAAAAA !important; }

        /* Sembunyikan layout utama, TAPI kecualikan elemen di dalam Picmo */
        nav:not(.picmo__picker nav), 
        header:not(.picmo__picker header), 
        .navbar, .topbar, #sidebar {
            display: none !important;
        }
        
        main {
            padding-top: 1rem !important;
        }

        /* --- FIX TAMPILAN PICMO EMOJI PICKER (MENGGUNAKAN TRIK SCALE) --- */
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

        /* 1. Kembalikan ukuran Picmo ke normal agar isinya LEGA dan UTUH 100% */
        .picmo__picker {
            --picker-width: 320px !important;
            --picker-height: 350px !important;
            --emojis-per-row: 8 !important;   
            width: 100% !important;
        }

        /* 2. Susutkan/Zoom-out keseluruhan container secara proporsional! */
        #picker-container {
            width: auto !important;
            height: auto !important;
            transform: scale(0.6); /* Susutkan menjadi 60% dari ukuran asli */
            transform-origin: bottom right; /* Titik pusat menyusutnya di pojok kanan bawah dekat tombol */
        }

        /* Kembalikan struktur Search dan Tab Kategori */
        .picmo__picker header, .picmo__picker nav {
            display: flex !important;
        }

        /* Pastikan tombol emoji rapi dan presisi */
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

        .picmo__emojiButton:hover {
            background-color: #f3f4f6 !important; 
        }
        .dark .picmo__emojiButton:hover {
            background-color: rgba(255, 255, 255, 0.1) !important; 
        }
        /* -------------------------------------- */
    </style>

    <div class="py-4 sm:px-6 lg:px-8">
        <div class="max-w-7xl mx-auto">
            
            <div class="mb-6 px-4 md:px-0">
                <a href="{{ route('admin.index') }}" class="custom-card hover:!bg-red-600 hover:!text-white hover:!border-red-600 border border-gray-200 dark:border-white/10 font-semibold py-2.5 px-5 rounded-xl inline-flex items-center transition-all duration-300 shadow-sm text-sm text-value group">
                    <i class='bx bx-arrow-back mr-2 text-xl transition-transform duration-300 group-hover:-translate-x-1'></i>
                    Kembali
                </a>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                
                <div class="lg:col-span-2 space-y-6">
                    
                    <div class="custom-card overflow-hidden mb-6">
                        <div class="p-6 md:p-8">
                            <h3 class="text-3xl font-bold mb-6 text-gray-900">{{ $pengaduan->judul }}</h3>
                            
                            <h4 class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-2">Deskripsi Laporan</h4>
                            <hr class="border-gray-100 mb-4">
                            
                            <div class="bg-red-50/50 border border-red-100 rounded-xl p-5 text-gray-800 leading-relaxed">
                                {{ $pengaduan->isi }}
                            </div>
                        </div>
                    </div>

                    <div class="custom-card overflow-hidden mb-6">
                        <div class="p-6 md:p-8 relative"> 
                            @if($pengaduan->balasan)
                                <h4 class="text-lg font-bold flex items-center gap-2 border-b border-gray-100 pb-4 text-gray-900 mb-4">
                                    <i class='bx bxs-check-shield text-green-500 text-2xl'></i> Tanggapan Admin
                                </h4>
                                <div class="bg-green-50/50 border border-green-200 rounded-xl p-5 text-gray-800 font-medium leading-relaxed">
                                    {{ $pengaduan->balasan }}
                                </div>
                            @else
                                <h4 class="text-lg font-bold flex items-center gap-2 border-b border-gray-100 pb-4 text-gray-900 mb-4">
                                    <i class='bx bx-message-square-edit text-red-500 text-2xl'></i> Berikan Tanggapan
                                </h4>
                                <form action="{{ route('admin.pengaduan.reply', $pengaduan->id) }}" method="POST">
                                    @csrf
                                    @method('PUT')
                                    
                                    <div class="mb-4 relative">
                                        <textarea 
                                            name="balasan" 
                                            id="isi_tanggapan"
                                            rows="5" 
                                            required 
                                            placeholder="Ketikkan tanggapan atau solusi Anda di sini..." 
                                            class="w-full custom-card p-4 rounded-xl border border-gray-200 focus:ring-2 focus:ring-red-500 focus:border-red-500 outline-none transition-all resize-y text-value"
                                        ></textarea>
                                        
                                        <button type="button" id="emoji-trigger" class="absolute right-4 bottom-4 text-gray-500 hover:text-red-600 transition-colors custom-card rounded-full p-1 shadow-md border border-gray-200 z-10 flex items-center justify-center h-8 w-8">
                                            <i class='bx bx-smile text-xl'></i>
                                        </button>

                                        <div id="picker-container" class="absolute right-0 bottom-[110%] z-[9999] shadow-2xl rounded-xl border border-gray-200 custom-card" style="display: none;"></div>
                                    </div>

                                    <div class="flex flex-wrap items-center justify-between gap-4 mt-4">
                                        <p class="text-sm text-gray-500 flex items-center gap-1 italic">
                                            <i class='bx bx-info-circle'></i> Status otomatis "Selesai"
                                        </p>
                                        <button type="submit" class="bg-red-600 hover:bg-red-700 text-white font-bold py-2.5 px-6 rounded-lg transition duration-200 flex items-center gap-2 shadow-sm">
                                            <i class='bx bx-send'></i> Kirim Tanggapan
                                        </button>
                                    </div>
                                </form>
                            @endif
                        </div>
                    </div>

                    @if(strtolower($pengaduan->status) == 'selesai' && !is_null($pengaduan->rating))
                    <div class="custom-card overflow-hidden">
                        <div class="p-6 md:p-8">
                            <h4 class="text-lg font-bold mb-4 flex items-center gap-2 border-b border-gray-100 pb-4 text-gray-900">
                                <i class='bx bxs-star text-yellow-400 text-2xl'></i> Penilaian dari Mahasiswa
                            </h4>
                            <div class="bg-yellow-50/30 border border-yellow-300 p-5 rounded-xl">
                                <div class="mb-3 flex items-center gap-2">
                                    <span class="text-sm font-bold text-gray-700">Bintang:</span>
                                    <div class="flex items-center gap-1">
                                        @for($i = 1; $i <= 5; $i++)
                                            <i class='bx {{ $i <= $pengaduan->rating ? 'bxs-star text-yellow-400' : 'bx-star text-gray-300' }} text-xl drop-shadow-sm'></i>
                                        @endfor
                                        <span class="ml-2 font-bold text-gray-500">({{ $pengaduan->rating }}/5)</span>
                                    </div>
                                </div>
                                <div>
                                    <span class="text-sm font-bold block mb-2 text-gray-700">Ulasan Singkat:</span>
                                    @if($pengaduan->ulasan)
                                        <div class="italic custom-card p-4 rounded-lg border border-yellow-200 shadow-sm text-value font-medium">
                                            "{{ $pengaduan->ulasan }}"
                                        </div>
                                    @else
                                        <p class="text-gray-400 italic text-sm">Tidak ada ulasan teks yang diberikan.</p>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                    @endif
                </div>

                <div class="lg:col-span-1 space-y-6">
                    
                    <div class="custom-card overflow-hidden mb-6">
                        <div class="p-6 md:p-8">
                            <h4 class="text-sm font-bold text-gray-400 uppercase tracking-wider mb-4 border-b pb-2">Informasi Detail</h4>
                            
                            <div class="space-y-5">
                                <div>
                                    <p class="text-xs text-gray-500 mb-1">Status Laporan</p>
                                    <span class="px-3 py-1.5 rounded-lg text-xs font-bold uppercase tracking-wider inline-flex items-center gap-1
                                        {{ $pengaduan->status == 'pending' ? 'bg-yellow-100 text-yellow-700' : '' }}
                                        {{ $pengaduan->status == 'diproses' ? 'bg-orange-100 text-orange-700' : '' }}
                                        {{ $pengaduan->status == 'selesai' ? 'bg-green-100 text-green-700' : '' }}
                                    ">
                                        @if($pengaduan->status == 'pending') <i class='bx bxs-time-five text-sm'></i>
                                        @elseif($pengaduan->status == 'diproses') <i class='bx bxs-cog bx-spin text-sm'></i>
                                        @elseif($pengaduan->status == 'selesai') <i class='bx bxs-check-circle text-sm'></i>
                                        @endif
                                        {{ $pengaduan->status }}
                                    </span>
                                </div>

                                <div>
                                    <p class="text-xs text-gray-500 mb-1">Kategori Masalah</p>
                                    <p class="font-semibold text-gray-800">{{ $pengaduan->kategori ?? 'Tidak ada kategori' }}</p>
                                </div>

                                <div>
                                    <p class="text-xs text-gray-500 mb-2">Dikirim Oleh</p>
                                    <div class="flex items-center gap-3">
                                        @if(isset($pengaduan->user->avatar) && $pengaduan->user->avatar != '')
                                            <img src="{{ asset('storage/' . $pengaduan->user->avatar) }}" alt="Foto" class="w-8 h-8 rounded-full object-cover border border-gray-200">
                                        @else
                                            <img src="https://ui-avatars.com/api/?name={{ urlencode($pengaduan->user->name) }}&background=FDF2F2&color=8B1A1A" alt="Avatar" class="w-8 h-8 rounded-full">
                                        @endif
                                        <p class="font-semibold text-gray-800">{{ $pengaduan->user->name }}</p>
                                    </div>
                                </div>

                                <div>
                                    <p class="text-xs text-gray-500 mb-1">Waktu Dibuat</p>
                                    <p class="font-semibold text-gray-800 text-sm flex items-center">
                                        <i class='bx bx-calendar-alt mr-2 text-gray-400 text-lg'></i> 
                                        {{ \Carbon\Carbon::parse($pengaduan->created_at)->translatedFormat('d F Y - H:i') }}
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="custom-card overflow-hidden mb-6">
                        <div class="p-6 md:p-8">
                            <h4 class="text-sm font-bold text-gray-400 uppercase tracking-wider mb-4 border-b pb-2">Bukti Lampiran</h4>
                            @if($pengaduan->bukti)
                                <a href="{{ asset('storage/' . $pengaduan->bukti) }}" target="_blank" class="block group relative overflow-hidden rounded-xl border border-gray-200">
                                    <img src="{{ asset('storage/' . $pengaduan->bukti) }}" alt="Bukti Laporan" class="w-full h-auto object-cover transform group-hover:scale-105 transition duration-300">
                                    <div class="absolute inset-0 bg-black bg-opacity-0 group-hover:bg-opacity-30 transition duration-300 flex items-center justify-center">
                                        <i class='bx bx-zoom-in text-white text-4xl opacity-0 group-hover:opacity-100 transition duration-300'></i>
                                    </div>
                                </a>    
                                <p class="text-xs text-gray-500 mt-3 text-center flex justify-center items-center gap-1">
                                    <i class='bx bx-pointer'></i> Klik gambar untuk memperbesar
                                </p>
                            @else
                                <div class="bg-gray-50 p-6 rounded-xl border border-gray-200 text-center border-dashed">
                                    <i class='bx bx-image-alt text-5xl text-gray-300 mb-2'></i>
                                    <p class="text-sm text-gray-500 font-medium">Tidak ada lampiran gambar</p>
                                </div>
                            @endif
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/@picmo/renderer-fontawesome@5.1.1/dist/umd/index.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/picmo@5.8.5/dist/umd/index.min.js"></script>
    
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            if (typeof picmo === 'undefined') {
                console.error('Library Picmo gagal dimuat.');
                return;
            }

            const trigger = document.querySelector('#emoji-trigger');
            const container = document.querySelector('#picker-container');
            const textarea = document.querySelector('#isi_tanggapan');

            if (trigger && container && textarea) {
                container.innerHTML = '';
                
                // Tambahkan 'emojisPerRow' agar posisinya merapat
                const picker = picmo.createPicker({
                    rootElement: container,
                    showSearch: true,
                    showPreview: false,
                    emojisPerRow: 8, // Mengunci susunan 8 emoji per baris agar rapi
                });

                trigger.addEventListener('click', (e) => {
                    e.stopPropagation();
                    e.preventDefault();
                    if (container.style.display === 'none') {
                        container.style.display = 'block';
                        trigger.classList.add('text-red-600', 'border-red-300', 'bg-red-50');
                    } else {
                        container.style.display = 'none';
                        trigger.classList.remove('text-red-600', 'border-red-300', 'bg-red-50');
                    }
                });

                picker.addEventListener('emoji:select', event => {
                    const start = textarea.selectionStart;
                    const end = textarea.selectionEnd;
                    textarea.value = textarea.value.substring(0, start) + event.emoji + textarea.value.substring(end);
                    textarea.focus();
                    textarea.selectionStart = textarea.selectionEnd = start + event.emoji.length;
                    container.style.display = 'none';
                    trigger.classList.remove('text-red-600', 'border-red-300', 'bg-red-50');
                });

                document.addEventListener('click', (e) => {
                    if (!container.contains(e.target) && e.target !== trigger && !trigger.contains(e.target)) {
                        container.style.display = 'none';
                        trigger.classList.remove('text-red-600', 'border-red-300', 'bg-red-50');
                    }
                });
            }
        });
    </script>
</x-app-layout>