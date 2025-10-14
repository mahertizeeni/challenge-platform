<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>الملف الشخصي</title>
    <style>
        body {
            font-family: "Tajawal", sans-serif;
            background: linear-gradient(135deg, #74ebd5, #ACB6E5);
            margin: 0;
            padding: 0;
            color: #333;
        }

        .container {
            max-width: 900px;
            margin: 40px auto;
            padding: 20px;
        }

        .profile-header {
            text-align: center;
            margin-bottom: 40px;
        }

        .profile-header h1 {
            font-size: 32px;
            margin-bottom: 10px;
        }

        .profile-header p {
            font-size: 18px;
            color: #444;
        }

        .games-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 20px;
        }

        /* تصميم الكرت */
        .game-card {
            display: block;
            background: #fff;
            border-radius: 20px;
            padding: 20px;
            text-align: center;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            transition: transform 0.2s, box-shadow 0.3s;
            text-decoration: none;
            color: inherit;
        }

        .game-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 20px rgba(79, 172, 254, 0.2);
        }

        .game-name {
            font-size: 22px;
            font-weight: bold;
            color: #2b2b2b;
            margin-bottom: 10px;
        }

        .game-date {
            font-size: 16px;
            color: #777;
        }

        /* تصميم للموبايل */
        @media (max-width: 600px) {
            .profile-header h1 {
                font-size: 26px;
            }

            .game-name {
                font-size: 20px;
            }
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="profile-header">
            <h1>مرحباً، {{ Auth::user()->name }}</h1>
            <p>إليك قائمة الألعاب السابقة الخاصة بك 🎮</p>
        </div>

        <div class="games-grid">
            @forelse ($games as $game)
                <a href="{{ route('game_sessions.play', $game->id) }}" class="game-card">
                    <div class="game-name">{{ $game->name }}</div>
                    <div class="game-date">🗓️ {{ $game->created_at->format('Y-m-d h:i A') }}</div>
                </a>
            @empty
                <p style="text-align:center; font-size:18px;">لا توجد ألعاب سابقة بعد.</p>
            @endforelse
        </div>
    </div>
</body>

</html>
