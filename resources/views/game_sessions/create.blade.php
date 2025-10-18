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

        .container {
            background: white;
            border-radius: 25px;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.15);
            width: 100%;
            max-width: 480px;
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

        .add-btn {
            background: #ffb300;
            color: #222;
        }

        .add-btn:hover {
            background: #ffc93c;
        }

        .categories {
            text-align: right;
            margin-top: 15px;
            max-height: 200px;
            overflow-y: auto;
            padding: 10px;
            border: 1px solid #eee;
            border-radius: 12px;
        }

        .categories label {
            display: block;
            margin: 8px 0;
            font-weight: normal;
            color: #333;
            padding: 5px 10px;
            border-radius: 8px;
            transition: background 0.2s;
        }

        .categories label:hover {
            background: #f0f8ff;
        }

        .category-checkbox {
            margin-left: 8px;
        }

        .selected-categories {
            margin-top: 15px;
            padding: 10px;
            background: #f8f9fa;
            border-radius: 12px;
            text-align: right;
        }

        .selected-categories h4 {
            margin: 0 0 8px 0;
            color: #555;
        }

        .selected-list {
            font-size: 14px;
            color: #666;
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
    </style>
</head>

<body>

    <div class="container">
        <h2>🎮 إنشاء لعبة جديدة</h2>

        <form action="{{ route('game_sessions.store') }}" method="POST" id="gameForm">
            @csrf

            <label>اسم اللعبة:</label>
            <input type="text" name="game_name" placeholder="أدخل اسم اللعبة..." required>

            <h3>👥 أسماء اللاعبين:</h3>
            <div id="players">
                <div><input type="text" name="players[]" placeholder="اسم اللاعب الأول" required></div>
            </div>

            <button type="button" class="add-btn" onclick="addPlayer()">➕ إضافة لاعب</button>

            <h3>🧩 اختر التصنيفات (اختياري):</h3>

            <!-- عرض التصنيفات المختارة -->
            <div class="selected-categories" id="selectedCategories" style="display: none;">
                <h4>التصنيفات المختارة:</h4>
                <div class="selected-list" id="selectedList"></div>
            </div>

            <div class="categories">
                @foreach ($categories as $category)
                    <label>
                        <input type="checkbox" name="categories[]" value="{{ $category->id }}" class="category-checkbox"
                            onchange="updateSelectedCategories()">
                        {{ $category->name }}
                    </label>
                @endforeach
            </div>

            <br>
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

        // تحديث التصنيفات المختارة
        function updateSelectedCategories() {
            const checkboxes = document.querySelectorAll('.category-checkbox:checked');
            const selectedList = document.getElementById('selectedList');
            const selectedContainer = document.getElementById('selectedCategories');

            if (checkboxes.length > 0) {
                let selectedNames = [];
                checkboxes.forEach(checkbox => {
                    // الحصول على اسم التصنيف من النص المجاور
                    const categoryName = checkbox.parentElement.textContent.trim();
                    selectedNames.push(categoryName);
                });

                selectedList.innerHTML = selectedNames.join('، ');
                selectedContainer.style.display = 'block';
            } else {
                selectedContainer.style.display = 'none';
            }
        }

        // التحقق من صحة النموذج قبل الإرسال
        document.getElementById('gameForm').addEventListener('submit', function(e) {
            const gameName = document.querySelector('input[name="game_name"]').value.trim();
            const playerInputs = document.querySelectorAll('input[name="players[]"]');

            // التحقق من أن اسم اللعبة غير فارغ
            if (!gameName) {
                e.preventDefault();
                alert('يرجى إدخال اسم اللعبة');
                return;
            }

            // التحقق من أن جميع أسماء اللاعبين غير فارغة
            let validPlayers = true;
            playerInputs.forEach(input => {
                if (!input.value.trim()) {
                    validPlayers = false;
                    input.style.borderColor = 'red';
                } else {
                    input.style.borderColor = '#ddd';
                }
            });

            if (!validPlayers) {
                e.preventDefault();
                alert('يرجى إدخال جميع أسماء اللاعبين');
                return;
            }

            // إظهار رسالة تحميل
            const submitBtn = this.querySelector('button[type="submit"]');
            submitBtn.innerHTML = '⏳ جاري إنشاء اللعبة...';
            submitBtn.disabled = true;
        });
    </script>

</body>

</html>
