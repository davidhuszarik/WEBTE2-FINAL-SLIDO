let ws = new WebSocket(`wss://${window.location.hostname}/wss`);

ws.onopen = function () {
    console.log("Connection established");
};

ws.onclose = function () {
    console.log("Connection closed");
};