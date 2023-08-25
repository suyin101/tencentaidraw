<?php

//
$apiUrl = '你的网站/draw.php';
$prompt = $_GET['prompt'];
$styles = $_GET['Styles'];

// 检查风格参数是否为整数数字
if (!is_numeric($styles)) {
    // 风格参数无效，返回错误响应
    $response = array(
        'error' => 'Invalid Styles parameter'
    );
    header('Content-Type: application/json');
    echo json_encode($response);
    exit;
}

// 构建请求 URL，包括风格参数
$requestUrl = $apiUrl . '?prompt=' . urlencode($prompt) . '&Styles=' . urlencode($styles);

// 发起请求并获取响应
$response = file_get_contents($requestUrl);

// 将响应发送回前端
header('Content-Type: application/json');
echo $response;   
