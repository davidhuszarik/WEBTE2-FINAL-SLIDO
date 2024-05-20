<?php
// TODO this is a panel for questions
// TODO for admins it includes a tooltip to choose user

$noQuestionsMessage = "No questions found.";
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title id="pageTitle">ODILS | Questions</title>

    <link rel="icon" type="image/x-icon" href="images/favicon.png">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.25/css/dataTables.bootstrap4.min.css">
    
    <style>
        body {
            background-color: #28a745;
            font-family: Arial, sans-serif;
            color: #333;
            margin: 0;
            padding: 0;
        }
        .question {
            margin: 20px;
            padding: 20px;
            border: 1px solid #ddd;
            border-radius: 5px;
            background-color: #f9f9f9;
        }
        .question h2 {
            margin-bottom: 10px;
            font-size: 20px;
        }
        .question p {
            margin: 0;
        }
        .no-questions {
            text-align: center;
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
            min-height: 70vh;
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

        .cursor-pointer {
            cursor: pointer;
        }

        #particles-js {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: -1;
        }
        .btn-green {
            background-color: #28a745;
            border-color: #28a745;
        }
        .btn-green:hover {
            background-color: #218838;
            border-color: #218838;
        }
        #questionsTable_wrapper{
            padding: 40px;
        }
        #questionsTable th{
            border-bottom: 2px solid #218838;
            background-color: rgba(80, 215, 90, 0.5);
        }
        #questionsTable tr:nth-child(even) {
            border-bottom: 2px solid #218838;
            background-color: rgba(80, 215, 90, 0.1);
        }
        .dataTables_info{
            color: #ffffff;
        }
        .page-item.active .page-link {
            background-color: rgba(80, 215, 90, 0.4) !important;
            border-color: rgba(80, 215, 90, 0.4) !important;
        }
    </style>
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-dark">
    <div class="container">
        <a class="navbar-brand"><img id="logo" src="images/logo.png" alt="ODILS | Questions"></a>
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
                        <a class="dropdown-item cursor-pointer" id="englishLink">English <span id="englishIndicator"></span></a>
                        <a class="dropdown-item cursor-pointer" id="slovakLink">Slovak <span id="slovakIndicator"></span></a>
                    </div>
                </li>
                <li class="nav-item" id="userMenuItem" style="display: none;">
                    <a class="nav-link" id="userNameLink"><i class="fas fa-user"></i> <span id="userName"></span></a>
                </li>

            </ul>
        </div>
    </div>
