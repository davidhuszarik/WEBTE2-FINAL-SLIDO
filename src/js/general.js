function logout() {
    let loginButton = document.getElementById('loginLink');
    let logoutButton = document.getElementById('logoutLink');
    let userMenuItem = document.getElementById('userMenuItem');
    let panelLink = document.getElementById('panelLink');
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
                loginButton.style.display = "block";
                logoutButton.style.display = "none";
                userMenuItem.style.display = "none";
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
                        success: function() {
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
                loginButton.style.display = "block";
                logoutButton.style.display = "none";
                userMenuItem.style.display = "none";
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

document.getElementById('englishLink').addEventListener('click', function () {
    translateToEnglish();
    Swal.fire({
        icon: 'success',
        title: 'Language changed',
        text: 'The language has been successfully changed.'
    });
});

document.getElementById('slovakLink').addEventListener('click', function () {
    translateToSlovak();
    Swal.fire({
        icon: 'success',
        title: 'Jazyk zmenený',
        text: 'Jazyk bol úspešne zmenený.'
    });
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