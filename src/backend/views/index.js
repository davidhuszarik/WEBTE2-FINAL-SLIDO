/*
let ws = new WebSocket(`wss://${window.location.hostname}/wss`);

ws.onopen = function () {
    console.log("Connection established");
};

ws.onclose = function () {
    console.log("Connection closed");
};
*/

function visualizeLoginState(){
    let credentials = sessionStorage.getItem('credentials');
    if (credentials) {
        let parsedCredentials = JSON.parse(credentials);
        let loginButton = document.getElementById('loginLink');
        let logoutButton = document.getElementById('logoutLink');
        let userMenuItem = document.getElementById('userMenuItem');
        let userNameLink = document.getElementById('userNameLink');
        let panelLink = document.getElementById('panelLink');
        if (loginButton) {
            loginButton.style.display = "none";
        }
        if (logoutButton) {
            logoutButton.style.display = "block";
        }
        if (userMenuItem) {
            userMenuItem.style.display = "block";
        }
        if (userNameLink) {
            userNameLink.textContent = "You are logged in as " + parsedCredentials.username;
        }
        panelLink.style.display = "block";
    } else {
        let loginButton = document.getElementById('loginLink');
        let logoutButton = document.getElementById('logoutLink');
        let userMenuItem = document.getElementById('userMenuItem');
        let panelLink = document.getElementById('panelLink');
        if (loginButton) {
            loginButton.style.display = "block";
        }
        if (logoutButton) {
            logoutButton.style.display = "none";
        }
        if (userMenuItem) {
            userMenuItem.style.display = "none";
        }
        panelLink.style.display = "none";
    }
}


// TODO integrate this into every page
$.ajax({
    url: 'session',
    type: 'GET',
    success: function(result, textStatus, xhr) {
        // Handle success response here
        if (xhr.status === 200){
            sessionStorage.setItem('credentials', JSON.stringify(JSON.parse(result).credentials));
        }
        else{
            // TODO this has to be included when logging out
            sessionStorage.removeItem('credentials');
        }
        visualizeLoginState();
    },
    error: function(xhr, status, error) {
        // Handle error response here
        console.error('Error while getting session:', error);
    }
});