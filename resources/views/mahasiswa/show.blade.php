<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Laporan - e-Pengaduan</title>
    <script src="https://cdn.tailwindcss.com"></script>
    {{-- <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet"> --}}
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #f9fafb;
            color: #1f2937;
        }

        /* --- FIX TAMPILAN PICMO EMOJI PICKER --- */
        .picmo__picker {
            --picker-width: 320px !important;
            --picker-height: 350px !important;
            --emojis-per-row: 8 !important;   
            width: 100% !important;
        }

        #picker-container-ulasan {
            width: auto !important;
            height: auto !important;
            transform: scale(0.6); /* Disamakan dengan admin (0.6) agar lebih ramping dan tidak terpotong */
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
        
        /* Animasi Bintang */
        .star-svg {
            transition: color 0.2s ease-in-out;
        }
    </style>
</head>
<body class="antialiased py-6 sm:px-6 lg:px-8">

    <div class="max-w-7xl mx-auto">
        
        <div class="mb-6 px-4 md:px-0">
            <a href="{{ route('dashboard') }}" class="bg-white border border-gray-200 text-gray-700 hover:bg-blue-50 hover:text-blue-600 hover:border-blue-300 font-semibold py-2.5 px-5 rounded-xl inline-flex items-center transition duration-200 shadow-sm text-sm">
                <i class='bx bx-arrow-back mr-2 text-xl'></i>
                Kembali ke Dashboard
            </a>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 px-4 md:px-0">
            
            <div class="lg:col-span-2 space-y-6">
                
                <div class="bg-white shadow-sm sm:rounded-2xl border border-gray-100 overflow-hidden">
                    <div class="p-6 md:p-8">
                        <h3 class="text-2xl font-bold text-gray-900 mb-4">{{ $laporan->judul }}</h3>
                        
                        <div class="mt-6">
                            <h4 class="text-sm font-bold text-gray-400 uppercase tracking-wider mb-3 border-b pb-2">Deskripsi Laporan</h4>
                            <div class="bg-blue-50/50 p-5 rounded-xl border border-blue-100 text-gray-700 whitespace-pre-line leading-relaxed text-base">
                                {{ $laporan->isi }}
                            </div>
                        </div>
                    </div>
                </div>

                <div class="bg-white shadow-sm sm:rounded-2xl border border-gray-100 overflow-hidden">
                    <div class="p-6 md:p-8">
                        <h4 class="text-lg font-bold text-gray-800 mb-4 flex items-center gap-2 border-b pb-2">
                            <i class='bx bxs-check-shield text-blue-500 text-xl'></i> Tanggapan Admin/Petugas
                        </h4>
                        
                        @if($laporan->balasan)
                            <div class="bg-green-50 p-5 rounded-xl border border-green-200 text-green-800 whitespace-pre-line leading-relaxed shadow-sm font-medium">
                                {{ $laporan->balasan }}
                            </div>
                        @elseif(strtolower($laporan->status) == 'selesai' && !$laporan->balasan)
                            <div class="bg-gray-50 p-5 rounded-xl border border-gray-200 text-gray-600 italic">
                                Laporan telah diselesaikan, namun tidak ada pesan balasan tertulis dari Admin.
                            </div>
                        @else
                            <div class="bg-yellow-50 p-5 rounded-xl border border-yellow-200 text-yellow-800 flex items-center gap-3">
                                <i class='bx bx-time-five text-2xl animate-pulse'></i> 
                                <span class="font-medium">Belum ada tanggapan. Laporan Anda sedang dalam proses pemeriksaan.</span>
                            </div>
                        @endif
                    </div>
                </div>

                @if(strtolower($laporan->status) == 'selesai')
                <div class="bg-white shadow-sm sm:rounded-2xl border border-gray-100 overflow-hidden">
                    <div class="p-6 md:p-8">
                        <h4 class="text-lg font-bold text-gray-800 mb-4 flex items-center gap-2 border-b pb-2">
                            <i class='bx bxs-star text-yellow-400 text-xl'></i> Penilaian Layanan
                        </h4>

                        @if(is_null($laporan->rating))
                            {{-- Form Jika Belum Memberi Rating --}}
                            <p class="text-sm font-semibold text-gray-700 mb-5">Bagaimana tingkat kepuasan Anda terhadap penanganan laporan ini?</p>
                            
                            <form action="{{ route('mahasiswa.laporan.rating', $laporan->id) }}" method="POST">
                                @csrf
                                
                                {{-- UI Bintang --}}
                                <div class="flex items-center space-x-2 mb-6" id="star-container">
                                    @for($i = 1; $i <= 5; $i++)
                                        <label for="star{{ $i }}" class="cursor-pointer transition duration-150 hover:scale-110 drop-shadow-sm" id="label-star{{ $i }}">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 text-gray-200 star-svg" viewBox="0 0 20 20" fill="currentColor" stroke="#9ca3af" stroke-width="1">
                                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                            </svg>
                                        </label>
                                        <input type="radio" name="rating" id="star{{ $i }}" value="{{ $i }}" class="opacity-0 absolute w-0 h-0" required onclick="updateStars({{ $i }})">
                                    @endfor
                                </div>

                                {{-- Textarea Ulasan --}}
                                <div class="mb-6 relative w-full">
                                    <label for="ulasan" class="block text-sm font-semibold text-gray-700 mb-2">Berikan Ulasan Singkat (Opsional)</label>
                                    <div class="relative">
                                        <textarea name="ulasan" id="ulasan" rows="3" class="w-full bg-gray-50 border border-gray-300 rounded-xl py-3 pl-4 pr-12 text-sm text-gray-800 placeholder-gray-400 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition-all resize-y" placeholder="Ceritakan pengalaman Anda di sini..."></textarea>
                                        
                                        <button type="button" id="emoji-trigger-ulasan" class="absolute right-4 bottom-4 text-gray-500 hover:text-blue-600 transition-colors bg-white rounded-full p-1 shadow-md border border-gray-200 z-10 flex items-center justify-center h-8 w-8">
                                            <i class='bx bx-smile text-xl'></i>
                                        </button>

                                        <div id="picker-container-ulasan" class="absolute right-0 bottom-[110%] z-[9999] shadow-2xl rounded-xl border border-gray-200 bg-white" style="display: none;"></div>
                                    </div>
                                </div>

                                <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2.5 px-6 rounded-lg shadow-sm transition-all text-sm flex items-center gap-2 w-full justify-center md:w-auto md:justify-start">
                                    <i class='bx bx-send'></i> Kirim Penilaian
                                </button>
                            </form>

                        @else
                            {{-- Tampilan Jika Sudah Memberi Rating --}}
                            <div class="bg-yellow-50 border border-yellow-200 p-5 rounded-xl">
                                <div class="flex items-center space-x-1 mb-4">
                                    <span class="text-sm font-bold text-gray-700 mr-2">Bintang:</span>
                                    @for($i = 1; $i <= 5; $i++)
                                        <i class='bx {{ $i <= $laporan->rating ? 'bxs-star text-yellow-400 drop-shadow-sm' : 'bx-star text-gray-300' }} text-2xl'></i>
                                    @endfor
                                    <span class="ml-2 text-sm font-bold text-gray-700">({{ $laporan->rating }}/5)</span>
                                </div>
                                <div>
                                    <span class="text-sm font-bold text-gray-700 block mb-2">Ulasan Singkat:</span>
                                    @if($laporan->ulasan)
                                        <p class="text-gray-800 italic bg-white p-4 rounded-lg border border-yellow-100 shadow-sm">"{{ $laporan->ulasan }}"</p>
                                    @else
                                        <p class="text-gray-500 italic text-sm">Tidak ada ulasan teks yang diberikan.</p>
                                    @endif
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
                @endif
            </div>

            <div class="space-y-6">
                
                <div class="bg-white shadow-sm sm:rounded-2xl border border-gray-100 overflow-hidden">
                    <div class="p-6">
                        <h4 class="text-sm font-bold text-gray-400 uppercase tracking-wider mb-4 border-b pb-2">Informasi Detail</h4>
                        
                        <div class="space-y-5">
                            <div>
                                <p class="text-xs text-gray-500 mb-1">Status Laporan</p>
                                <span class="px-3 py-1.5 rounded-lg text-xs font-bold uppercase tracking-wider inline-flex items-center gap-1
                                    {{ strtolower($laporan->status) == 'pending' ? 'bg-red-100 text-red-700' : '' }}
                                    {{ strtolower($laporan->status) == 'selesai' ? 'bg-green-100 text-green-700' : '' }}"
                                    @if(strtolower($laporan->status) == 'diproses' || strtolower($laporan->status) == 'proses')
                                        style="background-color: #ffedd5; color: #c2410c;"
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
                                <p class="text-xs text-gray-500 mb-1">Kategori Masalah</p>
                                <p class="font-semibold text-gray-800 flex items-center gap-2">
                                    <i class='bx bx-purchase-tag text-gray-400'></i> {{ $laporan->kategori ?? 'Umum' }}
                                </p>
                            </div>

                            <div>
                                <p class="text-xs text-gray-500 mb-1">Waktu Dibuat</p>
                                <p class="font-semibold text-gray-800 text-sm flex items-center">
                                    <i class='bx bx-calendar-alt mr-2 text-gray-400 text-lg'></i> 
                                    {{ \Carbon\Carbon::parse($laporan->created_at)->translatedFormat('d F Y - H:i') }}
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="bg-white shadow-sm sm:rounded-2xl border border-gray-100 overflow-hidden">
                    <div class="p-6">
                        <h4 class="text-sm font-bold text-gray-400 uppercase tracking-wider mb-4 border-b pb-2">Bukti Lampiran</h4>
                        @if($laporan->bukti)
                            <a href="{{ asset('storage/' . $laporan->bukti) }}" target="_blank" class="block group relative overflow-hidden rounded-xl border border-gray-200 shadow-sm">
                                <img src="{{ asset('storage/' . $laporan->bukti) }}" alt="Bukti Laporan" class="w-full h-auto object-cover transform group-hover:scale-105 transition duration-300">
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

    <script src="https://cdn.jsdelivr.net/npm/@picmo/renderer-fontawesome@5.1.1/dist/umd/index.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/picmo@5.8.5/dist/umd/index.min.js"></script>

    <script>
        // Fungsi untuk meng-update warna bintang secara dinamis saat diklik
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

        // Fungsi Picmo Emoji Picker
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

                // Tampilkan/Sembunyikan panel emoji
                trigger.addEventListener('click', (e) => {
                    e.stopPropagation();
                    e.preventDefault();
                    if (container.style.display === 'none' || container.style.display === '') {
                        container.style.display = 'block';
                        trigger.classList.add('text-blue-600', 'bg-blue-50');
                    } else {
                        container.style.display = 'none';
                        trigger.classList.remove('text-blue-600', 'bg-blue-50');
                    }
                });

                // Sisipkan emoji ke textarea
                picker.addEventListener('emoji:select', event => {
                    const start = textarea.selectionStart;
                    const end = textarea.selectionEnd;
                    textarea.value = textarea.value.substring(0, start) + event.emoji + textarea.value.substring(end);
                    textarea.focus();
                    textarea.selectionStart = textarea.selectionEnd = start + event.emoji.length;
                    container.style.display = 'none';
                    trigger.classList.remove('text-blue-600', 'bg-blue-50');
                });

                // Tutup panel jika klik di luar area
                document.addEventListener('click', (e) => {
                    if (!container.contains(e.target) && e.target !== trigger && !trigger.contains(e.target)) {
                        container.style.display = 'none';
                        trigger.classList.remove('text-blue-600', 'bg-blue-50');
                    }
                });
            }
        });
    </script>
</body>
</html>