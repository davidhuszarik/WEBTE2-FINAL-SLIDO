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
<body>

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
                    <a class="nav-link" href="#welcome"><i class="fas fa-home"></i> Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="login.php"><i class="fas fa-info-circle"></i> Login</a>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button"
                       data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Language
                    </a>
                    <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                        <a class="dropdown-item" href="#">English</a>
                        <a class="dropdown-item" href="#">Slovak</a>
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
        <h1 style="position: absolute; top: 30%; left: 50%; transform: translate(-50%, -50%); z-index: 1;">Got an
            invitation code?</h1>
        <p style="position: absolute; top: 40%; left: 50%; transform: translate(-50%, -50%); z-index: 1; font-size: 16px;">
            Enter the invitation code you received to connect as visitor</p>
        <div style="position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%); z-index: 1;">
            <input type="text" id="invitationCode" name="invitationCode" placeholder="Please, enter your invitation code here"
                   style="width: 300px; padding: 10px; border: 1px solid #ccc; border-radius: 5px; font-size: 16px;">
            <button onclick="sendInvitation()"
                    style="margin-top: 10px; padding: 10px 20px; background-color: #007bff; color: #fff; border: none; border-radius: 5px; font-size: 16px; cursor: pointer;">
                <i class="fas fa-paper-plane"></i> Connect
            </button>
        </div>
    </div>
</div>
<section id="who-we-are" class="section" style="margin-top: 50px; margin-bottom: 50px;">
    <div class="container">
        <h2 class="text-center">What's good about ODILS?</h2>
        <div class="row align-items-center">
            <div class="col-md-4 text-center">
                <img src="images/imagWithLogo.png" class="img-fluid" alt="Who We Are Image" style="max-width: 200px;"> <!-- Adjust max-width as needed -->
            </div>
            <div class="col-md-8">
                <p style="margin-top: 20px; margin-bottom: 20px;">Odils emerges as a transformative platform redefining audience engagement across various settings, be it presentations, meetings, or events. Its essence lies in cultivating active participation and inclusivity among participants, regardless of the event's magnitude or format.</p>
                <p style="margin-top: 20px; margin-bottom: 0;">Through Odils, attendees transcend the role of mere spectators, becoming integral contributors to the discourse. They can pose inquiries, partake in polls, and share insights in real-time, fostering a dynamic environment that sustains audience interest and involvement from start to finish.</p>
            </div>

            <div class="vertical-divider"></div>

        </div>
    </div>
</section>
<hr style="border-top: 2px solid #ccc; width: 80px; margin: 20px auto;">
<div class="container text-center" style="margin-bottom: 50px;">
    <p><strong>Do you need help?</strong> You can find our documentation here: <a href="help.html">DOCUMENTATION</a> <br>
        The logo was created using <a href="https://textcraft.net/">Textcraft</a>, the phone icon is from <a href="https://www.rawpixel.com/">Rawpixel</a>, and some parts of the text were generated by <a href="https://chatgpt.com/?oai-dm=1">AI</a>.</p>
</div>





<footer class="footer">
    <div class="container">
        <p>&copy; 2024 ODILS. All rights reserved.<br>
        This is a school project and is not affiliated with Cisco/Slido.</p>
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
</script>
</body>
</html>
