<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Golf Tournament Portal</title>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Montserrat', Arial, sans-serif;
            background: linear-gradient(135deg, #e0f7fa 0%, #a7ffeb 100%);
            min-height: 100vh;
            margin: 0;
            padding: 0;
        }
        .container {
            max-width: 700px;
            margin: 60px auto;
            background: #fff;
            border-radius: 18px;
            box-shadow: 0 8px 32px rgba(44, 62, 80, 0.15);
            padding: 40px 32px 32px 32px;
            text-align: center;
        }
        .golf-icon {
            font-size: 70px;
            color: #43a047;
            margin-bottom: 10px;
        }
        h1 {
            font-size: 2.7rem;
            color: #2e7d32;
            margin-bottom: 10px;
        }
        .subtitle {
            font-size: 1.2rem;
            color: #388e3c;
            margin-bottom: 30px;
        }
        .actions {
            margin-top: 30px;
            display: flex;
            flex-direction: column;
            gap: 18px;
        }
        .actions a {
            display: inline-block;
            background: #43a047;
            color: #fff;
            text-decoration: none;
            font-weight: 600;
            padding: 14px 0;
            border-radius: 8px;
            font-size: 1.1rem;
            transition: background 0.2s;
        }
        .actions a:hover {
            background: #2e7d32;
        }
        .footer {
            margin-top: 40px;
            color: #888;
            font-size: 0.95rem;
        }
        @media (max-width: 600px) {
            .container { padding: 24px 8px; }
            h1 { font-size: 2rem; }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="golf-icon">⛳</div>
        <h1>Golf Tournament Portal</h1>
        <div class="subtitle">Welcome to the official golf tournament management system.<br>Track scores, view tournaments, and stay updated!</div>
        <div class="actions">
            <a href="/scoreboard">🏆 View Scoreboard</a>
            <a href="/tournaments">⛳ View Tournaments</a>
            <a href="/players">👤 View Players</a>
        </div>
        <div class="footer">
            &copy; {{ date('Y') }} Golf Tournament Portal. All rights reserved.
        </div>
    </div>
</body>
</html>
