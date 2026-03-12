<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class StatusLaporanNotification extends Notification
{
    use Queueable; // Pastikan TIDAK ADA implements ShouldQueue di baris atas

    public $pengaduan;

    public function __construct($pengaduan)
    {
        $this->pengaduan = $pengaduan;
    }

    // INI KUNCI UTAMANYA: Wajib me-return ['database'] agar masuk ke tabel
    public function via($notifiable)
    {
        return ['database'];
    }

    // Kita gunakan toDatabase() agar lebih spesifik dan disukai PostgreSQL
    public function toDatabase($notifiable)
    {
        $status = strtoupper($this->pengaduan->status);
        
        return [
            'judul' => 'Status Laporan Diperbarui!',
            'pesan' => "Laporan Anda: '{$this->pengaduan->judul}' sekarang berstatus {$status}.",
            'laporan_id' => $this->pengaduan->id,
        ];
    }
}
