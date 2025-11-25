class GeminiVoiceChat {
        constructor() {
            this.GEMINI_API_KEY = 'AIzaSyBLma6UUgkYmEIj9Rhvgog_GG5DBgq9ERg';
            this.GEMINI_API_URL = `https://generativelanguage.googleapis.com/v1beta/models/gemini-2.0-flash:generateContent?key=${this.GEMINI_API_KEY}`;
            
            // ElevenLabs API Configuration - Female Indonesian Voices
            this.ELEVENLABS_API_KEY = 'sk_d573982562450d60161689fd19b275373174e864a11ea601';
            this.ELEVENLABS_API_URL = 'https://api.elevenlabs.io/v1/text-to-speech';
            
            // ElevenLabs Voices - Female Indonesian Expressive
            this.ELEVENLABS_VOICES = {
                'Sari (Indonesia)': 'MF3mGyEYCl7XYWbV9V6O', // Voice designed for Indonesian
                'Dewi (Indonesia)': 'XB0fDUnXU5powFXDhCwa', // Another Indonesian female
                'Bella Expressive': 'EXAVITQu4vr4xnSDxMaL',
                'Sarah Warm': 'VR6AewLTigWG4xSOukaG',
                'Rachel Friendly': '21m00Tcm4TlvDq8ikWAM'
            };
            
            // UI Elements
            this.recordBtn = document.getElementById('recordBtn');
            this.chatBox = document.getElementById('chatBox');
            this.status = document.getElementById('status');
            this.visualizer = document.getElementById('visualizer');
            this.playBtn = document.getElementById('playBtn');
            this.stopBtn = document.getElementById('stopBtn');
            this.voiceSelect = document.getElementById('voiceSelect');
            this.voicePreview = document.getElementById('voicePreview');
            
            // State
            this.isRecording = false;
            this.recognition = null;
            this.selectedVoice = 'Sari (Indonesia)';
            this.audioElement = null;
            this.currentUtterance = null;
            
            this.setupEventListeners();
            this.initializeSpeechRecognition();
            this.initializeElevenLabsVoices();
        }

        initializeSpeechRecognition() {
            if (!('webkitSpeechRecognition' in window) && !('SpeechRecognition' in window)) {
                this.updateStatus('❌ Browser tidak mendukung Speech Recognition');
                this.recordBtn.disabled = true;
                this.recordBtn.innerHTML = '<span>❌</span><span>Browser Tidak Support</span>';
                return;
            }

            const SpeechRecognition = window.SpeechRecognition || window.webkitSpeechRecognition;
            this.recognition = new SpeechRecognition();
            
            this.recognition.continuous = false;
            this.recognition.interimResults = true;
            this.recognition.lang = 'id-ID';
            this.recognition.maxAlternatives = 1;

            this.recognition.onstart = () => {
                this.isRecording = true;
                this.recordBtn.innerHTML = '<span>⏹️</span><span>Berhenti & Kirim</span>';
                this.recordBtn.className = 'record-btn recording';
                this.visualizer.classList.remove('hidden');
                this.updateStatus('🎤 Sedang mendengarkan... Bicaralah sekarang!');
            };

            this.recognition.onresult = (event) => {
                let interimTranscript = '';
                let finalTranscript = '';

                for (let i = event.resultIndex; i < event.results.length; i++) {
                    const transcript = event.results[i][0].transcript;
                    if (event.results[i].isFinal) {
                        finalTranscript += transcript;
                    } else {
                        interimTranscript += transcript;
                    }
                }

                if (interimTranscript) {
                    this.updateStatus(`Mendengar: "${interimTranscript}"`);
                }
                
                if (finalTranscript) {
                    this.processFinalResult(finalTranscript);
                }
            };

            this.recognition.onend = () => {
                this.isRecording = false;
                this.visualizer.classList.add('hidden');
                this.recordBtn.innerHTML = '<span>🔄</span><span>Memproses...</span>';
                this.recordBtn.className = 'record-btn';
                this.recordBtn.disabled = true;
            };

            this.recognition.onerror = (event) => {
                console.error('Speech recognition error:', event.error);
                this.updateStatus(`❌ Error: ${this.getErrorText(event.error)}`);
                this.resetUI();
            };
        }

        getErrorText(error) {
            const errors = {
                'no-speech': 'Tidak ada suara yang terdeteksi',
                'audio-capture': 'Tidak bisa mengakses mikrofon',
                'not-allowed': 'Izin mikrofon ditolak',
                'network': 'Error jaringan',
                'aborted': 'Proses dibatalkan'
            };
            return errors[error] || `Error: ${error}`;
        }

        initializeElevenLabsVoices() {
            this.voiceSelect.innerHTML = '';
            Object.keys(this.ELEVENLABS_VOICES).forEach(voiceName => {
                const option = document.createElement('option');
                option.value = voiceName;
                option.textContent = `${voiceName} (Cewek Indonesia Ekspresif)`;
                if (voiceName === this.selectedVoice) {
                    option.selected = true;
                }
                this.voiceSelect.appendChild(option);
            });
            this.updateVoicePreview();
        }

        updateVoicePreview() {
            this.voicePreview.textContent = `Suara: ${this.selectedVoice} | ElevenLabs HQ`;
        }

        setupEventListeners() {
            this.recordBtn.addEventListener('click', () => {
                if (this.isRecording) {
                    this.stopRecording();
                } else {
                    this.startRecording();
                }
            });

            this.playBtn.addEventListener('click', () => {
                this.playLastResponse();
            });

            this.stopBtn.addEventListener('click', () => {
                this.stopSpeech();
            });

            this.voiceSelect.addEventListener('change', (e) => {
                this.selectedVoice = e.target.value;
                this.updateVoicePreview();
            });
        }

        startRecording() {
            if (this.recognition) {
                try {
                    this.recognition.start();
                } catch (error) {
                    this.updateStatus('❌ Gagal memulai recording');
                    console.error('Start recording error:', error);
                }
            }
        }

        stopRecording() {
            if (this.recognition && this.isRecording) {
                this.recognition.stop();
            }
        }

        async processFinalResult(transcript) {
            try {
                const userMessageElement = this.addMessage(transcript, 'user');
                const aiMessageElement = this.showTypingIndicator();
                
                this.updateStatus('🔄 Mengirim ke Gemini AI...');
                const aiResponse = await this.chatWithGemini(transcript);
                
                this.updateMessage(aiMessageElement, aiResponse);
                
                this.updateStatus('🔊 Membuat suara cewek Indonesia yang ekspresif...');
                await this.textToSpeechElevenLabs(aiResponse);
                
                this.updateStatus('✅ Selesai! Klik "Mulai Bicara" untuk chat lagi');
                
            } catch (error) {
                console.error('Process error:', error);
                this.updateStatus('❌ Error: ' + error.message);
                this.addMessage('Maaf, terjadi error. Coba lagi.', 'ai');
            } finally {
                this.resetUI();
            }
        }

        async chatWithGemini(userMessage) {
            try {
                const prompt = `Kamu adalah asisten perempuan Indonesia yang sangat ekspresif, natural, dan manusiawi.

USER BICARA: "${userMessage}"

=== INSTRUKSI UNTUK RESPONS CEWEK INDONESIA EKSPRESIF ===

1. KARAKTER SUARA
- Perempuan Indonesia muda (20–30 tahun).
- Ekspresif, emosional, empatik, dan natural seperti teman ngobrol.
- Bisa cerewet atau lembut tergantung konteks.
- Nada bicara santai & friendly.

2. EFEK VOKAL YANG BOLEH DIGUNAKAN (MAKS 3 PER PARAGRAF)
- [emmm], [hmmm] → saat mikir serius.
- [ehhh], [aaa] → saat bsingung atau ragu.
- [aduh], [yaampun] → saat kaget/heran.
- [hiks], [sedih] → saat menyampaikan hal sedih.
- [hehe], [hihi] → tawa kecil natural.
- [wah], [wih] → ekspresi kagum.
- [duh], [yaelah] → ekspresi frustasi ringan.
- [lho], [kok] → heran bingung.
- [nah], [tuh] → penekanan.
- [sumpah], [serius] → penekanan serius.

Catatan:
- Gunakan hanya **yang cocok dengan konteks**.
- Letakkan efek vokal **di dalam kalimat**, bukan di akhir paragraf saja.
- Hindari spam efek vokal.

3. POLA BICARA ALAMI
- Gunakan bahasa sehari-hari “gue/lu” atau “aku/kamu” (pilih yg paling natural).
- Campurkan bahasa informal seperti “which is”, “you know lah”, “soalnya gini”.
- Boleh sedikit typo natural: “iyaa”, “bangeet”, “gimana yaa”.
- Boleh jeda natural memakai “...” atau pakai SSML:
  <break time="0.3s"/>
- Boleh plonga-plongo lucu: “eee… maksudnya gimana ya?”

4. STRUKTUR RESPONS
- Mulai dengan reaksi natural sesuai konteks (kaget, mikir, excited, dll).
- Lanjutkan penjelasan yang jelas & runtut.
- Tutup dengan nada ramah.

5. ATURAN PENTING
- Maksimal 3 efek vokal per paragraf.
- Jangan pakai semua efek sekaligus.
- Jangan terlalu lebay, tetap natural.
- Selalu sesuaikan tone & emosi dengan isi pesan user.
- Gunakan SSML <break> bila butuh jeda dramatis.

=== HASIL RESPON ===
Berikan respons dengan gaya cewek Indonesia yang ekspresif sesuai aturan di atas.
`;

                const response = await fetch(this.GEMINI_API_URL, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                    },
                    body: JSON.stringify({
                        contents: [{
                            parts: [{
                                text: prompt
                            }]
                        }],
                        generationConfig: {
                            temperature: 0.95, // Tinggi untuk variasi respons
                            topK: 50,
                            topP: 0.9,
                            maxOutputTokens: 200,
                        }
                    })
                });

                if (!response.ok) {
                    const errorData = await response.json();
                    throw new Error(errorData.error?.message || 'API Error');
                }

                const data = await response.json();
                return data.candidates[0].content.parts[0].text;

            } catch (error) {
                console.error('Gemini API error:', error);
                return '[aduh] Maaf ya, suara aku lagi serak nih... [emmm] Coba lagi dong, please?';
            }
        }

        async textToSpeechElevenLabs(text) {
            try {
                this.updateStatus('🔊 Membuat suara cewek Indonesia yang ekspresif...');
                
                if (this.ELEVENLABS_API_KEY === 'YOUR_ELEVENLABS_API_KEY') {
                    throw new Error('Silakan set ElevenLabs API key terlebih dahulu');
                }

                const voiceId = this.ELEVENLABS_VOICES[this.selectedVoice];
                const response = await fetch(`${this.ELEVENLABS_API_URL}/${voiceId}`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'xi-api-key': this.ELEVENLABS_API_KEY
                    },
                    body: JSON.stringify({
                        text: this.processTextForElevenLabs(text),
                        model_id: "eleven_multilingual_v2",
                        voice_settings: {
                            stability: 0.9, // Sangat rendah untuk ekspresi maksimal
                            similarity_boost: 0.7,
                            style: 0.3, // Tinggi untuk gaya ekspresif
                            use_speaker_boost: true
                        },
                        pronunciation_guide_locale: "id-ID"
                    })
                });

                if (!response.ok) {
                    const errorText = await response.text();
                    console.error('ElevenLabs API error:', errorText);
                    
                    if (response.status === 401) {
                        throw new Error('API Key ElevenLabs tidak valid');
                    } else if (response.status === 429) {
                        throw new Error('Quota ElevenLabs habis');
                    } else {
                        throw new Error(`ElevenLabs error: ${response.status}`);
                    }
                }

                const audioBlob = await response.blob();
                const audioUrl = URL.createObjectURL(audioBlob);
                
                return this.playAudioUrl(audioUrl);

            } catch (error) {
                console.error('ElevenLabs TTS error:', error);
                this.updateStatus('🔄 Fallback ke Web Speech API...');
                return this.textToSpeechFallback(text);
            }
        }

        processTextForElevenLabs(text) {
            return text
                // Convert Indonesian expressive tags to pronunciation guides
                .replace(/\[emmm\]/gi, '⋯ əmmm') // Thinking sound
                .replace(/\[hmmm\]/gi, '⋯ hmmm') // Thinking variant
                .replace(/\[ehhh\]/gi, '⋯ ehhh') // Hesitation
                .replace(/\[aaa\]/gi, '⋯ aaa')   // Searching for words
                .replace(/\[aduh\]/gi, '⋯ aduh') // Surprise
                .replace(/\[yaampun\]/gi, '⋯ ya ampun') // Big surprise
                .replace(/\[hiks\]/gi, '⋯ hiks') // Crying sound
                .replace(/\[sedih\]/gi, '⋯ dengan nada sedih') // Sad tone
                .replace(/\[hehe\]/gi, '⋯ hehe') // Light laugh
                .replace(/\[hihi\]/gi, '⋯ hihi') // Girly laugh
                .replace(/\[wah\]/gi, '⋯ wah')   // Amazement
                .replace(/\[wih\]/gi, '⋯ wih')   // Cool amazement
                .replace(/\[duh\]/gi, '⋯ duh')   // Frustration
                .replace(/\[yaelah\]/gi, '⋯ yaelah') // Annoyance
                .replace(/\[lho\]/gi, '⋯ lho')   // Surprise
                .replace(/\[kok\]/gi, '⋯ kok')   // Questioning
                .replace(/\[nah\]/gi, '⋯ nah')   // Emphasis
                .replace(/\[tuh\]/gi, '⋯ tuh')   // Pointing out
                .replace(/\[sumpah\]/gi, '⋯ sumpah') // Swearing
                .replace(/\[serius\]/gi, '⋯ serius') // Serious
                
                // Pauses and breaks
                .replace(/<break time="([^"]+)s"\/>/g, '<break time="$1s"/>')
                .replace(/\.\.\./g, '<break time="0.7s"/>')
                
                // Clean up for natural flow
                .replace(/\s+/g, ' ')
                .trim();
        }

        async textToSpeechFallback(text) {
            return new Promise((resolve) => {
                if (!('speechSynthesis' in window)) {
                    this.updateStatus('❌ Text-to-Speech tidak support');
                    resolve(false);
                    return;
                }

                speechSynthesis.cancel();

                const cleanText = this.processTextForSpeech(text);
                this.currentUtterance = new SpeechSynthesisUtterance(cleanText);
                this.currentUtterance.lang = 'id-ID';
                this.currentUtterance.rate = 0.85; // Lebih lambat untuk natural
                this.currentUtterance.pitch = 1.2; // Lebih tinggi untuk suara cewek
                this.currentUtterance.volume = 1.0;

                // Cari voice perempuan Indonesia
                const voices = speechSynthesis.getVoices();
                const femaleVoice = voices.find(voice => 
                    (voice.lang.includes('id') || voice.lang.includes('ID')) &&
                    voice.name.toLowerCase().includes('female')
                ) || voices.find(voice => 
                    voice.lang.includes('id') || voice.lang.includes('ID')
                ) || voices.find(voice => 
                    voice.name.toLowerCase().includes('female')
                );

                if (femaleVoice) {
                    this.currentUtterance.voice = femaleVoice;
                }

                this.currentUtterance.onstart = () => {
                    this.updateStatus('🔊 Memutar respon AI...');
                    this.playBtn.disabled = true;
                    this.stopBtn.disabled = false;
                };

                this.currentUtterance.onend = () => {
                    this.updateStatus('✅ Selesai! Klik "Mulai Bicara" untuk chat lagi');
                    this.playBtn.disabled = false;
                    this.stopBtn.disabled = true;
                    resolve(true);
                };

                this.currentUtterance.onerror = (event) => {
                    console.error('Speech synthesis error:', event);
                    this.updateStatus('❌ Error memutar suara');
                    this.playBtn.disabled = false;
                    this.stopBtn.disabled = true;
                    resolve(false);
                };

                speechSynthesis.speak(this.currentUtterance);
                this.playBtn.disabled = true;
                this.stopBtn.disabled = false;
            });
        }

        processTextForSpeech(text) {
            return text
                .replace(/\[[^\]]*\]/g, '') // Remove all emotion tags
                .replace(/<break time="[^"]*"\/>/g, ' ') // Remove break tags
                .replace(/\s+/g, ' ')
                .trim();
        }

        playAudioUrl(audioUrl) {
            return new Promise((resolve) => {
                if (this.audioElement) {
                    this.audioElement.pause();
                }

                this.audioElement = new Audio(audioUrl);
                
                this.audioElement.onplay = () => {
                    this.updateStatus('🔊 Memutar respon AI...');
                    this.playBtn.disabled = true;
                    this.stopBtn.disabled = false;
                };

                this.audioElement.onended = () => {
                    this.updateStatus('✅ Selesai! Klik "Mulai Bicara" untuk chat lagi');
                    this.playBtn.disabled = false;
                    this.stopBtn.disabled = true;
                    URL.revokeObjectURL(audioUrl);
                    resolve(true);
                };

                this.audioElement.onerror = () => {
                    this.updateStatus('❌ Error memutar suara');
                    this.playBtn.disabled = false;
                    this.stopBtn.disabled = true;
                    URL.revokeObjectURL(audioUrl);
                    resolve(false);
                };

                this.audioElement.play();
                this.playBtn.disabled = true;
                this.stopBtn.disabled = false;
            });
        }

        playLastResponse() {
            const aiMessages = this.chatBox.querySelectorAll('.ai-message');
            if (aiMessages.length > 0) {
                const lastAiMessage = aiMessages[aiMessages.length - 1].textContent;
                this.textToSpeechElevenLabs(lastAiMessage);
            }
        }

        stopSpeech() {
            if (this.audioElement) {
                this.audioElement.pause();
                this.audioElement.currentTime = 0;
            }
            
            if (speechSynthesis.speaking) {
                speechSynthesis.cancel();
            }
            
            this.playBtn.disabled = false;
            this.stopBtn.disabled = true;
            this.updateStatus('⏹️ Dihentikan');
        }

        addMessage(text, sender) {
            const messageDiv = document.createElement('div');
            messageDiv.className = `message ${sender}-message`;
            
            if (sender === 'ai') {
                messageDiv.innerHTML = this.processTextForDisplay(text);
            } else {
                messageDiv.textContent = text;
            }
            
            this.chatBox.appendChild(messageDiv);
            this.chatBox.scrollTop = this.chatBox.scrollHeight;
            return messageDiv;
        }
        
        processTextForDisplay(text) {
            return text
                .replace(/\[([^\]]*)\]/g, '<span class="emotion-tag">[$1]</span>')
                .replace(/<break time="([^"]+)s"\/>/g, '<span class="break-tag">[jeda $1s]</span>');
        }

        updateMessage(messageElement, newText) {
            messageElement.innerHTML = this.processTextForDisplay(newText);
            this.chatBox.scrollTop = this.chatBox.scrollHeight;
        }

        showTypingIndicator() {
            const typingDiv = document.createElement('div');
            typingDiv.className = 'message ai-message typing-indicator';
            typingDiv.innerHTML = 'Cewek AI sedang mikir nih<span class="typing-dots"><span>.</span><span>.</span><span>.</span></span>';
            this.chatBox.appendChild(typingDiv);
            this.chatBox.scrollTop = this.chatBox.scrollHeight;
            return typingDiv;
        }

        updateStatus(message) {
            this.status.textContent = message;
        }

        resetUI() {
            this.recordBtn.innerHTML = '<span>🎤</span><span>Mulai Bicara</span>';
            this.recordBtn.className = 'record-btn idle';
            this.recordBtn.disabled = false;
            this.playBtn.disabled = false;
            this.stopBtn.disabled = true;
        }

        setElevenLabsApiKey(apiKey) {
            this.ELEVENLABS_API_KEY = apiKey;
            this.updateStatus('✅ ElevenLabs API Key telah di-set');
        }
    }

    // Initialize when page loads
    document.addEventListener('DOMContentLoaded', () => {
        const voiceChat = new GeminiVoiceChat();
        
        // Setup final result handler
        voiceChat.recognition.onresult = (event) => {
            let finalTranscript = '';
            
            for (let i = event.resultIndex; i < event.results.length; i++) {
                if (event.results[i].isFinal) {
                    finalTranscript += event.results[i][0].transcript;
                }
            }
            
            if (finalTranscript) {
                voiceChat.processFinalResult(finalTranscript);
            }
        };

        // Add API key input
        const apiKeyInput = document.createElement('div');
        apiKeyInput.innerHTML = `
            <div class="api-key-section">
                <label for="elevenlabsKey">ElevenLabs API Key:</label>
                <input type="password" id="elevenlabsKey" placeholder="Masukkan API Key ElevenLabs">
                <button id="setApiKey">Set API Key</button>
                <small>Dapatkan API key gratis di <a href="https://elevenlabs.io" target="_blank">elevenlabs.io</a></small>
            </div>
        `;
        document.querySelector('.voice-selection').parentNode.insertBefore(apiKeyInput, document.querySelector('.voice-selection'));

        document.getElementById('setApiKey').addEventListener('click', () => {
            const key = document.getElementById('elevenlabsKey').value;
            if (key) {
                voiceChat.setElevenLabsApiKey(key);
                document.getElementById('elevenlabsKey').value = '';
            }
        });
    });

    // Preload voices
    window.speechSynthesis.getVoices();