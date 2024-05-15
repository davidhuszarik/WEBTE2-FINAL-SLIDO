<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="backend/views/index.js"></script>
    <title>Obmedzená oblasť</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            text-align: center;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .container {
            width: 300px;
            padding: 20px;
            border: 1px solid #ccc;
            border-radius: 10px;
            background-color: #f9f9f9;
        }

        #logo {
            width: 100px;
            margin-bottom: 20px;
        }

        #progressBar {
            width: 100%;
            height: 20px;
            background-color: #ccc;
            border-radius: 10px;
            margin-top: 20px;
        }

        #progress {
            width: 0;
            height: 100%;
            background-color: #4caf50;
            border-radius: 10px;
        }
    </style>
</head>
<body>
<div class="container">
    <img id="logo" src="backend/views/images/logo.png" alt="Your Logo">
    <h1 id="title">Prístup zamietnutý</h1>
    <p id="text">Budete presmerovaní na prihlasovaciu stránku do <span id="countdown">5</span> sekúnd.</p>
    <div id="progressBar">
        <div id="progress"></div>
    </div>
</div>

<script>
    let countdown = 5;
    let countdownElement = document.getElementById('countdown');

    let countdownInterval = setInterval(function () {
        countdown--;
        countdownElement.textContent = countdown;
        updateProgressBar();

        if (countdown <= 0) {
            clearInterval(countdownInterval);
            redirectToLogin();
        }
    }, 1000);

    function updateProgressBar() {
        let progress = (5 - countdown) * 20;
        document.getElementById('progress').style.width = progress + '%';
    }

    function redirectToLogin() {
        window.location.href = 'index.php';
    }


    function translateToEnglish() {
        document.getElementById('title').innerText = 'Permission denied';
        document.getElementById('text').innerText = 'You will be redirected to the home page!';
    }

    function translateToSlovak() {
        document.getElementById('title').innerText = 'Prístup zamietnutý';
        document.getElementById('text').innerText = 'Budete presmerovaní na domovskú stránku!';
    }

    function checkSavedLanguage() {
        let savedLanguage = localStorage.getItem('selectedLanguage');
        if (savedLanguage === 'english') {
            translateToEnglish();
        } else if (savedLanguage === 'slovak') {
            translateToSlovak();
        } else {
            translateToEnglish();
        }
    }

    window.onload = function () {
        checkSavedLanguage();
    };
</script>
</body>
</html>
