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
        <link rel="stylesheet" href="styles/panel.css">
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.form/4.3.0/jquery.form.min.js"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.js"></script>
        <script src="https://cdn.jsdelivr.net/particles.js/2.0.0/particles.min.js"></script>
        <script src="backend/views/index.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <script src="js/panel.js" defer></script>
        <script src="js/general.js" defer></script>
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
    </body>
</html>

