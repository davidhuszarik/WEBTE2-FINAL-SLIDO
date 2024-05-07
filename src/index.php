<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ODILS | Homepage</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.css" rel="stylesheet">
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

<body onload="translateToSlovak()">

<nav class="navbar navbar-expand-lg navbar-dark">
    <div class="container">
        <a class="navbar-brand" href="#"><img id="logo" src="images/logo.png" alt="ODILS | Homepage"></a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ml-auto">
                <li class="nav-item active">
                    <a class="nav-link" id="homeLink" href="#welcome"><i class="fas fa-home"></i> Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="loginLink" href="login.php"><i class="fas fa-info-circle"></i> Login</a>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button"
                       data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Language
                    </a>
                    <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                        <a class="dropdown-item" id="englishLink" href="#">English <span id="englishIndicator"></span></a>
                        <a class="dropdown-item" id="slovakLink" href="#">Slovak <span id="slovakIndicator"></span></a>
                    </div>
                </li>
            </ul>
        </div>
    </div>
</nav>

<div class="divider"></div>
<div id="welcome" class="jumbotron" style="padding: 20px 20px;" data-aos="fade-up" data-aos-duration="1000">
    <div class="container" style="position: relative;">
        <div id="particles-js"></div>
        <h1 style="position: absolute; top: 30%; left: 50%; transform: translate(-50%, -50%); z-index: 1;" id="invitationHeading"></h1>
        <p style="position: absolute; top: 40%; left: 50%; transform: translate(-50%, -50%); z-index: 1; font-size: 16px;" id="invitationMessage"></p>
        <div style="position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%); z-index: 1;">
            <input type="text" id="invitationCode" name="invitationCode" placeholder="XXX-XXX-XXX"
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
                <img src="images/imagWithLogo.png" class="img-fluid" alt="Who We Are Image" style="max-width: 200px;">
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

<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.js"></script>
<script src="https://cdn.jsdelivr.net/particles.js/2.0.0/particles.min.js"></script>

<script>
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
        document.getElementById('homeLink').innerText = 'Home';
        document.getElementById('loginLink').innerText = 'Login';
        document.getElementById('navbarDropdown').innerText = 'Language';
        document.getElementById('invitationHeading').innerText = 'Got an invitation code?';
        document.getElementById('invitationMessage').innerText = 'Enter the invitation code you received to connect as visitor';
        document.getElementById('connectText').innerText = 'Connect';
        document.getElementById('whatsGoodHeading').innerText = "What's good about ODILS?";
        document.getElementById('whatsGoodText1').innerText = 'Odils emerges as a transformative platform redefining audience engagement across various settings, be it presentations, meetings, or events.';
        document.getElementById('whatsGoodText2').innerText = 'Through Odils, attendees transcend the role of mere spectators, becoming integral contributors to the discourse.';
        document.getElementById('needHelpText').innerText = 'Do you need help?';
        document.getElementById('documentationText').innerText = 'You can find our documentation here:';
        document.getElementById('logoText').innerText = 'The logo was created using';
        document.getElementById('phoneIconText').innerText = 'the phone icon is from';
        document.getElementById('aiText').innerText = 'and some parts of the text were generated by';
        document.getElementById('rightsReservedText').innerText = 'All rights reserved.';
        document.getElementById('schoolProjectText').innerText = 'This is a school project and is not affiliated with Cisco/Slido.';
        document.getElementById('englishIndicator').style.display = 'inline';
        document.getElementById('slovakIndicator').style.display = 'none';
        localStorage.setItem('selectedLanguage', 'english');
    }

    function translateToSlovak() {
        document.getElementById('homeLink').innerText = 'Domov';
        document.getElementById('loginLink').innerText = 'Prihlásenie';
        document.getElementById('navbarDropdown').innerText = 'Jazyk';
        document.getElementById('invitationHeading').innerText = 'Máte pozvánkový kód?';
        document.getElementById('invitationMessage').innerText = 'Zadajte pozvánkový kód, ktorý ste dostali, aby ste sa pripojili ako návštevník';
        document.getElementById('connectText').innerText = 'Pripojiť sa';
        document.getElementById('whatsGoodHeading').innerText = "Čo je dobré na ODILS?";
        document.getElementById('whatsGoodText1').innerText = 'Odils sa stáva transformačnou platformou, ktorá predefinuje zapojenie publika v rôznych prostrediach, či už ide o prezentácie, stretnutia alebo udalosti.';
        document.getElementById('whatsGoodText2').innerText = 'Prostredníctvom Odils účastníci presahujú úlohu iba divákov, stávajú sa neoddeliteľnými prispievateľmi k diskurzu.';
        document.getElementById('needHelpText').innerText = 'Potrebujete pomoc?';
        document.getElementById('documentationText').innerText = 'Nájdete našu dokumentáciu tu:';
        document.getElementById('logoText').innerText = 'Logo bolo vytvorené pomocou';
        document.getElementById('phoneIconText').innerText = 'ikona telefónu je od';
        document.getElementById('aiText').innerText = 'a niektoré časti textu boli vygenerované pomocou';
        document.getElementById('rightsReservedText').innerText = 'Všetky práva vyhradené.';
        document.getElementById('schoolProjectText').innerText = 'Toto je školský projekt a nie je spätý s Cisco/Slido.';
        document.getElementById('slovakIndicator').style.display = 'inline';
        document.getElementById('englishIndicator').style.display = 'none';
        localStorage.setItem('selectedLanguage', 'slovak');
    }

    document.getElementById('englishLink').addEventListener('click', function() {
        translateToEnglish();
    });

    document.getElementById('slovakLink').addEventListener('click', function() {
        translateToSlovak();
    });
</script>
</body>
</html>
