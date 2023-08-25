<?php
require_once 'vendor/autoload.php';

use TencentCloud\Common\Credential;
use TencentCloud\Common\Profile\ClientProfile;
use TencentCloud\Common\Profile\HttpProfile;
use TencentCloud\Common\Exception\TencentCloudSDKException;
use TencentCloud\Aiart\V20221229\AiartClient;
use TencentCloud\Aiart\V20221229\Models\TextToImageRequest;

try {
    // 实例化一个认证对象，入参需要传入腾讯云账户 SecretId 和 SecretKey
    // 请注意保密密钥，不要将真实密钥泄露在代码中
    $cred = new Credential("你的SecretId", "你的SecretKey");

    // 实例化一个 HTTP 选项，可选的，没有特殊需求可以跳过
    $httpProfile = new HttpProfile();
    $httpProfile->setEndpoint("aiart.tencentcloudapi.com");

    // 实例化一个 ClientProfile 对象，可选的，没有特殊需求可以跳过
    $clientProfile = new ClientProfile();
    $clientProfile->setHttpProfile($httpProfile);

    // 实例化要请求产品的 Client 对象
    $client = new AiartClient($cred, "ap-shanghai", $clientProfile);

    // 实例化一个 TextToImageRequest 对象
    $req = new TextToImageRequest();
    $userInput = $_GET['prompt'];
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

    $params = array(
        "Prompt" => $userInput,
        "Styles" => array(strval($styles)) // 将风格参数转换为字符串
    );
    $req->fromJsonString(json_encode($params));

    // 返回的 resp 是一个 TextToImageResponse 对象，与请求对象对应
    $resp = $client->TextToImage($req);

    // 输出 json 格式的字符串响应
    header('Content-Type: application/json');
    echo $resp->toJsonString();
} catch (TencentCloudSDKException $e) {
    echo $e;
}
