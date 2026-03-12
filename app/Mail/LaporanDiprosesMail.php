<?php

namespace App\Mail;

use App\Models\Pengaduan;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class LaporanDiprosesMail extends Mailable
{
    use Queueable, SerializesModels;

    public $pengaduan; // Variabel penyimpan data laporan

    public function __construct(Pengaduan $pengaduan)
    {
        $this->pengaduan = $pengaduan;
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Informasi: Laporan Anda Sedang Diproses',
        );
    }

    public function content(): Content
    {
        // KITA LANGSUNG ARAHKAN KE VIEW YANG BENAR AGAR TIDAK ERROR
        return new Content(
            view: 'emails.laporan_diproses', 
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
}
