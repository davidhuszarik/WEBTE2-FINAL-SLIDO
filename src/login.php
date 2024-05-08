<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ODILS | Login</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            background-color: #e9f5f0;
        }

        .form-container {
            padding: 50px;
            background: #ffffff;
            border: 1px solid #a2d9ce;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
        }

        .btn-primary {
            background-color: #28a745;
            border-color: #28a745;
        }

        .register-prompt {
            text-align: center;
            margin-top: 15px;
            color: #6c757d;
        }

        .register-link {
            color: #007bff;
        }

        .is-invalid {
            border-color: #dc3545;
        }

        .is-valid {
            border-color: #28a745;
        }

        .logo {
            display: block;
            margin: 0 auto 15px;
            max-width: 100px;
            height: auto;
        }

        .btn-primary:hover {
            background-color: #1d6f3c;
            border-color: #1d6f3c;
        }

        #particles-js {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: -1;
        }
    </style>
</head>
<body>
<div id="particles-js"></div>
<script src="https://cdn.jsdelivr.net/particles.js/2.0.0/particles.min.js"></script>
<script src="https://threejs.org/examples/js/libs/stats.min.js"></script>
<div class="form-container">
    <form id="loginForm">
        <img src="images/logo.png" alt="Logo" class="logo">
        <div class="form-group">
            <label id="usernameLabel" for="username">Username</label>
            <input type="text" class="form-control" id="username" required maxlength="25">
            <div class="invalid-feedback" id="usernameFeedback">Please enter your username.</div>
        </div>
        <div class="form-group">
            <label id="passwordLabel" for="password">Password</label>
            <input type="password" class="form-control" id="password" required>
            <div class="invalid-feedback">Please enter your password.</div>
        </div>
        <button id="loginButton" type="submit" class="btn btn-primary btn-block">Log in</button>
        <div class="register-prompt">
            <span id="registerPrompt"></span>
        </div>
        <div style="text-align: center; margin-top: 10px;">
            <button id="backButton" onclick="window.location.href = 'index.html';" class="btn btn-secondary">Back</button>
        </div>
    </form>
</div>

