<!DOCTYPE html>
<html lang="ar">

<head>
    <meta charset="UTF-8">
    <title>إنشاء لعبة جديدة</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>

<body style="font-family: Arial; margin: 40px;">

    <h2>🎮 إنشاء لعبة جديدة</h2>

    <form action="{{ route('game_sessions.store') }}" method="POST">
        @csrf

        <label>اسم اللعبة:</label>
        <input type="text" name="game_name" required>
        <br><br>

        <h3>👥 أسماء اللاعبين:</h3>
        <div id="players">
            <input type="text" name="players[]" placeholder="اسم اللاعب" required>
        </div>
        <br>
        <button type="button" onclick="addPlayer()">➕ إضافة لاعب</button>

        <br><br>
        <button type="submit">بدء اللعبة</button>
    </form>

    <script>
        function addPlayer() {
            const div = document.createElement('div');
            div.innerHTML = '<input type="text" name="players[]" placeholder="اسم اللاعب" required>';
            document.getElementById('players').appendChild(div);
        }
    </script>

</body>

</html>
