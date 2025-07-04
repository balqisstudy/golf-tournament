<!DOCTYPE html>
<head>
    <title>Tournament || Golf Tournament</title>
    <link rel="stylesheet" href="tournament.css">

    <style>
        .banner {
            width: 100%;
            height: 250px;
            background-color: #2e8b57;
            background-image: linear-gradient(rgba(0,0,0,0.3), rgba(0,0,0,0.3));
            background-size: cover;
            background-position: center;
            display: flex;
            align-items: flex-end;
            padding: 20px;
            box-sizing: border-box;
        }

        h1 {
            color: white;
            font-size: 2.5rem;
            margin: 0;
            text-shadow: 1px 1px 3px rgba(0,0,0,0.5);
        }
        
        .scoreboard-container {
            max-width: 1000px;
            margin: 30px auto;
            padding: 0 20px;
        }
        
        table {
            width: 100%;
            border-collapse: collapse;
            background-color: white;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            border-radius: 8px;
            overflow: hidden;
        }
        
        th {
            background-color: #2e8b57;
            color: white;
            padding: 12px 15px;
            text-align: left;
            font-weight: 600;
        }
        
        td {
            padding: 12px 15px;
            border-bottom: 1px solid #e0e0e0;
        }
        
        tr:last-child td {
            border-bottom: none;
        }
        
        tr:hover {
            background-color: #f0f8f4;
        }
    </style>
</head>
<body>
    <header class="header">
        <a href="/" class="web">Golf</a>
        <nav class="navLink">
            <a href="/players">Players</a>
            <a href="/tournaments">Tournament</a>
            <a href="/profile">Profile</a>
        </nav>
    </header>

    <div class="banner">
        <img src="#" alt="Golf Tournament Banner">
    </div>
    
    <h1>Tournament Leaderboard</h1>
    
    <div class="scoreboard-container">
    <table>
        <!--
        Scoreboard Right Here
        -->
    </table>