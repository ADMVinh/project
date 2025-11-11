<?php
// File: public/test-gemini.php
// Truy cập: http://localhost:8000/test-gemini.php

$apiKey = 'AIzaSyCfJyvxoJ-uOfqOzWNeuIxzYbc-Stj8uyw';
$url = 'https://generativelanguage.googleapis.com/v1beta/models/gemini-pro:generateContent?key=' . $apiKey;

$data = [
    'contents' => [
        [
            'parts' => [
                ['text' => 'Xin chào, bạn là ai?']
            ]
        ]
    ]
];

$ch = curl_init($url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
curl_setopt($ch, CURLOPT_HTTPHEADER, [
    'Content-Type: application/json'
]);

$response = curl_exec($ch);
$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
curl_close($ch);

echo "<h2>HTTP Code: $httpCode</h2>";
echo "<h3>Response:</h3>";
echo "<pre>" . print_r(json_decode($response, true), true) . "</pre>";

if ($httpCode !== 200) {
    echo "<h3 style='color: red;'>Có lỗi xảy ra!</h3>";
    echo "<p>Vui lòng kiểm tra:</p>";
    echo "<ul>";
    echo "<li>API Key có đúng không?</li>";
    echo "<li>API Key đã được enable chưa?</li>";
    echo "<li>Có kết nối internet không?</li>";
    echo "</ul>";
}
?>