</nav>
<?php
if (isset($users)){
    // TODO if admin
    // important not to expose other details than usename and id
    if (isset($questions) && count($questions) > 0) {
        echo "<table id='questionsTable' class='table dt-responsive nowrap' style='width:100%; background-color: white;'>";
        echo "<thead><tr><th>Title</th><th>Content</th></tr></thead>";
        echo "<tbody>";
        foreach ($questions as $question) {
            echo "<tr>";
            echo "<td>" . htmlspecialchars($question->getTitleEn()) . "</td>";
            echo "<td>" . htmlspecialchars($question->getContentEn()) . "</td>";
            echo "</tr>";
        }
        echo "</tbody>";
        echo "</table>";
        echo "<div style='text-align: center;'>";
        echo "<a href='#createQuestionModal' class='btn btn-green text-white' data-toggle='modal' style='border: 2px solid white;'><i class='fas fa-plus'></i> Create Question</a>";
        echo "</div>";
    } else {
        echo "<div class='question no-questions'>";
        echo "<h2>" . $noQuestionsMessage . "</h2>";
        echo "<a href='#createQuestionModal' class='btn btn-green text-white' data-toggle='modal'><i class='fas fa-plus'></i> Create Question</a>";
        echo "</div>";
    }
}
else{
    if (isset($questions) && count($questions) > 0) {
        echo "<table id='questionsTable' class='table dt-responsive nowrap' style='width:100%; background-color: white;'>";
        echo "<thead><tr><th>Title</th><th>Content</th></tr></thead>";
        echo "<tbody>";
        foreach ($questions as $question) {
            echo "<tr>";
            echo "<td>" . htmlspecialchars($question->getTitleEn()) . "</td>";
            echo "<td>" . htmlspecialchars($question->getContentEn()) . "</td>";
            echo "</tr>";
        }
        echo "</tbody>";
        echo "</table>";
        echo "<div style='text-align: center;'>";
        echo "<a href='#createQuestionModal' class='btn btn-green text-white' data-toggle='modal' style='border: 2px solid white;'><i class='fas fa-plus'></i> Create Question</a>";
        echo "</div>";
    } else {
        echo "<div class='question no-questions'>";
        echo "<h2>" . $noQuestionsMessage . "</h2>";
        echo "<a href='#createQuestionModal' class='btn btn-green text-white' data-toggle='modal'><i class='fas fa-plus'></i> Create Question</a>";
        echo "</div>";
    }
}
?>
<!-- create question modal -->
<div class='modal fade' id='createQuestionModal' tabindex='-1' role='dialog' aria-labelledby='createQuestionModalLabel' aria-hidden='true'>
  <div class='modal-dialog' role='document'>
    <div class='modal-content'>
      <div class='modal-header'>
        <h5 class='modal-title' id='createQuestionModalLabel'>Create New Question</h5>
        <button type='button' class='close' data-dismiss='modal' aria-label='Close'>
          <span aria-hidden='true'>&times;</span>
        </button>
      </div>
      <div class='modal-body'>
        <form id="new-question-form">
            <div class="form-group">
                <label for="title-en">Title (English):</label>
                <input type="text" id="title-en" name="title-en" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="title-sk">Title (Slovak):</label>
                <input type="text" id="title-sk" name="title-sk" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="content-en">Content (English):</label>
                <textarea id="content-en" name="content-en" class="form-control" required></textarea>
            </div>
            <div class="form-group">
                <label for="content-sk">Content (Slovak):</label>
                <textarea id="content-sk" name="content-sk" class="form-control" required></textarea>
            </div>
            <div class="form-group">
                <label for="type">Type:</label>
                <select id="type" name="type" class="form-control" required>
                    <option value="single_choice">Single Choice</option>
                    <option value="multi_choice">Multiple Choice</option>
                </select>
            </div>
            <div class='modal-footer'>
              <button type='button' class='btn btn-secondary' data-dismiss='modal'>Close</button>
              <button type='submit' class='btn btn-green text-white'>Submit</button>
            </div>
        </form>
      </div>
    </div>
  </div>
