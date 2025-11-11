<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class GeminiService
{
    protected $apiKey;
    protected $apiUrl;
    protected $model;

    public function __construct()
    {
        $this->apiKey = config('services.gemini.api_key');
        $this->model = config('services.gemini.model', 'gemini-pro');
        $this->apiUrl = "https://generativelanguage.googleapis.com/v1beta/models/{$this->model}:generateContent";
    }

    /**
     * Gửi tin nhắn đến Gemini và nhận phản hồi
     */
    public function chat($message, $conversationHistory = [])
    {
        try {
            // Chuẩn bị context cho chatbot về website
            $systemContext = $this->getSystemContext();
            
            // Tạo contents array với lịch sử hội thoại
            $contents = [];
            
            // Thêm system context
            if (!empty($systemContext)) {
                $contents[] = [
                    'role' => 'user',
                    'parts' => [['text' => $systemContext]]
                ];
                $contents[] = [
                    'role' => 'model',
                    'parts' => [['text' => 'Tôi hiểu. Tôi sẽ hỗ trợ khách hàng về cửa hàng của bạn.']]
                ];
            }
            
            // Thêm lịch sử hội thoại
            foreach ($conversationHistory as $msg) {
                $contents[] = [
                    'role' => $msg['role'],
                    'parts' => [['text' => $msg['content']]]
                ];
            }
            
            // Thêm tin nhắn hiện tại
            $contents[] = [
                'role' => 'user',
                'parts' => [['text' => $message]]
            ];

            $response = Http::timeout(30)
                ->post($this->apiUrl . '?key=' . $this->apiKey, [
                    'contents' => $contents,
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
                    ]
                ]);

            if ($response->successful()) {
                $data = $response->json();
                
                if (isset($data['candidates'][0]['content']['parts'][0]['text'])) {
                    return [
                        'success' => true,
                        'message' => $data['candidates'][0]['content']['parts'][0]['text'],
                        'data' => $data
                    ];
                }
                
                return [
                    'success' => false,
                    'message' => 'Xin lỗi, tôi không thể tạo phản hồi phù hợp lúc này.',
                    'error' => 'No content in response'
                ];
            }

            Log::error('Gemini API Error: ' . $response->body());
            
            return [
                'success' => false,
                'message' => 'Xin lỗi, có lỗi xảy ra khi kết nối với AI.',
                'error' => $response->body()
            ];

        } catch (\Exception $e) {
            Log::error('Gemini Service Exception: ' . $e->getMessage());
            
            return [
                'success' => false,
                'message' => 'Xin lỗi, hệ thống đang gặp sự cố. Vui lòng thử lại sau.',
                'error' => $e->getMessage()
            ];
        }
    }

    /**
     * Tạo context về website cho chatbot
     */
    protected function getSystemContext()
    {
        return "Bạn là trợ lý AI thông minh của một cửa hàng thương mại điện tử. 
        
Thông tin về cửa hàng:
- Tên: " . config('app.name') . "
- Chúng tôi bán các sản phẩm thời trang, phụ kiện, và hàng gia dụng
- Chúng tôi có chính sách đổi trả trong vòng 7 ngày
- Miễn phí vận chuyển cho đơn hàng trên 500,000 VNĐ
- Hỗ trợ thanh toán: COD, VNPay

Nhiệm vụ của bạn:
1. Trả lời câu hỏi của khách hàng về sản phẩm, chính sách, đơn hàng
2. Hướng dẫn khách hàng mua sắm
3. Giải đáp thắc mắc về vận chuyển, thanh toán
4. Luôn lịch sự, thân thiện và chuyên nghiệp
5. Trả lời bằng tiếng Việt
6. Nếu không biết thông tin cụ thể, hãy khuyên khách hàng liên hệ hotline hoặc email hỗ trợ

Hãy trả lời ngắn gọn, rõ ràng và hữu ích.";
    }

    /**
     * Tạo gợi ý sản phẩm
     */
    public function suggestProducts($query)
    {
        $message = "Khách hàng đang tìm kiếm: {$query}. 
        Hãy đề xuất 3-5 từ khóa hoặc loại sản phẩm phù hợp mà cửa hàng thời trang có thể có. 
        Chỉ liệt kê tên sản phẩm, không giải thích.";
        
        return $this->chat($message);
    }
}