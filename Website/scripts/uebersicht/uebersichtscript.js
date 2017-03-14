$(document).ready(function () {
    // Neuladen der Sensordatentabelle alle 5000ms -> 5s
    $("#datentabelle").load("scripts/uebersicht/sensordaten.php");
    var refreshId = setInterval(function () {
        $("#datentabelle").load('scripts/uebersicht/sensordaten.php')
    }, 5000);
});