</div>
<script type="text/javascript" src="https://code.jquery.com/jquery-3.5.1.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.form/4.3.0/jquery.form.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/1.10.25/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.10.25/js/dataTables.bootstrap4.min.js"></script>
<script src="index.js"></script>
<script>
    $(document).ready(function() {
        let table = $('#questionsTable').DataTable({
            responsive: true,
            autoWidth: false,
            lengthChange: false,
            paging: true,
            searching: true,
            info: true,
            order: [[0, 'asc']],
            language: {
                search: "_INPUT_",
                searchPlaceholder: "Search"
            }
        });
    });
    // TODO implement translation
    function translateToEnglish() {
        document.getElementById('pageTitle').innerText = 'ODILS |> Questions';
        document.getElementById('homeLink').innerHTML = '<i class="fas fa-home"></i> Home';
        document.getElementById('loginLink').innerHTML = "<i class=\"fas fa-angle-double-right\"></i> Login";
        document.getElementById('navbarDropdown').innerHTML = '<i class="fas fa-globe"></i> Language';
        document.getElementById('logoutLink').innerHTML = '<i class="fas fa-sign-out-alt"></i> Logout';
        document.getElementById('englishIndicator').style.display = 'inline';
        document.getElementById('slovakIndicator').style.display = 'none';
        localStorage.setItem('selectedLanguage', 'english');
        let credentials = sessionStorage.getItem('credentials');
        if (credentials) {
            let parsedCredentials = JSON.parse(credentials);
            let userNameLink = document.getElementById('userNameLink');
            userNameLink.innerHTML = "You are logged in as <strong>" + parsedCredentials.username + " </strong>";
        }
    }

    function translateToSlovak() {
        document.getElementById('pageTitle').innerText = 'ODILS |> Domov';
        document.getElementById('homeLink').innerHTML = '<i class="fas fa-home"></i> Domov';
        document.getElementById('loginLink').innerHTML = "<i class=\"fas fa-angle-double-right\"></i> Prihlásenie";
        document.getElementById('navbarDropdown').innerHTML = '<i class="fas fa-globe"></i> Jazyk';
        document.getElementById('logoutLink').innerHTML = '<i class="fas fa-sign-out-alt"></i> Odhlásenie';
        document.getElementById('slovakIndicator').style.display = 'inline';
        document.getElementById('englishIndicator').style.display = 'none';
        localStorage.setItem('selectedLanguage', 'slovak');
        let credentials = sessionStorage.getItem('credentials');
        if (credentials) {
            let parsedCredentials = JSON.parse(credentials);
            let userNameLink = document.getElementById('userNameLink');
            userNameLink.innerHTML = "Si prihlásený ako <strong>" + parsedCredentials.username + " </strong>";
        }
    }

    document.getElementById('new-question-form').addEventListener('submit', function(event) {
        event.preventDefault();
        var titleEn = document.getElementById('title-en').value;
        var titleSk = document.getElementById('title-sk').value;
        var contentEn = document.getElementById('content-en').value;
        var contentSk = document.getElementById('content-sk').value;
        var type = document.getElementById('type').value;
        $.ajax({
            url: window.location.href,
            type: 'POST',
            contentType: 'application/json',
            data: {
                question: {
                    user_id: 1,
                    title_en: titleEn,
                    title_sk: titleSk,
                    content_en: contentEn,
                    content_sk: contentSk,
                    type: "single_choice"
                },
                // TODO implement options
                options: [
                    {
                        value_en: "asdasdasdasd",
                        value_sk: "asdasdasd",
                        is_correct: true
                    },
                    {
                        value_en: "sjeriuesrg",
                        value_sk: "diuius",
                        is_correct: false
                    }
                ]
            },
            success: function(response) {
                console.log('Response:', response);
            },
            error: function(jqXHR, textStatus, errorThrown) {
                console.log('Error:', textStatus, errorThrown);
            }
        });
    });

    // FIXME - this is annoying
    // document.getElementById('englishLink').addEventListener('click', function () {
    //     translateToEnglish();
    //     Swal.fire({
    //         icon: 'success',
    //         title: 'Language changed',
    //         text: 'The language has been successfully changed.'
    //     });
    // });

    // document.getElementById('slovakLink').addEventListener('click', function () {
    //     translateToSlovak();
    //     Swal.fire({
    //         icon: 'success',
    //         title: 'Jazyk zmenený',
    //         text: 'Jazyk bol úspešne zmenený.'
    //     });
    // });

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
                    let loginButton = document.getElementById('loginLink');
                    loginButton.style.display = "block";
                    let logoutButton = document.getElementById('logoutLink');
                    logoutButton.style.display = "none";
                    let userMenuItem = document.getElementById('userMenuItem');
                    userMenuItem.style.display = "none";
                    let panelLink = document.getElementById('panelLink');
                    panelLink.style.display = "none";
                    if (checkSavedLanguage() === "english") {
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
                    let loginButton = document.getElementById('loginLink');
                    loginButton.style.display = "block";
                    let logoutButton = document.getElementById('logoutLink');
                    logoutButton.style.display = "none";
                    let userMenuItem = document.getElementById('userMenuItem');
                    userMenuItem.style.display = "none";
                    let panelLink = document.getElementById('panelLink');
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
    document.getElementById('englishLink').addEventListener('click', translateToEnglish);
    document.getElementById('slovakLink').addEventListener('click', translateToSlovak);
</script>
</body>
</html>
