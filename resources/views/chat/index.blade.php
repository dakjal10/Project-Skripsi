@extends('layouts.main')

@section('title', 'Live Chat - E-Pengaduan')

@section('konten_utama')
    <div class="head-title">
        <div class="left">
            <h1>Live Chat</h1>
            <ul class="breadcrumb">
                <li><a href="{{ route('dashboard') }}">Dashboard</a></li>
                <li><i class='bx bx-chevron-right'></i></li>
                <li><a class="active" href="#">Live Chat</a></li>
            </ul>
        </div>
    </div>

    <div class="table-data" style="margin-top: 20px;">
        <div class="order" style="padding: 0; display: flex; height: 75vh; min-height: 550px; overflow: hidden; border-radius: 10px;">
            
            <div style="width: 30%; border-right: 1px solid #eee; background: #fff; display: flex; flex-direction: column;">
                <div style="padding: 20px; border-bottom: 1px solid #eee; font-weight: 600; color: var(--dark); font-size: 16px;">
                    Kontak & Grup
                </div>
                
                <ul style="list-style: none; padding: 0; margin: 0; overflow-y: auto; flex: 1;">
                    
                    <li onclick="selectGroup()" style="padding: 15px 20px; border-bottom: 1px solid #f9f9f9; cursor: pointer; display: flex; align-items: center; gap: 15px; transition: 0.2s;" onmouseover="this.style.background='#f0fdf4'" onmouseout="this.style.background='transparent'">
                        <div style="width: 45px; height: 45px; border-radius: 50%; background: #10B981; color: white; display: flex; align-items: center; justify-content: center; font-weight: bold; font-size: 18px; box-shadow: 0 2px 5px rgba(16,185,129,0.3);">
                            <i class='bx bxs-group'></i>
                        </div>
                        <div style="flex: 1;"> <h4 style="margin: 0; font-size: 14px; font-weight: 600; color: var(--dark);">Grup Chat Publik</h4>
                            <p style="margin: 0; font-size: 12px; color: var(--dark-grey);">Semua Pengguna</p>
                        </div>
                        <div id="badge-group" style="display: none; background: #ef4444; color: white; font-size: 11px; font-weight: bold; padding: 2px 7px; border-radius: 10px;">0</div>
                    </li>

                    @foreach($users as $user)
                        @php
                            // Cek apakah user punya avatar. Jika tidak, gunakan UI Avatars otomatis.
                            $avatarUrl = (isset($user->avatar) && $user->avatar != '') 
                                ? asset('storage/' . $user->avatar) 
                                : 'https://ui-avatars.com/api/?name=' . urlencode($user->name) . '&background=EBF4FF&color=3B82F6&bold=true';
                        @endphp

                        <li onclick="selectContact({{ $user->id }}, '{{ $user->name }}', '{{ $avatarUrl }}')" style="padding: 15px 20px; border-bottom: 1px solid #f9f9f9; cursor: pointer; display: flex; align-items: center; gap: 15px; transition: 0.2s;" onmouseover="this.style.background='#eff6ff'" onmouseout="this.style.background='transparent'">
                            
                            <img src="{{ $avatarUrl }}" alt="Foto" style="width: 45px; height: 45px; border-radius: 50%; object-fit: cover; border: 1px solid #e5e7eb; box-shadow: 0 2px 5px rgba(0,0,0,0.05);">
                            
                            <div style="flex: 1;">
                                <h4 style="margin: 0; font-size: 14px; font-weight: 600; color: var(--dark);">{{ $user->name }}</h4>
                                <p style="margin: 0; font-size: 12px; color: var(--dark-grey);">Obrolan Privat</p>
                            </div>
                            
                            <div id="badge-{{ $user->id }}" style="display: none; background: #ef4444; color: white; font-size: 11px; font-weight: bold; padding: 2px 7px; border-radius: 10px;">0</div>
                        </li>
                    @endforeach
                </ul>
            </div>

            <div style="width: 70%; display: flex; flex-direction: column; background: #f8fafc;">
                
                <div id="chat-header" style="padding: 20px; border-bottom: 1px solid #eee; background: #fff; display: flex; align-items: center; gap: 15px;">
                    <div>
                        <h3 style="margin: 0; font-size: 18px; font-weight: 600; color: var(--dark);">Pilih Kontak atau Grup</h3>
                        <p style="margin: 0; font-size: 13px; color: var(--dark-grey);">Mulai percakapan dengan pengguna lain di sebelah kiri.</p>
                    </div>
                </div>
                
                <div id="chat-messages" style="flex: 1; padding: 25px; overflow-y: auto; display: flex; flex-direction: column;">
                    <div style="height: 100%; display: flex; align-items: center; justify-content: center; color: var(--dark-grey); font-style: italic;">
                        Silakan pilih kontak atau grup untuk memulai obrolan.
                    </div>
                </div>

                <div style="position: relative; padding: 15px 20px; background: #fff; border-top: 1px solid #eee; display: flex; gap: 10px; align-items: center;">
                    
                    <div id="emoji-picker-container" style="display: none; position: absolute; bottom: 70px; left: 20px; z-index: 9999; background: #fff; border: 1px solid #e5e7eb; box-shadow: 0 10px 25px rgba(0,0,0,0.15); border-radius: 8px; width: 320px; height: 400px; overflow: hidden;">
                        <emoji-picker class="light" style="width: 100%; height: 100%; display: flex; --num-columns: 8; --emoji-size: 1.5rem;"></emoji-picker>
                    </div>

                    <button id="emoji-button" disabled style="background: transparent; border: none; font-size: 26px; cursor: pointer; color: var(--dark-grey); transition: 0.3s; display: flex; align-items: center; justify-content: center; padding: 0;">
                        <i class='bx bx-smile' onmouseover="this.style.color='var(--blue)'" onmouseout="this.style.color='var(--dark-grey)'"></i>
                    </button>

                    <input type="text" id="message-input" placeholder="Ketik pesan Anda di sini..." disabled style="flex: 1; padding: 12px 20px; border: 1px solid #ccc; border-radius: 30px; outline: none; font-family: inherit; font-size: 14px; background: #f9f9f9;">
                    
                    <button id="send-button" disabled style="background: var(--blue, #3b82f6); color: white; border: none; padding: 12px 25px; border-radius: 30px; cursor: pointer; font-weight: bold; transition: 0.3s; display: flex; align-items: center; gap: 5px;">
                        <span>Kirim</span>
                        <i class='bx bxs-send'></i>
                    </button>
                </div>
            </div>

        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    {{-- <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script> --}}
    <script type="module" src="https://unpkg.com/emoji-picker-element@1"></script>
    <script type="module" src="https://cdn.jsdelivr.net/npm/emoji-picker-element@1"></script>

    <script>
        let currentReceiverId = null;
        let currentChatType = 'none';
        const currentUserId = {{ Auth::id() }};
        
        const chatMessages = document.getElementById('chat-messages');
        const messageInput = document.getElementById('message-input');
        const sendButton = document.getElementById('send-button');
        const chatHeader = document.getElementById('chat-header');
        const typingIndicator = document.getElementById('typing-indicator');
        const emojiButton = document.getElementById('emoji-button');
        const emojiPickerContainer = document.getElementById('emoji-picker-container');
        const picker = document.querySelector('emoji-picker');

        // Fungsi Format Waktu
        function formatTime(dateString) {
            const date = dateString ? new Date(dateString) : new Date();
            let hours = date.getHours();
            let minutes = date.getMinutes();
            hours = hours < 10 ? '0' + hours : hours;
            minutes = minutes < 10 ? '0' + minutes : minutes;
            return hours + ':' + minutes;
        }

        // Reset Notifikasi/Badge saat kontak diklik
        function resetBadge(idStr) {
            const badge = document.getElementById('badge-' + idStr);
            if(badge) {
                badge.innerText = '0';
                badge.style.display = 'none';
            }
        }

        // Tambah Notifikasi/Badge dengan Logika Baru yang Lebih Kuat
        function incrementBadge(idStr) {
            console.log("🔔 Memicu notifikasi untuk ID:", idStr); // Pengecekan di Console
            
            const badge = document.getElementById('badge-' + idStr);
            if(badge) {
                // Pastikan yang diambil murni angka
                let count = parseInt(badge.innerText.trim()) || 0;
                badge.innerText = count + 1;
                
                // Pakai flex agar ukurannya bulat sempurna dan dipaksa tampil
                badge.style.display = 'flex'; 
                badge.style.alignItems = 'center';
                badge.style.justifyContent = 'center';
                badge.style.minWidth = '20px';
                badge.style.height = '20px';
                
                console.log("✅ Notifikasi berhasil dimunculkan! Total unread:", count + 1);
            } else {
                console.error("❌ Elemen dengan ID badge-" + idStr + " tidak ditemukan di HTML Sidebar!");
            }
        }

        function selectGroup() {
            currentReceiverId = null;
            currentChatType = 'group';
            resetBadge('group');

            chatHeader.innerHTML = `
                <div style="width: 45px; height: 45px; border-radius: 50%; background: #10B981; color: white; display: flex; align-items: center; justify-content: center; font-weight: bold; font-size: 18px;"><i class='bx bxs-group'></i></div>
                <div>
                    <h3 style="margin: 0; font-size: 18px; font-weight: 600; color: var(--dark);">Grup Chat Publik</h3>
                    <p style="margin: 0; font-size: 13px; color: #10B981;">Online • Semua Pengguna</p>
                </div>`;
            prepareChatRoom();
        }

        // Tambahkan parameter avatarUrl di sini
        function selectContact(id, name, avatarUrl) {
            currentReceiverId = id;
            currentChatType = 'personal';
            resetBadge(id);

            // Ganti kotak warna biru menjadi tag <img>
            chatHeader.innerHTML = `
                <img src="${avatarUrl}" alt="Profil" style="width: 45px; height: 45px; border-radius: 50%; object-fit: cover; border: 1px solid #e5e7eb; box-shadow: 0 2px 5px rgba(0,0,0,0.05);">
                <div>
                    <h3 style="margin: 0; font-size: 18px; font-weight: 600; color: var(--dark);">${name}</h3>
                    <p style="margin: 0; font-size: 13px; color: #3b82f6;">Online • Privat</p>
                </div>`;
            prepareChatRoom();
        }

        function prepareChatRoom() {
            messageInput.disabled = false;
            sendButton.disabled = false;
            emojiButton.disabled = false;
            chatMessages.innerHTML = '<div style="text-align: center; color: var(--dark-grey); margin-top: 20px;">Memuat riwayat pesan...</div>';
            
            const urlId = currentReceiverId === null ? 'group' : currentReceiverId;

            axios.get(`/chat/messages/${urlId}`)
                .then(res => {
                    chatMessages.innerHTML = '';
                    if(res.data.length === 0) {
                        chatMessages.innerHTML = '<div style="height: 100%; display: flex; align-items: center; justify-content: center; color: var(--dark-grey); font-style: italic;">Belum ada obrolan di ruangan ini. Mulai sapa sekarang!</div>';
                    } else {
                        res.data.forEach(msg => {
                            renderMessage(msg.message, msg.sender_id == currentUserId ? 'sent' : 'received', msg.created_at);
                        });
                        scrollToBottom();
                    }
                });
            
            setTimeout(() => messageInput.focus(), 100);
        }

        function renderMessage(text, type, timeString = null) {
            if(chatMessages.innerHTML.includes('Silakan pilih') || chatMessages.innerHTML.includes('Belum ada obrolan') || chatMessages.innerHTML.includes('Memuat riwayat pesan')) {
                chatMessages.innerHTML = '';
            }

            const div = document.createElement('div');
            const isSent = type === 'sent';
            const msgTime = formatTime(timeString);
            
            div.style.marginBottom = '15px';
            div.style.display = 'flex';
            div.style.justifyContent = isSent ? 'flex-end' : 'flex-start';

            const bubble = document.createElement('div');
            bubble.style.maxWidth = '70%';
            bubble.style.padding = '10px 15px 5px 15px';
            bubble.style.borderRadius = '15px';
            bubble.style.fontSize = '14px';
            bubble.style.lineHeight = '1.5';
            bubble.style.boxShadow = '0 1px 2px rgba(0,0,0,0.05)';
            bubble.style.display = 'flex';
            bubble.style.flexDirection = 'column';

            const textDiv = document.createElement('div');
            textDiv.textContent = text;
            
            const timeDiv = document.createElement('div');
            timeDiv.textContent = msgTime;
            timeDiv.style.fontSize = '10px';
            timeDiv.style.alignSelf = 'flex-end';
            timeDiv.style.marginTop = '4px';

            if (isSent) {
                bubble.style.background = 'var(--blue, #3b82f6)';
                bubble.style.color = '#fff';
                bubble.style.borderBottomRightRadius = '0px';
                timeDiv.style.color = 'rgba(255,255,255,0.7)';
            } else {
                bubble.style.background = '#fff';
                bubble.style.color = 'var(--dark, #333)';
                bubble.style.border = '1px solid #eee';
                bubble.style.borderBottomLeftRadius = '0px';
                timeDiv.style.color = '#999';
            }

            bubble.appendChild(textDiv);
            bubble.appendChild(timeDiv);
            div.appendChild(bubble);
            chatMessages.appendChild(div);
        }

        function scrollToBottom() {
            chatMessages.scrollTop = chatMessages.scrollHeight;
        }

        let typingTimer;
        messageInput.addEventListener('input', function() {
            if(currentChatType === 'personal' && typeof window.Echo !== 'undefined') {
                window.Echo.private(`chat.${currentReceiverId}`).whisper('typing', {
                    userId: currentUserId,
                    isTyping: true
                });
            }
        });

        sendButton.addEventListener('click', sendMessage);
        messageInput.addEventListener('keypress', function (e) {
            if (e.key === 'Enter') sendMessage();
        });

        function sendMessage() {
            const text = messageInput.value.trim();
            if (!text || currentChatType === 'none') return;
            
            renderMessage(text, 'sent');
            messageInput.value = '';
            scrollToBottom();
            
            axios.post('/chat/message', {
                receiver_id: currentReceiverId,
                message: text
            }).catch(err => {
                console.error("Gagal mengirim pesan", err);
            });
        }
        /// Buka/Tutup menu Emoji
        emojiButton.addEventListener('click', (e) => {
            e.preventDefault();  // Mencegah *refresh* atau efek bawaan tombol
            e.stopPropagation(); // Mencegah klik bocor ke area lain
            
            // Logika buka-tutup yang lebih solid
            if (emojiPickerContainer.style.display === 'none' || emojiPickerContainer.style.display === '') {
                emojiPickerContainer.style.display = 'block';
            } else {
                emojiPickerContainer.style.display = 'none';
            }
        });

        // Masukkan Emoji ke dalam input teks
        picker.addEventListener('emoji-click', event => {
            const cursorPosition = messageInput.selectionStart;
            const textBefore = messageInput.value.substring(0, cursorPosition);
            const textAfter = messageInput.value.substring(cursorPosition);
            
            messageInput.value = textBefore + event.detail.unicode + textAfter;
            messageInput.focus();
        });

        // Tutup menu Emoji jika user mengklik area lain
        document.addEventListener('click', (event) => {
            // HANYA jalankan pengecekan jika popup sedang terbuka
            if (emojiPickerContainer.style.display === 'block') {
                if (!emojiButton.contains(event.target) && !emojiPickerContainer.contains(event.target)) {
                    emojiPickerContainer.style.display = 'none';
                }
            }
        });

        document.addEventListener('DOMContentLoaded', () => {
            setTimeout(() => {
                if (typeof window.Echo !== 'undefined') {
                    console.log("✅ Laravel Echo Siap! Mendengarkan pesan...");
                    
                    window.Echo.private(`chat.${currentUserId}`)
                        .listen('MessageSent', (e) => {
                            // PENGUBAHAN PENTING: Gunakan '==' agar aman dari perbedaan tipe data (String vs Integer)
                            if (currentChatType === 'personal' && currentReceiverId == e.message.sender_id) {
                                renderMessage(e.message.message, 'received', e.message.created_at);
                                scrollToBottom();
                            } else {
                                // Jika tab tidak sedang terbuka di kontak tersebut
                                incrementBadge(e.message.sender_id);
                            }
                        })
                        .listenForWhisper('typing', (e) => {
                            if(currentChatType === 'personal' && currentReceiverId == e.userId) {
                                typingIndicator.innerText = "Lawan bicara sedang mengetik...";
                                typingIndicator.style.display = 'block';
                                
                                clearTimeout(typingTimer);
                                typingTimer = setTimeout(() => {
                                    typingIndicator.style.display = 'none';
                                }, 2000);
                            }
                        });

                    window.Echo.channel('chat.group')
                        .listen('MessageSent', (e) => {
                            if (e.message.sender_id != currentUserId) {
                                if (currentChatType === 'group') {
                                    renderMessage(e.message.message, 'received', e.message.created_at);
                                    scrollToBottom();
                                } else {
                                    incrementBadge('group');
                                }
                            }
                        });
                }
            }, 1000); 
        });
    </script>
@endsection