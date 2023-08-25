<?php
?>
<!DOCTYPE html>
<html>

<head>
    <title>AI绘画--苏音</title>
    <style>
       body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f1f1f1;
        }

        .container {
            max-width: 500px;
            margin: 0 auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 5px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
        }

        h1 {
            font-size: 24px;
            text-align: center;
            margin-bottom: 20px;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-group label {
            display: block;
            font-size: 16px;
            margin-bottom: 5px;
        }

        .form-group input[type="text"] {
            width: 100%;
            padding: 10px;
            font-size: 16px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        .form-group button {
            display: block;
            width: 100%;
            padding: 10px;
            font-size: 16px;
            background-color: #4caf50;
            color: #fff;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        .styled-select {
            position: relative;
            display: block;
            width: 100%;
            height: 40px;
            background-color: #fff;
            border: 1px solid #ccc;
            border-radius: 4px;
            padding: 0 10px;
            font-size: 16px;
            color: #333;
            cursor: pointer;
        }

        .styled-select::after {
            content: "\25BC";
            position: absolute;
            top: 50%;
            right: 10px;
            transform: translateY(-50%);
            font-size: 16px;
        }

        .styled-select select {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            opacity: 0;
            cursor: pointer;
        }

        #result {
            text-align: center;
            margin-top: 30px;
        }

        #result .loader {
            display: none;
            margin: 0 auto;
            width: 50px;
            height: 50px;
            border: 5px solid #f3f3f3;
            border-top: 5px solid #3498db;
            border-radius: 50%;
            animation: spin 2s linear infinite;
        }

        #result img {
            max-width: 100%;
            height: auto;
            display: none;
            margin-top: 20px;
        }

        @media only screen and (max-width: 600px) {
            .container {
                max-width: 100%;
                border-radius: 0;
                box-shadow: none;
                padding: 10px;
            }

            .form-group input[type="text"],
            .form-group button {
                font-size: 14px;
            }
        }

        @keyframes spin {
            0% {
                transform: rotate(0deg);
            }

            100% {
                transform: rotate(360deg);
            }
        }
    </style>
</head>

<body>
    <div class="container">
        <h1>AI绘画苏音</h1>
        <div class="form-group">
            <label for="prompt">请输入关键词：</label>
            <input type="text" id="prompt" placeholder="AI绘画描述词，越详细越好" />
        </div>
        <div class="form-group">
            <label for="styles">选择风格：</label>
            <select id="styles" class="styled-select">
                  <option value="101">水墨画</option>
                <option value="102">概念艺术</option>
                <option value="103">油画</option>
                <option value="104">水彩画</option>
                <option value="106">厚涂风格</option>
                <option value="107">插画</option>
                <option value="108">剪纸风格</option>
                <option value="109">印象派</option>
                <option value="110">2.5D</option>
                <option value="111">肖像画</option>
                <option value="112">黑白素描画</option>
                <option value="113">赛博朋克</option>
                <option value="114">科幻风格</option>
                <option value="115">暗黑风格</option>
                <option value="201">日系动漫</option>
                <option value="202">怪兽风格</option>
                <option value="301">游戏卡通手绘</option>
                <option value="401">通用写实风格</option>
            </select>
        </div>
        <div class="form-group">
            <button onclick="callAPI()">开始生成</button>
        </div>
        <div id="result">
            <div class="loader"></div>
            <img id="result-image" />
        </div>
        <div id="remaining-count">
            剩余次数: <span id="count"></span>
        </div>
    </div>

    <script>
        // 从localStorage获取剩余次数，如果不存在则设置为初始值3
        var remainingCount = localStorage.getItem("remainingCount") || 20;

        function callAPI() {
            if (remainingCount <= 0) {
                alert("每个IP只能成功调用三十次接口。");
                return;
            }

            var userPrompt = document.getElementById("prompt").value;
            var stylesSelect = document.getElementById("styles");
            var selectedStyle = stylesSelect.value;

            if (userPrompt.trim() === "") {
                alert("请输入关键词");
                return;
            }

            if (!isValidStyle(selectedStyle)) {
                alert("请选择有效的风格");
                return;
            }

            var url =
                "你的网站/proxy.php?prompt=" +
                encodeURIComponent(userPrompt) +
                "&Styles=" +
                selectedStyle;

            var loader = document.querySelector("#result .loader");
            loader.style.display = "block";

            var xhr = new XMLHttpRequest();
            xhr.onreadystatechange = function() {
                if (xhr.readyState === XMLHttpRequest.DONE) {
                    loader.style.display = "none";

                    if (xhr.status === 200) {
                        var response = JSON.parse(xhr.responseText);
                        var resultImage = response.ResultImage;
                        displayImage(resultImage);

                        // 减少剩余次数并更新页面上的显示
                        remainingCount--;
                        document.getElementById("count").innerText = remainingCount;

                        // 将剩余次数存储在localStorage中
                        localStorage.setItem("remainingCount", remainingCount);
                    } else {
                        console.error("请求发生错误");
                    }
                }
            };

            xhr.open("GET", url, true);
            xhr.send();
        }

        function displayImage(base64Data) {
            var image = document.getElementById("result-image");
            image.src = "data:image/png;base64," + base64Data;
            image.style.display = "block";
        }

        function isValidStyle(style) {
            return /^[0-9]+$/.test(style);
        }
    </script>
</body>

</html>
