<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MindSpace - Konseling AI untuk Gen Z</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Poppins', 'Segoe UI', sans-serif;
        }
        
        :root {
            --primary: #4CAF50;
            --secondary: #81C784;
            --accent: #66BB6A;
            --dark-green: #388E3C;
            --light-green: #C8E6C9;
            --bg: #f0f7f0;
            --surface: #ffffff;
            --text: #2E7D32;
            --text-light: #4CAF50;
        }
        
        body {
            background: var(--bg);
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 20px;
            color: var(--text);
        }
        
        .container {
            width: 100%;
            max-width: 1100px;
            display: flex;
            gap: 25px;
        }
        
        .left-panel {
            flex: 1;
            display: grid;
            grid-template-columns: 1fr 1fr;
            grid-template-rows: auto auto auto;
            gap: 20px;
            align-content: start;
        }
        
        .right-panel {
            flex: 1.2;
        }
        
        .card {
            background: var(--bg);
            border-radius: 25px;
            padding: 25px;
            box-shadow: 
                8px 8px 16px rgba(0, 0, 0, 0.07),
                -8px -8px 16px rgba(255, 255, 255, 0.8);
            position: relative;
            overflow: hidden;
            transition: all 0.3s ease;
        }
        
        .card:hover {
            transform: translateY(-5px);
            box-shadow: 
                12px 12px 24px rgba(0, 0, 0, 0.09),
                -12px -12px 24px rgba(255, 255, 255, 0.9);
        }
        
        .header-card {
            grid-column: 1 / -1;
            text-align: center;
            padding: 30px 25px;
        }
        
        .logo {
            font-size: 2.5rem;
            font-weight: 800;
            background: linear-gradient(135deg, var(--primary), var(--dark-green));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            margin-bottom: 8px;
            letter-spacing: -1px;
        }
        
        .tagline {
            color: var(--text-light);
            font-size: 0.95rem;
            font-weight: 500;
            margin-bottom: 15px;
        }
        
        .status-indicator {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
        }
        
        .status-dot {
            width: 10px;
            height: 10px;
            border-radius: 50%;
            background: var(--primary);
            box-shadow: 0 0 10px rgba(76, 175, 80, 0.5);
        }
        
        .status-text {
            font-size: 0.85rem;
            color: var(--text-light);
        }
        
        .feature-card {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            text-align: center;
            cursor: pointer;
            min-height: 140px;
        }
        
        .feature-icon {
            width: 60px;
            height: 60px;
            border-radius: 18px;
            display: flex;
            align-items: center;
            justify-content: center;
            background: var(--light-green);
            color: var(--dark-green);
            font-size: 1.5rem;
            margin-bottom: 15px;
            box-shadow: 
                5px 5px 10px rgba(0, 0, 0, 0.07),
                -5px -5px 10px rgba(255, 255, 255, 0.8);
            transition: all 0.3s ease;
        }
        
        .feature-card:hover .feature-icon {
            transform: scale(1.1);
            box-shadow: 
                8px 8px 16px rgba(0, 0, 0, 0.09),
                -8px -8px 16px rgba(255, 255, 255, 0.9);
        }
        
        .feature-title {
            font-weight: 600;
            font-size: 0.95rem;
            margin-bottom: 5px;
            color: var(--dark-green);
        }
        
        .feature-desc {
            font-size: 0.75rem;
            color: var(--text-light);
            line-height: 1.3;
        }
        
        .mood-card {
            grid-column: 1 / -1;
        }
        
        .mood-title {
            font-size: 1.1rem;
            margin-bottom: 20px;
            color: var(--dark-green);
            font-weight: 600;
            text-align: center;
        }
        
        .mood-options {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 15px;
        }
        
        .mood-option {
            background: var(--bg);
            border-radius: 18px;
            padding: 18px 12px;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: all 0.3s ease;
            box-shadow: 
                5px 5px 10px rgba(0, 0, 0, 0.05),
                -5px -5px 10px rgba(255, 255, 255, 0.8);
        }
        
        .mood-option:hover {
            transform: translateY(-3px);
            box-shadow: 
                8px 8px 15px rgba(0, 0, 0, 0.07),
                -8px -8px 15px rgba(255, 255, 255, 0.8);
        }
        
        .mood-emoji {
            font-size: 2rem;
            margin-bottom: 10px;
        }
        
        .mood-label {
            font-size: 0.8rem;
            color: var(--text-light);
            font-weight: 500;
        }
        
        .main-card {
            background: var(--bg);
            border-radius: 30px;
            padding: 30px 25px;
            box-shadow: 
                10px 10px 20px rgba(0, 0, 0, 0.07),
                -10px -10px 20px rgba(255, 255, 255, 0.8);
            position: relative;
            overflow: hidden;
            height: 100%;
            display: flex;
            flex-direction: column;
        }
        
        .visualization-container {
            height: 180px;
            background: var(--bg);
            border-radius: 20px;
            margin-bottom: 25px;
            position: relative;
            overflow: hidden;
            box-shadow: 
                inset 5px 5px 10px rgba(0, 0, 0, 0.05),
                inset -5px -5px 10px rgba(255, 255, 255, 0.8);
            display: flex;
            align-items: center;
            justify-content: center;
        }
        
        .audio-wave {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 4px;
            height: 100%;
            width: 100%;
            padding: 0 20px;
        }
        
        .wave-bar {
            width: 6px;
            border-radius: 3px;
            background: linear-gradient(to top, var(--primary), var(--secondary));
            transition: height 0.3s ease;
            box-shadow: 0 0 8px rgba(76, 175, 80, 0.3);
        }
        
        .chat-container {
            background: var(--bg);
            border-radius: 20px;
            padding: 20px;
            flex: 1;
            overflow-y: auto;
            margin-bottom: 20px;
            box-shadow: 
                inset 5px 5px 10px rgba(0, 0, 0, 0.05),
                inset -5px -5px 10px rgba(255, 255, 255, 0.8);
        }
        
        .message {
            margin-bottom: 15px;
            padding: 12px 18px;
            border-radius: 18px;
            max-width: 85%;
            animation: fadeIn 0.4s ease;
            position: relative;
            font-size: 0.95rem;
            line-height: 1.4;
        }
        
        .user-message {
            background: var(--surface);
            color: var(--text);
            margin-left: auto;
            border-bottom-right-radius: 5px;
            box-shadow: 
                5px 5px 10px rgba(0, 0, 0, 0.05),
                -5px -5px 10px rgba(255, 255, 255, 0.8);
        }
        
        .ai-message {
            background: var(--bg);
            color: var(--text);
            border-bottom-left-radius: 5px;
            box-shadow: 
                5px 5px 10px rgba(0, 0, 0, 0.05),
                -5px -5px 10px rgba(255, 255, 255, 0.8);
        }
        
        .input-container {
            display: flex;
            gap: 12px;
            align-items: center;
        }
        
        .message-input {
            flex: 1;
            padding: 16px 20px;
            border: none;
            border-radius: 50px;
            background: var(--bg);
            box-shadow: 
                inset 5px 5px 10px rgba(0, 0, 0, 0.05),
                inset -5px -5px 10px rgba(255, 255, 255, 0.8);
            font-size: 0.95rem;
            outline: none;
            transition: all 0.3s ease;
            color: var(--text);
        }
        
        .message-input:focus {
            box-shadow: 
                inset 3px 3px 6px rgba(0, 0, 0, 0.05),
                inset -3px -3px 6px rgba(255, 255, 255, 0.8),
                0 0 0 2px rgba(76, 175, 80, 0.2);
        }
        
        .send-button {
            background: var(--bg);
            border: none;
            border-radius: 50%;
            width: 55px;
            height: 55px;
            display: flex;
            justify-content: center;
            align-items: center;
            color: var(--primary);
            font-size: 1.2rem;
            cursor: pointer;
            box-shadow: 
                5px 5px 10px rgba(0, 0, 0, 0.07),
                -5px -5px 10px rgba(255, 255, 255, 0.8);
            transition: all 0.3s ease;
        }
        
        .send-button:hover {
            box-shadow: 
                3px 3px 6px rgba(0, 0, 0, 0.07),
                -3px -3px 6px rgba(255, 255, 255, 0.8),
                inset 2px 2px 4px rgba(0, 0, 0, 0.05),
                inset -2px -2px 4px rgba(255, 255, 255, 0.8);
        }
        
        .send-button:active {
            box-shadow: 
                inset 5px 5px 10px rgba(0, 0, 0, 0.05),
                inset -5px -5px 10px rgba(255, 255, 255, 0.8);
        }
        
        .call-controls {
            display: flex;
            justify-content: center;
            gap: 20px;
            margin-top: 20px;
        }
        
        .control-button {
            background: var(--bg);
            border: none;
            border-radius: 50%;
            width: 55px;
            height: 55px;
            display: flex;
            justify-content: center;
            align-items: center;
            color: var(--text);
            font-size: 1.2rem;
            cursor: pointer;
            box-shadow: 
                5px 5px 10px rgba(0, 0, 0, 0.07),
                -5px -5px 10px rgba(255, 255, 255, 0.8);
            transition: all 0.3s ease;
        }
        
        .control-button:hover {
            transform: translateY(-3px);
            box-shadow: 
                8px 8px 15px rgba(0, 0, 0, 0.07),
                -8px -8px 15px rgba(255, 255, 255, 0.8);
        }
        
        .control-button:active {
            box-shadow: 
                inset 5px 5px 10px rgba(0, 0, 0, 0.05),
                inset -5px -5px 10px rgba(255, 255, 255, 0.8);
        }
        
        .control-button.active {
            color: var(--primary);
            box-shadow: 
                inset 5px 5px 10px rgba(0, 0, 0, 0.05),
                inset -5px -5px 10px rgba(255, 255, 255, 0.8);
        }
        
        .end-call {
            color: var(--dark-green);
        }

        /* Popup Styles */
        .popup-overlay {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(0, 0, 0, 0.5);
            display: flex;
            justify-content: center;
            align-items: center;
            z-index: 1000;
            opacity: 0;
            visibility: hidden;
            transition: all 0.3s ease;
        }

        .popup-overlay.active {
            opacity: 1;
            visibility: visible;
        }

        .popup-content {
            background: var(--bg);
            border-radius: 30px;
            padding: 30px;
            max-width: 500px;
            width: 90%;
            box-shadow: 
                20px 20px 40px rgba(0, 0, 0, 0.15),
                -20px -20px 40px rgba(255, 255, 255, 0.8);
            transform: scale(0.9);
            transition: all 0.3s ease;
            position: relative;
        }

        .popup-overlay.active .popup-content {
            transform: scale(1);
        }

        .popup-close {
            position: absolute;
            top: 20px;
            right: 20px;
            background: var(--bg);
            border: none;
            border-radius: 50%;
            width: 40px;
            height: 40px;
            display: flex;
            justify-content: center;
            align-items: center;
            color: var(--text-light);
            font-size: 1.2rem;
            cursor: pointer;
            box-shadow: 
                5px 5px 10px rgba(0, 0, 0, 0.07),
                -5px -5px 10px rgba(255, 255, 255, 0.8);
            transition: all 0.3s ease;
        }

        .popup-close:hover {
            transform: rotate(90deg);
            color: var(--dark-green);
        }

        .popup-header {
            text-align: center;
            margin-bottom: 25px;
        }

        .popup-icon {
            width: 80px;
            height: 80px;
            border-radius: 20px;
            display: flex;
            align-items: center;
            justify-content: center;
            background: var(--light-green);
            color: var(--dark-green);
            font-size: 2rem;
            margin: 0 auto 20px;
            box-shadow: 
                8px 8px 16px rgba(0, 0, 0, 0.07),
                -8px -8px 16px rgba(255, 255, 255, 0.8);
        }

        .popup-title {
            font-size: 1.5rem;
            font-weight: 700;
            color: var(--dark-green);
            margin-bottom: 10px;
        }

        .popup-subtitle {
            color: var(--text-light);
            font-size: 1rem;
        }

        .popup-body {
            margin-bottom: 25px;
        }

        .popup-description {
            color: var(--text);
            line-height: 1.6;
            margin-bottom: 20px;
            text-align: center;
        }

        .popup-features {
            display: flex;
            flex-direction: column;
            gap: 12px;
            margin-bottom: 25px;
        }

        .popup-feature {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 12px 15px;
            background: var(--bg);
            border-radius: 15px;
            box-shadow: 
                inset 3px 3px 6px rgba(0, 0, 0, 0.05),
                inset -3px -3px 6px rgba(255, 255, 255, 0.8);
        }

        .popup-feature i {
            color: var(--primary);
            font-size: 1.1rem;
            width: 20px;
        }

        .popup-feature span {
            color: var(--text);
            font-size: 0.9rem;
        }

        .popup-action {
            display: flex;
            justify-content: center;
        }

        .popup-button {
            background: var(--bg);
            border: none;
            border-radius: 50px;
            padding: 15px 40px;
            color: var(--primary);
            font-weight: 600;
            font-size: 1rem;
            cursor: pointer;
            box-shadow: 
                8px 8px 16px rgba(0, 0, 0, 0.07),
                -8px -8px 16px rgba(255, 255, 255, 0.8);
            transition: all 0.3s ease;
        }

        .popup-button:hover {
            transform: translateY(-3px);
            box-shadow: 
                12px 12px 24px rgba(0, 0, 0, 0.09),
                -12px -12px 24px rgba(255, 255, 255, 0.9);
        }

        .popup-button:active {
            box-shadow: 
                inset 5px 5px 10px rgba(0, 0, 0, 0.05),
                inset -5px -5px 10px rgba(255, 255, 255, 0.8);
        }
        
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }
        
        @keyframes pulse {
            0% { transform: scale(1); }
            50% { transform: scale(1.05); }
            100% { transform: scale(1); }
        }
        
        .pulse {
            animation: pulse 2s infinite;
        }
        
        /* Scrollbar styling */
        ::-webkit-scrollbar {
            width: 6px;
        }
        
        ::-webkit-scrollbar-track {
            background: transparent;
        }
        
        ::-webkit-scrollbar-thumb {
            background: rgba(76, 175, 80, 0.3);
            border-radius: 3px;
        }
        
        ::-webkit-scrollbar-thumb:hover {
            background: rgba(76, 175, 80, 0.5);
        }
        
        /* Responsive design */
        @media (max-width: 768px) {
            .container {
                flex-direction: column;
            }
            
            .left-panel {
                grid-template-columns: 1fr;
            }
            
            .card {
                padding: 20px;
            }
            
            .logo {
                font-size: 2.2rem;
            }
            
            .visualization-container {
                height: 150px;
            }
            
            .message {
                max-width: 90%;
                font-size: 0.9rem;
            }

            .popup-content {
                padding: 25px 20px;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <!-- Panel Kiri: Grid Lunchbox -->
        <div class="left-panel">
            <!-- Header Card -->
            <div class="card header-card">
                <div class="logo">MindSpace</div>
                <div class="tagline">Your AI Mental Wellness Companion</div>
                <div class="status-indicator">
                    <div class="status-dot"></div>
                    <div class="status-text">AI Counselor is online</div>
                </div>
            </div>
            
            <!-- Journal Card -->
            <div class="card feature-card" id="journal-btn">
                <div class="feature-icon">
                    <i class="fas fa-book"></i>
                </div>
                <div class="feature-title">Journal</div>
                <div class="feature-desc">Write your thoughts</div>
            </div>
            
            <!-- White Noise Card -->
            <div class="card feature-card" id="white-noise-btn">
                <div class="feature-icon">
                    <i class="fas fa-water"></i>
                </div>
                <div class="feature-title">White Noise</div>
                <div class="feature-desc">Calming sounds</div>
            </div>
            
            <!-- Meditation Card -->
            <div class="card feature-card" id="meditation-btn">
                <div class="feature-icon">
                    <i class="fas fa-spa"></i>
                </div>
                <div class="feature-title">Meditation</div>
                <div class="feature-desc">Guided sessions</div>
            </div>
            
            <!-- Breathing Card -->
            <div class="card feature-card" id="breathing-btn">
                <div class="feature-icon">
                    <i class="fas fa-wind"></i>
                </div>
                <div class="feature-title">Breathing</div>
                <div class="feature-desc">Relaxation exercises</div>
            </div>
            
            <!-- Mood Card -->
            <div class="card mood-card">
                <div class="mood-title">How are you feeling today?</div>
                <div class="mood-options">
                    <div class="mood-option" data-mood="happy">
                        <div class="mood-emoji">😊</div>
                        <div class="mood-label">Happy</div>
                    </div>
                    <div class="mood-option" data-mood="calm">
                        <div class="mood-emoji">😌</div>
                        <div class="mood-label">Calm</div>
                    </div>
                    <div class="mood-option" data-mood="sad">
                        <div class="mood-emoji">😢</div>
                        <div class="mood-label">Sad</div>
                    </div>
                    <div class="mood-option" data-mood="anxious">
                        <div class="mood-emoji">😰</div>
                        <div class="mood-label">Anxious</div>
                    </div>
                    <div class="mood-option" data-mood="angry">
                        <div class="mood-emoji">😠</div>
                        <div class="mood-label">Angry</div>
                    </div>
                    <div class="mood-option" data-mood="tired">
                        <div class="mood-emoji">😴</div>
                        <div class="mood-label">Tired</div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Panel Kanan: Visualisasi dan Chat -->
        <div class="right-panel">
            <div class="main-card">
                <div class="visualization-container">
                    <div class="audio-wave" id="audio-wave">
                        <!-- Audio wave bars akan di-generate oleh JavaScript -->
                    </div>
                </div>
                
                <div class="chat-container" id="chat-container">
                    <div class="message ai-message">
                        Hey! 👋 I'm your MindSpace AI. I'm here to listen and support you. What's on your mind today?
                    </div>
                </div>
                
                <div class="input-container">
                    <input type="text" class="message-input" id="message-input" placeholder="Type your message here...">
                    <button class="send-button" id="send-button">
                        <i class="fas fa-paper-plane"></i>
                    </button>
                </div>
                
                <div class="call-controls">
                    <button class="control-button" id="mic-button">
                        <i class="fas fa-microphone"></i>
                    </button>
                    <button class="control-button end-call" id="end-call">
                        <i class="fas fa-phone-slash"></i>
                    </button>
                    <button class="control-button" id="mood-button">
                        <i class="fas fa-smile"></i>
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Popup Menu -->
    <div class="popup-overlay" id="popup-overlay">
        <div class="popup-content">
            <button class="popup-close" id="popup-close">
                <i class="fas fa-times"></i>
            </button>
            
            <div class="popup-header">
                <div class="popup-icon" id="popup-icon">
                    <i class="fas fa-book"></i>
                </div>
                <h2 class="popup-title" id="popup-title">Journal</h2>
                <p class="popup-subtitle" id="popup-subtitle">Write and reflect on your thoughts</p>
            </div>
            
            <div class="popup-body">
                <p class="popup-description" id="popup-description">
                    Journaling helps process emotions and gain clarity. Write freely without judgment.
                </p>
                
                <div class="popup-features">
                    <div class="popup-feature">
                        <i class="fas fa-check-circle"></i>
                        <span id="feature-1">Private and secure storage</span>
                    </div>
                    <div class="popup-feature">
                        <i class="fas fa-check-circle"></i>
                        <span id="feature-2">Daily prompts and guidance</span>
                    </div>
                    <div class="popup-feature">
                        <i class="fas fa-check-circle"></i>
                        <span id="feature-3">Mood tracking integration</span>
                    </div>
                </div>
            </div>
            
            <div class="popup-action">
                <button class="popup-button" id="popup-start-btn">Start Journaling</button>
            </div>
        </div>
    </div>

    <script>
        // Inisialisasi audio wave
        const audioWave = document.getElementById('audio-wave');
        for (let i = 0; i < 40; i++) {
            const bar = document.createElement('div');
            bar.className = 'wave-bar';
            bar.style.height = `${Math.random() * 70 + 30}%`;
            audioWave.appendChild(bar);
        }
        
        // Animasi audio wave
        function animateAudioWave() {
            const bars = document.querySelectorAll('.wave-bar');
            bars.forEach(bar => {
                const newHeight = Math.random() * 70 + 30;
                bar.style.height = `${newHeight}%`;
                
                // Ubah warna berdasarkan tinggi
                if (newHeight > 80) {
                    bar.style.background = 'linear-gradient(to top, var(--dark-green), var(--primary))';
                } else if (newHeight > 50) {
                    bar.style.background = 'linear-gradient(to top, var(--primary), var(--secondary))';
                } else {
                    bar.style.background = 'linear-gradient(to top, var(--secondary), var(--light-green))';
                }
            });
        }
        
        setInterval(animateAudioWave, 300);
        
        // Fungsi chat
        const chatContainer = document.getElementById('chat-container');
        const messageInput = document.getElementById('message-input');
        const sendButton = document.getElementById('send-button');
        
        function addMessage(text, isUser) {
            const messageDiv = document.createElement('div');
            messageDiv.className = `message ${isUser ? 'user-message' : 'ai-message'}`;
            messageDiv.textContent = text;
            chatContainer.appendChild(messageDiv);
            chatContainer.scrollTop = chatContainer.scrollHeight;
        }
        
        function sendMessage() {
            const message = messageInput.value.trim();
            if (message) {
                addMessage(message, true);
                messageInput.value = '';
                
                // Simulasi respons AI
                setTimeout(() => {
                    const responses = [
                        "I hear you. That sounds challenging. Tell me more about how that makes you feel.",
                        "Thanks for sharing that with me. It takes courage to open up. How are you coping with these feelings?",
                        "I understand. Remember that your feelings are valid. What do you think might help you feel better?",
                        "I'm here for you. Let's work through this together. What's one small thing that usually brings you comfort?",
                        "That sounds really tough. Be gentle with yourself today. Is there something that usually helps when you feel this way?"
                    ];
                    const randomResponse = responses[Math.floor(Math.random() * responses.length)];
                    addMessage(randomResponse, false);
                }, 1500);
            }
        }
        
        sendButton.addEventListener('click', sendMessage);
        
        messageInput.addEventListener('keypress', (e) => {
            if (e.key === 'Enter') {
                sendMessage();
            }
        });
        
        // Event listener untuk tombol kontrol
        const micButton = document.getElementById('mic-button');
        micButton.addEventListener('click', function() {
            this.classList.toggle('active');
            if (this.classList.contains('active')) {
                this.innerHTML = '<i class="fas fa-microphone-slash"></i>';
            } else {
                this.innerHTML = '<i class="fas fa-microphone"></i>';
            }
        });
        
        document.getElementById('end-call').addEventListener('click', function() {
            if (confirm('End this session?')) {
                alert('Session ended. Take care of yourself! 💚');
            }
        });
        
        document.getElementById('mood-button').addEventListener('click', function() {
            const moods = ['😊', '😢', '😡', '😴', '😰', '😎'];
            const randomMood = moods[Math.floor(Math.random() * moods.length)];
            addMessage(`Current mood: ${randomMood}`, true);
        });
        
        // Popup functionality
        const popupOverlay = document.getElementById('popup-overlay');
        const popupClose = document.getElementById('popup-close');
        const popupIcon = document.getElementById('popup-icon');
        const popupTitle = document.getElementById('popup-title');
        const popupSubtitle = document.getElementById('popup-subtitle');
        const popupDescription = document.getElementById('popup-description');
        const feature1 = document.getElementById('feature-1');
        const feature2 = document.getElementById('feature-2');
        const feature3 = document.getElementById('feature-3');
        const popupStartBtn = document.getElementById('popup-start-btn');
        
        // Data untuk setiap menu
        const menuData = {
            'journal': {
                icon: 'fas fa-book',
                title: 'Journal',
                subtitle: 'Write and reflect on your thoughts',
                description: 'Journaling helps process emotions and gain clarity. Write freely without judgment in your personal digital space.',
                features: [
                    'Private and secure storage',
                    'Daily prompts and guidance',
                    'Mood tracking integration'
                ],
                buttonText: 'Start Journaling'
            },
            'white-noise': {
                icon: 'fas fa-water',
                title: 'White Noise',
                subtitle: 'Calming sounds for focus and relaxation',
                description: 'Immerse yourself in soothing ambient sounds that can help reduce anxiety, improve focus, and promote better sleep.',
                features: [
                    '10+ calming soundscapes',
                    'Customizable volume mixing',
                    'Timer and sleep functions'
                ],
                buttonText: 'Play Sounds'
            },
            'meditation': {
                icon: 'fas fa-spa',
                title: 'Mindfulness',
                subtitle: 'Guided meditation and awareness practices',
                description: 'Develop mindfulness through guided meditation sessions tailored to your current emotional state and experience level.',
                features: [
                    'Beginner to advanced sessions',
                    'Breathing awareness exercises',
                    'Progress tracking'
                ],
                buttonText: 'Begin Practice'
            },
            'breathing': {
                icon: 'fas fa-wind',
                title: 'Breathing',
                subtitle: 'Relaxation and stress relief exercises',
                description: 'Follow guided breathing patterns designed to calm your nervous system, reduce stress, and increase mental clarity.',
                features: [
                    '4-7-8 breathing technique',
                    'Box breathing method',
                    'Customizable intervals'
                ],
                buttonText: 'Start Exercise'
            }
        };
        
        // Fungsi untuk membuka popup
        function openPopup(menuType) {
            const data = menuData[menuType];
            
            popupIcon.innerHTML = `<i class="${data.icon}"></i>`;
            popupTitle.textContent = data.title;
            popupSubtitle.textContent = data.subtitle;
            popupDescription.textContent = data.description;
            feature1.textContent = data.features[0];
            feature2.textContent = data.features[1];
            feature3.textContent = data.features[2];
            popupStartBtn.textContent = data.buttonText;
            
            popupOverlay.classList.add('active');
            document.body.style.overflow = 'hidden';
        }
        
        // Fungsi untuk menutup popup
        function closePopup() {
            popupOverlay.classList.remove('active');
            document.body.style.overflow = 'auto';
        }
        
        // Event listener untuk feature cards
        document.getElementById('journal-btn').addEventListener('click', function() {
            openPopup('journal');
        });
        
        document.getElementById('white-noise-btn').addEventListener('click', function() {
            openPopup('white-noise');
        });
        
        document.getElementById('meditation-btn').addEventListener('click', function() {
            openPopup('meditation');
        });
        
        document.getElementById('breathing-btn').addEventListener('click', function() {
            openPopup('breathing');
        });
        
        // Event listener untuk tombol close popup
        popupClose.addEventListener('click', closePopup);
        popupOverlay.addEventListener('click', function(e) {
            if (e.target === popupOverlay) {
                closePopup();
            }
        });
        
        // Event listener untuk tombol start di popup
        popupStartBtn.addEventListener('click', function() {
            const title = popupTitle.textContent;
            addMessage(`Starting ${title} session... 🚀`, false);
            closePopup();
        });
        
        // Event listener untuk mood options
        const moodOptions = document.querySelectorAll('.mood-option');
        moodOptions.forEach(option => {
            option.addEventListener('click', function() {
                const mood = this.getAttribute('data-mood');
                const moodLabels = {
                    'happy': 'Happy 😊',
                    'calm': 'Calm 😌', 
                    'sad': 'Sad 😢',
                    'anxious': 'Anxious 😰',
                    'angry': 'Angry 😠',
                    'tired': 'Tired 😴'
                };
                
                addMessage(`I'm feeling ${moodLabels[mood]} today.`, true);
                
                // Berikan respons berdasarkan mood
                setTimeout(() => {
                    let response = "";
                    switch(mood) {
                        case 'happy':
                            response = "That's wonderful! 😊 I'm glad you're feeling happy today. What's bringing you joy?";
                            break;
                        case 'calm':
                            response = "Peaceful and calm - that's a beautiful state to be in. 🍃 Enjoy this moment of tranquility.";
                            break;
                        case 'sad':
                            response = "I'm sorry you're feeling sad. 💚 It's okay to feel this way. Would you like to talk about what's bothering you?";
                            break;
                        case 'anxious':
                            response = "Anxiety can be really challenging. 🫂 Let's try some breathing exercises together to help calm your nerves.";
                            break;
                        case 'angry':
                            response = "Anger is a valid emotion. 🔥 Let's explore what's causing these feelings in a safe space.";
                            break;
                        case 'tired':
                            response = "It sounds like you could use some rest. 💤 Remember to be kind to yourself when you're feeling tired.";
                            break;
                    }
                    addMessage(response, false);
                }, 1000);
            });
        });
        
        // Auto-focus pada input
        messageInput.focus();
    </script>
</body>
</html>