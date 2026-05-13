<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use App\Models\Message; // Tambahkan ini
use App\Events\MessageSent;

class ChatController extends Controller
{
    public function index()
    {
        // Mengambil daftar kontak (Selain user yang sedang login)
        // Nanti kita bisa filter, misal mahasiswa hanya melihat admin, dsb.
        $users = User::where('id', '!=', Auth::id())->get();

        return view('chat.index', compact('users'));
    }
    // Fungsi untuk mengambil riwayat pesan
    // Fungsi untuk mengambil riwayat pesan
    public function fetchMessages($id)
    {
        // LOGIKA BARU: Jika ID yang dikirim adalah 'group', ambil semua pesan grup
        if ($id === 'group') {
            // Ambil pesan yang receiver_id-nya kosong (NULL di database)
            $messages = Message::whereNull('receiver_id')->orderBy('created_at', 'asc')->get();
            return response()->json($messages);
        }

        // LOGIKA LAMA: Jika bukan grup, ambil riwayat personal (1-on-1)
        $messages = Message::where(function($q) use ($id) {
            $q->where('sender_id', Auth::id())->where('receiver_id', $id);
        })->orWhere(function($q) use ($id) {
            $q->where('sender_id', $id)->where('receiver_id', Auth::id());
        })->orderBy('created_at', 'asc')->get();

        return response()->json($messages);
    }

    // Fungsi untuk menyimpan pesan dan memancarkannya
    // FUNGSI SEND MESSAGE YANG DIPERBARUI
    public function sendMessage(Request $request)
    {
        $request->validate([
            // LOGIKA BARU: receiver_id sekarang nullable (boleh kosong untuk grup)
            'receiver_id' => 'nullable|exists:users,id',
            'message' => 'required|string'
        ]);

        $message = Message::create([
            'sender_id' => Auth::id(),
            // Jika ada kirim ke user, jika tidak simpan NULL (untuk grup)
            'receiver_id' => $request->receiver_id, 
            'message' => $request->message
        ]);

        // Pancarkan (broadcast) pesan ini ke Reverb
        broadcast(new MessageSent($message))->toOthers();

        return response()->json($message);
    }
}