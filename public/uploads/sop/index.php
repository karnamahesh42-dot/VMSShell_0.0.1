<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Access Restricted</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Font Awesome (optional for icon) -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" rel="stylesheet">

    <style>
        body {
            margin: 0;
            height: 100vh;
            font-family: Arial, sans-serif;
            background: linear-gradient(135deg, #1d2671, #c33764);
            display: flex;
            align-items: center;
            justify-content: center;
            color: #fff;
        }

        .card {
            background: rgba(0,0,0,0.35);
            padding: 30px 40px;
            border-radius: 12px;
            text-align: center;
            max-width: 420px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.4);
        }

        .card i {
            font-size: 60px;
            color: #ffc107;
            margin-bottom: 15px;
        }

        .card h1 {
            font-size: 22px;
            margin-bottom: 10px;
        }

        .card p {
            font-size: 14px;
            opacity: 0.9;
            margin-bottom: 25px;
        }

        .card a {
            display: inline-block;
            padding: 10px 22px;
            background: #ffc107;
            color: #000;
            text-decoration: none;
            font-weight: bold;
            border-radius: 6px;
            transition: 0.3s;
        }

        .card a:hover {
            background: #ffdb4d;
        }

        .footer {
            margin-top: 15px;
            font-size: 12px;
            opacity: 0.7;
        }
    </style>
</head>
<body>

<div class="card">
    <i class="fas fa-lock"></i>
    <h1>Access Restricted</h1>
    <p>
        You are trying to access a secured directory directly.<br>
        This area is protected and requires proper authorization.
    </p>
    <div class="footer">
        © Access360
    </div>
</div>

</body>
</html>
