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

window.onload = function () {
    checkSavedLanguage();
};