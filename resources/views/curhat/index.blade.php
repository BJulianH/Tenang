@extends('layouts.app')

@section('title', 'Curhat with Wilson')

@section('styles')
<style>
    .chat-container {
        height: calc(100vh - 200px);
        max-height: 600px;
    }
    
    .wilson-avatar {
        width: 50px;
        height: 50px;
        background: linear-gradient(135deg, #58cc70, #45b259);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        box-shadow: 0 4px 0 #339847;
        border: 3px solid white;
    }
    
    .user-avatar {
        width: 50px;
        height: 50px;
        background: linear-gradient(135deg, #ffc800, #e6b400);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        box-shadow: 0 4px 0 #cc9f00;
        border: 3px solid white;
        color: white;
        font-weight: bold;
    }
    
    .message-bubble {
        max-width: 80%;
        border-radius: 18px;
        padding: 12px 16px;
        position: relative;
        animation: slideIn 0.3s ease-out;
    }
    
    .wilson-message {
        background: #f0f9f0;
        border: 2px solid #58cc70;
        border-bottom-left-radius: 4px;
    }
    
    .user-message {
        background: #fff9e6;
        border: 2px solid #ffc800;
        border-bottom-right-radius: 4px;
    }
    
    .typing-indicator {
        display: flex;
        align-items: center;
        gap: 4px;
        padding: 12px 16px;
        background: #f0f9f0;
        border-radius: 18px;
        border: 2px solid #58cc70;
        width: fit-content;
    }
    
    .typing-dot {
        width: 8px;
        height: 8px;
        background: #58cc70;
        border-radius: 50%;
        animation: typing 1.4s infinite;
    }
    
    .typing-dot:nth-child(2) { animation-delay: 0.2s; }
    .typing-dot:nth-child(3) { animation-delay: 0.4s; }
    
    @keyframes typing {
        0%, 60%, 100% { transform: translateY(0); }
        30% { transform: translateY(-8px); }
    }
    
    .quick-replies {
        display: flex;
        gap: 8px;
        flex-wrap: wrap;
        margin-top: 10px;
    }
    
    .quick-reply-btn {
        background: white;
        border: 2px solid #e9ecef;
        border-radius: 20px;
        padding: 8px 16px;
        font-size: 14px;
        cursor: pointer;
        transition: all 0.2s;
    }
    
    .quick-reply-btn:hover {
        border-color: #58cc70;
        background: #f0f9f0;
        transform: translateY(-2px);
    }
    
    .chat-input-container {
        border: 3px solid #e9ecef;
        border-radius: 24px;
        overflow: hidden;
        background: white;
    }
    
    #message-input {
        border: none;
        outline: none;
        padding: 16px;
        width: 100%;
        font-family: 'Nunito', sans-serif;
    }
    
    .send-btn {
        background: #58cc70;
        color: white;
        border: none;
        padding: 12px 24px;
        cursor: pointer;
        transition: all 0.2s;
        font-weight: bold;
    }
    
    .send-btn:hover {
        background: #45b259;
    }
    
    .send-btn:disabled {
        background: #ced4da;
        cursor: not-allowed;
    }
    
    .clear-chat-btn {
        background: #ff6b6b;
        color: white;
        border: none;
        padding: 8px 16px;
        border-radius: 12px;
        cursor: pointer;
        transition: all 0.2s;
        font-weight: bold;
        box-shadow: 0 4px 0 #ff5252;
    }
    
    .clear-chat-btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 0 #ff5252;
    }
    
    .clear-chat-btn:active {
        transform: translateY(2px);
        box-shadow: 0 2px 0 #ff5252;
    }
    
    .welcome-card {
        background: linear-gradient(135deg, #58cc70, #45b259);
        color: white;
        border-radius: 24px;
        padding: 24px;
        box-shadow: 0 8px 0 #339847;
        animation: slideIn 0.5s ease-out;
    }
    
    .emoji-reaction {
        display: inline-block;
        animation: celebrate 0.6s ease-out;
        margin: 0 2px;
    }
    
    /* Responsive */
    @media (max-width: 768px) {
        .chat-container {
            height: calc(100vh - 160px);
        }
        
        .message-bubble {
            max-width: 90%;
        }
        
        .wilson-avatar, .user-avatar {
            width: 40px;
            height: 40px;
        }
    }
</style>
@endsection

@section('content')
<div class="container mx-auto px-4 py-6">
    <!-- Header -->
    <div class="flex justify-between items-center mb-6">
        <div>
            <h1 class="text-3xl font-bold text-neutral-800">Curhat with Wilson</h1>
            <p class="text-neutral-600">Teman virtual yang selalu siap mendengarkan</p>
        </div>
        <button id="clear-chat" class="clear-chat-btn">
            <i class="fas fa-trash-alt mr-2"></i>Clear Chat
        </button>
    </div>

    <!-- Welcome Card -->
    <div class="welcome-card mb-6">
        <div class="flex items-center gap-4 mb-4">
            <div class="wilson-avatar">
                <i class="fas fa-headset text-white text-xl"></i>
            </div>
            <div>
                <h2 class="text-2xl font-bold">Halo! Aku Wilson 👋</h2>
                <p class="opacity-90">Aku di sini untuk mendengarkan ceritamu. Apapun yang kamu rasakan, aku siap menerimanya dengan hangat.</p>
            </div>
        </div>
        <div class="flex flex-wrap gap-2">
            <span class="bg-white/20 px-3 py-1 rounded-full text-sm">🤝 Tidak judgmental</span>
            <span class="bg-white/20 px-3 py-1 rounded-full text-sm">🔒 Privasi terjaga</span>
            <span class="bg-white/20 px-3 py-1 rounded-full text-sm">💝 Empatik</span>
            <span class="bg-white/20 px-3 py-1 rounded-full text-sm">😊 Ramah</span>
        </div>
    </div>

    <!-- Quick Reply Suggestions -->
    <div class="mb-6">
        <p class="text-neutral-700 mb-3">Coba mulai dengan:</p>
        <div class="quick-replies">
            <button class="quick-reply-btn" data-message="Hari ini berat banget...">😔 Hari ini berat banget...</button>
            <button class="quick-reply-btn" data-message="Aku lagi senang nih!">😊 Aku lagi senang nih!</button>
            <button class="quick-reply-btn" data-message="Bisa cerita tentang perasaan kesepian?">🏠 Soal kesepian</button>
            <button class="quick-reply-btn" data-message="Ada yang pengen aku share tapi bingung mulai dari mana">🤔 Bingung mulai dari mana</button>
        </div>
    </div>

    <!-- Chat Container -->
    <div class="bg-white rounded-duo-xl p-4 shadow-duo-lg mb-6">
        <div id="chat-messages" class="chat-container overflow-y-auto p-4 mb-4 space-y-4">
            <!-- Messages will be loaded here -->
            @if(empty($chatHistory))
                <div class="text-center py-12">
                    <div class="inline-block p-6 rounded-full bg-primary-50 mb-4">
                        <i class="fas fa-comments text-primary-500 text-4xl"></i>
                    </div>
                    <h3 class="text-xl font-bold text-neutral-700 mb-2">Mari mulai percakapan</h3>
                    <p class="text-neutral-600">Wilson siap mendengarkan ceritamu. Ketik pesan atau pilih quick reply di atas!</p>
                </div>
            @else
                @foreach($chatHistory as $chat)
                    @if($chat['role'] == 'user')
                        <div class="flex justify-end items-start gap-3">
                            <div class="message-bubble user-message">
                                <p class="text-neutral-800">{{ $chat['message'] }}</p>
                                <span class="text-xs text-neutral-500 mt-1 block">{{ $chat['timestamp']->format('H:i') }}</span>
                            </div>
                            <div class="user-avatar">
                                {{ substr(auth()->user()->name, 0, 1) }}
                            </div>
                        </div>
                    @else
                        <div class="flex items-start gap-3">
                            <div class="wilson-avatar">
                                <i class="fas fa-headset text-white"></i>
                            </div>
                            <div class="message-bubble wilson-message">
                                <p class="text-neutral-800">{!! nl2br(e($chat['message'])) !!}</p>
                                <span class="text-xs text-neutral-500 mt-1 block">Wilson • {{ $chat['timestamp']->format('H:i') }}</span>
                            </div>
                        </div>
                    @endif
                @endforeach
            @endif
        </div>

        <!-- Typing Indicator (Hidden by default) -->
        <div id="typing-indicator" class="hidden">
            <div class="flex items-start gap-3">
                <div class="wilson-avatar">
                    <i class="fas fa-headset text-white"></i>
                </div>
                <div class="typing-indicator">
                    <div class="typing-dot"></div>
                    <div class="typing-dot"></div>
                    <div class="typing-dot"></div>
                </div>
            </div>
        </div>

        <!-- Input Area -->
        <div class="chat-input-container flex">
            <input 
                type="text" 
                id="message-input" 
                placeholder="Tulis ceritamu di sini..." 
                maxlength="1000"
                autocomplete="off"
            >
            <button id="send-btn" class="send-btn">
                <i class="fas fa-paper-plane mr-2"></i>Kirim
            </button>
        </div>
        <div class="text-right mt-2">
            <span id="char-count" class="text-sm text-neutral-500">0/1000</span>
        </div>
    </div>

    <!-- Safety Notice -->
    <div class="bg-blue-50 border-2 border-blue-200 rounded-duo p-4">
        <div class="flex items-start gap-3">
            <i class="fas fa-shield-alt text-blue-500 text-xl mt-1"></i>
            <div>
                <h4 class="font-bold text-blue-800 mb-1">Ingat ya!</h4>
                <p class="text-blue-700 text-sm">
                    Wilson adalah teman curhat virtual. Untuk kondisi darurat atau masalah serius, 
                    <a href="#" class="font-bold underline">hubungi profesional kesehatan mental</a>.
                </p>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const messageInput = document.getElementById('message-input');
    const sendBtn = document.getElementById('send-btn');
    const chatMessages = document.getElementById('chat-messages');
    const typingIndicator = document.getElementById('typing-indicator');
    const charCount = document.getElementById('char-count');
    const clearChatBtn = document.getElementById('clear-chat');
    const quickReplyBtns = document.querySelectorAll('.quick-reply-btn');

    // Auto-focus input
    messageInput.focus();

    // Character counter
    messageInput.addEventListener('input', function() {
        const length = this.value.length;
        charCount.textContent = `${length}/1000`;
        
        if (length > 1000) {
            charCount.classList.add('text-red-500');
            sendBtn.disabled = true;
        } else if (length > 0) {
            charCount.classList.remove('text-red-500');
            sendBtn.disabled = false;
        } else {
            sendBtn.disabled = true;
        }
    });

    // Quick reply buttons
    quickReplyBtns.forEach(btn => {
        btn.addEventListener('click', function() {
            messageInput.value = this.dataset.message;
            messageInput.focus();
            messageInput.dispatchEvent(new Event('input'));
        });
    });

    // Send message function
    async function sendMessage() {
        const message = messageInput.value.trim();
        if (!message || message.length > 1000) return;

        // Add user message to chat
        addMessageToChat('user', message);
        
        // Clear input
        messageInput.value = '';
        charCount.textContent = '0/1000';
        sendBtn.disabled = true;
        
        // Show typing indicator
        typingIndicator.classList.remove('hidden');
        scrollToBottom();

        try {
            const response = await fetch('{{ route("curhat.send") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({ message: message })
            });

            const data = await response.json();

            // Hide typing indicator
            typingIndicator.classList.add('hidden');

            if (data.success) {
                // Add Wilson's response
                addMessageToChat('assistant', data.response);
            } else {
                showNotification('Gagal mengirim pesan', 'error');
            }
        } catch (error) {
            console.error('Error:', error);
            typingIndicator.classList.add('hidden');
            showNotification('Koneksi error, coba lagi', 'error');
        }
    }

    // Add message to chat UI
    function addMessageToChat(role, message) {
        const timestamp = new Date().toLocaleTimeString([], {hour: '2-digit', minute:'2-digit'});
        const userInitial = '{{ substr(auth()->user()->name, 0, 1) }}';
        
        if (role === 'user') {
            const messageHtml = `
                <div class="flex justify-end items-start gap-3">
                    <div class="message-bubble user-message">
                        <p class="text-neutral-800">${escapeHtml(message)}</p>
                        <span class="text-xs text-neutral-500 mt-1 block">${timestamp}</span>
                    </div>
                    <div class="user-avatar">
                        ${userInitial}
                    </div>
                </div>
            `;
            chatMessages.innerHTML += messageHtml;
        } else {
            const messageHtml = `
                <div class="flex items-start gap-3">
                    <div class="wilson-avatar">
                        <i class="fas fa-headset text-white"></i>
                    </div>
                    <div class="message-bubble wilson-message">
                        <p class="text-neutral-800">${formatMessage(message)}</p>
                        <span class="text-xs text-neutral-500 mt-1 block">Wilson • ${timestamp}</span>
                    </div>
                </div>
            `;
            chatMessages.innerHTML += messageHtml;
        }
        
        scrollToBottom();
    }

    // Format message with line breaks and emojis
    function formatMessage(text) {
        return escapeHtml(text)
            .replace(/\n/g, '<br>')
            .replace(/:\)/g, '😊')
            .replace(/:\(/g, '😔')
            .replace(/<3/g, '❤️')
            .replace(/:D/g, '😄');
    }

    // Escape HTML to prevent XSS
    function escapeHtml(text) {
        const div = document.createElement('div');
        div.textContent = text;
        return div.innerHTML;
    }

    // Scroll to bottom of chat
    function scrollToBottom() {
        chatMessages.scrollTop = chatMessages.scrollHeight;
    }

    // Clear chat function
    async function clearChat() {
        if (!confirm('Yakin ingin menghapus semua percakapan?')) return;

        try {
            const response = await fetch('{{ route("curhat.clear") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                }
            });

            const data = await response.json();
            
            if (data.success) {
                chatMessages.innerHTML = `
                    <div class="text-center py-12">
                        <div class="inline-block p-6 rounded-full bg-primary-50 mb-4">
                            <i class="fas fa-comments text-primary-500 text-4xl"></i>
                        </div>
                        <h3 class="text-xl font-bold text-neutral-700 mb-2">Mari mulai percakapan</h3>
                        <p class="text-neutral-600">Wilson siap mendengarkan ceritamu. Ketik pesan atau pilih quick reply di atas!</p>
                    </div>
                `;
                showNotification('Percakapan berhasil dihapus', 'success');
            }
        } catch (error) {
            console.error('Error:', error);
            showNotification('Gagal menghapus percakapan', 'error');
        }
    }

    // Event listeners
    sendBtn.addEventListener('click', sendMessage);
    
    messageInput.addEventListener('keypress', function(e) {
        if (e.key === 'Enter' && !e.shiftKey) {
            e.preventDefault();
            sendMessage();
        }
    });

    clearChatBtn.addEventListener('click', clearChat);

    // Initialize
    scrollToBottom();
    sendBtn.disabled = true;

    // Show welcome notification for new users
    @if(empty($chatHistory))
    setTimeout(() => {
        showNotification('Wilson siap mendengarkan ceritamu! 😊', 'success');
    }, 1000);
    @endif
});
</script>
@endsection