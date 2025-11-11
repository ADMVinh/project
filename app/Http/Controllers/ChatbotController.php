<?php

namespace App\Http\Controllers;

use App\Services\GeminiService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class ChatbotController extends Controller
{
    protected $geminiService;

    public function __construct(GeminiService $geminiService)
    {
        $this->geminiService = $geminiService;
    }

    /**
     * Xử lý tin nhắn từ chatbot
     */
    public function sendMessage(Request $request)
    {
        $request->validate([
            'message' => 'required|string|max:1000'
        ]);

        $message = $request->input('message');
        
        // Lấy lịch sử hội thoại từ session
        $conversationHistory = Session::get('chatbot_history', []);
        
        // Gửi tin nhắn đến Gemini
        $response = $this->geminiService->chat($message, $conversationHistory);
        
        if ($response['success']) {
            // Lưu tin nhắn vào lịch sử
            $conversationHistory[] = [
                'role' => 'user',
                'content' => $message
            ];
            $conversationHistory[] = [
                'role' => 'model',
                'content' => $response['message']
            ];
            
            // Giới hạn lịch sử 10 tin nhắn gần nhất (5 cặp hỏi-đáp)
            if (count($conversationHistory) > 10) {
                $conversationHistory = array_slice($conversationHistory, -10);
            }
            
            Session::put('chatbot_history', $conversationHistory);
        }
        
        return response()->json($response);
    }

    /**
     * Xóa lịch sử hội thoại
     */
    public function clearHistory()
    {
        Session::forget('chatbot_history');
        
        return response()->json([
            'success' => true,
            'message' => 'Đã xóa lịch sử hội thoại'
        ]);
    }

    /**
     * Lấy lịch sử hội thoại
     */
    public function getHistory()
    {
        $history = Session::get('chatbot_history', []);
        
        return response()->json([
            'success' => true,
            'history' => $history
        ]);
    }

    /**
     * Gợi ý câu hỏi nhanh
     */
    public function quickQuestions()
    {
        $questions = [
            'Chính sách đổi trả như thế nào?',
            'Các hình thức thanh toán?',
            'Thời gian giao hàng bao lâu?',
            'Có miễn phí vận chuyển không?',
            'Làm sao để theo dõi đơn hàng?',
        ];
        
        return response()->json([
            'success' => true,
            'questions' => $questions
        ]);
    }
}