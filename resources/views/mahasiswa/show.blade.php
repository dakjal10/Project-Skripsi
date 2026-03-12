<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Laporan</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100 p-8">

    <div class="max-w-4xl mx-auto bg-white p-8 rounded-lg shadow-md">
        <div class="flex justify-between items-center border-b pb-4 mb-6">
            <h1 class="text-2xl font-bold text-gray-800">Detail Laporan</h1>
            <a href="{{ route('dashboard') }}" class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded-lg text-sm transition">
                &larr; Kembali ke Dashboard
            </a>
        </div>

        <div class="mb-6">
            <h2 class="text-xl font-bold text-gray-800">{{ $laporan->judul }}</h2>
            <div class="flex space-x-4 text-sm text-gray-500 mt-2">
                <span>📅 {{ \Carbon\Carbon::parse($laporan->created_at)->format('d M Y - H:i') }}</span>
                <span>🏷️ Kategori: {{ $laporan->kategori }}</span>
                <span>
                    Status: 
                    @if(strtolower($laporan->status) == 'pending')
                        <span class="text-orange-500 font-bold">Pending</span>
                    @elseif(strtolower($laporan->status) == 'diproses')
                        <span class="text-blue-500 font-bold">Diproses</span>
                    @elseif(strtolower($laporan->status) == 'selesai')
                        <span class="text-green-500 font-bold">Selesai</span>
                    @endif
                </span>
            </div>
        </div>

        <div class="bg-gray-50 p-4 rounded-lg border mb-6">
            <h3 class="font-semibold text-gray-700 mb-2">Isi Keluhan:</h3>
            <p class="text-gray-600 whitespace-pre-line">{{ $laporan->isi }}</p>
        </div>

        @if($laporan->bukti)
        <div class="mb-6">
            <h3 class="font-semibold text-gray-700 mb-2">Bukti Lampiran:</h3>
            <div class="border rounded-lg p-2 inline-block">
                <img src="{{ asset('storage/' . $laporan->bukti) }}" alt="Bukti Laporan" class="max-w-md rounded shadow-sm">
            </div>
        </div>
        @endif

        @if($laporan->balasan)
        <div class="bg-green-50 border border-green-200 p-4 rounded-lg">
            <h3 class="font-bold text-green-800 mb-2">Balasan / Tanggapan Admin:</h3>
            <p class="text-green-700 whitespace-pre-line">{{ $laporan->balasan }}</p>
        </div>
        @elseif(strtolower($laporan->status) == 'selesai' && !$laporan->balasan)
        <div class="bg-gray-50 border p-4 rounded-lg">
            <h3 class="font-bold text-gray-800 mb-2">Tanggapan Admin:</h3>
            <p class="text-gray-600 italic">Laporan telah diselesaikan, namun tidak ada pesan balasan.</p>
        </div>
        @else
        <div class="bg-yellow-50 border border-yellow-200 p-4 rounded-lg">
            <p class="text-yellow-700 text-sm italic">Belum ada tanggapan dari Admin. Laporan Anda sedang dalam antrean.</p>
        </div>
        @endif

    </div>
    {{-- AREA RATING KEPUASAN --}}
        @if(strtolower($laporan->status) == 'selesai')
            
            <hr class="my-6">
            <h3 class="text-lg font-bold text-gray-800 mb-4">Penilaian Layanan</h3>

            @if(is_null($laporan->rating))
                {{-- Form Jika Belum Pernah Memberi Rating --}}
                <div class="bg-blue-50 p-6 rounded-lg border border-blue-100">
                    <p class="text-sm text-gray-600 mb-4">Bagaimana tingkat kepuasan Anda terhadap penanganan laporan ini?</p>
                    
                    <form action="{{ route('mahasiswa.laporan.rating', $laporan->id) }}" method="POST">
                        @csrf
                        
                        {{-- UI Bintang Interaktif Menggunakan SVG Bawaan --}}
                        <div class="flex items-center space-x-2 mb-4" id="star-container">
                            @for($i = 1; $i <= 5; $i++)
                                <label for="star{{ $i }}" class="cursor-pointer transition duration-150 hover:scale-110" id="label-star{{ $i }}">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 text-gray-300 star-svg" viewBox="0 0 20 20" fill="currentColor">
                                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                    </svg>
                                </label>
                                <input type="radio" name="rating" id="star{{ $i }}" value="{{ $i }}" class="opacity-0 absolute w-0 h-0" required onclick="updateStars({{ $i }})">
                            @endfor
                        </div>

                        {{-- Textarea Ulasan dengan Emoji --}}
                        <div class="mb-5">
                            <label for="ulasan" class="block text-sm font-medium text-gray-700 mb-2">Berikan Ulasan Singkat (Opsional)</label>
                            
                            <div class="relative w-full">
                                <textarea name="ulasan" id="ulasan" rows="3" class="w-full border-gray-300 rounded-md shadow-sm py-3 pl-3 pr-12 focus:border-blue-500 focus:ring focus:ring-blue-200" placeholder="Ketik di sini..."></textarea>
                                
                                <button 
                                    type="button" 
                                    id="emoji-trigger-ulasan" 
                                    class="absolute right-3 bottom-3 text-gray-400 hover:text-blue-600 transition-colors z-10"
                                >
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.828 14.828a4 4 0 01-5.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                </button>

                                <div 
                                    id="picker-container-ulasan" 
                                    class="absolute z-50 right-0 bottom-full mb-2 shadow-2xl rounded-xl border border-gray-200 bg-white w-[320px]" 
                                    style="display: none;"
                                ></div>
                            </div>
                        </div>

                        <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-6 rounded-lg shadow transition">
                            Kirim Penilaian
                        </button>
                    </form>
                </div>

                {{-- Script Interaksi Bintang SVG --}}
                <script>
                    function updateStars(value) {
                        for(let i = 1; i <= 5; i++) {
                            const svg = document.querySelector('#label-star' + i + ' svg');
                            if(i <= value) {
                                svg.classList.remove('text-gray-300');
                                svg.classList.add('text-yellow-400');
                            } else {
                                svg.classList.remove('text-yellow-400');
                                svg.classList.add('text-gray-300');
                            }
                        }
                    }
                </script>

            @else
                {{-- Tampilan Jika Sudah Memberi Rating --}}
                <div class="bg-white border p-6 rounded-lg shadow-sm">
                    <div class="flex items-center space-x-1 mb-2">
                        @for($i = 1; $i <= 5; $i++)
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 {{ $i <= $laporan->rating ? 'text-yellow-400' : 'text-gray-200' }}" viewBox="0 0 20 20" fill="currentColor">
                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                            </svg>
                        @endfor
                        <span class="ml-2 text-sm font-bold text-gray-700">({{ $laporan->rating }}/5)</span>
                    </div>
                    @if($laporan->ulasan)
                        <p class="text-gray-600 italic">"{{ $laporan->ulasan }}"</p>
                    @endif
                </div>
            @endif

        @endif

    </div>
