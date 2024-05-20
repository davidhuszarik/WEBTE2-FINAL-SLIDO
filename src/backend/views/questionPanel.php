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
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.css" rel="stylesheet">

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.form/4.3.0/jquery.form.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.js"></script>
    <script src="index.js"></script>
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
</style>
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-dark">
    <div class="container">
        <a class="navbar-brand"><img id="logo" src="images/logo.png" alt="ODILS | Homepage"></a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ml-auto">
                <li class="nav-item active">
                    <a class="nav-link" id="homeLink" href="../../index.php"><i class="fas fa-home"></i> Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="loginLink" href="../../login"><i class="fas fa-info-circle"></i> Login</a>
                </li>
                <li class="nav-item">
                    <button class="nav-link" id="logoutLink" style="display: none;" onclick="logout()">Logout</button>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="panelLink" style="display: none;" href="../../panel.php"><i
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
        foreach ($questions as $question) {
            echo "<div class='question'>";
            echo "<h2>" . htmlspecialchars($question['title']) . "</h2>";
            echo "<p>" . htmlspecialchars($question['content']) . "</p>";
            echo "</div>";
        }
    } else {
        echo "<div class='question no-questions'>";
        echo "<h2>" . $noQuestionsMessage . "</h2>";
        echo "<a href='#createQuestionModal' class='btn btn-green text-white' data-toggle='modal'><i class='fas fa-plus'></i> Create Question</a>";
        echo "</div>";
    }
}
else{
    if (isset($questions) && count($questions) > 0) {
        foreach ($questions as $question) {
            echo "<div class='question'>";
            echo "<h2>" . htmlspecialchars($question['title']) . "</h2>";
            echo "<p>" . htmlspecialchars($question['content']) . "</p>";
            echo "</div>";
        }
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
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    function translateToSlovak() {
        document.getElementById('pageTitle').innerText = 'ODILS |> Vytvorenie Otázky';
    }

    function translateToEnglish() {
        document.getElementById('pageTitle').innerText = 'ODILS |> Create Question';
    }

    document.getElementById('new-question-form').addEventListener('submit', function(event) {
        event.preventDefault();
        var titleEn = document.getElementById('title-en').value;
        var titleSk = document.getElementById('title-sk').value;
        var contentEn = document.getElementById('content-en').value;
        var contentSk = document.getElementById('content-sk').value;
        var type = document.getElementById('type').value;
        var questionData = {
            'title_en': titleEn,
            'title_sk': titleSk,
            'content_en': contentEn,
            'content_sk': contentSk,
            'type': type
        };
        // Send questionData
        $.ajax({
            url: window.location.href,
            type: 'POST',
            data: questionData,
            success: function(response) {
                // handle success
                console.log(response);
            },
            error: function(error) {
                // handle error
                console.log(error);
            }
        });
    });
</script>
</body>
</html>

<script>

    /*
    $.ajax({
        url: window.location.href,
        type: 'POST',
        contentType: 'application/json',
        data: {
            question: {
                user_id: 1,
                title_en: "asd",
                title_sk: "asd",
                content_en: "asdasdasd",
                content_sk: "asdasdasd",
                type: "single_choice"
            },
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
     */

</script>
