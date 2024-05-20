<script>
    /*
    $.ajax({
        url: window.location.href,
        type: 'POST',
        contentType: 'application/json',
        data: {
            is_open: true
            end_timestamp: "2024-06-19 11:58:49"
        },
        success: function(response) {
            console.log('Response:', response);
        },
        error: function(jqXHR, textStatus, errorThrown) {
            console.log('Error:', textStatus, errorThrown);
        }
    });

    $.ajax({
        url: window.location.href,
        type: 'POST',
        contentType: 'application/json',
        data: {
            is_open: false
        },
        success: function(response) {
            console.log('Response:', response);
        },
        error: function(jqXHR, textStatus, errorThrown) {
            console.log('Error:', textStatus, errorThrown);
        }
    });

    $.ajax({
        url: window.location.href,
        type: 'DELETE',
        contentType: 'application/json',
        success: function(response) {
            console.log('Response:', response);
        },
        error: function(jqXHR, textStatus, errorThrown) {
            console.log('Error:', textStatus, errorThrown);
        }
    });

    $.ajax({
        url: "https://localhost/question/clone/3",
        type: 'POST',
        contentType: 'application/json',
        success: function(response) {
            console.log('Response:', response);
        },
        error: function(jqXHR, textStatus, errorThrown) {
            console.log('Error:', textStatus, errorThrown);
        }
    });
    */
</script>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title id="pageTitle">ODILS | Admin Panel</title>

    <link rel="icon" type="image/x-icon" href="/backend/views/images/favicon.png">
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.6.1/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.css" rel="stylesheet">

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.form/4.3.0/jquery.form.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.js"></script>
    <script src="https://cdn.jsdelivr.net/particles.js/2.0.0/particles.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.form/4.3.0/jquery.form.min.js"></script>
    <script src="index.js"></script>

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

        .admin-panel-header img {
            max-width: 150px;
            margin-bottom: 20px;
        }

        .admin-panel-header h2 {
            color: #333;
        }

        .admin-details p {
            margin: 0;
            color: #6c757d;
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

        .form-group {
            margin-bottom: 15px;
        }
        .form-group label {
            display: block;
            margin-bottom: 5px;
        }
        .form-group input, .form-group textarea {
            width: 100%;
            padding: 8px;
            box-sizing: border-box;
        }
        .form-group input[type="checkbox"] {
            width: auto;
        }
        #questionForm{
            width: max-content;
        }
        .option {
            margin-top: 10px;
        }
        .form-container{
            display: flex;
            justify-content: center;
            align-content: center;
            width: 90%;
        }
        .remove-option {
            top: 10px;
            right: 10px;
            background-color: red;
            color: white;
            border: none;
            padding: 5px 10px;
            cursor: pointer;
        }
    </style>
</head>

<body onload="checkSavedLanguage()">
<nav class="navbar navbar-expand-lg navbar-dark">
    <div class="container">
        <a class="navbar-brand"><img id="logo" src="/backend/views/images/logo.png" alt="ODILS | Homepage"></a>
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