<script>
    const username = document.getElementById('username');
    const password = document.getElementById('password');
    const usernameFeedback = document.getElementById('usernameFeedback');

    username.addEventListener('input', validateUsername);
    password.addEventListener('input', validatePassword);

    function validateUsername() {
        let valid = true;
        const specialChars = /[ `!@#$%^&*()_+\-=\[\]{};':"\\|,.<>\/?~]/;
        if (specialChars.test(username.value)) {
            savedLanguage = localStorage.getItem('selectedLanguage');
            if (savedLanguage = "Slovak") {
                usernameFeedback.textContent = 'Používateľské meno obsahuje špeciálne znaky.';
            }
            else {
                usernameFeedback.textContent = 'Username contains special characters.';
            }
            username.classList.add('is-invalid');
            valid = false;
        } else if (username.value.trim() === '') {
            username.classList.add('is-invalid');
            savedLanguage = localStorage.getItem('selectedLanguage');
            if (savedLanguage = "Slovak") {
                usernameFeedback.textContent = 'Prosím, zadajte svoje používateľské meno.';
            }
            else {
                usernameFeedback.textContent = 'Please enter your username.';
            }
            valid = false;
        } else if (username.value.length > 25) {
            username.classList.add('is-invalid');
            savedLanguage = localStorage.getItem('selectedLanguage');
            if (savedLanguage = "Slovak") {
                usernameFeedback.textContent = 'Používateľské meno musí mať menej ako 25 znakov.';
            }
            else {
                usernameFeedback.textContent = 'Username must be less than 25 characters long.';
            }
            valid = false;
        } else {
            username.classList.remove('is-invalid');
            username.classList.add('is-valid');
            usernameFeedback.textContent = '';
        }
        return valid;
    }

    function translateToEnglish() {
        document.getElementById('username').placeholder = 'Username';
        document.getElementById('usernameLabel').textContent = 'Username';
        document.getElementById('password').placeholder = 'Password';
        document.getElementById('passwordLabel').textContent = 'Password';
        document.getElementById('loginButton').textContent = 'Log in';
        document.getElementById('backButton').textContent = 'Back';
        document.getElementById('registerPrompt').innerHTML = 'Don\'t have an account? <a href="register.php" class="register-link">Register</a>';
    }

    function translateToSlovak() {
        document.getElementById('username').placeholder = 'Užívateľské meno';
        document.getElementById('usernameLabel').textContent = 'Užívateľské meno';
        document.getElementById('password').placeholder = 'Heslo';
        document.getElementById('passwordLabel').textContent = 'Heslo';
        document.getElementById('loginButton').textContent = 'Prihlásiť';
        document.getElementById('backButton').textContent = 'Späť';
        document.getElementById('registerPrompt').innerHTML = 'Nemáte účet? <a href="register.php" class="register-link">Registrovať sa</a>';
    }

    function checkSavedLanguage() {
        var savedLanguage = localStorage.getItem('selectedLanguage');
        if (savedLanguage === 'english') {
            translateToEnglish();
        } else if (savedLanguage === 'slovak') {
            translateToSlovak();
        } else {
            translateToEnglish();
        }
    }

    window.onload = function() {
        checkSavedLanguage();
    };

    function validatePassword() {
        if (password.value.trim() === '') {
            password.classList.add('is-invalid');
        } else {
            password.classList.remove('is-invalid');
            password.classList.add('is-valid');
        }
    }

    document.getElementById('loginForm').addEventListener('submit', function (event) {
        let isValidUsername = validateUsername();
        let isValidPassword = password.value.trim() !== '';
        if (!isValidUsername || !isValidPassword) {
            event.preventDefault();
        }
    });



    particlesJS("particles-js", {
        "particles": {
            "number": {"value": 6, "density": {"enable": true, "value_area": 800}},
            "color": {"value": "#1b1e34"},
            "shape": {
                "type": "polygon",
                "stroke": {"width": 0, "color": "#000"},
                "polygon": {"nb_sides": 6},
                "image": {"src": "img/github.svg", "width": 100, "height": 100}
            },
            "opacity": {
                "value": 0.3,
                "random": true,
                "anim": {"enable": false, "speed": 1, "opacity_min": 0.1, "sync": false}
            },
            "size": {
                "value": 160,
                "random": false,
                "anim": {"enable": true, "speed": 10, "size_min": 40, "sync": false}
            },
            "line_linked": {"enable": false, "distance": 200, "color": "#ffffff", "opacity": 1, "width": 2},
            "move": {
                "enable": true,
                "speed": 8,
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
                "onhover": {"enable": false, "mode": "grab"},
                "onclick": {"enable": false, "mode": "push"},
                "resize": true
            },
            "modes": {
                "grab": {"distance": 400, "line_linked": {"opacity": 1}},
                "bubble": {"distance": 400, "size": 40, "duration": 2, "opacity": 8, "speed": 3},
                "repulse": {"distance": 200, "duration": 0.4},
                "push": {"particles_nb": 4},
                "remove": {"particles_nb": 2}
            }
        },
        "retina_detect": true
    });
    var count_particles, stats, update;
    stats = new Stats;
    stats.setMode(0);
    stats.domElement.style.position = 'absolute';
    stats.domElement.style.left = '0px';
    stats.domElement.style.top = '0px';
    document.body.appendChild(stats.domElement);
    count_particles = document.querySelector('.js-count-particles');
    update = function () {
        stats.begin();
        stats.end();
        if (window.pJSDom[0].pJS.particles && window.pJSDom[0].pJS.particles.array) {
            count_particles.innerText = window.pJSDom[0].pJS.particles.array.length;
        }
        requestAnimationFrame(update);
    };
    requestAnimationFrame(update);

</script>
</body>
</html>
