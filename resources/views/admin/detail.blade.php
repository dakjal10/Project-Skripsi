<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-2xl text-gray-800 leading-tight">
                {{ __('Detail Laporan') }}
            </h2>
            <a href="{{ route('admin.index') }}" class="bg-white border border-gray-300 text-gray-700 hover:bg-gray-50 font-semibold py-2 px-4 rounded-lg inline-flex items-center transition shadow-sm text-sm">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                Kembali ke Daftar
            </a>
        </div>
    </x-slot>

    <div class="py-12 bg-gray-50 min-h-screen">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-lg sm:rounded-xl border border-gray-100 p-8">
                
                <div class="border-b border-gray-200 pb-6 mb-6">
                    <h3 class="text-3xl font-bold text-gray-900 mb-4">{{ $pengaduan->judul }}</h3>
                    <div class="flex flex-wrap items-center text-sm text-gray-600 gap-4">
                        <span class="flex items-center bg-gray-100 px-3 py-1 rounded-full">
                            <svg class="w-4 h-4 mr-2 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                            <strong class="mr-1">Pengirim:</strong> {{ $pengaduan->user->name }}
                        </span>
                        <span class="flex items-center bg-gray-100 px-3 py-1 rounded-full">
                            <svg class="w-4 h-4 mr-2 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                            <strong class="mr-1">Waktu:</strong> {{ \Carbon\Carbon::parse($pengaduan->created_at)->translatedFormat('d F Y - H:i') }}
                        </span>
                        <span class="px-3 py-1 rounded-full text-xs font-bold uppercase tracking-wider
                            {{ $pengaduan->status == 'pending' ? 'bg-yellow-100 text-yellow-800' : '' }}
                            {{ $pengaduan->status == 'diproses' ? 'bg-blue-100 text-blue-800' : '' }}
                            {{ $pengaduan->status == 'selesai' ? 'bg-green-100 text-green-800' : '' }}
                        ">
                            Status: {{ $pengaduan->status }}
                        </span>
                    </div>
                </div>

                <div class="mb-8">
                    <h4 class="text-lg font-bold text-gray-800 mb-3 border-l-4 border-indigo-500 pl-2">Deskripsi Laporan</h4>
                    <div class="bg-gray-50 p-6 rounded-lg border border-gray-200 text-gray-800 whitespace-pre-line leading-relaxed text-md">
                        {{ $pengaduan->isi }}
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 bg-indigo-50 p-6 rounded-lg border border-indigo-100">
                    <div>
                        <h4 class="text-sm font-bold text-indigo-400 uppercase tracking-wider mb-1">Kategori Masalah</h4>
                        <p class="text-indigo-900 font-semibold text-lg">{{ $pengaduan->kategori ?? 'Tidak ada kategori' }}</p>
                    </div>
                    <div>
                        <h4 class="text-sm font-bold text-indigo-400 uppercase tracking-wider mb-2">Bukti Lampiran</h4>
                        @if($pengaduan->bukti)
                            <div class="mt-2">
                                <a href="{{ asset('storage/' . $pengaduan->bukti) }}" target="_blank" class="block">
                                    <img src="{{ asset('storage/' . $pengaduan->bukti) }}" alt="Bukti Laporan" class="w-full max-w-sm rounded-lg shadow-sm border border-gray-200 hover:opacity-80 transition duration-200 object-cover">
                                </a>
                                <p class="text-xs text-gray-500 mt-2 flex items-center">
                                    <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0zM10 7v3m0 0v3m0-3h3m-3 0H7"></path></svg>
                                    Klik gambar untuk memperbesar
                                </p>
                            </div>
                        @else
                            <p class="text-gray-500 italic flex items-center mt-2 bg-gray-50 p-3 rounded border border-gray-100 w-fit">
                                <svg class="w-5 h-5 mr-2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                Tidak ada foto lampiran
                            </p>
                        @endif
                    </div>
                </div>
                <div class="mt-8">
                    @if($pengaduan->balasan)
                        <h4 class="text-lg font-bold text-gray-800 mb-3 border-l-4 border-green-500 pl-2">Tanggapan Admin</h4>
                        <div class="bg-green-50 p-6 rounded-lg border border-green-200 text-green-800 whitespace-pre-line leading-relaxed text-md shadow-sm">
                            {{ $pengaduan->balasan }}
                        </div>
                    @else
                        <h4 class="text-lg font-bold text-gray-800 mb-3 border-l-4 border-blue-500 pl-2">Berikan Tanggapan</h4>
                        <form action="{{ route('admin.pengaduan.reply', $pengaduan->id) }}" method="POST" class="bg-gray-50 p-6 rounded-lg border border-gray-200 shadow-inner">
                            @csrf
                            @method('PUT')
                            <div class="mb-5">
                                <label class="block font-bold mb-2 text-slate-800">Ketik Pesan Balasan / Solusi:</label>
                                
                                <div style="position: relative; width: 100%;">
                                    <textarea 
                                        name="balasan" 
                                        id="isi_tanggapan"
                                        rows="5" 
                                        required 
                                        placeholder="Ketikkan tanggapan Anda di sini..." 
                                        class="w-full p-4 rounded-xl border border-blue-400 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition-all resize-y text-slate-700 bg-white"
                                    ></textarea>
                                    
                                    <button 
                                        type="button" 
                                        id="emoji-trigger" 
                                        style="position: absolute; right: 15px; bottom: 15px; z-index: 20; background: transparent; border: none; cursor: pointer; padding: 5px;"
                                        class="text-slate-400 hover:text-blue-600 transition-colors flex items-center justify-center"
                                    >
                                        <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.828 14.828a4 4 0 01-5.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                        </svg>
                                    </button>

                                    <div 
                                        id="picker-container" 
                                        style="position: absolute; right: 0; bottom: 100%; margin-bottom: 8px; z-index: 999; max-width: 350px; width: 100%;"
                                        class="shadow-2xl rounded-xl border border-slate-200 bg-white"
                                    ></div>
                                </div>
                            </div>
                            </div>
                            <div class="flex items-center justify-between">
                                <p class="text-sm text-gray-500 italic">*Mengirim tanggapan akan otomatis mengubah status menjadi "Selesai".</p>
                                <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2 px-6 rounded-lg transition duration-150 shadow-md">
                                    Kirim Tanggapan
                                </button>
                            </div>
                        </form>
                    @endif
                </div>
                {{-- ==================== KODE RATING MAHASISWA ==================== --}}
                @if(strtolower($pengaduan->status) == 'selesai' && !is_null($pengaduan->rating))
                    <div class="mt-8">
                        <h4 class="text-lg font-bold text-gray-800 mb-3 border-l-4 border-yellow-400 pl-2">Penilaian dari Mahasiswa</h4>
                        
                        <div class="bg-yellow-50 border border-yellow-100 p-6 rounded-lg shadow-sm">
                            <div class="flex items-center space-x-1 mb-3">
                                <span class="text-sm font-bold text-gray-700 mr-2">Bintang:</span>
                                @for($i = 1; $i <= 5; $i++)
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 {{ $i <= $pengaduan->rating ? 'text-yellow-400' : 'text-gray-300' }}" viewBox="0 0 20 20" fill="currentColor">
                                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                    </svg>
                                @endfor
                                <span class="ml-2 text-sm font-bold text-gray-700">({{ $pengaduan->rating }}/5)</span>
                            </div>
                            
                            <div class="mt-2">
                                <span class="text-sm font-bold text-gray-700 block mb-1">Ulasan:</span>
                                @if($pengaduan->ulasan)
                                    <p class="text-gray-800 italic bg-white p-3 rounded border border-yellow-200">"{{ $pengaduan->ulasan }}"</p>
                                @else
                                    <p class="text-gray-500 italic text-sm">Mahasiswa hanya memberikan bintang tanpa ulasan teks.</p>
                                @endif
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/@picmo/renderer-fontawesome@5.1.1/dist/umd/index.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/picmo@5.8.5/dist/umd/index.min.js"></script>
    
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            // Cek apakah Picmo berhasil dimuat
            if (typeof picmo === 'undefined') {
                console.error('Library Picmo gagal dimuat. Periksa koneksi internet Anda.');
                return;
            }

            const trigger = document.querySelector('#emoji-trigger');
            const container = document.querySelector('#picker-container');
            const textarea = document.querySelector('#isi_tanggapan');

            if (trigger && container && textarea) {
                const picker = picmo.createPicker({
                    rootElement: container,
                    showSearch: true,
                    showPreview: false,
                    width: '100%',
                    height: '320px',
                });

                container.style.display = 'none';

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

                picker.addEventListener('emoji:select', event => {
                    const start = textarea.selectionStart;
                    const end = textarea.selectionEnd;
                    textarea.value = textarea.value.substring(0, start) + event.emoji + textarea.value.substring(end);
                    
                    textarea.focus();
                    textarea.selectionStart = textarea.selectionEnd = start + event.emoji.length;
                    
                    container.style.display = 'none';
                    trigger.classList.remove('text-blue-600');
                });

                document.addEventListener('click', (e) => {
                    if (!container.contains(e.target) && e.target !== trigger) {
                        container.style.display = 'none';
                        trigger.classList.remove('text-blue-600');
                    }
                });
            }
        });
    </script>
</x-app-layout>