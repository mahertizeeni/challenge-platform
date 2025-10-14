<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>🎮 إنشاء لعبة جديدة</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <style>
        body {
            font-family: "Tajawal", Arial, sans-serif;
            background: linear-gradient(135deg, #4facfe, #00f2fe);
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
            padding: 20px;
        }

        @media (max-width: 600px) {
            body {
                padding: 15px;
            }

            .container {
                padding: 15px;
            }

            button {
                padding: 5px 8px;
                font-size: 14px;
            }

            .pagination .page-link {
                padding: 4px 8px;
                font-size: 13px;
            }
        }

        .container {
            background: white;
            border-radius: 25px;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.15);
            width: 100%;
            max-width: 450px;
            padding: 30px;
            text-align: center;
            animation: fadeIn 0.8s ease-in-out;
        }

        h2 {
            color: #333;
            font-size: 28px;
            margin-bottom: 15px;
        }

        h3 {
            color: #555;
            margin-top: 25px;
            margin-bottom: 10px;
        }

        label {
            display: block;
            font-weight: bold;
            margin-bottom: 8px;
            color: #444;
            text-align: right;
        }

        input[type="text"] {
            width: 100%;
            padding: 12px;
            border: 2px solid #ddd;
            border-radius: 12px;
            outline: none;
            font-size: 16px;
            transition: all 0.3s ease;
        }

        input[type="text"]:focus {
            border-color: #4facfe;
            box-shadow: 0 0 8px rgba(79, 172, 254, 0.4);
        }

        button {
            background: linear-gradient(135deg, #4facfe, #00f2fe);
            border: none;
            color: white;
            padding: 12px 20px;
            border-radius: 12px;
            font-size: 16px;
            cursor: pointer;
            transition: transform 0.2s, box-shadow 0.3s;
            margin-top: 10px;
        }

        button:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 15px rgba(0, 0, 0, 0.2);
        }

        #players div {
            margin-bottom: 10px;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* مظهر مخصص لزر إضافة لاعب */
        .add-btn {
            background: #ffb300;
            color: #222;
        }

        .add-btn:hover {
            background: #ffc93c;
        }

        /* تحسين عرض الموبايل */
        @media (max-width: 480px) {
            .container {
                padding: 20px;
                border-radius: 20px;
            }

            h2 {
                font-size: 22px;
            }

            button {
                font-size: 15px;
            }
        }
    </style>
</head>

<body>

    <div class="container">
        <h2>🎮 إنشاء لعبة جديدة</h2>

        <form action="{{ route('game_sessions.store') }}" method="POST">
            @csrf

            <label>اسم اللعبة:</label>
            <input type="text" name="game_name" placeholder="أدخل اسم اللعبة..." required>

            <h3>👥 أسماء اللاعبين:</h3>
            <div id="players">
                <div><input type="text" name="players[]" placeholder="اسم اللاعب الأول" required></div>
            </div>

            <button type="button" class="add-btn" onclick="addPlayer()">➕ إضافة لاعب</button>

            <br><br>
            <button type="submit">🚀 بدء اللعبة</button>
        </form>
    </div>

    <script>
        let playerCount = 1;

        function addPlayer() {
            playerCount++;
            const div = document.createElement('div');
            div.innerHTML = `<input type="text" name="players[]" placeholder="اسم اللاعب ${playerCount}" required>`;
            document.getElementById('players').appendChild(div);
        }
    </script>

</body>

</html>
