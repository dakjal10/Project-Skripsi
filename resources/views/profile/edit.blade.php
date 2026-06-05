@extends('layouts.main')

@section('title', 'Pengaturan Profil - E-Pengaduan')

@section('konten_utama')
    <div class="head-title" style="margin-bottom: 24px;">
        <div class="left">
            <h1>Pengaturan Profil</h1>
            <ul class="breadcrumb">
                <li><a href="{{ route('dashboard') }}">Dashboard</a></li>
                <li><i class='bx bx-chevron-right' ></i></li>
                <li><a class="active" href="#">Pengaturan</a></li>
            </ul>
        </div>
    </div>

    <style>
        /* Mengatur Kotak Kartu Form */
        .profile-card {
            background-color: var(--light, #ffffff);
            padding: 30px;
            border-radius: 20px;
            margin-bottom: 24px;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05);
        }

        /* Merapikan Judul & Deskripsi */
        .profile-card header h2 {
            font-size: 20px;
            font-weight: 600;
            color: var(--dark, #342E37);
            margin-bottom: 8px;
        }
        .profile-card header p {
            font-size: 14px;
            color: var(--dark-grey, #888888);
            margin-bottom: 24px;
        }

        /* Mengatur Jarak antar Input Form */
        .profile-card form {
            display: flex;
            flex-direction: column;
            gap: 20px;
            max-width: 600px;
        }

        /* Merapikan Label Text */
        .profile-card label {
            display: block;
            font-size: 14px;
            font-weight: 600;
            color: var(--dark, #342E37);
            margin-bottom: 6px;
        }

        /* Mengatur Kotak Input agar seragam dan tidak keluar batas */
        .profile-card input[type="text"],
        .profile-card input[type="email"],
        .profile-card input[type="password"] {
            width: 100%;
            padding: 12px 16px;
            border: 1px solid #d1d5db;
            border-radius: 8px;
            background-color: #f9fafb;
            color: #333333;
            font-size: 14px;
            box-sizing: border-box; /* Penting: Mencegah input melebar keluar kartu */
            transition: all 0.3s ease;
        }
        .profile-card input:focus {
            outline: none;
            border-color: var(--maroon, #8B1A1A);
            background-color: #ffffff;
            box-shadow: 0 0 0 3px rgba(139, 26, 26, 0.15);
        }

        /* Merapikan Tombol Simpan */
        .profile-card button {
            background-color: var(--maroon, #8B1A1A);
            color: #ffffff;
            border: none;
            padding: 10px 24px;
            border-radius: 8px;
            font-weight: 600;
            font-size: 14px;
            cursor: pointer;
            transition: background-color 0.3s ease;
            width: fit-content;
            margin-top: 10px;
        }
        .profile-card button:hover {
            background-color: #661010;
        }

        /* Khusus Area Berbahaya (Hapus Akun) */
        .danger-card {
            background-color: #fef2f2;
            border: 1px solid #fecaca;
        }
        .danger-card button {
            background-color: var(--orange, #ef4444);
        }
        .danger-card button:hover {
            background-color: #dc2626;
        }

        /* Merapikan Pesan Error bawaan Laravel */
        .profile-card .text-red-600 { color: #dc2626; font-size: 12px; margin-top: 4px; display: block; }
        .profile-card .text-gray-600 { color: #4b5563; font-size: 14px; }
        .profile-card .text-green-600 { color: #16a34a; font-size: 14px; }

        /*Mengatur Foto Profil agar lebih BESAR dan KOTAK SUDUT MEMBULAT */
        .profile-card img {
            max-width: 200px; 
            max-height: 200px;
            width: 100%;
            height: 100%;
            object-fit: cover; 
            
            border-radius: 20px;
            
            margin-bottom: 20px; 
            border: 4px solid var(--light-grey, #eee); 
            display: block;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); 
        }

        .profile-card svg {
            max-width: 120px; 
            height: auto;
            margin-bottom: 20px;
            color: var(--dark-grey, #888888); 
        }
    </style>

    <div class="py-4">
        
        <div class="profile-card">
            @include('profile.partials.update-profile-information-form')
        </div>

        <div class="profile-card">
            @include('profile.partials.update-password-form')
        </div>

    </div>
@endsection