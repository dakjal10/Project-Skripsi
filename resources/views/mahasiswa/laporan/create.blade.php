@extends('layouts.main')

@section('title', 'Buat Laporan - E-Pengaduan')

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
            <h1>Buat Laporan</h1>
            <ul class="breadcrumb">
                <li>
                    <a href="{{ route('dashboard') }}">Dashboard</a>
                </li>
                <li><i class='bx bx-chevron-right' ></i></li>
                <li>
                    <a class="active" href="#">Pengaduan Baru</a>
                </li>
            </ul>
        </div>
    </div>

    <div class="table-data">
        <div class="order">
            <div class="head">
                <h3>Formulir Pengaduan Mahasiswa</h3>
            </div>
            
            
            @if (session('success'))
                <div style="background-color: #d4edda; color: #155724; padding: 15px; border-radius: 8px; margin-bottom: 20px; border: 1px solid #c3e6cb; display: flex; align-items: center; gap: 10px; font-family: var(--poppins);">
                    <i class='bx bxs-check-circle' style="font-size: 24px;"></i>
                    <span><strong>Berhasil!</strong> {{ session('success') }}</span>
                </div>
            @endif

            
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
            
            <form action="{{ route('mahasiswa.laporan.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div style="margin-bottom: 20px;">
                    <label style="display: block; font-weight: bold; margin-bottom: 8px; color: var(--dark);">Judul Laporan</label>
                    <input type="text" name="judul" required placeholder="Contoh: AC Kelas 3A Bocor" 
                           style="width: 100%; padding: 12px; border-radius: 8px; border: 1px solid var(--dark-grey); background: var(--light); color: var(--dark); outline: none; font-family: var(--poppins);">
                </div>
                
                <div style="margin-bottom: 20px;">
                    <label style="display: block; font-weight: bold; margin-bottom: 8px; color: var(--dark);">Kategori Laporan</label>
                    <select name="kategori" required style="width: 100%; padding: 12px; border-radius: 8px; border: 1px solid var(--dark-grey); background: var(--light); color: var(--dark); outline: none; font-family: var(--poppins); cursor: pointer;">
                         <option value="" disabled selected>-- Pilih Kategori Laporan --</option>
                         <option value="Fasilitas">Fasilitas & Infrastruktur Kampus</option>
                         <option value="Akademik">Pelayanan Akademik</option>
                         <option value="Keuangan">Administrasi & Keuangan</option>
                         <option value="Lainnya">Lain-lain</option>
                    </select>
                </div>
                
                <div style="margin-bottom: 20px; position: relative;">
                    <label style="display: block; font-weight: bold; margin-bottom: 8px; color: var(--dark);">Isi Keluhan/Laporan</label>
                    
                    <div style="position: relative;">
                        <textarea name="isi" rows="6" required placeholder="Jelaskan detail keluhan Anda di sini..." 
                                style="width: 100%; padding: 12px; border-radius: 8px; border: 1px solid var(--dark-grey); background: var(--light); color: var(--dark); outline: none; font-family: var(--poppins); resize: vertical;"></textarea>
                        
                        <button type="button" id="emoji-trigger" style="position: absolute; right: 10px; bottom: 10px; background: none; border: none; cursor: pointer; color: var(--dark-grey); font-size: 20px; z-index: 5;">
                            <i class='bx bx-smile'></i>
                        </button>

                        <div id="picker-container" style="position: absolute; right: 0; bottom: 45px; z-index: 100;"></div>
                    </div>
                </div>
                
                <div style="margin-bottom: 20px;">
                    <label style="display: block; font-weight: bold; margin-bottom: 8px; color: var(--dark);">Upload Bukti (Opsional - JPG/PNG/PDF)</label>
                    <input type="file" name="bukti" accept=".jpg,.png,.pdf"
                           style="width: 100%; padding: 12px; border-radius: 8px; border: 1px solid var(--dark-grey); background: var(--light); color: var(--dark); outline: none; font-family: var(--poppins);">
                </div>
                
                <div style="text-align: right;">
                    <a href="{{ route('dashboard') }}" style="display: inline-block; padding: 10px 20px; border-radius: 20px; background: var(--dark-grey); color: var(--dark); text-decoration: none; font-weight: 600; margin-right: 10px;">Batal</a>
                    
                    <button type="submit" style="background: var(--maroon); color: var(--light); padding: 10px 24px; border: none; border-radius: 20px; font-weight: 600; cursor: pointer; font-family: var(--poppins);">
                        <i class='bx bx-send'></i> Kirim Laporan
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