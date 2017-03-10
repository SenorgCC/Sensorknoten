$(document).ready(function () {
    // Neuladen alle 5000ms -> 5s
    $("#datentabelle").load("scripts/uebersicht/sensordaten.php");
    var refreshId = setInterval(function () {
        $("#datentabelle").load('scripts/uebersicht/sensordaten.php')
    }, 5000);
});