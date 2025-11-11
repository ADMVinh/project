<?php

if (!function_exists('formatVND')) {
    function formatVND($number) {
        // Ép kiểu sang float trước khi format
        $number = floatval(str_replace(',', '', $number)); 
        return number_format($number, 0, ',', '.') . ' ₫';
    }
}
