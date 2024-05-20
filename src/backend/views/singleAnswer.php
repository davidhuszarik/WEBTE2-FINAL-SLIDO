<?php
$length = count($options);
?>

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
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
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
            cursor: pointer;
            font-size: 16px;
            flex: 0 0 48%;
            margin-bottom: 10px;
            display: flex;
            justify-content: center;
            align-items: center;
        }
        input[type="radio"] {
            display: none;
        }
        input[type="radio"] + span {
            display: inline-block;
            padding: 10px 20px;
            border: 1px solid #ced4da;
            border-radius: 20px;
            background-color: #fff;
            transition: all 0.3s;
            user-select: none;
            text-align: center;
        }
        input[type="radio"]:checked + span {
            background-color: #28a745;
            color: #fff;
            border-color: #28a745;
        }
        input[type="radio"] + span:hover {
            background-color: #17a2b8;
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
        .options-container {
            display: flex;
            flex-wrap: wrap;
            justify-content: space-between;
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
            <form id="form-group">
                <div class="options-container">
                    <?php for ($i = 0; $i < $length; $i++): ?>
                        <label>
                            <input type="radio" name="option" value="<?php echo $options[$i]->getId(); ?>">
                            <span><?php echo $options[$i]->getValueSk(); ?></span>
                        </label>
                    <?php endfor; ?>
                </div>
            </form>
            <button id="sendButton" type="button" class="btn btn-primary btn-block">🗳️ Odoslať</button>
            <button id="backButton" type="button" class="btn btn-secondary btn-block">⬅️ Späť</button>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.form/4.3.0/jquery.form.min.js"></script>

<script>
    document.getElementById('backButton').addEventListener('click', function() {
        window.location.href = 'index.php';
    });

    document.getElementById('sendButton').addEventListener('click', handleFormSubmission);

    function handleFormSubmission() {
        const selectedOption = document.querySelector('input[name="option"]:checked');
        if (selectedOption) {
            $.ajax({
                url: window.location.href,
                type: "POST",
                data: {
                    options: [selectedOption.value]
                },
                success: function(response) {
                    console.log("POST request successful");
                    console.log("Response:", response);
                    if (checkSavedLanguage()  === "english") {
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
                            text: 'Tvoj odpoveď bol odoslané!'
                        });
                    }
                },
                error: function(xhr, status, error) {
                    console.error("Error making POST request:", error);
                }
            });
        } else {
            if (checkSavedLanguage() === "english") {
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: 'Please select an option before submitting.'
                });
            } else {
                Swal.fire({
                    icon: 'error',
                    title: 'Ups...',
                    text: 'Pred odoslaním vyberte možnosť.'
                });
            }
        }
    }

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
        document.getElementById('sendButton').innerHTML = "🗳️ Odoslať";
        document.getElementById('backButton').innerHTML = "⬅️ Späť";
    }

    function translateToEnglish() {
        document.getElementById('pageTitle').innerText = 'ODILS |> Voting';
        document.getElementById('questionTitle').innerHTML = '<?php echo $period->getTitleEn(); ?>';
        document.getElementById('questionContent').innerHTML = "<?php echo $period->getContentEn(); ?>";
        document.getElementById('sendButton').innerHTML = "🗳️ Send";
        document.getElementById('backButton').innerHTML = "⬅️ Back";
    }

    checkSavedLanguage();


</script>

</body>
</html>
