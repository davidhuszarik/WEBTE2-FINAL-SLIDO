<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title id="pageTitle">ODILS | Homepage</title>
    <link rel="icon" type="image/x-icon" href="backend/views/images/favicon.png">
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
            integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
            crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
        body {
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #e9f5f0;
        }

        .navbar {
            background-color: #28a745 !important;
        }

        .navbar-brand {
            color: #ffffff !important;
            font-weight: bold;
        }

        .navbar-nav .nav-link {
            color: #ffffff !important;
        }

        .jumbotron {
            background-color: #28a745;
            color: #ffffff;
            padding: 20px 20px;
            text-align: center;
            margin-bottom: 0;
            flex: 1;
        }

        h2 {
            margin-bottom: 30px;
        }

        .footer {
            background-color: #28a745;
            color: #ffffff;
            text-align: center;
            padding: 20px 0;
        }

        .divider {
            border-bottom: 1px solid #dee2e6;
        }

        #logo {
            max-width: 75px;
        }
    </style>
</head>

<body onload="translateToSlovak(); localStorage.setItem('selectedLanguage', 'slovak');">

<nav class="navbar navbar-expand-lg navbar-dark">
    <div class="container">
        <a class="navbar-brand"><img id="logo" src="backend/views/images/logo.png" alt="ODILS | Homepage"></a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ml-auto">
                <li class="nav-item active">
                    <a class="nav-link" id="homeLink" href="index.php"><i class="fas fa-home"></i> Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="loginLink" href="login"><i class="fas fa-info-circle"></i> Login</a>
                </li>
                <li class="nav-item">
                    <button class="nav-link" id="logoutLink" style="display: none;" onclick="logout()">Logout</button>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="panelLink" style="display: none;" href="panel.php"><i
                                class="fas fa-cogs"></i> Panel</a>
                </li>


                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" id="navbarDropdown" role="button"
                       data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Language
                    </a>
                    <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                        <a class="dropdown-item" id="englishLink">English <span id="englishIndicator"></span></a>
                        <a class="dropdown-item" id="slovakLink">Slovak <span id="slovakIndicator"></span></a>
                    </div>
                </li>
                <li class="nav-item" id="userMenuItem" style="display: none;">
                    <a class="nav-link" id="userNameLink"><i class="fas fa-user"></i> <span id="userName"></span></a>
                </li>

            </ul>
        </div>
    </div>
</nav>

<div class="divider"></div>
<div id="welcome" class="jumbotron" style="padding: 20px 20px;" data-aos="fade-up" data-aos-duration="1000">
    <div class="container" style="position: relative;">
        <div id="particles-js"></div>
        <h1 style="position: absolute; top: 30%; left: 50%; transform: translate(-50%, -50%); z-index: 1;"
            id="invitationHeading"></h1>
        <p style="position: absolute; top: 40%; left: 50%; transform: translate(-50%, -50%); z-index: 1; font-size: 16px;"
           id="invitationMessage"></p>
        <div style="position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%); z-index: 1;">
            <input type="text" id="invitationCode" name="invitationCode" placeholder="Enter your 6 digit-code"
                   style="width: 300px; padding: 10px; border: 1px solid #ccc; border-radius: 5px; font-size: 16px;">
            <button onclick="sendInvitation()"
                    style="margin-top: 10px; padding: 10px 20px; background-color: #007bff; color: #fff; border: none; border-radius: 5px; font-size: 16px; cursor: pointer;">
                <i class="fas fa-paper-plane"></i> <span id="connectText"></span>
            </button>
        </div>
    </div>
</div>
<section id="who-we-are" class="section" style="margin-top: 50px; margin-bottom: 50px;">
    <div class="container">
        <h2 class="text-center" id="whatsGoodHeading"></h2>
        <div class="row align-items-center">
            <div class="col-md-4 text-center">
                <img src="backend/views/images/imagWithLogo.png" class="img-fluid" alt="Who We Are Image"
                     style="max-width: 200px; border: 1px solid black;">
            </div>
            <div class="col-md-8">
                <p style="margin-top: 20px; margin-bottom: 20px;" id="whatsGoodText1"></p>
                <p style="margin-top: 20px; margin-bottom: 0;" id="whatsGoodText2"></p>
            </div>

            <div class="vertical-divider"></div>

        </div>
    </div>
</section>
<hr style="border-top: 2px solid #ccc; width: 80px; margin: 20px auto;">
<div class="container text-center" style="margin-bottom: 50px;">
    <p><strong id="needHelpText"></strong> <span id="documentationText"></span> <br>
        <span id="logoText"></span>, <span id="phoneIconText"></span>, <span id="aiText"></span>.</p>
