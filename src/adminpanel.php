<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.6.1/font/bootstrap-icons.css" rel="stylesheet">

    <style>
        body {
            background-color: #f8f9fa;
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
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

        .btn-yellow {
            background-color: #ffc107;
            border-color: #ffc107;
        }

        .btn-yellow:hover {
            background-color: #e0a800;
            border-color: #e0a800;
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
    </style>
</head>
<body>

<div class="admin-panel">
    <div class="admin-panel-header">
        <img src="images/logo.png" alt="Logo">
        <h2>Welcome to Admin Panel</h2>
    </div>
    <div class="admin-details">
        <p>Hello, John Doe!</p>
        <p>You are logged in as an administrator.</p>
    </div>
    <div class="admin-panel-content">
        <div class="section">
            <div class="section-title">Profile settings</div>
            <div class="section-content">
                <button class="btn btn-yellow mx-auto" data-toggle="modal" data-target="#changePasswordModal"><i class="bi bi-key"></i> Change password</button>
                <button class="btn btn-yellow mx-auto"><i class="bi bi-box-arrow-right"></i> Logout</button>
            </div>
        </div>
        <div class="section">
            <div class="section-title">User settings</div>
            <div class="section-content">
                <button class="btn btn-green mx-auto"><i class="bi bi-people"></i> Manage users</button>
            </div>
        </div>
        <div class="section">
            <div class="section-title">Question settings</div>
            <div class="section-content">
                <button class="btn btn-red mx-auto"><i class="bi bi-file-earmark-text"></i> Manage questions</button>
                <button class="btn btn-blue mx-auto"><i class="bi bi-bar-chart"></i> Show results</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="changePasswordModal" tabindex="-1" role="dialog" aria-labelledby="changePasswordModalLabel" aria-hidden="true">
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
                        <label for="currentPassword">Current password</label>
                        <input type="password" class="form-control" id="currentPassword" required>
                    </div>
                    <div class="form-group">
                        <label for="newPassword">New password</label>
                        <input type="password" class="form-control" id="newPassword" required>
                    </div>
                    <div class="form-group">
                        <label for="confirmNewPassword">Confirm new password</label>
                        <input type="password" class="form-control" id="confirmNewPassword" required>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" id="saveChanges" disabled>Save changes</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="logoutConfirmationModal" tabindex="-1" role="dialog" aria-labelledby="logoutConfirmationModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="logoutConfirmationModalLabel">Logout Confirmation</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                Are you sure you want to log out?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">No</button>
                <button type="button" class="btn btn-primary" id="confirmLogout">Yes</button>
            </div>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
</body>
</html>

<script>
    $(document).ready(function () {
        var passwordInput = $('#newPassword');

        passwordInput.keyup(function () {
            var password = $(this).val();

            if (validatePassword(password)) {
                $(this).removeClass('is-invalid').addClass('is-valid');
            } else {
                $(this).removeClass('is-valid').addClass('is-invalid');
            }

            checkForm();
        });

        function validatePassword(password) {
            var re = /^(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{7,}$/;
            return re.test(password);
        }

        function checkForm() {
            var isValid = $('.is-valid').length == 1;

            if (isValid) {
                $('#saveChanges').prop('disabled', false);
            } else {
                $('#saveChanges').prop('disabled', true);
            }
        }
    });
</script>
