<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-2xl text-gray-800 leading-tight">
            {{ __('Daftar Pengaduan Mahasiswa') }}
        </h2>
    </x-slot>

    <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
    <div class="bg-white rounded-lg shadow p-5 flex items-center">
        <div class="p-3 rounded-full bg-blue-100 text-blue-600 mr-4">
            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path></svg>
        </div>
        <div>
            <p class="mb-2 text-sm font-medium text-gray-600">Total Laporan</p>
            <p class="text-2xl font-semibold text-gray-700">{{ $total_laporan }}</p>
        </div>
    </div>

    <div class="bg-white rounded-lg shadow p-5 flex items-center">
        <div class="p-3 rounded-full bg-orange-100 text-orange-600 mr-4">
            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
        </div>
        <div>
            <p class="mb-2 text-sm font-medium text-gray-600">Menunggu (Pending)</p>
            <p class="text-2xl font-semibold text-gray-700">{{ $laporan_pending }}</p>
        </div>
    </div>

    <div class="bg-white rounded-lg shadow p-5 flex items-center">
        <div class="p-3 rounded-full bg-yellow-100 text-yellow-600 mr-4">
            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
        </div>
        <div>
            <p class="mb-2 text-sm font-medium text-gray-600">Sedang Diproses</p>
            <p class="text-2xl font-semibold text-gray-700">{{ $laporan_diproses }}</p>
        </div>
    </div>

    <div class="bg-white rounded-lg shadow p-5 flex items-center">
        <div class="p-3 rounded-full bg-green-100 text-green-600 mr-4">
            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
        </div>
        <div>
            <p class="mb-2 text-sm font-medium text-gray-600">Selesai</p>
            <p class="text-2xl font-semibold text-gray-700">{{ $laporan_selesai }}</p>
        </div>
    </div>
