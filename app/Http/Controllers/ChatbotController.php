<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Log;

class ChatbotController extends Controller
{
    private $geminiApiKey;
    private $apiUrl = 'https://generativelanguage.googleapis.com/v1beta/models/gemini-2.0-flash:generateContent';

    public function __construct()
    {
        $this->geminiApiKey = env('GEMINI_API_KEY');
        
        // Debugging
        Log::info('Gemini API Key exists: ' . (!empty($this->geminiApiKey) ? 'Yes' : 'No'));
    }

    public function index()
    {
        // Initialize session for chat history if not exists
        if (!Session::has('chat_history')) {
            Session::put('chat_history', []);
        }

        return view('curhat.index', [
            'chatHistory' => Session::get('chat_history', []),
            'user' => auth()->user()
        ]);
    }

    public function send(Request $request)
    {
        $request->validate([
            'message' => 'required|string|max:1000'
        ]);

        $userMessage = $request->message;
        $chatHistory = Session::get('chat_history', []);

        // Add user message to history
        $chatHistory[] = [
            'role' => 'user',
            'message' => $userMessage,
            'timestamp' => now()
        ];

        // Get AI response
        $aiResponse = $this->getGeminiResponse($userMessage, $chatHistory);

        // Add AI response to history
        $chatHistory[] = [
            'role' => 'assistant',
            'message' => $aiResponse,
            'timestamp' => now()
        ];

        // Store updated history in session (limit to last 10 messages)
        if (count($chatHistory) > 10) {
            $chatHistory = array_slice($chatHistory, -10);
        }
        
        Session::put('chat_history', $chatHistory);

        return response()->json([
            'success' => true,
            'response' => $aiResponse,
            'history' => $chatHistory
        ]);
    }

    public function clear()
    {
        Session::forget('chat_history');
        
        return response()->json([
            'success' => true,
            'message' => 'Chat cleared successfully'
        ]);
    }

    private function getGeminiResponse($userMessage, $chatHistory)
    {
        try {
            // Prepare conversation context
            $context = $this->buildContext($chatHistory);
            
            // Prepare prompt with Wilson's personality
            $prompt = $this->getWilsonPrompt($context, $userMessage);

            Log::info('Sending request to Gemini API');
            Log::info('Prompt length: ' . strlen($prompt));

            $response = Http::withHeaders([
                'Content-Type' => 'application/json',
            ])->post("{$this->apiUrl}?key={$this->geminiApiKey}", [
                'contents' => [
                    [
                        'parts' => [
                            ['text' => $prompt]
                        ]
                    ]
                ],
                'generationConfig' => [
                    'temperature' => 0.7,
                    'topK' => 40,
                    'topP' => 0.95,
                    'maxOutputTokens' => 1024,
                ],
                'safetySettings' => [
                    [
                        'category' => 'HARM_CATEGORY_HARASSMENT',
                        'threshold' => 'BLOCK_MEDIUM_AND_ABOVE'
                    ],
                    [
                        'category' => 'HARM_CATEGORY_HATE_SPEECH',
                        'threshold' => 'BLOCK_MEDIUM_AND_ABOVE'
                    ],
                    [
                        'category' => 'HARM_CATEGORY_SEXUALLY_EXPLICIT',
                        'threshold' => 'BLOCK_MEDIUM_AND_ABOVE'
                    ],
                    [
                        'category' => 'HARM_CATEGORY_DANGEROUS_CONTENT',
                        'threshold' => 'BLOCK_MEDIUM_AND_ABOVE'
                    ]
                ]
            ]);

            Log::info('Gemini API Response Status: ' . $response->status());
            
            if ($response->successful()) {
                $data = $response->json();
                Log::info('Gemini API Response Data: ', $data);
                
                if (isset($data['candidates'][0]['content']['parts'][0]['text'])) {
                    return $data['candidates'][0]['content']['parts'][0]['text'];
                }
                
                // Check for errors in response
                if (isset($data['error'])) {
                    Log::error('Gemini API Error: ' . json_encode($data['error']));
                    return "Maaf, ada kesalahan teknis. Coba lagi ya!";
                }
            } else {
                $errorData = $response->json();
                Log::error('Gemini API Failed: ' . $response->status());
                Log::error('Error Details: ', $errorData);
                
                // Return fallback response
                return "Hmm, Wilson sedang berpikir... Mungkin coba cerita dengan kata-kata yang berbeda?";
            }

            return "Wilson: Aku di sini untuk mendengarkan. Ceritakan lebih lanjut ya!";

        } catch (\Exception $e) {
            Log::error('Gemini API Exception: ' . $e->getMessage());
            Log::error('Stack Trace: ' . $e->getTraceAsString());
            return "Hmm... sepertinya ada gangguan teknis. Mau coba cerita lagi?";
        }
    }

    private function buildContext($chatHistory)
    {
        $context = "";
        foreach ($chatHistory as $chat) {
            $role = $chat['role'] == 'user' ? 'Pengguna' : 'Wilson';
            $context .= "{$role}: {$chat['message']}\n";
        }
        return $context;
    }

    private function getWilsonPrompt($context, $currentMessage)
    {
        // Gunakan HEREDOC syntax untuk string yang panjang
        return <<<PROMPT
Kamu adalah Wilson, seorang teman curhat AI yang ramah, empatik, dan supportive.

**Personality Wilson:**
1. Nama: Wilson (nama panggilan: Will)
2. Usia: 25 tahun (virtual)
3. Personality: Hangat, sabar, tidak judgmental, punya selera humor ringan
4. Background: Lulusan psikologi yang sekarang jadi 'teman virtual' untuk mendengarkan
5. Bahasa: Casual Indonesia, friendly, pakai kata-kata: "ya", "wah", "oh gitu", "aku ngerti"
6. Kebiasaan: Suka kasih emoji sesekali 😊, kadang kasih pertanyaan lanjutan
7. Prinsip: "Setiap perasaan valid, yang penting bagaimana kita menyikapinya"

**Aturan Respons:**
1. Dengarkan aktif - akuin perasaan user
2. Beri validasi emosional
3. Jangan kasih solusi langsung, tapi bantu user eksplorasi
4. Gunakan kalimat pendek & natural
5. Sesekali kasih pertanyaan reflektif
6. JANGAN diagnosa atau kasih saran medis
7. Tetap dalam batasan teman curhat, bukan terapis

**Konteks percakapan sebelumnya:**
$context

**Pesan pengguna baru:**
$currentMessage

**Instruksi khusus untuk Wilson:**
- Balas sebagai Wilson dengan personality di atas
- Gunakan bahasa sehari-hari yang natural
- Max 3 kalimat per respon
- Fokus pada mendengarkan dan memahami
- Boleh kasih 1-2 emoji jika pas
- Jangan terlalu formal
- Jika user cerita masalah berat, validasi dulu sebelum tanya lebih lanjut

**Wilson, silakan respon:**
PROMPT;
    }
}