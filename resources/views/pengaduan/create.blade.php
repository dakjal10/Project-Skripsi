@extends('layouts.main')

@section('title', 'Buat Laporan - E-Pengaduan')

@section('konten_utama')
{{-- <x-app-layout> --}}
<div class="max-w-2xl mx-auto mt-10 bg-white p-6 rounded-xl shadow">

    <h2 class="text-2xl font-bold mb-6">Kirim Pengaduan</h2>

    <form action="{{ route('pengaduan.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="mb-4">
            <label class="block mb-1">Judul</label>
            <input type="text" name="judul" class="w-full border rounded-lg p-2">
        </div>

        <div class="mb-4">
            <label class="block mb-1">Kategori</label>
            <select name="kategori" class="w-full border rounded-lg p-2">
                <option>Akademik</option>
                <option>Fasilitas</option>
                <option>Pelayanan</option>
            </select>
        </div>

        <div class="mb-4">
            <label class="block mb-1">Isi Keluhan</label>
            <textarea name="isi" rows="4" class="w-full border rounded-lg p-2"></textarea>
        </div>

        <div class="mb-4">
            <label class="block mb-1">Upload Bukti</label>
            <input type="file" name="bukti" class="w-full">
        </div>

        <button class="bg-blue-600 text-white px-4 py-2 rounded-lg">
            Kirim Pengaduan
        </button>

    </form>

</div>
{{-- </x-app-layout> --}}
@endsection
