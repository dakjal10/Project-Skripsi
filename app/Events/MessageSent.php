<?php

namespace App\Events;

use App\Models\Message;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\Channel;

// Perhatikan kita menambahkan "implements ShouldBroadcastNow"
class MessageSent implements ShouldBroadcastNow 
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $message;

    public function __construct(Message $message)
    {
        $this->message = $message;
    }

    public function broadcastOn(): array
    {
        // LOGIKA BARU UNTUK CHAT GRUP
        // Jika receiver_id ada isinya, kirim ke channel pribadi (1-on-1)
        if ($this->message->receiver_id) {
            return [
                new PrivateChannel('chat.' . $this->message->receiver_id),
            ];
        } 
        
        // Jika receiver_id kosong (NULL), kirim ke channel publik (Grup/Semua Orang)
        // Perhatikan kita menggunakan "Channel" biasa (bukan PrivateChannel)
        return [
            new \Illuminate\Broadcasting\Channel('chat.group'),
        ];
    }
}