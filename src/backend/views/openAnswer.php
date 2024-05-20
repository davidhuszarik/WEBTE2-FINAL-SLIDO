<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title id="pageTitle">ODILS | Hlasovanie</title>
    <link rel="icon" type="image/x-icon" href="images/favicon.png">
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
        body {
            background-color: #28a745;
        }
        .container {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
        .card {
            max-width: 400px;
            border: 1px solid #ced4da;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
        .card-body {
            padding: 30px;
        }
        .card-title {
            margin-bottom: 20px;
            color: #333;
        }
        .form-group {
            margin-bottom: 20px;
        }
        label {
            color: #555;
        }
        .form-control {
            border: 1px solid #ced4da;
            border-radius: 4px;
            width: 100%;
            max-width: none;
        }
        .btn-primary {
            background-color: #007bff;
            border: none;
        }
        .btn-primary:hover {
            background-color: #0056b3;
        }
        .logo {
            max-width: 100px;
            height: auto;
            display: block;
            margin: 0 auto 20px;
        }
        .divider {
            border-bottom: 1px solid #ced4da;
            margin-bottom: 20px;
        }
    </style>
</head>
<body>
<div class="container">
    <div class="card">
        <div class="card-body">
            <img src="images/logo.png" alt="Logo" class="logo">
            <div class="divider"></div>
            <h5 id="questionTitle" class="card-title text-center"><?php echo $period->getTitleSk(); ?></h5>
            <div class="divider"></div>
            <h4 id="questionContent" class="card-title text-center"><?php echo $period->getContentSk(); ?></h4>
            <div class="divider"></div>
            <div class="form-group">
                <label id="labelInput" for="textInput">Sem zadaj svoj odpoveď 👇</label>
                <input type="text" class="form-control" id="textInput" placeholder="Tvoj úžasný odpoveď" pattern="[a-zA-ZľščťžýáíéäôúňĽŠČŤŽÝÁÍÉÄÔÚŇ0-9\s]+" maxlength="50" required>
                <div id="invalidFeedback" class="invalid-feedback"></div>
            </div>
            <button id="sendButton" type="button" class="btn btn-primary btn-block">🗳️ Odoslať</button>
            <button id="backButton" type="button" class="btn btn-secondary btn-block">⬅️ Späť</button>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.form/4.3.0/jquery.form.min.js"></script>
</body>
</html>

<script>
    function validateInput() {
        var inputField = document.getElementById('textInput');
        if (inputField.checkValidity()) {
            inputField.classList.remove('is-invalid');
        } else {
            inputField.classList.add('is-invalid');
        }
    }

    document.getElementById('textInput').addEventListener('input', validateInput);

    function handleFormSubmission() {
        var inputField = document.getElementById('textInput');
        if (inputField.checkValidity()) {

            $.ajax({
                url: window.location.href,
                type: "POST",
                data: {
                    free_answer: inputField.value,
                },
                success: function(response) {
                    console.log("POST request successful");
                    console.log("Response:", response);
                    if (checkSavedLanguage() === "english") {
                        Swal.fire({
                            icon: 'success',
                            title: 'Great!',
                            text: 'Your answer was sent succesfully!'
                        });
                    }
                    else {
                        Swal.fire({
                            icon: 'success',
                            title: 'Super!',
                            text: 'Tvoja odpoveď bola odoslaná!'
                        });
                    }
                },
                error: function(xhr, status, error) {
                    console.error("Error making POST request:", error);
                }
            });

            inputField.value = '';
            inputField.classList.remove('is-invalid');


        } else {
            inputField.classList.add('is-invalid');
        }
    }

    document.getElementById('sendButton').addEventListener('click', handleFormSubmission);

    document.getElementById('backButton').addEventListener('click', function() {
        window.location.href = 'index.php';
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

    function translateToSlovak() {
        document.getElementById('pageTitle').innerText = 'ODILS |> Hlasovanie';
        document.getElementById('questionTitle').innerHTML = '<?php echo $period->getTitleSk(); ?>';
        document.getElementById('questionContent').innerHTML = "<?php echo $period->getContentSk(); ?>";
        document.getElementById('labelInput').innerHTML = "Sem zadaj svoju odpoveď 👇";
        document.getElementById('sendButton').innerHTML = "🗳️ Odoslať";
        document.getElementById('backButton').innerHTML = "⬅️ Späť";
        document.getElementById('invalidFeedback').innerHTML = "Odpoveď musí mať maximum 50 znakov a môže obsahovať len písmená a čísla.";
        document.getElementById('textInput').placeholder = "📝 Tvoja úžasná odpoveď";
    }

    function translateToEnglish() {
        document.getElementById('pageTitle').innerText = 'ODILS |> Voting';
        document.getElementById('questionTitle').innerHTML = '<?php echo $period->getTitleEn(); ?>';
        document.getElementById('questionContent').innerHTML = "<?php echo $period->getContentEn(); ?>";
        document.getElementById('labelInput').innerHTML = "Enter your answer here 👇";
        document.getElementById('sendButton').innerHTML = "🗳️ Send";
        document.getElementById('backButton').innerHTML = "⬅️ Back";
        document.getElementById('invalidFeedback').innerHTML = "The answer must be maximum 50 characters long and can only contain letters and numbers.";
        document.getElementById('textInput').placeholder = "📝 Your amazing answer";
    }

    checkSavedLanguage();
</script>

