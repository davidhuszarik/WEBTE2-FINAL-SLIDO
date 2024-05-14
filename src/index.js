/*
let ws = new WebSocket(`wss://${window.location.hostname}/wss`);

ws.onopen = function () {
    console.log("Connection established");
};

ws.onclose = function () {
    console.log("Connection closed");
};
*/


// TODO integrate this into every page
$.ajax({
    url: 'session',
    type: 'GET',
    success: function(result, textStatus, xhr) {
        // Handle success response here
        if (xhr.status === 200){
            sessionStorage.setItem('credentials', result);
        }
        else{
            // TODO this has to be included when logging out
            sessionStorage.removeItem('credentials');
        }
    },
    error: function(xhr, status, error) {
        // Handle error response here
        console.error('Error while getting session:', error);
    }
});