<div class="form-container">
    <form id="questionForm">
        <h1>Edit Question</h1>
        <div class="form-group">
            <label for="titleEn">Title (EN):</label>
            <input type="text" id="titleEn" name="titleEn">
        </div>
        <div class="form-group">
            <label for="titleSk">Title (SK):</label>
            <input type="text" id="titleSk" name="titleSk">
        </div>
        <div class="form-group">
            <label for="contentEn">Content (EN):</label>
            <textarea id="contentEn" name="contentEn"></textarea>
        </div>
        <div class="form-group">
            <label for="contentSk">Content (SK):</label>
            <textarea id="contentSk" name="contentSk"></textarea>
        </div>
        <div class="form-group">
            <label for="creationDate">Creation Date:</label>
            <input type="text" id="creationDate" name="creationDate" readonly>
        </div>
        <div class="form-group">
            <label for="type">Type:</label>
            <input type="text" id="type" name="type">
        </div>
        <h2>Options</h2>
        <div id="optionsContainer"></div>

        <button type="button" onclick="addOption()">Add Option</button>
        <button type="submit">Save</button>
    </form>
    <script>
        const jsonData = <?php echo json_encode(["question" => $question]);?>;


        document.addEventListener('DOMContentLoaded', () => {
            const questionForm = document.getElementById('questionForm');

            // Populate the form with JSON data
            document.getElementById('titleEn').value = jsonData.question.question.title_en;
            document.getElementById('titleSk').value = jsonData.question.question.title_sk;
            document.getElementById('contentEn').value = jsonData.question.question.content_en;
            document.getElementById('contentSk').value = jsonData.question.question.content_sk;
            document.getElementById('creationDate').value = jsonData.question.question.creation_date;
            document.getElementById('type').value = jsonData.question.question.type;

            const optionsContainer = document.getElementById('optionsContainer');
            jsonData.question.options.forEach((option, index) => {
                addOption(option);
            });

            questionForm.addEventListener('submit', (event) => {
                event.preventDefault();

                const updatedData = {
                    question: {
                        id: jsonData.question.question.id,
                        user_id: jsonData.question.question.user_id,
                        title_en: document.getElementById('titleEn').value,
                        title_sk: document.getElementById('titleSk').value,
                        content_en: document.getElementById('contentEn').value,
                        content_sk: document.getElementById('contentSk').value,
                        creation_date: document.getElementById('creationDate').value,
                        type: document.getElementById('type').value,
                    },
                    options: []
                };

                optionsContainer.querySelectorAll('.option').forEach(optionDiv => {
                    const optionId = optionDiv.getAttribute('data-id');
                    const valueEn = optionDiv.querySelector('.valueEn').value;
                    const valueSk = optionDiv.querySelector('.valueSk').value;
                    const is_correct = optionDiv.querySelector('.isCorrect').checked;

                    updatedData.options.push({id: parseInt(optionId), question_id: jsonData.question.question.id, value_en: valueEn, value_sk: valueSk, is_correct: is_correct});
                });

                if(updatedData == jsonData){
                    return;
                }
                console.log('Updated Data:', updatedData);
                $.ajax({
                    url: window.location.href,
                    type: 'PUT',
                    contentType: 'application/json',
                    data: updatedData,
                    success: function(response) {
                        window.location.reload();
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        console.log('Error:', textStatus, errorThrown);
                    }
                });
            });
        });

        function addOption(option = {id: '', valueEn: '', valueSk: '', isCorrect: false}) {
            const optionsContainer = document.getElementById('optionsContainer');
            const optionDiv = document.createElement('div');
            optionDiv.classList.add('option');
            optionDiv.setAttribute('data-id', option.id);

            optionDiv.innerHTML = `
            <div class="form-group">
                <label for="valueEn">Option Value (EN):</label>
                <input type="text" class="valueEn" value="${option.valueEn}">
            </div>
            <div class="form-group">
                <label for="valueSk">Option Value (SK):</label>
                <input type="text" class="valueSk" value="${option.valueSk}">
            </div>
            <div class="form-group">
                <label for="isCorrect">Is Correct:</label>
                <input type="checkbox" class="isCorrect" ${option.isCorrect ? 'checked' : ''}>
            </div>
            <button type="button" class="remove-option" onclick="removeOption(this)">Remove</button>
        `;

            optionsContainer.appendChild(optionDiv);
        }

        function removeOption(button) {
            const optionDiv = button.parentElement;
            optionDiv.remove();
        }
    </script>
</div>

<footer class="footer">
    <div class="container">
        <p>&copy; 2024 ODILS. <span id="rightsReservedText"></span><br>
            <span id="schoolProjectText"></span></p>
    </div>
</footer>
</body>
</html>

<script>

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
        document.getElementById('manageQuestionsButton').innerHTML = '<i class="bi bi-file-earmark-text"></i> Správa otázok';
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

