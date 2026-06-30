<?php
// Jeśli w przyszłości będziesz chciał zapisywać jej odpowiedzi do bazy lub wysyłać na maila, 
// logikę PHP można dopisać tutaj. Na razie strona działa w całości dynamicznie u użytkownika.
?>
<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Randka</title>
    <style>
        /* CSS STYLE */
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        body {
            background: linear-gradient(135deg, #ffe5ec, #ffc2d1, #f7aef8);
            background-size: 400% 400%;
            animation: gradientBG 15s ease infinite;
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            overflow: hidden;
        }

        @keyframes gradientBG {
            0% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
            100% { background-position: 0% 50%; }
        }

        .container {
            background: rgba(255, 255, 255, 0.85);
            backdrop-filter: blur(10px);
            padding: 40px 30px;
            border-radius: 24px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            text-align: center;
            max-width: 450px;
            width: 90%;
            min-height: 300px;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            transition: all 0.5s ease-in-out;
            position: relative;
        }

        .panel {
            display: none;
            width: 100%;
            animation: fadeIn 0.5s ease-in-out forwards;
        }

        .panel.active {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }

        h2 {
            color: #ff4d6d;
            margin-bottom: 25px;
            font-size: 26px;
            line-height: 1.4;
        }

        p.sub-text {
            color: #666;
            margin-bottom: 20px;
            font-size: 16px;
        }

        .btn-container {
            display: flex;
            gap: 20px;
            justify-content: center;
            align-items: center;
            width: 100%;
            position: relative;
            min-height: 60px;
        }

        button, .btn-next {
            background: #ff4d6d;
            color: white;
            border: none;
            padding: 12px 28px;
            font-size: 18px;
            font-weight: 600;
            border-radius: 50px;
            cursor: pointer;
            transition: transform 0.2s, background 0.2s, box-shadow 0.2s;
            box-shadow: 0 4px 15px rgba(255, 77, 109, 0.3);
        }

        button:hover, .btn-next:hover {
            background: #ff758f;
            transform: scale(1.05);
            box-shadow: 0 6px 20px rgba(255, 77, 109, 0.5);
        }

        #btn-no {
            background: #adb5bd;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
            position: absolute;
            transition: all 0.2s ease;
            white-space: nowrap;
        }
        #btn-no:hover {
            background: #6c757d;
        }

        /* Styl wyboru randki */
        .options-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 12px;
            width: 100%;
            margin-bottom: 25px;
        }

        .option-btn {
            background: #fff;
            color: #ff4d6d;
            border: 2px solid #ffccd5;
            padding: 12px;
            font-size: 15px;
            border-radius: 14px;
            box-shadow: none;
        }

        .option-btn.selected {
            background: #ff4d6d;
            color: white;
            border-color: #ff4d6d;
        }

        /* Inputs dla kalendarza */
        .datetime-container {
            display: flex;
            flex-direction: column;
            gap: 15px;
            width: 100%;
            margin-bottom: 25px;
        }

        input[type="date"], input[type="time"] {
            width: 100%;
            padding: 12px;
            border: 2px solid #ffccd5;
            border-radius: 12px;
            font-size: 16px;
            outline: none;
            color: #495057;
            text-align: center;
        }

        input[type="date"]:focus, input[type="time"]:focus {
            border-color: #ff4d6d;
        }

        .final-text {
            font-size: 18px;
            color: #4a4a4a;
            line-height: 1.6;
            margin-bottom: 20px;
        }

        .heart {
            color: #ff4d6d;
            font-size: 40px;
            animation: heartbeat 1.2s infinite;
            margin-top: 15px;
        }

        @keyframes heartbeat {
            0% { transform: scale(1); }
            20% { transform: scale(1.25); }
            40% { transform: scale(1.1); }
            60% { transform: scale(1.25); }
            80% { transform: scale(1); }
            100% { transform: scale(1); }
        }
    </style>
</head>
<body>

<div class="container">

    <div class="panel active" id="panel-1">
        <h2>Pójdziesz ze mną na randkę?</h2>
        <div class="btn-container" style="height: 100px;">
            <button id="btn-yes" onclick="nextPanel(2)">Tak!</button>
            <button id="btn-no" onmouseover="flyAway()" onclick="flyAway()">Nie</button>
        </div>
    </div>

    <div class="panel" id="panel-2">
        <h2>Naprawdę powiedziałaś tak?!</h2>
        <p class="sub-text">Nawet nie wiesz, jak bardzo się cieszę!</p>
        <button class="btn-next" onclick="nextPanel(3)">Dalej ❤️</button>
    </div>

    <div class="panel" id="panel-3">
        <h2>Kiedy jesteś wolna?</h2>
        <p class="sub-text">Wybierz idealny dzień i godzinę:</p>
        <div class="datetime-container">
            <input type="date" id="date-input" min="<?php echo date('Y-m-d'); ?>">
            <input type="time" id="time-input" value="18:00">
        </div>
        <button class="btn-next" onclick="nextPanel(4)">Wybierz co robimy</button>
    </div>

    <div class="panel" id="panel-4">
        <h2>Na co masz ochotę?</h2>
        <p class="sub-text">Możesz wybrać kilka opcji!</p>
        <div class="options-grid">
            <button class="option-btn" onclick="toggleOption(this)">Jedzenie 🍕</button>
            <button class="option-btn" onclick="toggleOption(this)">Film 🎬</button>
            <button class="option-btn" onclick="toggleOption(this)">Spacer 🌅</button>
            <button class="option-btn" onclick="toggleOption(this)">Morze 🌊</button>
            <button class="option-btn" onclick="toggleOption(this)">Góry ⛰</button>
            <button class="option-btn" onclick="toggleOption(this)">Wspólne granie 🎮</button>
        </div>
        <button class="btn-next" onclick="nextPanel(5)">Gotowe! 🥰</button>
    </div>

    <div class="panel" id="panel-5">
        <h2>Dziękuję, że jesteś! ❤️</h2>
        <p class="final-text">
            Dziękuję, że jesteś ze mną, jesteś dla mnie najważniejszą osobą na całym świecie. 
            Dzięki tobie mój dzień staje się lepszy. 
        </p>
        <p class="final-text" style="font-weight: bold; color: #ff4d6d;">Do zobaczenia!</p>
        <div class="heart">❤️</div>
    </div>

</div>

<script>
    // JAVASCRIPT LOGIC

    // Przechodzenie między panelami
    function nextPanel(panelNumber) {
        // Ukryj wszystkie panele
        document.querySelectorAll('.panel').forEach(panel => {
            panel.classList.remove('active');
        });
        // Pokaż wybrany panel
        document.getElementById('panel-' + panelNumber).classList.add('active');
    }

    // Uciekający przycisk "Nie"
    function flyAway() {
        const btnNo = document.getElementById('btn-no');
        const container = document.querySelector('.container');
        
        // Obliczanie bezpiecznych granic wewnątrz kontenera
        const padding = 20;
        const maxX = container.clientWidth - btnNo.clientWidth - padding;
        const maxY = container.clientHeight - btnNo.clientHeight - padding;
        
        // Losowanie nowej pozycji (z przesunięciem od środka)
        const randomX = Math.floor(Math.random() * maxX);
        const randomY = Math.floor(Math.random() * (maxY - 60)) + 40; // unikamy samej góry, gdzie jest nagłówek

        btnNo.style.left = randomX + 'px';
        btnNo.style.top = randomY + 'px';
    }

    // Zaznaczanie opcji w panelu 4
    function toggleOption(button) {
        button.classList.toggle('selected');
    }
</script>

</body>
</html>