<!DOCTYPE html>
<html lang="ar">

<head>
    <meta charset="UTF-8">
    <title>{{ $gameSession->name }}</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>

<body style="font-family: Arial; margin: 40px;">

    <h2>🎯 اللعبة: {{ $gameSession->name }}</h2>

    <h3>🏅 اللاعبين:</h3>

    <ul>
        @foreach ($contestants as $contestant)
            <li>
                {{ $contestant->name }} - <span id="score-{{ $contestant->id }}">{{ $contestant->score }}</span> نقطة
                <button onclick="changeScore({{ $contestant->id }}, 1)">➕</button>
                <button onclick="changeScore({{ $contestant->id }}, -1)">➖</button>
            </li>
        @endforeach
    </ul>


    <h3>🧠 الأسئلة:</h3>
    @foreach ($questions as $index => $question)
        <div style="margin-bottom: 10px;">
            <strong>سؤال {{ $index + 1 }}:</strong> {{ $question->question }}<br>
            <em>الإجابة:</em> {{ $question->answer }}
        </div>
    @endforeach


    <script>
        function changeScore(id, delta) {
            let scoreEl = document.getElementById('score-' + id);
            let newScore = parseInt(scoreEl.innerText) + delta;

            fetch(`/contestants/${id}/score`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    },
                    body: JSON.stringify({
                        score: newScore
                    })
                }).then(res => res.json())
                .then(data => {
                    if (data.success) scoreEl.innerText = data.score;
                });
        }
    </script>

</body>

</html>