</div>

<footer class="footer">
    <div class="container">
        <p>&copy; 2024 ODILS. <span id="rightsReservedText"></span><br>
            <span id="schoolProjectText"></span></p>
    </div>
</footer>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.form/4.3.0/jquery.form.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.js"></script>
<script src="https://cdn.jsdelivr.net/particles.js/2.0.0/particles.min.js"></script>

<script>
    const cookieAccepted = localStorage.getItem('cookieAccepted');
    if (!cookieAccepted) {
        Swal.fire({
            title: 'Súhlas so súbormi cookie',
            html: 'Táto webová stránka používa súbory cookie na zabezpečenie toho, aby ste na našej webovej stránke získali najlepšie skúsenosti. Súbory cookie sú malé textové súbory, ktoré sú uložené vo vašom zariadení a pomáhajú poskytovať personalizovaný zážitok pri prehliadaní a analyzujú premávku na webovej stránke. Kliknutím na tlačidlo "Súhlasiť" súhlasíte s používaním všetkých súborov cookie.',
            icon: 'info',
            showCancelButton: true,
            confirmButtonText: 'Súhlasiť',
            cancelButtonText: 'Odmietnuť',
            allowOutsideClick: false,
            allowEscapeKey: false
        }).then((result) => {
            if (result.isConfirmed) {
                localStorage.setItem('cookieAccepted', true);
                Swal.fire({
                    title: 'Súbor cookies bol úspešne akceptovaný!',
                    icon: 'success',
                    confirmButtonText: 'OK'
                });
            } else {
                window.location.href = 'restricted.php';
            }
        });
    }


    AOS.init();
    particlesJS("particles-js", {
        "particles": {
            "number": {"value": 160, "density": {"enable": true, "value_area": 800}},
            "color": {"value": "#ffffff"},
            "shape": {
                "type": "circle",
                "stroke": {"width": 0, "color": "#000000"},
                "polygon": {"nb_sides": 5},
                "image": {"src": "img/github.svg", "width": 100, "height": 100}
            },
            "opacity": {
                "value": 0.5,
                "random": false,
                "anim": {"enable": false, "speed": 1, "opacity_min": 0.1, "sync": false}
            },
            "size": {
                "value": 3,
                "random": true,
                "anim": {"enable": false, "speed": 40, "size_min": 0.1, "sync": false}
            },
            "line_linked": {"enable": true, "distance": 150, "color": "#ffffff", "opacity": 0.4, "width": 1},
            "move": {
                "enable": true,
                "speed": 6,
                "direction": "none",
                "random": false,
                "straight": false,
                "out_mode": "out",
                "bounce": false,
                "attract": {"enable": false, "rotateX": 600, "rotateY": 1200}
            }
        },
        "interactivity": {
            "detect_on": "canvas",
            "events": {
                "onhover": {"enable": true, "mode": "repulse"},
                "onclick": {"enable": false, "mode": "push"},
                "resize": true
            },
            "modes": {
                "grab": {"distance": 400, "line_linked": {"opacity": 1}},
                "bubble": {"distance": 400, "size": 40, "duration": 2, "opacity": 8, "speed": 3},
                "repulse": {"distance": 63.86715631486508, "duration": 0.4},
                "push": {"particles_nb": 4},
                "remove": {"particles_nb": 2}
            }
        },
        "retina_detect": true
    });

    function translateToEnglish() {
        document.getElementById('pageTitle').innerText = 'ODILS |> Homepage';
        document.getElementById('homeLink').innerHTML = '<i class="fas fa-home"></i> Home';
        document.getElementById('loginLink').innerHTML = "<i class=\"fas fa-angle-double-right\"></i> Login";
        document.getElementById('navbarDropdown').innerHTML = '<i class="fas fa-globe"></i> Language';
        document.getElementById('invitationHeading').innerHTML = '👋 <strong>Hey, got an invitation code?</strong>';
        document.getElementById('logoutLink').innerHTML = '<i class="fas fa-sign-out-alt"></i> Logout';
        document.getElementById('invitationMessage').innerText = 'Enter the invitation code you received to connect as visitor';
        document.getElementById('connectText').innerText = 'Connect';
        document.getElementById('whatsGoodHeading').innerHTML = "🔍 <strong>WHAT IS ODILS?</strong>";
        document.getElementById('whatsGoodText1').innerHTML = '<strong>ODILS</strong> is an easy to use Q&A and polling platform for meetings and events. It allows meeting and event organizers to crowdsource top questions to drive meaningful conversations, engage participants with live polls and capture valuable event data.';
        document.getElementById('whatsGoodText2').innerHTML = 'Through <strong>ODILS</strong>, attendees transcend the role of mere spectators, becoming integral contributors to the discourse.';
        document.getElementById('needHelpText').innerText = 'Do you need help?';
        document.getElementById('documentationText').innerHTML = 'You can find our documentation here: <a href="https://www.example.com/documentation">DOCUMENTATION</a>';
        document.getElementById('logoText').innerText = 'The logo was created using';
        document.getElementById('phoneIconText').innerText = 'the phone icon is from';
        document.getElementById('aiText').innerText = 'and some parts of the text were generated by';
        document.getElementById('rightsReservedText').innerText = 'All rights reserved.';
        document.getElementById('schoolProjectText').innerText = 'This is a school project and is not affiliated with Cisco/Slido.';
        document.getElementById('englishIndicator').style.display = 'inline';
        document.getElementById('slovakIndicator').style.display = 'none';
        document.getElementById('invitationCode').placeholder = 'Enter your 6-digit code'
        localStorage.setItem('selectedLanguage', 'english');
        var credentials = sessionStorage.getItem('credentials');
        if (credentials) {
            var parsedCredentials = JSON.parse(credentials);
            var userNameLink = document.getElementById('userNameLink');
            userNameLink.innerHTML = "You are logged in as <strong>" + parsedCredentials.username + " </strong>";
        }
    }

    function translateToSlovak() {
        document.getElementById('pageTitle').innerText = 'ODILS |> Domov';
        document.getElementById('homeLink').innerHTML = '<i class="fas fa-home"></i> Domov';
        document.getElementById('loginLink').innerHTML = "<i class=\"fas fa-angle-double-right\"></i> Prihlásenie";
        document.getElementById('navbarDropdown').innerHTML = '<i class="fas fa-globe"></i> Jazyk';
        document.getElementById('invitationHeading').innerHTML = '👋 <strong>Ahoj, máš pozvánkový kód?</strong>';

        document.getElementById('logoutLink').innerHTML = '<i class="fas fa-sign-out-alt"></i> Odhlásenie';
        document.getElementById('invitationMessage').innerText = 'Zadaj pozvánkový kód, ktorý si dostal, aby si sa mohol pripojiť ako návštevník.';
        document.getElementById('connectText').innerText = 'Pripojiť sa';
        document.getElementById('whatsGoodHeading').innerHTML = "🔍 <strong>ČO JE ODILS?</strong>";
        document.getElementById('whatsGoodText1').innerHTML = '<strong>ODILS</strong> je jednoduchá a intuitívna platforma pre otázky a ankety, určená pre stretnutia a udalosti. Organizátorom stretnutí a podujatí umožňuje získať najlepšie otázky od účastníkov a viesť zmysluplné rozhovory, zapájať účastníkov živými anketami a zbierať cenné údaje o udalostiach.';
        document.getElementById('whatsGoodText2').innerHTML = 'Prostredníctvom <strong>ODILS</strong> účastníci presahujú úlohu iba divákov, stávajú sa neoddeliteľnými prispievateľmi k diskurzu.';
        document.getElementById('needHelpText').innerText = 'Potrebujete pomoc?';
        document.getElementById('documentationText').innerHTML = 'Nájdite našu dokumentáciu tu: <a href="https://www.example.com/documentation">DOKUMENTÁCIA</a>';
        document.getElementById('logoText').innerText = 'Logo bolo vytvorené pomocou';
        document.getElementById('phoneIconText').innerText = 'ikona telefónu je od';
        document.getElementById('aiText').innerText = 'a niektoré časti textu boli vygenerované pomocou';
        document.getElementById('rightsReservedText').innerText = 'Všetky práva vyhradené.';
        document.getElementById('schoolProjectText').innerText = 'Toto je školský projekt a nie je spätý s Cisco/Slido.';
        document.getElementById('slovakIndicator').style.display = 'inline';
        document.getElementById('englishIndicator').style.display = 'none';
        document.getElementById('invitationCode').placeholder = 'Zadaj tvôj 6 miestný kód'
        localStorage.setItem('selectedLanguage', 'slovak');
        var credentials = sessionStorage.getItem('credentials');
        if (credentials) {
            var parsedCredentials = JSON.parse(credentials);
            var userNameLink = document.getElementById('userNameLink');
            userNameLink.innerHTML = "Si prihlásený ako <strong>" + parsedCredentials.username + " </strong>";
        }
    }

    document.getElementById('englishLink').addEventListener('click', function () {
        translateToEnglish();
        Swal.fire({
            icon: 'success',
            title: 'Language changed',
            text: 'The language has been successfully changed.'
        });
    });

    document.getElementById('slovakLink').addEventListener('click', function () {
        translateToSlovak();
        Swal.fire({
            icon: 'success',
            title: 'Jazyk zmenený',
            text: 'Jazyk bol úspešne zmenený.'
        });
    });

    document.addEventListener("DOMContentLoaded", function () {
        var credentials = sessionStorage.getItem('credentials');
        if (credentials) {
            var parsedCredentials = JSON.parse(credentials);
            var loginButton = document.getElementById('loginLink');
            var logoutButton = document.getElementById('logoutLink');
            var userMenuItem = document.getElementById('userMenuItem');
            var userNameLink = document.getElementById('userNameLink');
            var panelLink = document.getElementById('panelLink');
            if (loginButton) {
                loginButton.style.display = "none";
            }
            if (logoutButton) {
                logoutButton.style.display = "block";
            }
            if (userMenuItem) {
                userMenuItem.style.display = "block";
            }
            if (userNameLink) {
                userNameLink.textContent = "You are logged in as " + parsedCredentials.username;
            }
            panelLink.style.display = "block";
        } else {
            var loginButton = document.getElementById('loginLink');
            var logoutButton = document.getElementById('logoutLink');
            var userMenuItem = document.getElementById('userMenuItem');
            var panelLink = document.getElementById('panelLink');
            if (loginButton) {
                loginButton.style.display = "block";
            }
            if (logoutButton) {
                logoutButton.style.display = "none";
            }
            if (userMenuItem) {
                userMenuItem.style.display = "none";
            }
            panelLink.style.display = "none";
        }
    });

    function checkSavedLanguage() {
        var savedLanguage = localStorage.getItem('selectedLanguage');
        if (savedLanguage === 'english') {
            translateToEnglish();
            return "english";
        } else if (savedLanguage === 'slovak') {
            translateToSlovak();
        } else {
            translateToEnglish();
            return "slovak";
        }
    }

    function logout() {
        if (checkSavedLanguage() === "english") {
            Swal.fire({
                title: 'Are you sure you want to log out?',
                text: "You will be logged out of your account.",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, log me out!'
            }).then((result) => {
                if (result.isConfirmed) {
                    sessionStorage.removeItem('credentials');
                    var loginButton = document.getElementById('loginLink');
                    loginButton.style.display = "block";
                    var logoutButton = document.getElementById('logoutLink');
                    logoutButton.style.display = "none";
                    var userMenuItem = document.getElementById('userMenuItem');
                    userMenuItem.style.display = "none";
                    var panelLink = document.getElementById('panelLink');
                    panelLink.style.display = "none";
                    if (checkSavedLanguage() == "english") {
                        Swal.fire({
                            title: 'Logged out successfully!',
                            text: "You have been logged out of your account.",
                            icon: 'success',
                            confirmButtonColor: '#3085d6',
                            confirmButtonText: 'OK'
                        });
                        $.ajax({
                            url: 'login',
                            type: 'DELETE',
                            success: function(result) {
                                // Handle success response here
                                console.log('Deleted successfully');
                            }
                        });
                    }
                }
            });
        } else {
            Swal.fire({
                title: 'Ste si istý/á, že sa chcete odhlásiť?',
                text: "Budete odhlásený/á zo svojho účtu.",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Áno, odhlásiť ma!'
            }).then((result) => {
                if (result.isConfirmed) {
                    sessionStorage.removeItem('credentials');
                    var loginButton = document.getElementById('loginLink');
                    loginButton.style.display = "block";
                    var logoutButton = document.getElementById('logoutLink');
                    logoutButton.style.display = "none";
                    var userMenuItem = document.getElementById('userMenuItem');
                    userMenuItem.style.display = "none";
                    var panelLink = document.getElementById('panelLink');
                    panelLink.style.display = "none";
                    Swal.fire({
                        title: 'Úspešné odhlásenie!',
                        text: "Boli ste úspešne odhlásení zo svojho účtu.",
                        icon: 'success',
                        confirmButtonColor: '#3085d6',
                        confirmButtonText: 'OK'
                    });
                    $.ajax({
                        url: '/login',
                        type: 'DELETE',
                        success: function(result) {
                        }
                    });
                }
            });
        }
    }

</script>
</body>
</html>
