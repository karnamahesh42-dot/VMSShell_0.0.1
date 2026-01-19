<?php
// Hide directory listing by showing a clean message
http_response_code(404);
?>
<!DOCTYPE html>
<html>
<head>
    <title>Invalid URL</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f8f8f8;
            text-align: center;
            padding-top: 80px;
            color: #333;
        }
        .box {
            background: #fff;
            padding: 40px;
            display: inline-block;
            border-radius: 10px;
            box-shadow: 0 0 15px rgba(0,0,0,0.1);
        }
        h1 {
            color: #d9534f;
            margin-bottom: 10px;
        }
        p {
            font-size: 18px;
        }
    </style>
</head>
<body>

<div class="box">
    <h1>Invalid URL</h1>
    <p>The page you are trying to access is not available.</p>
</div>

</body>
</html>
