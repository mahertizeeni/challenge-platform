<!DOCTYPE html>
<html lang="ar">

<head>
    <meta charset="UTF-8">
    <title>{{ $gameSession->name }}</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <style>
        body {
            font-family: "Tajawal", Arial, sans-serif;
            background: linear-gradient(135deg, #e0f2fe, #fef9c3);
            margin: 0;
            padding: 40px;
            color: #1e293b;
        }

        h2,
        h3 {
            color: #0f172a;
        }

        .container {
            max-width: 800px;
            margin: auto;
            background: white;
            padding: 25px 30px;
            border-radius: 16px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.08);
        }

        ul {
            list-style: none;
            padding: 0;
        }

        li {
            margin-bottom: 10px;
            padding: 10px;
            border: 1px solid #e2e8f0;
            border-radius: 10px;
            background: #f8fafc;
            display: flex;
            justify-content: space-between;
            align-items: center;
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


        button {
            border: none;
            padding: 6px 10px;
            border-radius: 8px;
            cursor: pointer;
            font-size: 16px;
            transition: 0.3s;
        }

        button:hover {
            transform: scale(1.1);
        }

        .plus {
            background: #16a34a;
            color: white;
        }

        .minus {
            background: #dc2626;
            color: white;
        }

        .question {
            background: #f1f5f9;
            padding: 15px;
            border-radius: 12px;
            margin-bottom: 12px;
            border-left: 5px solid #3b82f6;
        }

        .question strong {
            color: #1e3a8a;
        }

        /* ====== Pagination Style ====== */
        .pagination {
            display: flex;
            justify-content: center;
            list-style: none;
            gap: 6px;
            margin-top: 25px;
            padding: 0;
        }

        .pagination li {
            display: inline-block;
        }

        .pagination a,
        .pagination span {
            color: #1e40af;
            font-size: 14px;
            padding: 6px 10px;
            border: 1px solid #dbeafe;
            border-radius: 6px;
            text-decoration: none;
            transition: 0.2s;
            background: white;
        }

        .pagination a:hover {
            background: #3b82f6;
            color: white;
        }

        .pagination .active span {
            background: #1e40af;
            color: white;
            border-color: #1e40af;
        }

        /* ====== SVG Icon Fix ====== */
        .pagination svg {
            width: 16px;
            height: 16px;
            vertical-align: middle;
        }

        .pagination span svg,
        .pagination a svg {
            margin: 0 2px;
        }

        .pagination>* {
            font-size: 14px !important;
        }
    </style>
</head>

<body>

    <div class="container">
        <h2>🎯 اللعبة: {{ $gameSession->name }}</h2>

        <h3>🏅 اللاعبين:</h3>
        <ul>
            @foreach ($contestants as $contestant)
                <li>
                    <div>
                        {{ $contestant->name }} -
                        <strong id="score-{{ $contestant->id }}">{{ $contestant->score }}</strong> نقطة
                    </div>
                    <div>
                        <button class="plus" onclick="changeScore({{ $contestant->id }}, 1)">+</button>
                        <button class="minus" onclick="changeScore({{ $contestant->id }}, -1)">−</button>
                    </div>
                </li>
            @endforeach
        </ul>

        <h3>🧠 الأسئلة:</h3>
        @foreach ($questions as $index => $question)
            <div class="question">
                <strong>سؤال {{ $loop->iteration + ($questions->currentPage() - 1) * $questions->perPage() }}:</strong>
                {{ $question->question }}<br>
                <em>الإجابة:</em> {{ $question->answer }}
            </div>
        @endforeach

        <div>
            {{ $questions->links() }}
        </div>
    </div>

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
                })
                .then(res => res.json())
                .then(data => {
                    if (data.success) scoreEl.innerText = data.score;
                });
        }
    </script>

</body>

</html>
