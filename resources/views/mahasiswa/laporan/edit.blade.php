@extends('layouts.main')

@section('title', 'Edit Laporan - E-Pengaduan')

@section('konten_utama')

    <style>
        .picmo__picker {
            --picker-width: 320px !important;
            --picker-height: 350px !important;
            --emojis-per-row: 8 !important;   
            width: 100% !important;
        }
        #picker-container {
            width: auto !important;
            height: auto !important;
            transform: scale(0.6); 
            transform-origin: bottom right; 
        }
        .picmo__picker header, .picmo__picker nav {
            display: flex !important;
        }
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
    </style>
    <div class="head-title">
        <div class="left">
            <h1>Edit Laporan</h1>
            <ul class="breadcrumb">
                <li>
                    <a href="{{ route('dashboard') }}">Dashboard</a>
                </li>
                <li><i class='bx bx-chevron-right' ></i></li>
                <li>
                    <a href="{{ route('mahasiswa.laporan.show', $laporan->id) }}">Detail Laporan</a>
                </li>
                <li><i class='bx bx-chevron-right' ></i></li>
                <li>
                    <a class="active" href="#">Edit</a>
                </li>
            </ul>
        </div>
    </div>

    <div class="table-data">
        <div class="order">
            <div class="head">
                <h3>Edit Pengaduan Mahasiswa</h3>
            </div>
            
            @if ($errors->any())
                <div style="background-color: #ffe6e6; color: red; padding: 15px; border-radius: 8px; margin-bottom: 20px;">
                    <strong>Oops! Ada yang salah:</strong>
                    <ul style="margin-top: 10px; padding-left: 20px;">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            
            <form action="{{ route('mahasiswa.laporan.update', $laporan->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div style="margin-bottom: 20px;">
                    <label style="display: block; font-weight: bold; margin-bottom: 8px; color: var(--dark);">Judul Laporan</label>
                    <input type="text" name="judul" required value="{{ old('judul', $laporan->judul) }}" placeholder="Contoh: AC Kelas 3A Bocor" 
                           style="width: 100%; padding: 12px; border-radius: 8px; border: 1px solid var(--dark-grey); background: var(--light); color: var(--dark); outline: none; font-family: var(--poppins);">
                </div>
                
                <div style="margin-bottom: 20px; position: relative;">
                    <label style="display: block; font-weight: bold; margin-bottom: 8px; color: var(--dark);">Isi Keluhan/Laporan (Deskripsi)</label>
                    
                    <div style="position: relative;">
                        <textarea name="isi" rows="6" required placeholder="Jelaskan detail keluhan Anda di sini..." 
                                style="width: 100%; padding: 12px; border-radius: 8px; border: 1px solid var(--dark-grey); background: var(--light); color: var(--dark); outline: none; font-family: var(--poppins); resize: vertical;">{{ old('isi', $laporan->isi) }}</textarea>
                        
                        <button type="button" id="emoji-trigger" style="position: absolute; right: 10px; bottom: 10px; background: none; border: none; cursor: pointer; color: var(--dark-grey); font-size: 20px; z-index: 5;">
                            <i class='bx bx-smile'></i>
                        </button>

                        <div id="picker-container" style="position: absolute; right: 0; bottom: 45px; z-index: 100;"></div>
                    </div>
                </div>
                
                <div style="margin-bottom: 20px;">
                    <label style="display: block; font-weight: bold; margin-bottom: 8px; color: var(--dark);">Ganti Bukti (Opsional - JPG/PNG/PDF)</label>
                    
                    @if($laporan->bukti)
                        <div style="margin-bottom: 10px;">
                            <p style="font-size: 13px; color: var(--dark-grey); margin-bottom: 5px;">Bukti saat ini:</p>
                            @if(\Illuminate\Support\Str::endsWith($laporan->bukti, '.pdf'))
                                <a href="{{ asset('storage/' . $laporan->bukti) }}" target="_blank" style="color: blue; text-decoration: underline; font-size: 14px;"><i class='bx bxs-file-pdf'></i> Lihat File PDF</a>
                            @else
                                <img src="{{ asset('storage/' . $laporan->bukti) }}" alt="Bukti Saat Ini" style="max-height: 150px; border-radius: 8px; border: 1px solid var(--dark-grey);">
                            @endif
                        </div>
                    @endif

                    <input type="file" name="bukti" accept=".jpg,.png,.pdf"
                           style="width: 100%; padding: 12px; border-radius: 8px; border: 1px solid var(--dark-grey); background: var(--light); color: var(--dark); outline: none; font-family: var(--poppins);">
                    <small style="color: var(--dark-grey); display: block; margin-top: 5px;">Biarkan kosong jika tidak ingin mengubah bukti yang sudah ada.</small>
                </div>
                
                <div style="text-align: right;">
                    <a href="{{ route('mahasiswa.laporan.show', $laporan->id) }}" style="display: inline-block; padding: 10px 20px; border-radius: 20px; background: var(--dark-grey); color: var(--dark); text-decoration: none; font-weight: 600; margin-right: 10px;">Batal</a>
                    
                    <button type="submit" style="background: var(--maroon); color: var(--light); padding: 10px 24px; border: none; border-radius: 20px; font-weight: 600; cursor: pointer; font-family: var(--poppins);">
                        <i class='bx bx-save'></i> Simpan Perubahan
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection
<script src="https://cdn.jsdelivr.net/npm/picmo@5.8.5/dist/umd/index.min.js"></script>

<script>
    document.addEventListener('DOMContentLoaded', () => {
        const trigger = document.querySelector('#emoji-trigger');
        const container = document.querySelector('#picker-container');
        const textarea = document.querySelector('textarea[name="isi"]');

        if (trigger && container && textarea) {
            const picker = picmo.createPicker({
                rootElement: container,
                showSearch: true,
                showPreview: false,
                displayMessages: { search: 'Cari emoji...' }
            });

            container.style.display = 'none';

            trigger.addEventListener('click', (e) => {
                e.stopPropagation();
                container.style.display = container.style.display === 'none' ? 'block' : 'none';
            });

            picker.addEventListener('emoji:select', event => {
                const emoji = event.emoji;
                const start = textarea.selectionStart;
                const end = textarea.selectionEnd;
                
                textarea.value = textarea.value.substring(0, start) + emoji + textarea.value.substring(end);
                
                textarea.focus();
                textarea.selectionStart = textarea.selectionEnd = start + emoji.length;
                container.style.display = 'none';
            });

            document.addEventListener('click', (e) => {
                if (!container.contains(e.target) && e.target !== trigger) {
                    container.style.display = 'none';
                }
            });
        }
    });
</script>
