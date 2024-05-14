<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title id="pageTitle">ODILS | Admin Panel</title>
    <link rel="icon" type="image/x-icon" href="backend/views/images/favicon.png">
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.6.1/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
        body {
            background-color: #f8f9fa;
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
        }

        #logo {
            max-width: 75px;
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
            cursor: pointer;
        }

        .admin-panel {
            background: #ffffff;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            margin: 50px auto;
            max-width: 800px;
            padding: 30px;
        }

        .admin-panel-header {
            text-align: center;
            margin-bottom: 30px;
        }

        .admin-panel-header img {
            max-width: 150px;
            margin-bottom: 20px;
        }

        .admin-panel-header h2 {
            color: #333;
        }

        .admin-details {
            text-align: right;
            margin-bottom: 20px;
        }

        .admin-details p {
            margin: 0;
            color: #6c757d;
        }

        .admin-panel-content {
            text-align: center;
            margin-top: 30px;
        }

        .section {
            border: 1px solid #ced4da;
            border-radius: 5px;
            padding: 20px;
            margin-bottom: 20px;
            background-color: #f8f9fa;
        }

        .section-title {
            font-size: 20px;
            font-weight: bold;
            margin-bottom: 10px;
        }

        .section-content {
            text-align: center;
        }

        .btn-green {
            background-color: #28a745;
            border-color: #28a745;
        }

        .btn-green:hover {
            background-color: #218838;
            border-color: #218838;
        }

        .btn-red {
            background-color: #dc3545;
            border-color: #dc3545;
        }

        .btn-red:hover {
            background-color: #c82333;
            border-color: #c82333;
        }

        .btn-blue {
            background-color: #007bff;
            border-color: #007bff;
        }

        .btn-blue:hover {
            background-color: #0056b3;
            border-color: #0056b3;
        }

        .footer {
            background-color: #28a745;
            color: #ffffff;
            text-align: center;
            padding: 20px 0;
        }

        .cursor-pointer {
            cursor: pointer;
        }

    </style>
</head>

<body onload="checkSavedLanguage()">
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
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" id="navbarDropdown" role="button"
                       data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Language
                    </a>
                    <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                        <a class="dropdown-item cursor-pointer" id="englishLink">English <span id="englishIndicator"></span></a>
                        <a class="dropdown-item cursor-pointer" id="slovakLink">Slovak <span id="slovakIndicator"></span></a>
                    </div>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="logoutLink" onclick="logout()">Logout</a>
                </li>
                <li class="nav-item" id="userMenuItem" style="display: none;">
                    <a class="nav-link" id="userNameLink"><i class="fas fa-user"></i> <span id="userName"></span></a>
                </li>
            </ul>
        </div>
    </div>
</nav>
<div class="admin-panel">
    <div class="admin-panel-header">
        <h2 id="welcomeTitle">Welcome to Admin Panel</h2>
    </div>
    <div class="admin-details">
        <p id="usernameText">Hello, John Doe!</p>
        <p id="groupText">You are logged in as an administrator.</p>
    </div>
    <div class="admin-panel-content">
        <div class="section">
            <div id="profileTitle" class="section-title">Profile settings</div>
            <div class="section-content">
                <button id="changePasswordButton" class="btn btn-secondary mx-auto" data-toggle="modal" data-target="#changePasswordModal">
                    <i class="bi bi-key"></i> Change password
                </button>
            </div>
        </div>
        <div class="section" id="userSettingsSection">
            <div id="userSettingsLabel" class="section-title">User settings</div>
            <div class="section-content">
                <button id="manageUsersButton" class="btn btn-green mx-auto"><i class="bi bi-people"></i> Manage users
                </button>
            </div>
        </div>
        <div class="section">
            <div id="questionsSettingsTitle" class="section-title">Question settings</div>
            <div class="section-content">
                <button id="manageQuestionsButton" class="btn btn-red mx-auto"><i class="bi bi-file-earmark-text"></i>
                    Manage questions
                </button>
                <button class="btn btn-blue mx-auto"><i class="bi bi-bar-chart"></i> Show results</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="changePasswordModal" tabindex="-1" role="dialog" aria-labelledby="changePasswordModalLabel"
     aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="changePasswordModalLabel">Change password</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form>
                    <div class="form-group">
                        <label id="currentPasswordLabel" for="currentPassword" >Current password</label>
                        <input type="password"  class="form-control" id="currentPassword" required autocomplete="current-password">
                    </div>
                    <div class="form-group">
                        <label id="newPasswordLabel" for="newPassword">New password</label>
                        <input type="password" class="form-control" id="newPassword" required autocomplete="new-password">
                        <small id="passwordCriteria" class="form-text text-muted">
                            Password must be at least 8 characters long and contain at least one uppercase letter, one lowercase letter, and one number.
                        </small>
                    </div>
                    <div class="form-group">
                        <label id="confirmNewPasswordLabel" for="confirmNewPassword">Confirm new password</label>
                        <input type="password" class="form-control" id="confirmNewPassword" required autocomplete="new-password">
                        <small id="passwordMatchError" class="form-text text-danger d-none">Passwords do not match.</small>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button id="confirmPasswordButton" type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button id="closePasswordButton" onclick="changePassword()" type="button" class="btn btn-primary btn-success">Save changes</button>
            </div>
        </div>
    </div>
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
</body>
</html>

