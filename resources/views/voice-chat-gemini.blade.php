<!DOCTYPE html>
<html>
<head>
    <title>Voice Chat dengan Gemini</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <style>
        .voice-chat-container {
            max-width: 800px;
            margin: 0 auto;
            padding: 20px;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
        }
        
        .chat-wrapper {
            background: white;
            border-radius: 20px;
            padding: 30px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.2);
        }
        
        .chat-box {
            height: 400px;
            border: 2px solid #e0e0e0;
            border-radius: 15px;
            padding: 20px;
            margin-bottom: 20px;
            overflow-y: auto;
            background: #fafafa;
        }
        
        .message {
            margin: 15px 0;
            padding: 12px 18px;
            border-radius: 18px;
            max-width: 70%;
            word-wrap: break-word;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
            animation: fadeIn 0.3s ease-in;
            line-height: 1.4;
        }
        
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }
        
        .user-message {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            margin-left: auto;
            margin-right: 0;
        }
        
        .ai-message {
            background: white;
            color: #333;
            border: 1px solid #e0e0e0;
        }
        
        .controls {
            text-align: center;
            padding: 20px;
        }
        
        .record-btn {
            padding: 20px 40px;
            font-size: 18px;
            border: none;
            border-radius: 50px;
            cursor: pointer;
            margin: 10px;
            transition: all 0.3s ease;
            font-weight: bold;
            box-shadow: 0 4px 15px rgba(0,0,0,0.2);
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
        }
        
        .record-btn.recording {
            background: linear-gradient(135deg, #ff6b6b 0%, #ee5a24 100%);
            color: white;
            animation: pulse 1.5s infinite;
            transform: scale(1.05);
        }
        
        .record-btn.idle {
            background: linear-gradient(135deg, #4ecdc4 0%, #44a08d 100%);
            color: white;
        }
        
        .record-btn:disabled {
            background: #cccccc;
            cursor: not-allowed;
            transform: none !important;
            animation: none !important;
        }
        
        @keyframes pulse {
            0% { transform: scale(1); box-shadow: 0 4px 15px rgba(255,107,107,0.4); }
            50% { transform: scale(1.05); box-shadow: 0 6px 20px rgba(255,107,107,0.6); }
            100% { transform: scale(1); box-shadow: 0 4px 15px rgba(255,107,107,0.4); }
        }
        
        .status {
            text-align: center;
            margin: 10px 0;
            font-style: italic;
            color: #666;
            min-height: 20px;
            font-weight: 500;
        }
        
        .audio-controls {
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 15px;
            margin-top: 15px;
        }
        
        .audio-btn {
            padding: 10px 20px;
            border: none;
            border-radius: 25px;
            background: #667eea;
            color: white;
            cursor: pointer;
            font-size: 14px;
            transition: background 0.3s;
        }
        
        .audio-btn:hover {
            background: #5a6fd8;
        }
        
        .audio-btn:disabled {
            background: #cccccc;
            cursor: not-allowed;
        }
        
        .typing-indicator {
            display: inline-block;
            padding: 10px 15px;
            background: #f0f0f0;
            border-radius: 15px;
            color: #666;
            font-style: italic;
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
            margin: 15px 0;
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 3px;
        }
        
        .bar {
            width: 4px;
            height: 20px;
            background: #4ecdc4;
            border-radius: 2px;
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
            background: #f0f0f0;
            padding: 2px 8px;
            border-radius: 10px;
            font-size: 0.8em;
            color: #666;
            margin-right: 5px;
            border: 1px solid #ddd;
        }
        
        .voice-selector {
            margin: 15px 0;
            text-align: center;
        }
        
        .voice-selector select {
            padding: 8px 15px;
            border-radius: 20px;
            border: 1px solid #ddd;
            background: white;
            font-size: 14px;
        }
        
        .voice-preview {
            margin-top: 10px;
            font-size: 12px;
            color: #666;
        }
    </style>
</head>
<body>
    <div class="voice-chat-container">
        <div class="chat-wrapper">
            <h1 style="text-align: center; color: #333; margin-bottom: 10px;">
                🎤 Voice Chat Natural dengan Gemini AI
            </h1>
            <p style="text-align: center; color: #666; margin-bottom: 20px;">
                Suara realistis dengan emosi natural dan ekspresi
            </p>
            
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

    <script src="{{ asset('js/dashboard.js') }}">
    
</script>
</body>
</html>