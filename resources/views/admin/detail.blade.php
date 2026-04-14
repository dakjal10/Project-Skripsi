<x-app-layout>
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>

    <style>
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
            transform: scale(0.6); /* Susutkan menjadi 80% dari ukuran asli (bisa diganti 0.75 jika masih kurang kecil) */
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
        /* -------------------------------------- */
    </style>

    <div class="py-4 sm:px-6 lg:px-8">
        <div class="max-w-7xl mx-auto">
            
            <div class="mb-6">
                <a href="{{ route('admin.index') }}" class="bg-white border border-gray-200 text-gray-700 hover:bg-blue-50 hover:text-blue-600 hover:border-blue-300 font-semibold py-2.5 px-5 rounded-xl inline-flex items-center transition duration-200 shadow-sm text-sm">
                    <i class='bx bx-arrow-back mr-2 text-xl'></i>
                    Kembali
                </a>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                
                <div class="lg:col-span-2 space-y-6">
                    
                    <div class="bg-white shadow-sm sm:rounded-2xl border border-gray-100 overflow-hidden">
                        <div class="p-6 md:p-8">
                            <h3 class="text-2xl font-bold text-gray-900 mb-4">{{ $pengaduan->judul }}</h3>
                            
                            <div class="mt-6">
                                <h4 class="text-sm font-bold text-gray-400 uppercase tracking-wider mb-3 border-b pb-2">Deskripsi Laporan</h4>
                                <div class="bg-blue-50/50 p-5 rounded-xl border border-blue-100 text-gray-700 whitespace-pre-line leading-relaxed">
                                    {{ $pengaduan->isi }}
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="bg-white shadow-sm sm:rounded-2xl border border-gray-100">
                        <div class="p-6 md:p-8 relative"> 
                            @if($pengaduan->balasan)
                                <h4 class="text-lg font-bold text-gray-800 mb-4 flex items-center gap-2 border-b pb-2">
                                    <i class='bx bxs-check-shield text-green-500 text-xl'></i> Tanggapan Admin
                                </h4>
                                <div class="bg-green-50 p-5 rounded-xl border border-green-200 text-green-800 whitespace-pre-line leading-relaxed shadow-sm">
                                    {{ $pengaduan->balasan }}
                                </div>
                            @else
                                <h4 class="text-lg font-bold text-gray-800 mb-4 flex items-center gap-2 border-b pb-2">
                                    <i class='bx bx-message-square-edit text-blue-500 text-xl'></i> Berikan Tanggapan
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
                                            class="w-full p-4 rounded-xl border border-gray-300 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition-all resize-y text-slate-700 bg-gray-50/50"
                                        ></textarea>
                                        
                                        <button type="button" id="emoji-trigger" class="absolute right-4 bottom-4 text-gray-500 hover:text-blue-600 transition-colors bg-white rounded-full p-1 shadow-md border border-gray-200 z-10 flex items-center justify-center h-8 w-8">
                                            <i class='bx bx-smile text-xl'></i>
                                        </button>

                                        <div id="picker-container" class="absolute right-0 bottom-[110%] z-[9999] shadow-2xl rounded-xl border border-gray-200 bg-white" style="display: none;"></div>
                                    </div>

                                    <div class="flex flex-wrap items-center justify-between gap-4 mt-4">
                                        <p class="text-sm text-gray-500 flex items-center gap-1 italic">
                                            <i class='bx bx-info-circle'></i> Status otomatis "Selesai"
                                        </p>
                                        <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2.5 px-6 rounded-lg transition duration-200 flex items-center gap-2 shadow-sm">
                                            <i class='bx bx-send'></i> Kirim Tanggapan
                                        </button>
                                    </div>
                                </form>
                            @endif
                        </div>
                    </div>

                    @if(strtolower($pengaduan->status) == 'selesai' && !is_null($pengaduan->rating))
                    <div class="bg-white shadow-sm sm:rounded-2xl border border-gray-100 overflow-hidden">
                        <div class="p-6 md:p-8">
                            <h4 class="text-lg font-bold text-gray-800 mb-4 flex items-center gap-2 border-b pb-2">
                                <i class='bx bxs-star text-yellow-400 text-xl'></i> Penilaian dari Mahasiswa
                            </h4>
                            <div class="bg-yellow-50 border border-yellow-200 p-5 rounded-xl">
                                <div class="flex items-center space-x-1 mb-4">
                                    <span class="text-sm font-bold text-gray-700 mr-2">Bintang:</span>
                                    @for($i = 1; $i <= 5; $i++)
                                        <i class='bx {{ $i <= $pengaduan->rating ? 'bxs-star text-yellow-400' : 'bx-star text-gray-300' }} text-2xl'></i>
                                    @endfor
                                    <span class="ml-2 text-sm font-bold text-gray-700">({{ $pengaduan->rating }}/5)</span>
                                </div>
                                <div>
                                    <span class="text-sm font-bold text-gray-700 block mb-2">Ulasan Singkat:</span>
                                    @if($pengaduan->ulasan)
                                        <p class="text-gray-800 italic bg-white p-4 rounded-lg border border-yellow-100 shadow-sm">"{{ $pengaduan->ulasan }}"</p>
                                    @else
                                        <p class="text-gray-500 italic text-sm">Tidak ada ulasan teks yang diberikan.</p>
                                    @endif
                                </div>
                            </div>
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
                                            <img src="https://ui-avatars.com/api/?name={{ urlencode($pengaduan->user->name) }}&background=EBF4FF&color=3B82F6" alt="Avatar" class="w-8 h-8 rounded-full">
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

                    <div class="bg-white shadow-sm sm:rounded-2xl border border-gray-100 overflow-hidden">
                        <div class="p-6">
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
                        trigger.classList.add('text-blue-600', 'border-blue-300', 'bg-blue-50');
                    } else {
                        container.style.display = 'none';
                        trigger.classList.remove('text-blue-600', 'border-blue-300', 'bg-blue-50');
                    }
                });

                picker.addEventListener('emoji:select', event => {
                    const start = textarea.selectionStart;
                    const end = textarea.selectionEnd;
                    textarea.value = textarea.value.substring(0, start) + event.emoji + textarea.value.substring(end);
                    textarea.focus();
                    textarea.selectionStart = textarea.selectionEnd = start + event.emoji.length;
                    container.style.display = 'none';
                    trigger.classList.remove('text-blue-600', 'border-blue-300', 'bg-blue-50');
                });

                document.addEventListener('click', (e) => {
                    if (!container.contains(e.target) && e.target !== trigger && !trigger.contains(e.target)) {
                        container.style.display = 'none';
                        trigger.classList.remove('text-blue-600', 'border-blue-300', 'bg-blue-50');
                    }
                });
            }
        });
    </script>
</x-app-layout>