<script>

    validatePasswords();

    function validatePasswords() {
        let currentPasswordInput = document.getElementById('currentPassword');
        let newPasswordInput = document.getElementById('newPassword');
        let confirmNewPasswordInput = document.getElementById('confirmNewPassword');
        let submitButton = document.getElementById('closePasswordButton');

        let passwordRegex = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d).{8,}$/;

        function validatePassword(passwordInput) {
            let password = passwordInput.value;
            if (passwordRegex.test(password)) {
                passwordInput.classList.remove('is-invalid');
                passwordInput.classList.add('is-valid');
                return true;
            } else {
                passwordInput.classList.remove('is-valid');
                passwordInput.classList.add('is-invalid');
                return false;
            }
        }

        function toggleSubmitButton() {
            submitButton.disabled = !(validatePassword(currentPasswordInput) && validatePassword(newPasswordInput) && validatePassword(confirmNewPasswordInput) && newPasswordInput.value === confirmNewPasswordInput.value);
        }

        currentPasswordInput.addEventListener('input', function() {
            validatePassword(currentPasswordInput);
            toggleSubmitButton();
        });

        newPasswordInput.addEventListener('input', function() {
            validatePassword(newPasswordInput);
            toggleSubmitButton();
        });

        confirmNewPasswordInput.addEventListener('input', function() {
            validatePassword(confirmNewPasswordInput);
            toggleSubmitButton();
            if (newPasswordInput.value !== confirmNewPasswordInput.value) {
                confirmNewPasswordInput.classList.add('is-invalid');
                document.getElementById('passwordMatchError').classList.remove('d-none');
            } else {
                document.getElementById('passwordMatchError').classList.add('d-none');
            }
        });

        toggleSubmitButton();
    }

    function changePassword(){
        let currentPassword = document.getElementById('currentPassword').value;
        let newPassword = document.getElementById('newPassword').value;
        let currentLanguage = checkSavedLanguage();
        $.ajax({
            url: 'user',
            type: 'PUT',
            dataType: 'json',
            data: {
                old_password: currentPassword,
                new_password: newPassword,
            },
            success: function() {
                if (currentLanguage === "english") {
                    Swal.fire({
                        icon: 'success',
                        title: 'Successfully updated password',
                        text: 'Now you can use your new password.',
                    });
                } else {
                    Swal.fire({
                        icon: 'success',
                        title: 'Heslo úspešne aktualizované',
                        text: 'Teraz môžeš použiť tvoj nové heslo.',
                    });
                }
                $('#changePasswordModal').modal('hide');
                document.getElementById('currentPassword').value = '';
                document.getElementById('newPassword').value = '';
                document.getElementById('confirmNewPassword').value = '';
                document.getElementById('currentPassword').classList.remove('is-valid');
                document.getElementById('newPassword').classList.remove('is-valid');
                document.getElementById('confirmNewPassword').classList.remove('is-valid');
            },
            error: function(xhr) {
                if (xhr.responseJSON.error === "Missing required fields") {
                    if (currentLanguage === "english") {
                        Swal.fire({
                            icon: 'error',
                            title: 'Missing required field(s)',
                            text: 'Please enter a value for the all input field.',
                        });
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Chýbajúce povinné polia',
                            text: 'Prosím, zadaj hodnotu pre všetky vstupné polia.',
                        });
                    }
                } else if (xhr.responseJSON.error === "Could not update password") {
                    if (currentLanguage === "english") {
                        Swal.fire({
                            icon: 'error',
                            title: 'Could not update password',
                            text: 'There was an error on the server side, please try again later.',
                        });
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Nepodarilo sa aktualizovať heslo',
                            text: 'Došlo k chybe na strane servera, skús to prosím neskôr znova.',
                        });
                    }
                } else if (xhr.responseJSON.error === "Old password does not match") {
                    if (currentLanguage === "english") {
                        Swal.fire({
                            icon: 'error',
                            title: 'Old password does not match',
                            text: 'Please enter your valid old password.',
                        });
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Staré heslo sa nezhoduje',
                            text: 'Prosím, zadaj tvoj platné staré heslo.',
                        });
                    }
                }
            }
        });
    }

    document.getElementById('englishLink').addEventListener('click', function () {
        translateToEnglish();
    });

    document.getElementById('slovakLink').addEventListener('click', function () {
        translateToSlovak();
    });

    function translateToEnglish() {
        document.getElementById('homeLink').innerHTML = '<i class="fas fa-home"></i> Home';
        document.getElementById('pageTitle').innerText = 'ODILS |> Panel';
        document.getElementById('navbarDropdown').innerHTML = '<i class="fas fa-globe"></i> Language';
        document.getElementById('welcomeTitle').innerHTML = '<strong>Welcome to ODILS Panel</strong>';
        document.getElementById('profileTitle').innerText = 'Profile';
        document.getElementById('changePasswordButton').innerHTML = '🔐 Change password';
        document.getElementById('userSettingsLabel').innerText = 'Hidden functions for admins';
        document.getElementById('manageUsersButton').innerHTML = '<i class="bi bi-people"></i> Manage users';
        document.getElementById('questionsSettingsTitle').innerText = 'Questions';
        document.getElementById('logoutLink').innerHTML = '<i class="fas fa-sign-out-alt"></i> Logout';
        document.getElementById('manageQuestionsButton').innerHTML = '<i class="bi bi-file-earmark-text"></i> Manage questions';
        document.getElementById('rightsReservedText').innerText = 'All rights reserved.';
        document.getElementById('schoolProjectText').innerText = 'This is a school project and is not affiliated with Cisco/Slido.';
        document.getElementById('changePasswordModalLabel').innerText = '🔐 Change password';
        document.getElementById('newPasswordLabel').innerText = 'New password';
        document.getElementById('confirmNewPasswordLabel').innerText = 'Confrim password';
        document.getElementById('currentPasswordLabel').innerText = 'Current password';
        document.getElementById('passwordCriteria').innerText = 'Password must be at least 8 characters long and contain at least one uppercase letter, one lowercase letter, and one number.';
        document.getElementById('confirmPasswordButton').innerText = 'Back';
        document.getElementById('closePasswordButton').innerText = 'Submit';
        localStorage.setItem('selectedLanguage', 'english');
        let credentials = sessionStorage.getItem('credentials');
        if (credentials) {
            let parsedCredentials = JSON.parse(credentials);
            let userNameLink = document.getElementById('userNameLink');
            let usernameLabel = document.getElementById('usernameText');
            let groupText = document.getElementById('groupText');
            userNameLink.innerHTML = "You are logged in as <strong>" + parsedCredentials.username + " </strong>";
            usernameLabel.innerHTML = "Logged in as: <strong>" + parsedCredentials.username + " </strong>";

            let role = parsedCredentials.role;
            let roleText = "Role: ";
            let userColor = "green";
            let adminColor = "red";

            if (role === "admin") {
                roleText += "<span style='color: " + adminColor + "; font-weight: bold;'>ADMIN</span>";
            } else if (role === "user") {
                roleText += "<span style='color: " + userColor + "; font-weight: bold;'>User</span>";
            } else {
                roleText += role;
            }
            groupText.innerHTML = roleText;
        }
    }

    function translateToSlovak() {
        document.getElementById('homeLink').innerHTML = '<i class="fas fa-home"></i> Domov';
        document.getElementById('pageTitle').innerText = 'ODILS |> Panel';
        document.getElementById('navbarDropdown').innerHTML = '<i class="fas fa-globe"></i> Jazyk';
        document.getElementById('welcomeTitle').innerHTML = '<strong>Vitajte v ODILS paneli</strong>';
        document.getElementById('profileTitle').innerText = 'Profil';
        document.getElementById('changePasswordButton').innerHTML = '🔐 Zmena hesla';
        document.getElementById('userSettingsLabel').innerText = 'Skryté funkcie pre admina';
        document.getElementById('manageUsersButton').innerHTML = '<i class="bi bi-people"></i> Správa užívateľov';
        document.getElementById('questionsSettingsTitle').innerText = 'Otázky';
        document.getElementById('manageQuestionsButton').innerHTML = '<i class="bi bi-file-earmark-text"></i> Správa otázky';
        document.getElementById('logoutLink').innerHTML = '<i class="fas fa-sign-out-alt"></i> Odhlásenie';
        document.getElementById('rightsReservedText').innerText = 'Všetky práva vyhradené.';
        document.getElementById('schoolProjectText').innerText = 'Toto je školský projekt a nie je spätý s Cisco/Slido.';
        document.getElementById('changePasswordModalLabel').innerText = '🔐 Zmena hesla';
        document.getElementById('currentPasswordLabel').innerText = 'Aktuálne heslo';
        document.getElementById('newPasswordLabel').innerText = 'Nové heslo';
        document.getElementById('confirmNewPasswordLabel').innerText = 'Potvrdenie hesla';
        document.getElementById('passwordCriteria').innerText = 'Heslo musí mať aspoň 8 znakov a obsahovať aspoň jedno veľké písmeno, jedno malé písmeno a jedno číslo.';
        document.getElementById('confirmPasswordButton').innerText = 'Späť';
        document.getElementById('closePasswordButton').innerText = 'Poslať';
        localStorage.setItem('selectedLanguage', 'slovak');
        let credentials = sessionStorage.getItem('credentials');
        if (credentials) {
            let parsedCredentials = JSON.parse(credentials);
            let userNameLink = document.getElementById('userNameLink');
            let usernameLabel = document.getElementById('usernameText');
            let groupText = document.getElementById('groupText');
            userNameLink.innerHTML = "Si prihlásený ako <strong>" + parsedCredentials.username + " </strong>";
            usernameLabel.innerHTML = "Prihlásený ako: <strong>" + parsedCredentials.username + " </strong>";

            let role = parsedCredentials.role;
            let roleText = "Rola: ";
            let userColor = "green";
            let adminColor = "red";

            if (role === "admin") {
                roleText += "<span style='color: " + adminColor + "; font-weight: bold;'>ADMIN</span>";
            } else if (role === "user") {
                roleText += "<span style='color: " + userColor + "; font-weight: bold;'>Použivateľ</span>";
            } else {
                roleText += role;
            }
            groupText.innerHTML = roleText;
        }
    }

    document.addEventListener("DOMContentLoaded", function () {
        let credentials = sessionStorage.getItem('credentials');
        if (credentials) {
            let parsedCredentials = JSON.parse(credentials);
            let logoutButton = document.getElementById('logoutLink');
            let userMenuItem = document.getElementById('userMenuItem');
            let userNameLink = document.getElementById('userNameLink');
            let userSettingsSection = document.getElementById('userSettingsSection');

            if (logoutButton) {
                logoutButton.style.display = "block";
            }
            if (userMenuItem) {
                userMenuItem.style.display = "block";
            }
            if (userNameLink) {
                userNameLink.textContent = "You are logged in as " + parsedCredentials.username;
            }
            if (parsedCredentials.role === 'admin') {
                userSettingsSection.style.display = "block";
            } else {
                userSettingsSection.style.display = "none";
            }
        } else {
            window.location.href = 'restricted.php';
        }
    });

    function checkSavedLanguage() {
        let savedLanguage = localStorage.getItem('selectedLanguage');
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
                    $.ajax({
                        url: 'login',
                        type: 'DELETE',
                        success: function() {
                            console.log('Deleted successfully');
                        }
                    });
                    Swal.fire({
                        title: 'Logged out successfully!',
                        text: "You have been logged out of your account.",
                        icon: 'success',
                        confirmButtonColor: '#3085d6',
                        confirmButtonText: 'OK'
                    }).then(function () {
                        window.location.href = 'index.php';
                    });
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
                    $.ajax({
                        url: 'login',
                        type: 'DELETE',
                        success: function() {
                            console.log('Deleted successfully');
                        }
                    });
                    Swal.fire({
                        title: 'Úspešné odhlásenie!',
                        text: "Boli ste úspešne odhlásení zo svojho účtu.",
                        icon: 'success',
                        confirmButtonColor: '#3085d6',
                        confirmButtonText: 'OK'
                    }).then(function () {
                        window.location.href = 'index.php';
                    });
                }
            });
        }
    }
</script>
