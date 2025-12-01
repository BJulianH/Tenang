@extends('layouts.app')

@section('title', 'Voice Chat dengan Gemini')

@section('styles')
<style>
    .main-container {
        display: flex;
        gap: 24px;
        height: calc(100vh - 200px);
        min-height: 600px;
    }

    .left-sidebar {
        flex: 1;
        max-width: 25%;
        display: flex;
        flex-direction: column;
        gap: 16px;
    }

    .chat-section {
        flex: 3;
        max-width: 75%;
        background: white;
        border-radius: 16px;
        padding: 24px;
        box-shadow: 0 4px 0 rgba(0, 0, 0, 0.1);
        border: 3px solid #f1f3f4;
        display: flex;
        flex-direction: column;
    }

    .feature-card {
        background: white;
        border-radius: 16px;
        padding: 24px;
        box-shadow: 0 4px 0 rgba(0, 0, 0, 0.1);
        border: 3px solid #f1f3f4;
        transition: all 0.2s ease;
        text-align: center;
        cursor: pointer;
    }

    .feature-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 6px 0 rgba(0, 0, 0, 0.1);
        border-color: #e5e7eb;
    }

    .feature-card:active {
        transform: translateY(2px);
        box-shadow: 0 2px 0 rgba(0, 0, 0, 0.1);
        border-color: #dfe3e6;
    }

    .feature-icon {
        width: 60px;
        height: 60px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 16px;
        font-size: 24px;
        box-shadow: 0 4px 0 rgba(0, 0, 0, 0.1);
    }

    .detail-icon {
        background: linear-gradient(135deg, #58cc70 0%, #45b259 100%);
        border: 2px solid #45b259;
    }

    .call-icon {
        background: linear-gradient(135deg, #4a8cff 0%, #3a7cff 100%);
        border: 2px solid #3a7cff;
    }

    .journal-icon {
        background: linear-gradient(135deg, #ff9f43 0%, #ff8f33 100%);
        border: 2px solid #ff8f33;
    }

    .feature-card h3 {
        color: #333;
        font-weight: 700;
        margin-bottom: 8px;
        font-size: 18px;
    }

    .feature-card p {
        color: #666;
        font-size: 14px;
        line-height: 1.4;
    }

    .chat-header {
        text-align: center;
        margin-bottom: 24px;
        padding-bottom: 16px;
        border-bottom: 2px solid #e9ecef;
    }

    .chat-header h1 {
        color: #333;
        font-weight: 700;
        margin-bottom: 8px;
    }

    .chat-header p {
        color: #666;
        font-size: 16px;
    }

    .chat-box {
        flex: 1;
        border: 2px solid #e0e0e0;
        border-radius: 16px;
        padding: 20px;
        margin-bottom: 20px;
        overflow-y: auto;
        background: #fafafa;
        min-height: 300px;
    }

    .message {
        margin: 12px 0;
        padding: 12px 16px;
        border-radius: 16px;
        max-width: 70%;
        word-wrap: break-word;
        animation: fadeIn 0.3s ease-in;
        line-height: 1.4;
        box-shadow: 0 2px 4px rgba(0,0,0,0.1);
    }

    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(10px); }
        to { opacity: 1; transform: translateY(0); }
    }

    .user-message {
        background: linear-gradient(135deg, #58cc70 0%, #45b259 100%);
        color: white;
        margin-left: auto;
        margin-right: 0;
        border: 2px solid #45b259;
    }

    .ai-message {
        background: white;
        color: #333;
        border: 2px solid #e0e0e0;
    }

    .controls {
        text-align: center;
        padding: 20px 0 0;
        border-top: 2px solid #e9ecef;
        margin-top: auto;
    }

    .record-btn {
        padding: 16px 32px;
        font-size: 18px;
        border: none;
        border-radius: 16px;
        cursor: pointer;
        margin: 10px;
        transition: all 0.2s ease;
        font-weight: 700;
        box-shadow: 0 4px 0 rgba(0,0,0,0.1);
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 10px;
        min-width: 200px;
    }

    .record-btn.recording {
        background: linear-gradient(135deg, #ff6b6b 0%, #ee5a24 100%);
        color: white;
        animation: pulse 1.5s infinite;
        transform: scale(1.05);
        border: 2px solid #ee5a24;
    }

    .record-btn.idle {
        background: linear-gradient(135deg, #58cc70 0%, #45b259 100%);
        color: white;
        border: 2px solid #45b259;
    }

    .record-btn:disabled {
        background: #cccccc;
        cursor: not-allowed;
        transform: none !important;
        animation: none !important;
        border: 2px solid #adb5bd;
    }

    @keyframes pulse {
        0% { transform: scale(1); box-shadow: 0 4px 0 rgba(255,107,107,0.4); }
        50% { transform: scale(1.05); box-shadow: 0 6px 0 rgba(255,107,107,0.6); }
        100% { transform: scale(1); box-shadow: 0 4px 0 rgba(255,107,107,0.4); }
    }

    .status {
        text-align: center;
        margin: 16px 0;
        font-style: italic;
        color: #666;
        min-height: 20px;
        font-weight: 500;
        padding: 8px;
        background: #f8f9fa;
        border-radius: 8px;
        border: 1px solid #e9ecef;
    }

    .audio-controls {
        display: flex;
        justify-content: center;
        align-items: center;
        gap: 12px;
        margin-top: 16px;
    }

    .audio-btn {
        padding: 10px 20px;
        border: none;
        border-radius: 12px;
        background: #58cc70;
        color: white;
        cursor: pointer;
        font-size: 14px;
        font-weight: 600;
        transition: all 0.2s ease;
        box-shadow: 0 2px 0 #45b259;
        border: 2px solid #45b259;
    }

    .audio-btn:hover {
        background: #4ec765;
        transform: translateY(-2px);
        box-shadow: 0 4px 0 #45b259;
    }

    .audio-btn:active {
        transform: translateY(1px);
        box-shadow: 0 1px 0 #45b259;
    }

    .audio-btn:disabled {
        background: #adb5bd;
        cursor: not-allowed;
        transform: none;
        box-shadow: 0 2px 0 #6c757d;
        border: 2px solid #6c757d;
    }

    .typing-indicator {
        display: inline-block;
        padding: 10px 15px;
        background: #f0f0f0;
        border-radius: 15px;
        color: #666;
        font-style: italic;
        border: 1px solid #e0e0e0;
    }

    .typing-dots {
        display: inline-block;
    }

    .typing-dots span {
        animation: typing 1.4s infinite;
        display: inline-block;
    }

    .typing-dots span:nth-child(2) { animation-delay: 0.2s; }
    .typing-dots span:nth-child(3) { animation-delay: 0.4s; }

    @keyframes typing {
        0%, 60%, 100% { opacity: 0.3; }
        30% { opacity: 1; }
    }

    .visualizer {
        width: 100%;
        height: 60px;
        margin: 16px 0;
        display: flex;
        justify-content: center;
        align-items: center;
        gap: 4px;
    }

    .bar {
        width: 6px;
        height: 20px;
        background: #58cc70;
        border-radius: 3px;
        animation: visualizer 1.5s ease-in-out infinite;
    }

    .bar:nth-child(2) { animation-delay: 0.1s; }
    .bar:nth-child(3) { animation-delay: 0.2s; }
    .bar:nth-child(4) { animation-delay: 0.3s; }
    .bar:nth-child(5) { animation-delay: 0.4s; }

    @keyframes visualizer {
        0%, 100% { height: 20px; }
        50% { height: 40px; }
    }

    .hidden {
        display: none;
    }

    .emotion-tag {
        display: inline-block;
        background: #e9ecef;
        padding: 2px 8px;
        border-radius: 10px;
        font-size: 0.8em;
        color: #495057;
        margin-right: 5px;
        border: 1px solid #dee2e6;
        font-weight: 600;
    }

    .voice-selector {
        margin: 16px 0;
        text-align: center;
        padding: 12px;
        background: #f8f9fa;
        border-radius: 12px;
        border: 1px solid #e9ecef;
    }

    .voice-selector label {
        font-weight: 600;
        color: #495057;
        margin-right: 8px;
    }

    .voice-selector select {
        padding: 8px 16px;
        border-radius: 12px;
        border: 2px solid #e0e0e0;
        background: white;
        font-size: 14px;
        font-weight: 500;
    }

    .voice-preview {
        margin-top: 8px;
        font-size: 12px;
        color: #6c757d;
        font-style: italic;
    }

    /* Custom scrollbar untuk chat box */
    .chat-box::-webkit-scrollbar {
        width: 8px;
    }

    .chat-box::-webkit-scrollbar-track {
        background: #f1f1f1;
        border-radius: 10px;
    }

    .chat-box::-webkit-scrollbar-thumb {
        background: #58cc70;
        border-radius: 10px;
    }

    .chat-box::-webkit-scrollbar-thumb:hover {
        background: #45b259;
    }

    /* Responsive Design */
    @media (max-width: 1024px) {
        .main-container {
            flex-direction: column;
            height: auto;
        }
        
        .left-sidebar {
            max-width: 100%;
            flex-direction: row;
            flex-wrap: wrap;
        }
        
        .feature-card {
            flex: 1;
            min-width: 200px;
        }
        
        .chat-section {
            max-width: 100%;
        }
    }

    @media (max-width: 768px) {
        .left-sidebar {
            flex-direction: column;
        }
        
        .feature-card {
            min-width: 100%;
        }
        
        .message {
            max-width: 85%;
        }
    }
</style>
@endsection

@section('content')
<div class="container mx-auto px-4 py-6">
    <div class="main-container">
        <!-- Sidebar Kiri (1/4) -->
        <div class="left-sidebar">
            <!-- Detail Button -->
            <div class="feature-card" id="detailBtn">
                <div class="feature-icon detail-icon">
                    <i class="fas fa-user text-white"></i>
                </div>
                <h3>Detail of You</h3>
                <p>Lihat detail profil dan progress kesehatan mental Anda</p>
            </div>

            <!-- Call Button -->
            <div class="feature-card" id="callBtn">
                <div class="feature-icon call-icon">
                    <i class="fas fa-phone text-white"></i>
                </div>
                <h3>Start Call Wilson</h3>
                <p>Mulai percakapan dengan AI assistant Wilson</p>
            </div>

            <!-- Journal Scan Wajah Button -->
            <div class="feature-card" id="journalBtn">
                <div class="feature-icon journal-icon">
                    <i class="fas fa-camera text-white"></i>
                </div>
                <h3>Journal Scan Wajah</h3>
                <p>Analisis ekspresi wajah untuk journaling emotional</p>
            </div>
        </div>

        <!-- Chat Section Kanan (3/4) -->
        <div class="chat-section">
            <div class="chat-header">
                <h1 class="text-2xl font-bold">🎤 Voice Chat dengan Gemini AI</h1>
                <p>Suara realistis dengan emosi natural dan ekspresi</p>
            </div>
            
            <div class="voice-selector">
                <label for="voiceSelect">Pilih Suara: </label>
                <select id="voiceSelect">
                    <option value="">Loading voices...</option>
                </select>
                <div class="voice-preview" id="voicePreview"></div>
            </div>
            
            <div class="chat-box" id="chatBox">
                <div class="message ai-message">
                    <span class="emotion-tag">[senyum]</span> 
                    👋 Halo! Saya asisten AI Gemini. Klik tombol "🎤 Mulai Bicara" di bawah dan mulai berbicara dalam Bahasa Indonesia! 
                    <span class="emotion-tag">[ramah]</span>
                </div>
            </div>

            <div class="status" id="status">Siap mendengarkan...</div>

            <div class="visualizer hidden" id="visualizer">
                <div class="bar"></div>
                <div class="bar"></div>
                <div class="bar"></div>
                <div class="bar"></div>
                <div class="bar"></div>
            </div>

            <div class="controls">
                <button class="record-btn idle" id="recordBtn">
                    <span>🎤</span>
                    <span>Mulai Bicara</span>
                </button>
                
                <div class="audio-controls">
                    <button class="audio-btn" id="playBtn" disabled>
                        🔈 Putar Response
                    </button>
                    <button class="audio-btn" id="stopBtn" disabled>
                        ⏹️ Berhenti
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Elements
        const chatBox = document.getElementById('chatBox');
        const recordBtn = document.getElementById('recordBtn');
        const status = document.getElementById('status');
        const visualizer = document.getElementById('visualizer');
        const playBtn = document.getElementById('playBtn');
        const stopBtn = document.getElementById('stopBtn');
        const voiceSelect = document.getElementById('voiceSelect');
        const voicePreview = document.getElementById('voicePreview');
        
        // Feature buttons
        const detailBtn = document.getElementById('detailBtn');
        const callBtn = document.getElementById('callBtn');
        const journalBtn = document.getElementById('journalBtn');
        
        // Variables
        let isRecording = false;
        let mediaRecorder;
        let audioChunks = [];
        let audioBlob;
        let audioUrl;
        let audio = new Audio();
        let voices = [];
        
        // Initialize speech synthesis voices
        function loadVoices() {
            voices = speechSynthesis.getVoices();
            voiceSelect.innerHTML = '';
            
            const supportedVoices = voices.filter(voice => 
                voice.lang.includes('id') || voice.lang.includes('en')
            );
            
            if (supportedVoices.length === 0) {
                voiceSelect.innerHTML = '<option value="">No supported voices found</option>';
                return;
            }
            
            supportedVoices.forEach((voice, index) => {
                const option = document.createElement('option');
                option.value = index;
                option.textContent = `${voice.name} (${voice.lang})`;
                voiceSelect.appendChild(option);
            });
            
            const indonesianVoice = supportedVoices.find(voice => voice.lang.includes('id'));
            if (indonesianVoice) {
                voiceSelect.value = supportedVoices.indexOf(indonesianVoice);
            }
            
            updateVoicePreview();
        }
        
        // Update voice preview information
        function updateVoicePreview() {
            const selectedIndex = voiceSelect.value;
            if (selectedIndex && voices[selectedIndex]) {
                const voice = voices[selectedIndex];
                voicePreview.textContent = `Suara: ${voice.name} - Bahasa: ${voice.lang} - ${voice.localService ? 'Lokal' : 'Online'}`;
            } else {
                voicePreview.textContent = '';
            }
        }
        
        // Event listeners for voice selection
        voiceSelect.addEventListener('change', updateVoicePreview);
        
        // Load voices when they become available
        if (speechSynthesis.onvoiceschanged !== undefined) {
            speechSynthesis.onvoiceschanged = loadVoices;
        }
        
        // Add message to chat
        function addMessage(text, isUser = false) {
            const messageDiv = document.createElement('div');
            messageDiv.className = `message ${isUser ? 'user-message' : 'ai-message'}`;
            
            if (!isUser) {
                const emotions = ['[senyum]', '[ramah]', '[antusias]', '[tenang]'];
                const randomEmotion = emotions[Math.floor(Math.random() * emotions.length)];
                messageDiv.innerHTML = `<span class="emotion-tag">${randomEmotion}</span> ${text}`;
            } else {
                messageDiv.textContent = text;
            }
            
            chatBox.appendChild(messageDiv);
            chatBox.scrollTop = chatBox.scrollHeight;
        }
        
        // Show typing indicator
        function showTypingIndicator() {
            const typingDiv = document.createElement('div');
            typingDiv.className = 'message ai-message typing-indicator';
            typingDiv.id = 'typingIndicator';
            typingDiv.innerHTML = 'Gemini mengetik <span class="typing-dots"><span>.</span><span>.</span><span>.</span></span>';
            chatBox.appendChild(typingDiv);
            chatBox.scrollTop = chatBox.scrollHeight;
        }
        
        // Hide typing indicator
        function hideTypingIndicator() {
            const typingIndicator = document.getElementById('typingIndicator');
            if (typingIndicator) {
                typingIndicator.remove();
            }
        }
        
        // Simulate AI response
        function simulateAIResponse(userMessage) {
            showTypingIndicator();
            
            setTimeout(() => {
                hideTypingIndicator();
                
                let response = "Maaf, saya tidak mengerti pertanyaan Anda. Bisakah Anda menjelaskannya lebih lanjut?";
                
                if (userMessage.toLowerCase().includes('halo') || userMessage.toLowerCase().includes('hai')) {
                    response = "Halo! Senang berbicara dengan Anda. Ada yang bisa saya bantu hari ini?";
                } else if (userMessage.toLowerCase().includes('nama')) {
                    response = "Saya adalah Gemini AI, asisten virtual yang siap membantu Anda!";
                } else if (userMessage.toLowerCase().includes('bagaimana') && userMessage.toLowerCase().includes('kabarmu')) {
                    response = "Saya baik-baik saja, terima kasih sudah bertanya! Bagaimana dengan hari Anda?";
                } else if (userMessage.toLowerCase().includes('terima kasih')) {
                    response = "Sama-sama! Senang bisa membantu Anda.";
                } else if (userMessage.toLowerCase().includes('bye') || userMessage.toLowerCase().includes('selamat tinggal')) {
                    response = "Selamat tinggal! Sampai jumpa lagi. Jaga diri Anda ya!";
                }
                
                addMessage(response, false);
                speakText(response);
            }, 2000);
        }
        
        // Text-to-speech function
        function speakText(text) {
            if (!speechSynthesis) {
                console.error('Speech synthesis not supported');
                return;
            }
            
            speechSynthesis.cancel();
            
            const selectedIndex = voiceSelect.value;
            if (!selectedIndex) {
                console.error('No voice selected');
                return;
            }
            
            const utterance = new SpeechSynthesisUtterance(text);
            utterance.voice = voices[selectedIndex];
            utterance.rate = 0.9;
            utterance.pitch = 1;
            utterance.volume = 1;
            
            utterance.onstart = function() {
                playBtn.disabled = true;
                stopBtn.disabled = false;
                status.textContent = 'Memutar respons...';
            };
            
            utterance.onend = function() {
                playBtn.disabled = false;
                stopBtn.disabled = true;
                status.textContent = 'Siap mendengarkan...';
            };
            
            speechSynthesis.speak(utterance);
        }
        
        // Start recording
        async function startRecording() {
            try {
                const stream = await navigator.mediaDevices.getUserMedia({ audio: true });
                mediaRecorder = new MediaRecorder(stream);
                audioChunks = [];
                
                mediaRecorder.ondataavailable = event => {
                    audioChunks.push(event.data);
                };
                
                mediaRecorder.onstop = () => {
                    audioBlob = new Blob(audioChunks, { type: 'audio/wav' });
                    audioUrl = URL.createObjectURL(audioBlob);
                    audio.src = audioUrl;
                    
                    status.textContent = 'Memproses audio...';
                    
                    setTimeout(() => {
                        const userMessages = [
                            "Halo, apa kabar?",
                            "Bisa ceritakan tentang diri Anda?",
                            "Apa yang bisa Anda bantu?",
                            "Hari ini cuacanya bagus ya",
                            "Saya butuh bantuan dengan sesuatu"
                        ];
                        
                        const randomMessage = userMessages[Math.floor(Math.random() * userMessages.length)];
                        addMessage(randomMessage, true);
                        simulateAIResponse(randomMessage);
                        
                        status.textContent = 'Siap mendengarkan...';
                    }, 1500);
                };
                
                mediaRecorder.start();
                isRecording = true;
                recordBtn.classList.remove('idle');
                recordBtn.classList.add('recording');
                recordBtn.innerHTML = '<span>⏹️</span><span>Berhenti Bicara</span>';
                visualizer.classList.remove('hidden');
                status.textContent = 'Mendengarkan...';
                
            } catch (error) {
                console.error('Error accessing microphone:', error);
                status.textContent = 'Error: Tidak dapat mengakses mikrofon';
            }
        }
        
        // Stop recording
        function stopRecording() {
            if (mediaRecorder && isRecording) {
                mediaRecorder.stop();
                isRecording = false;
                recordBtn.classList.remove('recording');
                recordBtn.classList.add('idle');
                recordBtn.innerHTML = '<span>🎤</span><span>Mulai Bicara</span>';
                visualizer.classList.add('hidden');
                
                mediaRecorder.stream.getTracks().forEach(track => track.stop());
            }
        }
        
        // Play recorded audio
        function playAudio() {
            if (audioUrl) {
                audio.play();
                playBtn.disabled = true;
                stopBtn.disabled = false;
                status.textContent = 'Memutar rekaman...';
                
                audio.onended = function() {
                    playBtn.disabled = false;
                    stopBtn.disabled = true;
                    status.textContent = 'Siap mendengarkan...';
                };
            }
        }
        
        // Stop audio playback
        function stopAudio() {
            audio.pause();
            audio.currentTime = 0;
            playBtn.disabled = false;
            stopBtn.disabled = true;
            status.textContent = 'Siap mendengarkan...';
        }
        
        // Feature button event listeners
        detailBtn.addEventListener('click', function() {
            addMessage("Saya ingin melihat detail profil saya", true);
            simulateAIResponse("Baik, saya akan menampilkan detail profil Anda. Fitur ini sedang dalam pengembangan.");
        });
        
        callBtn.addEventListener('click', function() {
            addMessage("Saya ingin memulai panggilan dengan Wilson", true);
            simulateAIResponse("Halo! Saya Wilson, AI assistant Anda. Senang bisa berbicara dengan Anda hari ini!");
        });
        
        journalBtn.addEventListener('click', function() {
            addMessage("Saya ingin melakukan journal scan wajah", true);
            simulateAIResponse("Mari kita analisis ekspresi wajah Anda untuk journaling emotional. Pastikan kamera Anda aktif.");
        });
        
        // Event listeners
        recordBtn.addEventListener('click', function() {
            if (isRecording) {
                stopRecording();
            } else {
                startRecording();
            }
        });
        
        playBtn.addEventListener('click', playAudio);
        stopBtn.addEventListener('click', stopAudio);
        
        // Initialize voices
        loadVoices();
        
        // Add Duolingo-style button interactions
        [recordBtn, playBtn, stopBtn, detailBtn, callBtn, journalBtn].forEach(button => {
            button.addEventListener('mousedown', function() {
                this.style.transform = 'translateY(2px)';
                if (this.classList.contains('record-btn') || this.classList.contains('feature-card')) {
                    this.style.boxShadow = '0 2px 0 rgba(0, 0, 0, 0.1)';
                }
            });
            
            button.addEventListener('mouseup', function() {
                this.style.transform = 'translateY(0)';
                if (this.classList.contains('record-btn') || this.classList.contains('feature-card')) {
                    this.style.boxShadow = this.classList.contains('recording') ? 
                        '0 4px 0 rgba(255,107,107,0.4)' : '0 4px 0 rgba(0, 0, 0, 0.1)';
                }
            });
            
            button.addEventListener('mouseleave', function() {
                this.style.transform = 'translateY(0)';
                if (this.classList.contains('record-btn') || this.classList.contains('feature-card')) {
                    this.style.boxShadow = this.classList.contains('recording') ? 
                        '0 4px 0 rgba(255,107,107,0.4)' : '0 4px 0 rgba(0, 0, 0, 0.1)';
                }
            });
        });
    });
</script>
@endsection