</div> <script src="https://cdn.jsdelivr.net/npm/picmo@5.8.5/dist/umd/index.min.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const trigger = document.querySelector('#emoji-trigger-ulasan');
            const container = document.querySelector('#picker-container-ulasan');
            const textarea = document.querySelector('#ulasan');

            if (trigger && container && textarea && typeof picmo !== 'undefined') {
                const picker = picmo.createPicker({
                    rootElement: container,
                    showSearch: true,
                    showPreview: false,
                    // --- GANTI UKURAN DI SINI ---
                    width: '320px',  // Kunci lebar tetap di 320px (tidak pakai %) agar tidak melar
                    height: '280px', // Kunci tinggi tetap di 280px agar lebih pendek
                    displayMessages: { search: 'Cari emoji...' }
                });

                // Tampilkan / Sembunyikan Emoji Panel
                trigger.addEventListener('click', (e) => {
                    e.stopPropagation();
                    if (container.style.display === 'none') {
                        container.style.display = 'block';
                        trigger.classList.add('text-blue-600');
                    } else {
                        container.style.display = 'none';
                        trigger.classList.remove('text-blue-600');
                    }
                });

                // Pilih Emoji
                picker.addEventListener('emoji:select', event => {
                    const start = textarea.selectionStart;
                    const end = textarea.selectionEnd;
                    textarea.value = textarea.value.substring(0, start) + event.emoji + textarea.value.substring(end);
                    
                    textarea.focus();
                    textarea.selectionStart = textarea.selectionEnd = start + event.emoji.length;
                    
                    // Tutup setelah memilih
                    container.style.display = 'none';
                    trigger.classList.remove('text-blue-600');
                });

                // Klik di luar panel akan menutupnya
                document.addEventListener('click', (e) => {
                    if (!container.contains(e.target) && e.target !== trigger) {
                        container.style.display = 'none';
                        trigger.classList.remove('text-blue-600');
                    }
                });
            }
        });
    </script>
</body>
</html>