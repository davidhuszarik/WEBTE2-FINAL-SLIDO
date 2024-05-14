<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title id="pageTitle">ODILS | Homepage</title>

    <link rel="icon" type="image/x-icon" href="backend/views/images/favicon.png">
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11">
    <link rel="stylesheet" href="styles/index.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.form/4.3.0/jquery.form.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.js"></script>
    <script src="https://cdn.jsdelivr.net/particles.js/2.0.0/particles.min.js"></script>
    <script src="backend/views/index.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="js/index.js" defer></script>
    <script src="js/general.js" defer></script>
</head>

<body onload="translateToSlovak(); localStorage.setItem('selectedLanguage', 'slovak');">

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

<div class="divider"></div>
<div id="welcome" class="jumbotron py-4" data-aos="fade-up" data-aos-duration="1000">
    <div class="container text-center position-relative d-flex justify-content-center align-items-center" style="min-height: 70vh">
        <div id="particles-js" class="position-absolute"></div>
        <div>
            <h1 class="my-3" id="invitationHeading"></h1>
            <p class="my-3" id="invitationMessage"></p>
            <div class="my-3 d-flex justify-content-center align-items-center flex-wrap">
                <input type="text" id="invitationCode" name="invitationCode" placeholder="Enter your 6 digit-code"
                    class="form-control form-control-lg text-center mx-1" style="max-width: 300px;">
                <button onclick="sendInvitation()"
                        class="btn btn-primary btn-lg my-2">
                    <i class="fas fa-paper-plane"></i> <span id="connectText"></span>
                </button>
            </div>
        </div>
    </div>
</div>
<section id="who-we-are" class="section" style="margin-top: 50px; margin-bottom: 50px;">
    <div class="container">
        <h2 class="text-center" id="whatsGoodHeading"></h2>
        <div class="row align-items-center">
            <div class="col-md-4 text-center">
                <img src="backend/views/images/imagWithLogo.png" class="img-fluid" alt="Who We Are Image"
                     style="max-width: 200px; border: 1px solid black;">
            </div>
            <div class="col-md-8">
                <p style="margin-top: 20px; margin-bottom: 20px;" id="whatsGoodText1"></p>
                <p style="margin-top: 20px; margin-bottom: 0;" id="whatsGoodText2"></p>
            </div>

            <div class="vertical-divider"></div>

        </div>
    </div>
</section>
<hr style="border-top: 2px solid #ccc; width: 80px; margin: 20px auto;">
<div class="container text-center" style="margin-bottom: 50px;">
    <p><strong id="needHelpText"></strong> <span id="documentationText"></span> <br>
        <span id="logoText"></span>, <span id="phoneIconText"></span>, <span id="aiText"></span>.</p>
</div>

<footer class="footer">
    <div class="container">
        <p>&copy; 2024 ODILS. <span id="rightsReservedText"></span><br>
            <span id="schoolProjectText"></span></p>
    </div>
</footer>
</body>
</html>
