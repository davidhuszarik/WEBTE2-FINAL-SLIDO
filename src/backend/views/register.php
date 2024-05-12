<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ODILS | Registration</title>
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
            max-width: 400px;
            width: 100%;
            margin: auto;
        }

        .btn-primary {
            background-color: #28a745;
            border-color: #28a745;
        }

        .btn-primary:hover {
            background-color: #1d6f3c;
            border-color: #1d6f3c;
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

        .row {
            margin: 0 -15px;
        }

        .col-md-6 {
            padding: 0 15px;
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
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.form/4.3.0/jquery.form.min.js"></script>
</head>
<body>
<div id="particles-js"></div>
<div class="count-particles"><span class="js-count-particles"></span></div>
<script src="https://cdn.jsdelivr.net/particles.js/2.0.0/particles.min.js"></script>
<script src="https://threejs.org/examples/js/libs/stats.min.js"></script>
<div class="form-container">
    <form id="registrationForm">
        <img src="../../images/logo.png" alt="Logo" class="logo">
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label id="usernameLabel" for="username">Username</label>
                    <input type="text" class="form-control" id="username" required maxlength="25">
                    <div class="invalid-feedback" id="usernameFeedback">Please enter your username.</div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label id="emailLabel" for="email">Email</label>
                    <input type="email" class="form-control" id="email" required>
                    <div class="invalid-feedback" id="emailFeedback">Please enter a valid email address.</div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label id="passwordLabel" for="password">Password</label>
                    <input type="password" class="form-control" id="password" required minlength="8">
                    <div class="invalid-feedback">Password must be at least 8 characters.</div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label id="confirmPasswordLabel" for="confirmPassword">Confirm password</label>
                    <input type="password" class="form-control" id="confirmPassword" required>
                    <div class="invalid-feedback" id="passwordConfirmFeedback">Passwords do not match.</div>
                </div>
            </div>
        </div>
        <button id="registerButton" type="submit" class="btn btn-primary btn-block">Register</button>
    </form>
    <div style="text-align: center; margin-top: 10px;">
        <button id="backButton" onclick="window.location.href = 'index.php';" class="btn btn-secondary btn-block">Back</button>
    </div>
    <div id="loginPrompt" style="text-align: center; margin-top: 10px;">
        <p>Have you already account? <a href="login">Login</a></p>
    </div>
</div>

<script>
    const username = document.getElementById('username');
    const email = document.getElementById('email');
    const password = document.getElementById('password');
    const confirmPassword = document.getElementById('confirmPassword');
    const usernameFeedback = document.getElementById('usernameFeedback');
    const emailFeedback = document.getElementById('emailFeedback');
    const passwordConfirmFeedback = document.getElementById('passwordConfirmFeedback');

    username.addEventListener('input', validateUsername);
    email.addEventListener('input', validateEmail);
    password.addEventListener('input', validatePasswordMatch);
    confirmPassword.addEventListener('input', validatePasswordMatch);

    function validateUsername() {
        const specialChars = /[ `!@#$%^&*()_+\-=\[\]{};':"\\|,.<>\/?~]/;
        if (specialChars.test(username.value)) {
            username.classList.add('is-invalid');
            savedLanguage = localStorage.getItem('selectedLanguage');
            if (savedLanguage === "slovak") {
                usernameFeedback.textContent = 'Používateľské meno obsahuje špeciálne znaky.';
            }
            else {
                usernameFeedback.textContent = 'Username contains special characters.';
            }
        } else if (username.value.trim() === '') {
            username.classList.add('is-invalid');
            savedLanguage = localStorage.getItem('selectedLanguage');
            if (savedLanguage === "slovak") {
                usernameFeedback.textContent = 'Prosím, zadajte používateľské meno.';
            }
            else {
                usernameFeedback.textContent = 'Please enter your username.';
            }
        } else if (username.value.length > 25) {
            username.classList.add('is-invalid');
            savedLanguage = localStorage.getItem('selectedLanguage');
            if (savedLanguage === "slovak") {
                usernameFeedback.textContent = 'Používateľské meno musí mať menej ako 25 znakov.';
            }
            else {
                usernameFeedback.textContent = 'Username must be less than 25 characters long.';
            }
        } else {
            username.classList.remove('is-invalid');
            username.classList.add('is-valid');
        }
    }

    function checkSavedLanguage() {
        var savedLanguage = localStorage.getItem('selectedLanguage');
        console.log(savedLanguage);
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

    function translateToEnglish() {
        document.getElementById('username').placeholder = 'Username';
        document.getElementById('email').placeholder = 'Email';
        document.getElementById('usernameLabel').textContent = 'Username';
        document.getElementById('password').placeholder = 'Password';
        document.getElementById('passwordLabel').textContent = 'Password';
        document.getElementById('confirmPassword').placeholder= 'Confirm password';
        document.getElementById('confirmPasswordLabel').textContent = 'Confirm password';
        document.getElementById('registerButton').textContent = 'Register';
        document.getElementById('backButton').textContent = 'Back';
        document.getElementById('loginPrompt').innerHTML = 'Have you already account? <a href="login" class="register-link">Log in</a>';
    }

    function translateToSlovak() {
        document.getElementById('email').placeholder = 'Email';
        document.getElementById('username').placeholder = 'Užívateľské meno';
        document.getElementById('usernameLabel').textContent = 'Užívateľské meno';
        document.getElementById('password').placeholder = 'Heslo';
        document.getElementById('passwordLabel').textContent = 'Heslo';
        document.getElementById('confirmPassword').placeholder= 'Potvrďte heslo';
        document.getElementById('confirmPasswordLabel').textContent = 'Potvrďte heslo';
        document.getElementById('registerButton').textContent = 'Registrovať';
        document.getElementById('backButton').textContent = 'Späť';
        document.getElementById('loginPrompt').innerHTML = 'Máš už učet? <a href="login" class="register-link">Prihlásiť</a>';
    }

    function validateEmail() {
        const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        if (!emailRegex.test(email.value)) {
            email.classList.add('is-invalid');
            savedLanguage = localStorage.getItem('selectedLanguage');
            if (savedLanguage === "slovak") {
                usernameFeedback.textContent = 'Prosím, zadaj správnu email.';
            }
            else {
                usernameFeedback.textContent = 'Please enter a valid email address.';
            }
        } else {
            email.classList.remove('is-invalid');
            email.classList.add('is-valid');
        }
    }

    function validatePasswordMatch() {
        if (password.value !== confirmPassword.value) {
            confirmPassword.classList.add('is-invalid');
            savedLanguage = localStorage.getItem('selectedLanguage');
            if (savedLanguage === "slovak") {
                usernameFeedback.textContent = 'Heslá sa nerovnajú.';
            }
            else {
                usernameFeedback.textContent = 'Passwords do not match.';
            }
        } else {
            confirmPassword.classList.remove('is-invalid');
            confirmPassword.classList.add('is-valid');
            passwordConfirmFeedback.textContent = '';
        }
    }

    document.getElementById('registrationForm').addEventListener('submit', function (event) {
        event.preventDefault();
        validateUsername();
        validateEmail();
        validatePasswordMatch();
        if (username.classList.contains('is-valid') && email.classList.contains('is-valid') && confirmPassword.classList.contains('is-valid')) {
            let formData = {
                username: $('#username').val(),
                email: $('#email').val(),
                password: $('#password').val()
            };

            // Post data to the same URL
            $.ajax({
                type: 'POST',
                url: window.location.href,
                data: formData,
                // TODO visual handle success and error here
                success: function(response) {
                    window.location.replace('/login');
                },
                error: function(xhr, status, error) {
                    console.error('Error:', error);
                }
            });
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
