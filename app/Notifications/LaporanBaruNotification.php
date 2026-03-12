<?php
// <!-- /ini code untuk notif lonceng bagian admin/ -->
namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class LaporanBaruNotification extends Notification
{
    use Queueable; 

    public $pengaduan;

    public function __construct($pengaduan)
    {
        $this->pengaduan = $pengaduan;
    }

    public function via($notifiable)
    {
        return ['database']; // Wajib dikirim ke database untuk lonceng
    }

    public function toDatabase($notifiable)
    {
        return [
            'judul' => 'Ada Laporan Baru!',
            'pesan' => "Laporan baru berjudul: '{$this->pengaduan->judul}' perlu segera dicek.",
            'laporan_id' => $this->pengaduan->id,
        ];
    }
}
