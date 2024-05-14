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

    currentPasswordInput.addEventListener('input', function () {
        validatePassword(currentPasswordInput);
        toggleSubmitButton();
    });

    newPasswordInput.addEventListener('input', function () {
        validatePassword(newPasswordInput);
        toggleSubmitButton();
    });

    confirmNewPasswordInput.addEventListener('input', function () {
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

function changePassword() {
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
        success: function () {
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
        error: function (xhr) {
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