</div>
{{-- //// --}}
    <div class="py-12 bg-gray-50 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            @if (session('success'))
                <div class="flex items-center bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6 rounded shadow-sm" role="alert">
                    <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path></svg>
                    <p><strong>Berhasil!</strong> {{ session('success') }}</p>
                </div>
            @endif

            <div class="bg-white p-4 mb-6 rounded-xl shadow-sm border border-gray-100 flex flex-col sm:flex-row justify-between items-center gap-4">
                <form action="{{ route('admin.index') }}" method="GET" class="w-full flex flex-col sm:flex-row gap-4 items-center">
                    
                    <div class="w-full sm:w-1/2 relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <svg class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                            </svg>
                        </div>
                        <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama mahasiswa atau judul..." 
                               class="pl-10 w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                    </div>

                    <div class="w-full sm:w-1/4">
                        <select name="status" class="w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm cursor-pointer">
                            <option value="">Semua Status</option>
                            <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                            <option value="diproses" {{ request('status') == 'diproses' ? 'selected' : '' }}>Diproses</option>
                            <option value="selesai" {{ request('status') == 'selesai' ? 'selected' : '' }}>Selesai</option>
                        </select>
                    </div>
                    <div class="w-full sm:w-1/4">
                        <select name="sort" onchange="this.form.submit()" class="w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm cursor-pointer">
                            <option value="terbaru" {{ request('sort') == 'terbaru' ? 'selected' : '' }}>Urutkan: Terbaru</option>
                            <option value="terbanyak" {{ request('sort') == 'terbanyak' ? 'selected' : '' }}>Urutkan: Dukungan Terbanyak 🔥</option>
                        </select>
                    </div>

                    <div class="flex gap-2 w-full sm:w-auto">
                        <button type="submit" class="inline-flex justify-center items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-lg font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 active:bg-indigo-900 focus:outline-none focus:border-indigo-900 focus:ring ring-indigo-300 disabled:opacity-25 transition ease-in-out duration-150 shadow-sm">
                            Cari
                        </button>

                        @if(request('search') || request('status'))
                            <a href="{{ route('admin.index') }}" class="inline-flex justify-center items-center px-4 py-2 bg-red-500 border border-transparent rounded-lg font-semibold text-xs text-white uppercase tracking-widest hover:bg-red-600 active:bg-red-700 focus:outline-none focus:border-red-700 focus:ring ring-red-300 transition ease-in-out duration-150 shadow-sm">
                                Reset
                            </a>
                        @endif

                        <a href="{{ route('admin.pengaduan.export', request()->query()) }}" target="_blank" class="inline-flex justify-center items-center px-4 py-2 bg-green-600 border border-transparent rounded-lg font-semibold text-xs text-white uppercase tracking-widest hover:bg-green-700 active:bg-green-900 focus:outline-none focus:border-green-900 focus:ring ring-green-300 transition ease-in-out duration-150 shadow-sm">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                            Export PDF
                        </a>
                    </div>
                </form>
            </div>
            <div class="bg-white overflow-hidden shadow-lg sm:rounded-xl border border-gray-100">
                <div class="overflow-x-auto">
                    <table class="min-w-full leading-normal">
                        <thead>
                            <tr>
                                <th class="px-6 py-4 border-b-2 border-gray-100 bg-gray-50 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">
                                    Pengirim
                                </th>
                                <th class="px-6 py-4 border-b-2 border-gray-100 bg-gray-50 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">
                                    Judul & Waktu Laporan
                                </th>
                                <th class="px-6 py-4 border-b-2 border-gray-100 bg-gray-50 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">
                                    Dukungan
                                </th>
                                <th class="px-6 py-4 border-b-2 border-gray-100 bg-gray-50 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">
                                    Status Laporan
                                </th>
                                <th class="px-6 py-4 border-b-2 border-gray-100 bg-gray-50 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">
                                    Aksi
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($pengaduans as $p)
                            <tr class="hover:bg-gray-50 transition duration-150 ease-in-out">
                                <td class="px-6 py-4 border-b border-gray-100 text-sm">
                                    <div class="flex items-center">
                                        <div class="flex-shrink-0 h-10 w-10 rounded-full bg-indigo-100 flex items-center justify-center text-indigo-700 font-bold text-lg shadow-inner">
                                            {{ strtoupper(substr($p->user->name, 0, 1)) }}
                                        </div>
                                        <div class="ml-4">
                                            <p class="text-gray-900 font-semibold whitespace-no-wrap">
                                                {{ $p->user->name }}
                                            </p>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 border-b border-gray-100 text-sm">
                                    <p class="text-gray-900 font-medium">{{ $p->judul }}</p>
                                    <p class="text-gray-400 text-xs mt-1">
                                        <i class="bx bx-time-five"></i> {{ \Carbon\Carbon::parse($p->created_at)->format('d M Y • H:i') }}
                                    </p>
                                </td>
                                <td class="px-6 py-4 border-b border-gray-100 text-sm">
                                    <div class="flex items-center text-blue-600 font-bold bg-blue-50 px-3 py-1 rounded-full w-fit border border-blue-100">
                                        <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                            <path d="M2 10.5a1.5 1.5 0 113 0v6a1.5 1.5 0 01-3 0v-6zM6 10.333v5.43a2 2 0 001.106 1.79l.05.025A4 4 0 008.943 18h5.416a2 2 0 001.962-1.608l1.2-6A2 2 0 0015.56 8H12V4a2 2 0 00-2-2 1 1 0 00-1 1v.667a4 4 0 01-.8 2.4L6.8 9.067a2 2 0 00-.8 1.266z" />
                                        </svg>
                                        {{ $p->likes_count ?? 0 }} <span class="ml-1 text-xs font-medium text-blue-400">Suara</span>
                                    </div>
                                    @if(($p->likes_count ?? 0) >= 10)
                                        <span class="flex items-center w-fit px-2 py-0.5 rounded text-xs font-bold bg-red-100 text-red-600 animate-pulse">
                                            <span class="w-2 h-2 rounded-full bg-red-600 mr-1"></span>
                                            PRIORITAS TINGGI
                                        </span>
                                    @elseif(($p->likes_count ?? 0) >= 5)
                                        <span class="flex items-center w-fit px-2 py-0.5 rounded text-xs font-bold bg-orange-100 text-orange-600">
                                            <span class="w-2 h-2 rounded-full bg-orange-600 mr-1"></span>
                                            PERLU PERHATIAN
                                        </span>
                                    @endif
                                    </div>
                                </td>
                                <td class="px-6 py-4 border-b border-gray-100 text-sm">
                                    <form action="{{ route('admin.pengaduan.updateStatus', $p->id) }}" method="POST" class="m-0">
                                        @csrf
                                        @method('PUT')
                                        <div class="relative inline-block w-40">
                                            <select name="status" onchange="this.form.submit()" class="block appearance-none w-full border text-sm font-semibold px-4 py-2 pr-8 rounded-full shadow-sm cursor-pointer focus:outline-none focus:ring-2 focus:ring-opacity-50 transition duration-200
                                                {{ $p->status == 'pending' ? 'bg-yellow-50 text-yellow-700 border-yellow-200 focus:ring-yellow-500 focus:border-yellow-500' : '' }}
                                                {{ $p->status == 'diproses' ? 'bg-blue-50 text-blue-700 border-blue-200 focus:ring-blue-500 focus:border-blue-500' : '' }}
                                                {{ $p->status == 'selesai' ? 'bg-green-50 text-green-700 border-green-200 focus:ring-green-500 focus:border-green-500' : '' }}
                                            ">
                                                <option value="pending" {{ $p->status == 'pending' ? 'selected' : '' }}>Pending</option>
                                                <option value="diproses" {{ $p->status == 'diproses' ? 'selected' : '' }}>Diproses</option>
                                                <option value="selesai" {{ $p->status == 'selesai' ? 'selected' : '' }}>Selesai</option>
                                            </select>
                                            <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-3 text-gray-500">
                                                <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z"/></svg>
                                            </div>
                                        </div>
                                    </form>
                                </td>
                                <td class="px-6 py-4 border-b border-gray-100 text-sm">
                                    <a href="{{ route('admin.pengaduan.show', $p->id) }}" class="inline-flex items-center justify-center bg-indigo-50 text-indigo-600 hover:bg-indigo-600 hover:text-white font-semibold px-4 py-2 rounded-lg transition duration-200 shadow-sm">
                                        Lihat Detail</a>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" class="px-6 py-12 border-b border-gray-200 bg-white text-center">
                                    <div class="flex flex-col items-center justify-center text-gray-400">
                                        <svg class="w-16 h-16 mb-4 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"></path></svg>
                                        <p class="text-lg font-medium">
                                            @if(request('search') || request('status'))
                                                Pencarian tidak ditemukan
                                            @else
                                                Belum ada laporan yang masuk
                                            @endif
                                        </p>
                                        <p class="text-sm">
                                            @if(request('search') || request('status'))
                                                Coba gunakan kata kunci atau filter lain.
                                            @else
                                                Silakan tunggu mahasiswa mengirimkan pengaduan.
                                            @endif
                                        </p>
                                    </div>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
            
        </div>
    </div>
</x-app-layout>